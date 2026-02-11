<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View_ui_cont extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('login');
        // }

        // var_dump($this->session->userdata());

        // else {
        //     redirect('dashboard');
        // }
        // $login = $this->session->userdata('logged_in');
        // $user_id = $this->session->userdata('user_id');
        // $username = $this->session->userdata('username');

        // var_dump($login);
        // var_dump($user_id);
        // var_dump($username);
        // exit;


    }

    public function index()
    {
        $this->dashboard();
    }

    public function dashboard()
    {
        ini_set('max_execution_time', 300); // 5 minutes
        ini_set('memory_limit', '512M'); // 512MB

        $data['total_client'] = $this->db
            ->where('status !=', '1')
            ->count_all_results('tbl_client');

        $this->db->select_sum('
            CASE 
                WHEN tbl_loan.status = "overdue" THEN COALESCE(p.payment_total, 0)
                ELSE tbl_loan.total_amt
            END',
            'total_amt'
        );

        // Subquery to sum payments per loan
        $subquery = '(SELECT loan_id, SUM(amt) AS payment_total FROM tbl_payment GROUP BY loan_id) AS p';

        $data['total_loan_amt'] = $this->db
            ->from('tbl_loan')
            ->join('tbl_client', 'tbl_loan.cl_id = tbl_client.id')
            ->join($subquery, 'p.loan_id = tbl_loan.id', 'left')
            // ->where('tbl_client.status !=', '1')
            ->get()
            ->row()
            ->total_amt ?: 0;

        $data['total_loan_payment'] = $this->db
            ->select_sum('tbl_payment.amt')
            ->join('tbl_loan', 'tbl_loan.id = tbl_payment.loan_id')
            ->join('tbl_client', 'tbl_client.id = tbl_loan.cl_id')
            // ->where('tbl_client.status !=', '1')
            ->where("tbl_payment.payment_for BETWEEN DATE_ADD(tbl_loan.start_date, INTERVAL 1 DAY) AND tbl_loan.due_date", NULL, FALSE)
            ->get('tbl_payment')
            ->row()
            ->amt ?? 0;

        $data['total_pull_out'] = $this->db
            ->select_sum('total_pull_out')
            ->get('tbl_pull_out')
            ->row()
            ->total_pull_out;

        $data['total_expenses'] = $this->db
            ->select_sum('amt')
            ->get('tbl_expenses')
            ->row()
            ->amt;

        // In your controller, after fetching the data:
        $payment_subquery = "
            (SELECT loan_id, SUM(amt) AS total_paid
            FROM tbl_payment 
            WHERE payment_for BETWEEN DATE_ADD(
                (SELECT start_date FROM tbl_loan WHERE id = tbl_payment.loan_id), 
                INTERVAL 1 DAY
            ) AND (
                SELECT due_date FROM tbl_loan WHERE id = tbl_payment.loan_id
            )
            GROUP BY loan_id) p
        ";

        $this->db->select("
            c.full_name,
            COUNT(DISTINCT l.id) AS total_loans,
            SUM(CASE WHEN l.status = 'completed' THEN 1 ELSE 0 END) AS completed_loans,
            SUM(CASE WHEN l.status = 'overdue' THEN 1 ELSE 0 END) AS overdue_loans,
            SUM(CASE WHEN l.status = 'ongoing' THEN 1 ELSE 0 END) AS ongoing_loans,
            COALESCE(SUM(p.total_paid), 0) AS total_paid
        ")
            ->from('tbl_client c')
            ->join('tbl_loan l', 'c.id = l.cl_id', 'left')
            ->join($payment_subquery, 'l.id = p.loan_id', 'left', false)
            ->where('c.status !=', '1')
            ->group_by('c.id')
            ->having('total_loans > 0')
            ->having('completed_loans > 0')
            ->limit(10); // Get more than needed

        $query = $this->db->get();
        $payors = $query->result_array();

        // Calculate performance score for each payor and sort
        foreach ($payors as &$payor) {
            $score = $payor['completed_loans'] * 10;
            $score -= $payor['overdue_loans'] * 20;
            if ($payor['total_loans'] > 0) {
                $score += ($payor['completed_loans'] / $payor['total_loans']) * 100;
            }
            $payor['performance_score'] = round($score, 2);
        }

        // Sort by performance score (descending)
        usort($payors, function ($a, $b) {
            return $b['performance_score'] <=> $a['performance_score'];
        });

        // Take top 5
        $data['good_payors'] = array_slice($payors, 0, 5);

        // In your dashboard() function:
        $selected_date = $this->input->get('selected_date') ?: date('Y-m-d');
        $range_type = $this->input->get('range_type') ?: 'day';

        // Calculate dates
        if ($range_type === 'month') {
            $start_date = date('Y-m-01', strtotime($selected_date));
            $end_date = date('Y-m-t', strtotime($selected_date));
        } elseif ($range_type === 'week') {
            $start_date = date('Y-m-d', strtotime('monday this week', strtotime($selected_date)));
            $end_date = date('Y-m-d', strtotime('sunday this week', strtotime($selected_date)));
        } else {
            $start_date = $selected_date;
            $end_date = $selected_date;
        }

        $this->db->select_sum('p.amt', 'total_payments')
            ->from('tbl_payment p')
            ->join('tbl_loan l', 'l.id = p.loan_id', 'left')
            ->join('tbl_client c', 'c.id = l.cl_id', 'left')
            // ->where('c.status !=', '1')
            ->where('DATE(p.payment_for) >=', $start_date)
            ->where('DATE(p.payment_for) <=', $end_date)
            ->where("p.payment_for BETWEEN DATE_ADD(l.start_date, INTERVAL 1 DAY) AND l.due_date", NULL, FALSE);

        $query = $this->db->get();
        $row = $query->row();

        // Store ALL variables in $data array
        $data['range_total'] = $row ? ($row->total_payments ?: 0) : 0;
        $data['selected_date'] = $selected_date;
        $data['range_type'] = $range_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // NEW: Get monthly payment data for the current year
        $current_year = date('Y');

        // Query to get monthly payment totals
        $this->db->select("MONTH(a.payment_for) as month, SUM(a.amt) as total")
            ->from('tbl_payment as a')
            ->join('tbl_loan as b', 'b.id = a.loan_id', 'left')
            ->join('tbl_client as c', 'c.id = b.cl_id', 'left')
            // ->where('c.status !=', '1')
            ->where('YEAR(a.payment_for)', $current_year)
            ->where("a.payment_for BETWEEN DATE_ADD(b.start_date, INTERVAL 1 DAY) AND b.due_date", NULL, FALSE)
            ->group_by('MONTH(a.payment_for)')
            ->order_by('MONTH(a.payment_for)');

        $query = $this->db->get();
        $monthly_data = $query->result_array();

        // Prepare data for all 12 months (fill with 0 for months with no data)
        $monthly_totals = array_fill(1, 12, 0);
        $year_total = 0;

        foreach ($monthly_data as $row) {
            $month = (int) $row['month'];
            $monthly_totals[$month] = floatval($row['total']);
            $year_total += floatval($row['total']);
        }

        // NEW: Get total amount for the current year
        $this->db->select_sum('a.amt')
            ->from('tbl_payment as a')
            ->join('tbl_loan as b', 'b.id = a.loan_id', 'left')
            ->join('tbl_client as c', 'c.id = b.cl_id', 'left')
            // ->where('c.status !=', '1')
            ->where("a.payment_for BETWEEN DATE_ADD(b.start_date, INTERVAL 1 DAY) AND b.due_date", NULL, FALSE)
            ->where('YEAR(a.payment_for)', $current_year);

        $year_total_query = $this->db->get();
        $data['year_total_payment'] = $year_total_query->row()->amt ?: 0;

        // Convert to simple array for JavaScript
        $data['monthly_payments'] = array_values($monthly_totals);
        $data['current_year'] = $current_year;
        $data['months'] = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];

        // ========== EFFICIENCY CALCULATIONS ==========
        // Get current date info
        $current_month_name = date('F');
        $current_month_num = date('n');
        $current_day = date('j');
        $days_in_month = date('t');

        // Current month's payment (array index is 0-11, month is 1-12)
        $current_month_index = $current_month_num - 1;
        $current_month_payment = isset($data['monthly_payments'][$current_month_index]) ?
            $data['monthly_payments'][$current_month_index] : 0;

        // Monthly target (1/12 of annual total)
        $monthly_target = $data['year_total_payment'] > 0 ?
            ($data['year_total_payment'] / 12) : 0;

        // Daily target for this month
        $daily_target = $days_in_month > 0 ? ($monthly_target / $days_in_month) : 0;
        $days_passed = min($current_day, $days_in_month);
        $expected_to_date = $daily_target * $days_passed;

        // Month-to-date efficiency
        $month_to_date_efficiency = $expected_to_date > 0 ?
            ($current_month_payment / $expected_to_date) * 100 : 0;

        // Year-to-date efficiency
        $months_passed = $current_month_num - 1; // Months completed (0-11)
        $ytd_total = 0;
        for ($i = 0; $i < $months_passed; $i++) {
            $ytd_total += isset($data['monthly_payments'][$i]) ? $data['monthly_payments'][$i] : 0;
        }
        $ytd_efficiency = $data['year_total_payment'] > 0 ?
            ($ytd_total / $data['year_total_payment']) * 100 : 0;

        // Pass efficiency variables to the view
        $data['current_month_name'] = $current_month_name;
        $data['current_month_payment'] = $current_month_payment;
        $data['monthly_target'] = $monthly_target;
        $data['month_to_date_efficiency'] = $month_to_date_efficiency;
        $data['ytd_efficiency'] = $ytd_efficiency;
        $data['ytd_total'] = $ytd_total;
        $data['months_passed'] = $months_passed;
        $data['expected_to_date'] = $expected_to_date;
        $data['current_day'] = $current_day;
        $data['days_in_month'] = $days_in_month;
        $data['daily_target'] = $daily_target;

        // Calculate remaining target
        $remaining_days = $days_in_month - $current_day;
        $remaining_target = $monthly_target - $current_month_payment;
        $data['remaining_days'] = $remaining_days;
        $data['remaining_target'] = $remaining_target;
        $data['daily_needed'] = $remaining_days > 0 ? ($remaining_target / $remaining_days) : $remaining_target;
        // ========== END EFFICIENCY CALCULATIONS ==========

        // NEW: Get additional statistics for dashboard
        // Get today's payments
        $today = date('Y-m-d');
        $this->db->select_sum('amt')
            ->from('tbl_payment')
            ->where('DATE(payment_for)', $today);
        $today_query = $this->db->get();
        $data['today_payments'] = $today_query->row()->amt ?: 0;


        // ========== LOAN STATISTICS WITH CLIENT FILTER ==========
        // Get loan status data for chart with client filter
        $loan_status_data = $this->db
            ->select('l.status, COUNT(*) as count, SUM(l.total_amt) as total')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            // ->where('c.status !=', '1')
            ->group_by('l.status')
            ->get()
            ->result_array();

        $data['loan_status_counts'] = [];
        foreach ($loan_status_data as $row) {
            $data['loan_status_counts'][$row['status']] = $row['count'];
        }

        // ========== END LOAN STATISTICS ==========

        // Load views
        $this->load->view('layouts/header');
        $this->load->view('dashboard', $data);
        $this->load->view('layouts/footer');
    }

    // NEW: AJAX endpoint to get payment data by year
    public function get_payment_chart_data($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $this->db->select("MONTH(a.payment_for) as month, SUM(a.amt) as total")
            ->from('tbl_payment as a')
            ->join('tbl_loan as b', 'b.id = a.loan_id', 'left')
            ->join('tbl_client as c', 'c.id = b.cl_id', 'left')
            // ->where('c.status !=', '1')
            ->where("a.payment_for BETWEEN DATE_ADD(b.start_date, INTERVAL 1 DAY) AND b.due_date", NULL, FALSE)
            ->where('YEAR(a.payment_for)', $year)
            ->group_by('MONTH(a.payment_for)')
            ->order_by('MONTH(a.payment_for)');


        $query = $this->db->get();
        $result = $query->result_array();

        // Prepare data for all 12 months
        $monthly_totals = array_fill(1, 12, 0);

        foreach ($result as $row) {
            $month = (int) $row['month'];
            $monthly_totals[$month] = floatval($row['total']);
        }

        // Get year total
        $this->db->select_sum('a.amt')
            ->from('tbl_payment as a')
            ->join('tbl_loan as b', 'b.id = a.loan_id', 'left')
            ->join('tbl_client as c', 'c.id = b.cl_id', 'left')
            // ->where('c.status !=', '1')
            ->where("a.payment_for BETWEEN DATE_ADD(b.start_date, INTERVAL 1 DAY) AND b.due_date", NULL, FALSE)
            ->where('YEAR(a.payment_for)', $year);
        $year_total_query = $this->db->get();
        $year_total = $year_total_query->row()->amt ?: 0;

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => array_values($monthly_totals),
            'year' => $year,
            'year_total' => $year_total,
            'months' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ]
        ]);
    }

    // NEW: Get available years for dropdown
    public function get_years()
    {
        $this->db->select("DISTINCT YEAR(payment_for) as year")
            ->from('tbl_payment')
            ->order_by('year', 'DESC');

        $query = $this->db->get();
        $years = $query->result_array();

        $year_list = [];
        foreach ($years as $y) {
            if ($y['year']) {
                $year_list[] = $y['year'];
            }
        }

        // If no years in database, add current year
        if (empty($year_list)) {
            $year_list[] = date('Y');
        }

        echo json_encode($year_list);
    }

    // NEW: AJAX endpoint to get pull out data by year
    public function get_pullout_chart_data($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $this->db->select("MONTH(date_added) as month, SUM(total_pull_out) as total")
            ->from('tbl_pull_out')
            ->where('status !=', '1')
            ->where('YEAR(date_added)', $year)
            ->group_by('MONTH(date_added)')
            ->order_by('MONTH(date_added)');

        $query = $this->db->get();
        $result = $query->result_array();

        // Prepare data for all 12 months
        $monthly_totals = array_fill(1, 12, 0);

        foreach ($result as $row) {
            $month = (int) $row['month'];
            $monthly_totals[$month] = floatval($row['total']);
        }

        // Get year total
        $this->db->select_sum('total_pull_out')
            ->from('tbl_pull_out')
            ->where('status !=', 1)
            ->where('YEAR(date_added)', $year);
        $year_total_query = $this->db->get();
        $year_total = $year_total_query->row()->total_pull_out ?: 0;

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => array_values($monthly_totals),
            'year' => $year,
            'year_total' => $year_total,
            'months' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            'label' => 'Pull Out Amount'
        ]);
    }

    // NEW: AJAX endpoint to get expenses data by year
    public function get_expenses_chart_data($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $this->db->select("MONTH(date_added) as month, SUM(amt) as total")
            ->from('tbl_expenses')
            ->where('status !=', '1')
            ->where('YEAR(date_added)', $year)
            ->group_by('MONTH(date_added)')
            ->order_by('MONTH(date_added)');

        $query = $this->db->get();
        $result = $query->result_array();

        // Prepare data for all 12 months
        $monthly_totals = array_fill(1, 12, 0);

        foreach ($result as $row) {
            $month = (int) $row['month'];
            $monthly_totals[$month] = floatval($row['total']);
        }

        // Get year total
        $this->db->select_sum('amt')
            ->from('tbl_expenses')
            ->where('YEAR(date_added)', $year);
        $year_total_query = $this->db->get();
        $year_total = $year_total_query->row()->amt ?: 0;

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => array_values($monthly_totals),
            'year' => $year,
            'year_total' => $year_total,
            'months' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            'label' => 'Expenses Amount'
        ]);
    }

    public function get_loan_chart_data($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $this->db->select(
            "MONTH(a.start_date) as month, SUM(a.capital_amt) as total"
        )
            ->from('tbl_loan as a')
            ->join('tbl_client as b', 'b.id = a.cl_id', 'left')
            // ->where('b.status !=', '1')
            ->where('YEAR(a.start_date)', $year)
            ->group_by('MONTH(a.start_date)')
            ->order_by('MONTH(a.start_date)');

        $query = $this->db->get();
        $result = $query->result_array();

        // Prepare data for all 12 months
        $monthly_totals = array_fill(1, 12, 0);

        foreach ($result as $row) {
            $month = (int) $row['month'];
            $monthly_totals[$month] = floatval($row['total']);
        }

        // Get year total
        $this->db->select_sum('a.capital_amt')
            ->from('tbl_loan as a')
            ->join('tbl_client as b', 'b.id = a.cl_id', 'left')
            // ->where('b.status !=', '1')
            ->where('YEAR(a.start_date)', $year);
        $year_total_query = $this->db->get();
        $year_total = $year_total_query->row()->capital_amt ?: 0;

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => array_values($monthly_totals),
            'year' => $year,
            'year_total' => $year_total,
            'months' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            'label' => 'Loan Amount'
        ]);
    }
    public function monitoring()
    {
        $this->load->view('layouts/header');
        $this->load->view('monitoring');
        $this->load->view('layouts/footer');
    }

    public function pull_out()
    {
        $this->load->view('layouts/header');
        $this->load->view('pull_out');
        $this->load->view('layouts/footer');
    }

    public function expenses()
    {
        $this->load->view('layouts/header');
        $this->load->view('expenses');
        $this->load->view('layouts/footer');
    }

    public function history()
    {
        $this->load->view('layouts/header');
        $this->load->view('history');
        $this->load->view('layouts/footer');
    }

}
