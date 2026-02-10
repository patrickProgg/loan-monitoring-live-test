<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenses_cont extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_expenses()
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
            2 => 'type',
            3 => 'amt'
        ];

        $orderColumn = $columns[$orderColumnIndex];

        $this->db->select('
           id,
           type,
           amt,
           date_added
        ');

        if ($history) {
            $this->db->where('status', '1');
        } else {
            $this->db->where('status', '0');
        }

        $this->db->from('tbl_expenses');

        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('DATE(a.date_added) >=', $startDate);
            $this->db->where('DATE(a.date_added) <=', $endDate);
        }

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('type', $searchValue);
            $this->db->or_like('amt', $searchValue);
            $this->db->or_like('date_added', $searchValue);
            $this->db->group_end();
        }

        $this->db->order_by($orderColumn, $orderDir);

        $subQuery = clone $this->db;
        $recordsFiltered = $subQuery->get()->num_rows();

        $this->db->limit($length, $start);

        $query = $this->db->get();
        $data = $query->result_array();

        $this->db->select_sum('amt');

        $this->db->where('status !=', '1');
        $this->db->from('tbl_expenses');

        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('type', $searchValue);
            $this->db->or_like('amt', $searchValue);
            $this->db->or_like('date_added', $searchValue);
            $this->db->group_end();
        }

        $totalRow = $this->db->get()->row();
        $totalAmount = $totalRow->amt ?? 0;

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $recordsFiltered,
            "recordsFiltered" => $recordsFiltered,
            "total_amt" => $totalAmount,
            "data" => $data
        ]);
    }

    public function add_expenses()
    {
        $expenses = $this->input->post('expenses');
        $date = $this->input->post('date');

        $all_inserted = true;

        foreach ($expenses as $exp) {
            $data = [
                'type' => $exp['type'],
                'amt' => $exp['amt'],
                'date_added' => $date
            ];

            $inserted = $this->db->insert('tbl_expenses', $data);
            if (!$inserted) {
                $all_inserted = false;
                break;
            }
        }

        if (!$all_inserted) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add expenses.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Expenses saved successfully.'
            ]);
        }
    }
    public function update_expenses($id)
    {
        $expenses = $this->input->post('expenses');
        $date = $this->input->post('date');

        foreach ($expenses as $exp) {
            $data = [
                'type' => $exp['type'],
                'amt' => $exp['amt'],
                'date_added' => $date
            ];

            $this->db->where('id', $id);
            $updated = $this->db->update('tbl_expenses', $data);
        }

        if (!$updated) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update expenses record.'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Expenses data updated successfully.',
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
        $updated = $this->db->update('tbl_expenses', $data);

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