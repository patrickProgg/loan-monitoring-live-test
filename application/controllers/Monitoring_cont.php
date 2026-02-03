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
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(17);
        $sheet->getColumnDimension('H')->setWidth(15);

        $loanData = $this->get_loan_released($selectedDate);

        $formattedDate = date('F j, Y', strtotime($selectedDate));
        $excelDateHeader = Date::PHPToExcel(strtotime($selectedDate));
        $previousDay = Date::PHPToExcel(strtotime($selectedDate . ' -1 day'));

        $data = [
            [$formattedDate],
            ["AREA 4'-Payment", "", "", ""],
            ["Processing Fee", "", "", "", "", "", "RP LENDING SERVICES", ""],
            ["EXCESS", "", "", "", "", "Area 4", "", ""],
            ["T O T A L - C P", "", "", "", "", "LEAH MAE GUCOR", "", ""],
            ["LESS : E X P E N S E S", "", "", "", "", "CASH COUNT", "", ""],
            ["Gas", "", "", "", "", "PIECES", "DENOMINATION", "AMOUNT"],
            ["Motor Shop", "", "", "", "", "", "", ""],
            ["Others", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["T O T A L E X P E N S E S", "", "", "", "", "", "", ""],
            ["Collector's Cash Remitt", "", $excelDateHeader, "", "", "", "", ""],
            ["Ending Cash on Hand", "", $previousDay, "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["TOTAL MONEY", "", "", "", "", "TOTAL", "", ""],
            ["LESS(RELEASED)", "", "", ""],
            ["Date", "Name", "", "Amount"],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["TOTAL RELEASED", "", "", ""],
            ["", "", "", ""],
            ["LESS(PULLOUT)", "", "", ""],
            ["Capital", "10 % Profit Sharing", "Ticket", "Amount"],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["", "", "", ""],
            ["TOTAL PULLOUT", "", "", ""],
            ["ENDING CASH ONHAND", "", "", ""],
        ];

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

        // Populate loan release data starting from Excel row 21
        $excelRow = 21;

        foreach ($loanData as $loan) {
            if ($excelRow > 32)
                break;

            $timestamp = strtotime($loan['start_date']);
            $excelDate = Date::PHPToExcel($timestamp);

            // Convert full name to title case
            $fullName = ucwords(strtolower($loan['full_name']));

            $sheet->setCellValue('A' . $excelRow, $excelDate);
            $sheet->getStyle('A' . $excelRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('B' . $excelRow, $fullName); // Use the capitalized version
            $sheet->setCellValue('D' . $excelRow, (float) $loan['total_amt']);
            $sheet->getStyle('D' . $excelRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $excelRow++;
        }

        // Calculate TOTAL RELEASED in Excel row 33
        $totalReleased = array_sum(array_column($loanData, 'total_amt'));
        $sheet->setCellValue('D33', (float) $totalReleased);

        // Apply number formatting to ALL number cells
        $numberCells = [
            'D1',
            'D2',
            'D3',
            'D4',
            'D5',
            'D6',
            'D7',
            'D8',
            'D9',
            'D10',
            'D11',
            'D12',
            'D13',
            'D14',
            'D15',
            'D16',
            'D17',
            'D18',
            'D19',
            'D20',
            'D21',
            'D22',
            'D23',
            'D24',
            'D25',
            'D26',
            'D27',
            'D28',
            'D29',
            'D30',
            'D31',
            'D32',
            'D33',
            'D34',
            'D35',
            'D36',
            'D37',
            'D38',
            'D39',
            'D40',
            'D41',
            'D42',
            'D43',
            'A37',
            'A38',
            'A39',
            'A40',
            'A41',
            'B37',
            'B38',
            'B39',
            'B40',
            'B41',
            'C37',
            'C38',
            'C39',
            'C40',
            'C41',
            'G8',
            'G9',
            'G10',
            'G11',
            'G12',
            'G13',
            'G14',
            'G15',
            'G16',
            'G17',
            'G18',
            'H8',
            'H9',
            'H10',
            'H11',
            'H12',
            'H13',
            'H14',
            'H15',
            'H16',
            'H17',
            'H18',

        ];

        foreach ($numberCells as $cell) {
            $sheet->getStyle($cell)->getNumberFormat()
                ->setFormatCode('#,##0.00');
            $sheet->getStyle($cell)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Apply date formatting to date cells
        $dateCells = [
            'A21',
            'A22',
            'A23',
            'A24',
            'A25',
            'A26',
            'A27',
            'A28',
            'A29',
            'A30',
            'A31',
            'A32',
            'C15',
            'C16'
        ];
        foreach ($dateCells as $cell) {
            $sheet->getStyle($cell)->getNumberFormat()
                ->setFormatCode('mm/dd/yyyy');
        }

        // Merge cells
        for ($row = 1; $row <= 14; $row++) {
            $sheet->mergeCells('A' . $row . ':C' . $row);
        }
        $sheet->mergeCells('G3:H3');
        $sheet->mergeCells('F5:H5');
        $sheet->mergeCells('F6:H6');
        for ($row = 15; $row <= 16; $row++) {
            $sheet->mergeCells('A' . $row . ':B' . $row);
        }
        $sheet->mergeCells('A17:D17');
        for ($row = 18; $row <= 19; $row++) {
            $sheet->mergeCells('A' . $row . ':C' . $row);
        }
        $sheet->mergeCells('F18:G18');
        for ($row = 20; $row <= 32; $row++) {
            $sheet->mergeCells('B' . $row . ':C' . $row);
        }
        $sheet->mergeCells('A33:C33');
        $sheet->mergeCells('A34:D34');
        $sheet->mergeCells('A35:C35');
        $sheet->mergeCells('A42:C42');
        $sheet->mergeCells('A43:C43');

        // Apply center alignment
        $sheet->getStyle('A1:C14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F3:H18')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F18:G18')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:B16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C15:C16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A18:C19')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A20:D20')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A21:A32')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C21:C32')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A33:C33')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A35:C35')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A36:C36')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A37:C41')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A42:C42')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A43:C43')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Style for title row
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('6ECF50');

        $sheet->getStyle('D15')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('FF66CC');

        $sheet->getStyle('D43')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('FF66CC');

        $dangerCells = [
            'A6',
            'D7',
            'D8',
            'D9',
            'D10',
            'D11',
            'D12',
            'D13',
            'D14',
            'A14',
            'A19',
            'D33',
            'A35',
            'D42',
        ];

        foreach ($dangerCells as $cell) {
            $sheet->getStyle($cell)->getFont()
                ->setBold(true)
                ->getColor()->setARGB(Color::COLOR_RED);
        }

        // Bold rows
        $totalRows = ['D2', 'D3', 'D4', 'D5', 'D15', 'D16', 'A18', 'D16', 'D18', 'A20', 'B20', 'D20', 'A33', 'A36', 'B36', 'C36', 'D36', 'A42', 'A43', 'F7', 'G7', 'H7', 'F18', 'H18', 'G3', 'F4', 'F5', 'F6', 'A5', 'A15', 'A16', 'D43', 'A2'];
        foreach ($totalRows as $cell) {
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        // Borders - UPDATED ROW NUMBERS
        $sheet->getStyle('A1:D19')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('F3:H5')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('F6:H6')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('F18:G18')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('H18:H18')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('F7:H17')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A20:D32')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A33:D33')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A34:D35')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A36:D41')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A42:D42')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A43:D43')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $lastRow = 4; // Row just before D5
        $sheet->setCellValue('D5', '=SUM(D2:D' . $lastRow . ')');

        $lastRow = 13; // Row just before D14
        $sheet->setCellValue('D14', '=SUM(D7:D' . $lastRow . ')');

        $sheet->setCellValue('D15', '=D5-D14');

        $sheet->setCellValue('D18', '=SUM(D15,D16)');

        $lastRow = 32; // Row just before D33
        $sheet->setCellValue('D33', '=SUM(D21:D' . $lastRow . ')');

        $sheet->setCellValue('D37', '=SUM(A37,B37,C37)');
        $sheet->setCellValue('D38', '=SUM(A38,B38,C38)');
        $sheet->setCellValue('D39', '=SUM(A39,B39,C39)');
        $sheet->setCellValue('D40', '=SUM(A40,B40,C40)');
        $sheet->setCellValue('D41', '=SUM(A41,B41,C41)');

        $lastRow = 41; // Row just before D42
        $sheet->setCellValue('D42', '=SUM(D37:D' . $lastRow . ')');

        // $sheet->setCellValue('D43', '=SUM(D18,D33,D42)');
        $sheet->setCellValue('D43', '=SUM(D18,D33)-D42');

        $denominationValues = [1000, 500, 200, 100, 50, 20, 10, 5, 1, 0.25];

        for ($row = 8; $row <= 17; $row++) {
            $index = $row - 8;

            // Set fixed H (denomination)
            $sheet->setCellValue('G' . $row, $denominationValues[$index]);
            $sheet->getStyle('G' . $row)->getNumberFormat()
                ->setFormatCode('#,##0.00');

            // Set formula in I = G * H (dynamic)
            $sheet->setCellValue('H' . $row, '=IF(F' . $row . '="","",F' . $row . '*G' . $row . ')');
            $sheet->getStyle('H' . $row)->getNumberFormat()
                ->setFormatCode('#,##0.00');
        }

        // Update total in I37
        $sheet->setCellValue('H18', '=SUM(H8:H17)');
        $sheet->getStyle('H18')->getNumberFormat()
            ->setFormatCode('#,##0.00');


        // // Output Excel
        // $writer = new Xlsx($spreadsheet);
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="DAILY_REPORT_' . $excelDateHeader . '.xlsx"');

        // $writer->save('php://output');

        $saveFolder = "C:/laragon/www/DAILY_REPORT";
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
        $this->db->where('b.status !=', '1');

        $query = $this->db->get();
        return $query->result_array();
    }

}
