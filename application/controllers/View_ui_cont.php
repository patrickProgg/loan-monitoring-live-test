<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View_ui_cont extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->dashboard();
    }
    public function dashboard()
    {
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
            ->where('tbl_client.status !=', '1')
            ->get()
            ->row()
            ->total_amt ?: 0;


        $data['total_loan_payment'] = $this->db
            ->select_sum('tbl_payment.amt')
            ->join('tbl_loan', 'tbl_loan.id = tbl_payment.loan_id')
            ->join('tbl_client', 'tbl_client.id = tbl_loan.cl_id')
            ->where('tbl_client.status !=', '1')
            ->get('tbl_payment')
            ->row()
            ->amt;

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

        // Subquery: total payments per loan
        $payment_subquery = "
            (SELECT loan_id, SUM(amt) AS total_paid
            FROM tbl_payment
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
            ->order_by('overdue_loans', 'ASC')
            ->order_by('completed_loans', 'DESC')
            ->limit(5);

        $query = $this->db->get();
        $data['good_payors'] = $query->result_array();


        // NEW: Get monthly payment data for the current year
        $current_year = date('Y');

        // Query to get monthly payment totals
        $this->db->select("MONTH(a.payment_for) as month, SUM(a.amt) as total")
            ->from('tbl_payment as a')
            ->join('tbl_loan as b', 'b.id = a.loan_id', 'left')
            ->join('tbl_client as c', 'c.id = b.cl_id', 'left')
            ->where('c.status !=', '1')
            ->where('YEAR(a.payment_for)', $current_year)
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
            ->where('c.status !=', '1')
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

        // Get this month's payments
        $this_month = date('Y-m');
        $this->db->select_sum('amt')
            ->from('tbl_payment')
            ->where("DATE_FORMAT(payment_for, '%Y-%m') =", $this_month);
        $month_query = $this->db->get();
        $data['this_month_payments'] = $month_query->row()->amt ?: 0;

        // ========== LOAN STATISTICS WITH CLIENT FILTER ==========
        // Get loan counts by status with client filter (exclude inactive clients where status != 1)
        $data['active_loans'] = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'ongoing')
            ->where('c.status !=', '1')
            ->count_all_results();

        $data['overdue_loans'] = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'overdue')
            ->where('c.status !=', '1')
            ->count_all_results();

        $data['completed_loans'] = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'completed')
            ->where('c.status !=', '1')
            ->count_all_results();

        // Get total overdue amount with client filter
        $this->db->select_sum('l.total_amt')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'overdue')
            ->where('c.status !=', '1');
        $overdue_query = $this->db->get();
        $data['overdue_amount'] = $overdue_query->row()->total_amt ?: 0;

        // Get total ongoing loans amount with client filter
        $this->db->select_sum('l.total_amt')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'ongoing')
            ->where('c.status !=', '1');
        $ongoing_query = $this->db->get();
        $data['ongoing_amount'] = $ongoing_query->row()->total_amt ?: 0;

        // Get total completed loans amount with client filter
        $this->db->select_sum('l.total_amt')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'completed')
            ->where('c.status !=', '1');
        $completed_query = $this->db->get();
        $data['completed_amount'] = $completed_query->row()->total_amt ?: 0;

        // Get loan status data for chart with client filter
        $loan_status_data = $this->db
            ->select('l.status, COUNT(*) as count, SUM(l.total_amt) as total')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('c.status !=', '1')
            ->group_by('l.status')
            ->get()
            ->result_array();

        $data['loan_status_counts'] = [];
        $data['loan_status_totals'] = [];
        foreach ($loan_status_data as $row) {
            $data['loan_status_counts'][$row['status']] = $row['count'];
            $data['loan_status_totals'][$row['status']] = $row['total'];
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
            ->where('c.status !=', '1')
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
            ->where('c.status !=', '1')
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

    // NEW: Get loan statistics WITH CLIENT FILTER
    public function get_loan_stats()
    {
        // Get loan counts by status with client filter
        $active_loans = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'ongoing')
            ->where('c.status !=', '1')
            ->count_all_results();

        $overdue_loans = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'overdue')
            ->where('c.status !=', '1')
            ->count_all_results();

        $completed_loans = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'completed')
            ->where('c.status !=', '1')
            ->count_all_results();

        // Get loan amounts by status with client filter
        $this->db->select_sum('l.total_amt')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'overdue')
            ->where('c.status !=', '1');
        $overdue_query = $this->db->get();
        $overdue_amount = $overdue_query->row()->total_amt ?: 0;

        $this->db->select_sum('l.total_amt')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'ongoing')
            ->where('c.status !=', '1');
        $ongoing_query = $this->db->get();
        $ongoing_amount = $ongoing_query->row()->total_amt ?: 0;

        $this->db->select_sum('l.total_amt')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'completed')
            ->where('c.status !=', '1');
        $completed_query = $this->db->get();
        $completed_amount = $completed_query->row()->total_amt ?: 0;

        echo json_encode([
            'success' => true,
            'active_loans' => $active_loans,
            'overdue_loans' => $overdue_loans,
            'completed_loans' => $completed_loans,
            'overdue_amount' => $overdue_amount,
            'ongoing_amount' => $ongoing_amount,
            'completed_amount' => $completed_amount
        ]);
    }

    // NEW: Get dashboard summary statistics WITH CLIENT FILTER
    public function get_dashboard_stats()
    {
        $current_year = date('Y');

        // Today's payments
        $today = date('Y-m-d');
        $this->db->select_sum('amt')
            ->from('tbl_payment')
            ->where('DATE(payment_for)', $today);
        $today_query = $this->db->get();
        $today_payments = $today_query->row()->amt ?: 0;

        // This month's payments
        $this_month = date('Y-m');
        $this->db->select_sum('amt')
            ->from('tbl_payment')
            ->where("DATE_FORMAT(payment_for, '%Y-%m') =", $this_month);
        $month_query = $this->db->get();
        $month_payments = $month_query->row()->amt ?: 0;

        // Year to date payments
        $this->db->select_sum('amt')
            ->from('tbl_payment')
            ->where('YEAR(payment_for)', $current_year);
        $year_query = $this->db->get();
        $year_payments = $year_query->row()->amt ?: 0;

        // Loan statistics with client filter
        $active_loans = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'ongoing')
            ->where('c.status !=', '1')
            ->count_all_results();

        $overdue_loans = $this->db
            ->select('l.*')
            ->from('tbl_loan l')
            ->join('tbl_client c', 'l.cl_id = c.id')
            ->where('l.status', 'overdue')
            ->where('c.status !=', '1')
            ->count_all_results();

        echo json_encode([
            'success' => true,
            'today_payments' => $today_payments,
            'month_payments' => $month_payments,
            'year_payments' => $year_payments,
            'active_loans' => $active_loans,
            'overdue_loans' => $overdue_loans,
            'current_year' => $current_year
        ]);
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
