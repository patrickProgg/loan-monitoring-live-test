<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php'; // adjust path if needed

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class Monitoring_cont extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_client()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);
        $history = $this->input->post('history');

        $order = $this->input->post('order');
        $orderColumnIndex = isset($order[0]['column']) ? $order[0]['column'] : 0;
        $orderDir = isset($order[0]['dir']) ? $order[0]['dir'] : 'DESC';

        $columns = [
            0 => 'a.acc_no',
            1 => 'a.full_name',
            2 => 'a.address',
            3 => 'a.date_added',
            4 => 'contact_no',
            5 => 'loan_count'
        ];

        $orderColumn = $columns[$orderColumnIndex];

        $subquery = '(SELECT loan_id, SUM(amt) AS payment_total FROM tbl_payment GROUP BY loan_id) as p';

        $this->db->select('
            a.id,
            a.acc_no,
            a.full_name,
            a.address,
            a.date_added,
            a.contact_no_1,
            a.contact_no_2,
            CONCAT(a.contact_no_1, " | ", a.contact_no_2) AS contact_no,
            COUNT(b.id) AS loan_count,
            COALESCE(SUM(
                CASE 
                    WHEN b.status = "overdue" THEN COALESCE(p.payment_total, 0)
                    ELSE b.total_amt
                END
            ), 0) AS total_loan_amount
        ');

        $this->db->from('tbl_client as a');
        $this->db->join('tbl_loan as b', 'b.cl_id = a.id', 'left');
        $this->db->join($subquery, 'p.loan_id = b.id', 'left');

        if ($history) {
            $this->db->where('a.status', '1');
        } else {
            $this->db->where('a.status', '0');
        }

        $this->db->group_by('a.id');

        if ($history) {
            $this->db->where('a.status', '1');
        } else {
            $this->db->where('a.status', '0');
        }

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('a.full_name', $searchValue);
            $this->db->or_like('a.address', $searchValue);
            $this->db->or_like('a.contact_no_1', $searchValue);
            $this->db->or_like('a.contact_no_2', $searchValue);
            $this->db->or_like('a.date_added', $searchValue);
            $this->db->group_end();
        }

        $this->db->group_by('a.id');

        $this->db->order_by($orderColumn, $orderDir);

        $subQuery = clone $this->db;
        $recordsFiltered = $subQuery->get()->num_rows();

        $this->db->limit($length, $start);

        $query = $this->db->get();
        $data = $query->result_array();

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $recordsFiltered,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }


    public function add_client()
    {
        $this->db->trans_start();

        $client_details = array(
            'acc_no' => $this->input->post('acc_no'),
            'full_name' => $this->input->post('full_name'),
            'address' => $this->input->post('address'),
            'contact_no_1' => $this->input->post('contact_no_1'),
            'contact_no_2' => $this->input->post('contact_no_2'),
            'date_added' => $this->input->post('date_added'),
        );

        $this->db->insert('tbl_client', $client_details);
        $client_id = $this->db->insert_id();

        $start_date = $this->input->post('date_added');
        $due_date = date('Y-m-d', strtotime($start_date . ' +58 days'));

        $loan_details = array(
            'cl_id' => $client_id,
            'capital_amt' => $this->input->post('capital_amt'),
            'interest' => $this->input->post('interest'),
            'added_amt' => $this->input->post('added_amt'),
            'total_amt' => $this->input->post('total_amt'),
            'start_date' => $start_date,
            'due_date' => $due_date
        );

        $this->db->insert('tbl_loan', $loan_details);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to save client or loan record.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Client and loan saved successfully.',
                'client_id' => $client_id
            ]);
        }
    }

    public function update_client()
    {
        $id = $this->input->post('id');

        $client_details = array(
            'acc_no' => $this->input->post('edit_acc_no'),
            'full_name' => $this->input->post('edit_full_name'),
            'address' => $this->input->post('edit_address'),
            'contact_no_1' => $this->input->post('edit_contact_no_1'),
            'contact_no_2' => $this->input->post('edit_contact_no_2'),
            'date_added' => $this->input->post('edit_start_date'),
        );

        $this->db->where('id', $id);
        $updated = $this->db->update('tbl_client', $client_details);

        if (!$updated) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update client details.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Client updated successfully.'
            ]);
        }
    }

    public function get_start_due_date()
    {
        $id = $this->input->post('id');

        $this->db->select("
            id,
            CONCAT(start_date, ' - ', due_date) AS date_to_pay,
            status
        ");

        $this->db->from('tbl_loan');
        $this->db->where('cl_id', $id);
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        echo json_encode([$query->result_array()]);
    }

    public function get_loan_details()
    {
        $id = $this->input->post('id');

        $this->db->select("
            a.capital_amt,
            a.interest,
            a.added_amt,
            a.total_amt,
            a.start_date,
            a.due_date,
            a.complete_date,
            a.status,
            b.payment_for,
            b.amt
        ");

        $this->db->from('tbl_loan as a');
        $this->db->join('tbl_payment as b', 'b.loan_id = a.id', 'left');
        $this->db->where('a.id', $id);

        $this->db->order_by('b.payment_for', 'ASC');

        $query = $this->db->get();
        echo json_encode($query->result_array());
    }

    public function save_payment()
    {
        $loan_id = $this->input->post('loan_id');
        $payment_for = $this->input->post('payment_for');
        $amount = $this->input->post('amount');

        $this->db->where('loan_id', $loan_id);
        $this->db->where('payment_for', $payment_for);
        $query = $this->db->get('tbl_payment');

        if ($query->num_rows() > 0) {
            $this->db->set('amt', $amount);
            $this->db->where('loan_id', $loan_id);
            $this->db->where('payment_for', $payment_for);
            $updated = $this->db->update('tbl_payment');

            if ($updated) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Payment updated successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update payment.'
                ]);
            }
        } else {
            $payment_details = array(
                'loan_id' => $loan_id,
                'payment_for' => $payment_for,
                'amt' => $amount
            );

            $inserted = $this->db->insert('tbl_payment', $payment_details);

            if ($inserted) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Payment inserted successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to insert payment.'
                ]);
            }
        }
    }

    public function complete_payment()
    {
        $loan_id = $this->input->post('loan_id');
        $complete_date = $this->input->post('complete_date');
        $action = $this->input->post('action');
        $running_bal = $this->input->post('running_bal');
        $due_date = $this->input->post('due_date');
        $new_start_date = $this->input->post('new_start_date');
        $interest = $this->input->post('interest');
        $added_amt = $this->input->post('added_amt');
        $total_amt = $this->input->post('total_amt');

        $data = array(
            'complete_date' => $complete_date,
            'status' => 'completed'
        );

        if ($action === "ongoing") {
            $data['status'] = 'ongoing';
            $data['complete_date'] = NULL;
        } else if ($action === "overdue") {
            $data['status'] = 'overdue';
            $data['complete_date'] = $due_date;
        }

        $loan = $this->db->select('cl_id')
            ->from('tbl_loan')
            ->where('id', $loan_id)
            ->get()
            ->row();

        if (!$loan) {
            echo json_encode(['status' => 'error', 'message' => 'Loan not found']);
            return;
        }

        $this->db->where('id', $loan_id);
        $updated = $this->db->update('tbl_loan', $data);

        if ($updated && $action === "overdue") {

            $new_due_date = date('Y-m-d', strtotime($new_start_date . ' +58 days'));

            $new_loan_details = array(
                'cl_id' => $loan->cl_id,
                'capital_amt' => $running_bal,
                'interest' => $interest,
                'added_amt' => $added_amt,
                'total_amt' => $total_amt,
                'start_date' => $new_start_date,
                'due_date' => $new_due_date
            );

            $inserted = $this->db->insert('tbl_loan', $new_loan_details);
        }

        $inserted = false;

        if (!$updated) {
            echo json_encode(['status' => 'error']);
        } else {
            echo json_encode(['status' => 'success', 'data' => $inserted]);
        }
    }

    public function add_new_loan_same_client()
    {
        $cl_id = $this->input->post('cl_id');
        $capital_amt = $this->input->post('capital_amt');
        $interest = $this->input->post('interest');
        $added_amt = $this->input->post('added_amt');
        $total_amt = $this->input->post('total_amt');
        $start_date = $this->input->post('start_date');

        $due_date = date('Y-m-d', strtotime($start_date . ' +58 days'));

        $new_loan_details = array(
            'cl_id' => $cl_id,
            'capital_amt' => $capital_amt,
            'interest' => $interest,
            'added_amt' => $added_amt,
            'total_amt' => $total_amt,
            'start_date' => $start_date,
            'due_date' => $due_date
        );

        $inserted = $this->db->insert('tbl_loan', $new_loan_details);

        if ($inserted) {
            echo json_encode([
                'status' => 'success',
                'message' => 'New Loan inserted successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to insert new loan.'
            ]);
        }
    }

    public function update_loan_data()
    {
        $id = $this->input->post('loan_id');

        $loan_details = array(
            'capital_amt' => $this->input->post('header_capital_amt'),
            'interest' => $this->input->post('header_interest'),
            'added_amt' => $this->input->post('header_added_amt'),
            'total_amt' => $this->input->post('header_total_amt'),
            'start_date' => $this->input->post('header_loan_date'),
            'due_date' => $this->input->post('header_due_date')
        );

        $this->db->where('id', $id);
        $updated = $this->db->update('tbl_loan', $loan_details);

        if (!$updated) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update loan details.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Loan updated successfully.'
            ]);
        }
    }

    public function delete_id()
    {
        $id = $this->input->post('id');

        $data = [
            'status' => "1"
        ];

        $this->db->where('id', $id);
        $updated = $this->db->update('tbl_client', $data);

        if (!$updated) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete client record.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Client data deleted successfully.',
            ]);
        }
    }

    public function recover_id()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');

        $this->db->where('id', $id);

        $status = [
            'status' => '0'
        ];

        if ($type === "client") {
            $recovered = $this->db->update('tbl_client', $status);
        } else if ($type === "pull_out") {
            $recovered = $this->db->update('tbl_pull_out', $status);
        } else {
            $recovered = $this->db->update('tbl_expenses', $status);
        }

        if ($recovered) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Data recovered successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to recover data.'
            ]);
        }
    }

    public function cash_count()
    {
        $selectedDate = $this->input->post('date');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(17);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);

        $loanData = $this->get_loan_released($selectedDate);

        $formattedDate = date('F j, Y', strtotime($selectedDate));
        $excelDateHeader = date('m/d/Y', strtotime($selectedDate));

        // Data array - ADDED empty row after row 18
        $data = [
            [$formattedDate],
            ["AREA 4'-Payment", "", "", "", 7854.00],
            ["Savings", "", "", "", 420.00],
            ["Processing Fee", "", "", "", ""],
            ["EXCESS", "", "", "", 20],
            ["T O T A L - C P", "", "", "", 8294.00],
            ["LESS : E X P E N S E S", "", "", "", ""],
            ["Savings Withdrawal", "", "", "", ""],
            ["Gas for motor mio", "", "", "", 180.00],
            ["RELEASED C/O REMITTANCE", "", "", "", ""],
            ["change oil jason", "", "", "", ""],
            ["", "", "", "", ""],
            ["", "", "", "", ""],
            ["", "", "", "", ""],
            ["", "", "", "", ""],
            ["T O T A L E X P E N S E S", "", "", "", 180.00],
            ["Collector's Cash Remitt", "", $excelDateHeader, "", 8114.00],
            ["Ending Cash on Hand", "", "01/29/2026", "", 4965.50],
            ["", "", "", "", ""], // ADDED: Empty row under Ending Cash on Hand (row 19)
            ["TOTAL MONEY", "", "", "", 13079.50],
            ["LESS(RELEASED)", "", "", "", ""],
            ["Date", "Name", "", "Amount", "", "", "", "RP LENDING SERVICES", "", ""],
            ["", "", "", "", "", "", "Area 4", "", "", ""],
            ["", "", "", "", "", "", "CASH ONHAND", "", "", ""],
            ["", "", "", "", "", "", "CASH COUNT", "", "", ""],
            ["", "", "", "", "", "", "NO. OF PIECE", "DENOMINATION", "AMOUNT", ""],
            ["", "", "", "", "", "", "", "1,000.00", "", ""],
            ["TOTAL RELEASED", "", "", "", "", "", "", "500.00", "", ""],
            ["LESS(WITHDRAWAL)", "", "", "", "", "", "", "200.00", "", ""],
            ["Date", "Name", "", "Amount", "", "", "", "100.00", "", ""],
            ["", "", "", "", "", "", "", "50.00", "", ""],
            ["", "", "", "", "", "", "", "20.00", "", ""],
            ["", "", "", "", "", "", "", "10.00", "", ""],
            ["", "", "", "", "", "", "", "5.00", "", ""],
            ["", "", "", "", "", "", "", "1.00", "", ""],
            ["TOTAL WITHDRAW", "", "", "", "", "", "", "0.25", "", ""],
            ["", "", "", "", "", "", "T O T A L", "", "", ""],
            ["ENDING CASH ONHAND", "", "", "", 13079.50],
        ];

        // Set formulas for AMOUNT column (I = G * H) for rows 27-36
        for ($row = 27; $row <= 36; $row++) {
            // Set formula: I = G * H (only calculate if G is not empty)
            $sheet->setCellValue('I' . $row, '=IF(G' . $row . '="","",G' . $row . '*H' . $row . ')');

            // Apply number format to the formula result
            $sheet->getStyle('I' . $row)->getNumberFormat()
                ->setFormatCode('#,##0.00');
        }

        // Set formula for TOTAL in I37 (sum of I27:I36)
        $sheet->setCellValue('I37', '=SUM(I27:I36)');

        // Make sure I37 has the same formatting
        $sheet->getStyle('I37')->getNumberFormat()
            ->setFormatCode('#,##0.00');

        // Set formulas for WITHDRAWAL section (Column E) based on cash count
        $sheet->setCellValue('E38', '=I37'); // TOTAL WITHDRAW = Cash Count Total

        // Update ENDING CASH ONHAND formula to use the calculated total
// E36 = E20 (TOTAL MONEY) - I37 (CASH COUNT TOTAL)
        $sheet->setCellValue('E36', '=E20-I37');

        // Also set the value in H column as numbers (remove commas from your data array)
        $denominationValues = [1000, 500, 200, 100, 50, 20, 10, 5, 1, 0.25];
        for ($row = 27; $row <= 36; $row++) {
            $index = $row - 27;
            if (isset($denominationValues[$index])) {
                $sheet->setCellValue('H' . $row, $denominationValues[$index]);
                $sheet->getStyle('H' . $row)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
            }
        }

        // Clear the static values from your data array for these cells
// since we're setting them dynamically above
        for ($row = 27; $row <= 36; $row++) {
            $sheet->setCellValue('I' . $row, ''); // Clear static value, formula will compute
        }

        // Write data to sheet
        $rowNumber = 1;
        foreach ($data as $row) {
            $col = 'A';
            foreach ($row as $cell) {
                $sheet->setCellValue($col . $rowNumber, $cell);
                $col++;
            }
            $rowNumber++;
        }

        // Populate loan release data starting from Excel row 23 (was 22, now +1)
        $excelRow = 23;

        foreach ($loanData as $loan) {
            if ($excelRow > 27) // Was 26, now 27
                break;

            $timestamp = strtotime($loan['start_date']);
            $excelDate = Date::PHPToExcel($timestamp);

            $sheet->setCellValue('A' . $excelRow, $excelDate);
            $sheet->getStyle('A' . $excelRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('B' . $excelRow, $loan['full_name']);
            $sheet->setCellValue('D' . $excelRow, (float) $loan['total_amt']);
            $sheet->getStyle('D' . $excelRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $excelRow++;
        }

        // Calculate TOTAL RELEASED in Excel row 28 (was 27, now +1)
        $totalReleased = array_sum(array_column($loanData, 'total_amt'));
        $sheet->setCellValue('E28', (float) $totalReleased); // Row 28

        // Update LESS(RELEASED) in Excel row 21 (was 20, now +1)
        $sheet->setCellValue('E21', (float) $totalReleased); // Row 21

        // Update ENDING CASH ONHAND in Excel row 37 (was 35, now 37)
        $totalMoney = 13079.50;
        $totalExpenses = 180.00;
        $endingCash = $totalMoney - $totalReleased - $totalExpenses;
        $sheet->setCellValue('E36', (float) $endingCash);

        // Apply number formatting to ALL number cells
        $numberCells = [
            'E2',
            'E3',
            'E5',
            'E6',
            'E8',
            'E9',
            'E10',
            'E11',
            'E15',
            'E16',
            'E17',
            'E18',
            'E21', // E21 instead of E20
            'E36',
            'D23',
            'D24',
            'D25',
            'D26',
            'D27',
            'E28',
            'E38',
            'H27',
            'H28',
            'H29',
            'H30',
            'H31',
            'H32',
            'H33',
            'H34',
            'H35',
            'H36',
            'I27',
            'I28',
            'I29',
            'I30',
            'I31',
            'I32',
            'I33',
            'I34',
            'I35',
            'I36',
            'I37',
        ];

        foreach ($numberCells as $cell) {
            $sheet->getStyle($cell)->getNumberFormat()
                ->setFormatCode('#,##0.00');
        }

        // Apply date formatting to date cells (rows shifted +1)
        $dateCells = ['A23', 'A24', 'A25', 'A26', 'A27'];
        foreach ($dateCells as $cell) {
            $sheet->getStyle($cell)->getNumberFormat()
                ->setFormatCode('mm/dd/yyyy');
        }

        // Merge cells
        for ($row = 1; $row <= 16; $row++) {
            $sheet->mergeCells('A' . $row . ':C' . $row);
        }

        for ($row = 17; $row <= 18; $row++) {
            $sheet->mergeCells('A' . $row . ':B' . $row);
        }

        for ($row = 20; $row <= 21; $row++) { // Row 19-20 (TOTAL MONEY and LESS RELEASED)
            $sheet->mergeCells('A' . $row . ':C' . $row);
        }

        for ($row = 22; $row <= 27; $row++) { // Row 22-27 (loan data area)
            $sheet->mergeCells('B' . $row . ':C' . $row);
        }

        for ($row = 28; $row <= 29; $row++) { // Row 28-29 (TOTAL RELEASED and LESS WITHDRAWAL)
            $sheet->mergeCells('A' . $row . ':C' . $row);
        }


        $rowsToMerge = [36, 38]; // ENDING CASH ONHAND and empty row

        foreach ($rowsToMerge as $row) {
            $sheet->mergeCells('A' . $row . ':C' . $row);
            $sheet->getStyle('A' . $row . ':C' . $row)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $rowsToMerge = [24, 25];

        foreach ($rowsToMerge as $row) {
            $sheet->mergeCells('G' . $row . ':J' . $row);
            $sheet->getStyle('G' . $row . ':J' . $row)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        for ($row = 26; $row <= 36; $row++) { // Row 22-27 (loan data area)
            $sheet->mergeCells('I' . $row . ':J' . $row);
        }

        $rowToMerge = 22;
        $sheet->mergeCells('H' . $rowToMerge . ':I' . $rowToMerge);
        $sheet->getStyle('H' . $rowToMerge . ':I' . $rowToMerge)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $rowToMerge = 37;
        $sheet->mergeCells('G' . $rowToMerge . ':H' . $rowToMerge);
        $sheet->getStyle('G' . $rowToMerge . ':H' . $rowToMerge)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $rowToMerge = 37;
        $sheet->mergeCells('I' . $rowToMerge . ':J' . $rowToMerge);
        $sheet->getStyle('I' . $rowToMerge . ':J' . $rowToMerge)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Apply center alignment
        $sheet->getStyle('A1:C16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A17:C18')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A20:C21')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A28:C29')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Style for title row
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('6ECF50');

        $sheet->getStyle('E17')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('FF66CC');

        $sheet->getStyle('E38')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('FF66CC');


        $dangerCells = ['A7', 'A16', 'A21', 'A29', 'E16', 'E9', 'E28', 'E36']; // Updated row numbers

        foreach ($dangerCells as $cell) {
            $sheet->getStyle($cell)->getFont()
                ->setBold(true)
                ->getColor()->setARGB(Color::COLOR_RED);
        }

        // Bold TOTAL rows - UPDATED ROW NUMBERS
        $totalRows = ['E6', 'E16', 'E28', 'E36', 'E37', 'A37', 'A2', 'A6', 'A38', 'E17', 'E18', 'E38', 'A20', 'A17', 'A18', 'H22', 'G24', 'G25', 'G37', 'G26', 'H26', 'I26', 'G23'];
        foreach ($totalRows as $cell) {
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        // Borders - UPDATED ROW NUMBERS
        $sheet->getStyle('A1:E21')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A22:D27')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A28:E29')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A30:D35')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A36:E36')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A37:E37')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A38:E38')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('E22:E27')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('E30:E35')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle('G22:J24')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('G25:J26')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('G26:J36')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('G37:H37')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('I37:J37')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('G38:J38')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        // Center align the headers - UPDATED ROW NUMBERS
        $sheet->getStyle('A22:E22')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I26:J36')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A30:E30')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A22:E22')->getFont()->setBold(true);
        $sheet->getStyle('A30:E30')->getFont()->setBold(true);

        $sheet->getStyle('G23:G23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G26:I36')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        $denominationValues = [1000, 500, 200, 100, 50, 20, 10, 5, 1, 0.25];

        for ($row = 27; $row <= 36; $row++) {
            $index = $row - 27;

            // Set fixed H (denomination)
            $sheet->setCellValue('H' . $row, $denominationValues[$index]);
            $sheet->getStyle('H' . $row)->getNumberFormat()
                ->setFormatCode('#,##0.00');

            // Set formula in I = G * H (dynamic)
            $sheet->setCellValue('I' . $row, '=IF(G' . $row . '="","",G' . $row . '*H' . $row . ')');
            $sheet->getStyle('I' . $row)->getNumberFormat()
                ->setFormatCode('#,##0.00');
        }

        // Update total in I37
        $sheet->setCellValue('I37', '=SUM(I27:I36)');
        $sheet->getStyle('I37')->getNumberFormat()
            ->setFormatCode('#,##0.00');


        // // Output Excel
        // $writer = new Xlsx($spreadsheet);
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="DAILY_REPORT_' . $excelDateHeader . '.xlsx"');

        // $writer->save('php://output');

        $saveFolder = "C:/laragon/www/loan-monitoring/DAILY_REPORT";
        if (!is_dir($saveFolder))
            mkdir($saveFolder, 0777, true);

        $filePath = $saveFolder . "/" . $formattedDate . ".xlsx";

        if (file_exists($filePath)) {
            unlink($filePath); // Delete the existing file
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        if ($writer) {
            echo json_encode([
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'status' => 'error'
            ]);
        }
    }

    private function get_loan_released($selectedDate)
    {
        $this->db->select('
            a.total_amt,
            a.start_date,
            b.full_name
        ');

        $this->db->from('tbl_loan as a');
        $this->db->join('tbl_client as b', 'b.id = a.cl_id');
        $this->db->where('a.start_date', $selectedDate);

        $query = $this->db->get();
        return $query->result_array();
    }

}
