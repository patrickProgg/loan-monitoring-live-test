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

        $order = $this->input->post('order');
        $orderColumnIndex = isset($order[0]['column']) ? $order[0]['column'] : 0;
        $orderDir = isset($order[0]['dir']) ? $order[0]['dir'] : 'DESC';

        $columns = [
            0 => 'date_added',
            1 => 'process_fee',
            2 => 'ticket',
            3 => 'profit_share',
            4 => 'pull_out',
            5 => 'total_pull_out'
        ];

        $orderColumn = $columns[$orderColumnIndex];

        $this->db->select('
           id,
           date_added,
           process_fee,
           ticket,
           profit_share,
           pull_out,
           total_pull_out
        ');

        $this->db->from('tbl_pull_out ');

        if (!empty($searchValue)) {
            $this->db->group_start();
        $this->db->like('id', $searchValue);
            $this->db->or_like('date_added' , $searchValue);
            $this->db->or_like('process_fee' , $searchValue);
            $this->db->or_like('ticket' , $searchValue);
            $this->db->or_like('profit_share' , $searchValue);
            $this->db->or_like('pull_out' , $searchValue);
            $this->db->or_like('total_pull_out' , $searchValue);
            $this->db->group_end();
        }

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

    public function add_pull_out()
    {
        $pull_out_details = array(
            'process_fee'     => $this->input->post('process_fee'),
            'ticket'       => $this->input->post('ticket'),
            'profit_share'  => $this->input->post('profit'),
            'pull_out'  => $this->input->post('pull_out'),
            'total_pull_out'    => $this->input->post('total_amt'),
            'date_added'    => $this->input->post('date_added'),
        );

        $inserted = $this->db->insert('tbl_pull_out', $pull_out_details);


        if (!$inserted) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to add pull out record.'
            ]);
        } else {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Pull out saved successfully.',
            ]);
        }
    }

    public function update_pull_out($id)
    {
        $pull_out_details = array(
            'process_fee'     => $this->input->post('process_fee'),
            'ticket'       => $this->input->post('ticket'),
            'profit_share'  => $this->input->post('profit'),
            'pull_out'  => $this->input->post('pull_out'),
            'total_pull_out'    => $this->input->post('total_amt'),
            'date_added'    => $this->input->post('date_added'),
        );

        $this->db->where('id',  $id );
        $updated = $this->db->update('tbl_pull_out', $pull_out_details);


        if (!$updated) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to update pull out record.'
            ]);
        } else {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Pull out data updated successfully.',
            ]);
        }
    }
}