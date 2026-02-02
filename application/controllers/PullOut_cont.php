<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PullOut_cont extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_pull_out()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchValue = trim($this->input->post('search')['value']);
        $history = $this->input->post('history');

        $order = $this->input->post('order');
        $orderColumnIndex = isset($order[0]['column']) ? $order[0]['column'] : 0;
        $orderDir = isset($order[0]['dir']) ? $order[0]['dir'] : 'DESC';

        $columns = [
            0 => 'id',
            1 => 'date_added',
            2 => 'process_fee',
            3 => 'ticket',
            4 => 'profit_share',
            5 => 'pull_out',
            6 => 'pull_out_capital',
            7 => 'total_pull_out'
        ];

        $orderColumn = $columns[$orderColumnIndex];

        $this->db->select('
            id, 
            date_added, 
            process_fee, 
            ticket, 
            profit_share, 
            pull_out, 
            pull_out_capital,
            total_pull_out
        ');

        if ($history) {
            $this->db->where('status', '1');
        } else {
            $this->db->where('status', '0');
        }

        $this->db->from('tbl_pull_out');

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('id', $searchValue);
            $this->db->or_like('date_added', $searchValue);
            $this->db->or_like('process_fee', $searchValue);
            $this->db->or_like('ticket', $searchValue);
            $this->db->or_like('profit_share', $searchValue);
            $this->db->or_like('pull_out', $searchValue);
            $this->db->or_like('total_pull_out', $searchValue);
            $this->db->group_end();
        }

        $this->db->order_by($orderColumn, $orderDir);

        $subQuery = clone $this->db;
        $recordsFiltered = $subQuery->get()->num_rows();

        $this->db->limit($length, $start);

        $query = $this->db->get();
        $data = $query->result_array();

        $this->db->select_sum('process_fee');
        $this->db->select_sum('ticket');
        $this->db->select_sum('profit_share');
        $this->db->select_sum('pull_out');
        $this->db->select_sum('pull_out_capital');
        $this->db->select_sum('total_pull_out');

        $this->db->where('status !=', '1');
        $this->db->from('tbl_pull_out');

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('id', $searchValue);
            $this->db->or_like('date_added', $searchValue);
            $this->db->or_like('process_fee', $searchValue);
            $this->db->or_like('ticket', $searchValue);
            $this->db->or_like('profit_share', $searchValue);
            $this->db->or_like('pull_out', $searchValue);
            $this->db->or_like('total_pull_out', $searchValue);
            $this->db->group_end();
        }

        $totalRow = $this->db->get()->row();
        $totalFee = $totalRow->process_fee ?? 0;
        $totalTicket = $totalRow->ticket ?? 0;
        $totalProfit = $totalRow->profit_share ?? 0;
        $totalPullOut = $totalRow->pull_out ?? 0;
        $totalPullOutCapital = $totalRow->pull_out_capital ?? 0;
        $totalAmount = $totalRow->total_pull_out ?? 0;

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $recordsFiltered,
            "recordsFiltered" => $recordsFiltered,
            "total_fee" => $totalFee,
            "total_ticket" => $totalTicket,
            "total_profit" => $totalProfit,
            "total_pull_out" => $totalPullOut,
            "total_pull_out_capital" => $totalPullOutCapital,
            "total_amt" => $totalAmount,
            "data" => $data
        ]);
    }
    public function add_pull_out()
    {
        $pull_out_details = array(
            'process_fee' => $this->input->post('process_fee'),
            'ticket' => $this->input->post('ticket'),
            'profit_share' => $this->input->post('profit'),
            'pull_out' => $this->input->post('pull_out'),
            'pull_out_capital' => $this->input->post('pull_out_capital'),
            'total_pull_out' => $this->input->post('total_amt'),
            'date_added' => $this->input->post('date_added'),
        );

        $inserted = $this->db->insert('tbl_pull_out', $pull_out_details);


        if (!$inserted) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add pull out record.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pull out saved successfully.',
            ]);
        }
    }

    public function update_pull_out($id)
    {
        $pull_out_details = array(
            'process_fee' => $this->input->post('process_fee'),
            'ticket' => $this->input->post('ticket'),
            'profit_share' => $this->input->post('profit'),
            'pull_out' => $this->input->post('pull_out'),
            'pull_out_capital' => $this->input->post('pull_out_capital'),
            'total_pull_out' => $this->input->post('total_amt'),
            'date_added' => $this->input->post('date_added'),
        );

        $this->db->where('id', $id);
        $updated = $this->db->update('tbl_pull_out', $pull_out_details);


        if (!$updated) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update pull out record.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pull out data updated successfully.',
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
        $updated = $this->db->update('tbl_pull_out', $data);

        if (!$updated) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete expenses record.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Expenses data deleted successfully.',
            ]);
        }
    }
}