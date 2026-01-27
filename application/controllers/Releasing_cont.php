<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Receiving_cont extends CI_Controller
class Releasing_cont extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Receiving_mod');
    }

    public function fetch_data_header()
    {
        $start = $this->input->post('start');
		$length = $this->input->post('length');
		$searchValue = trim($this->input->post('search')['value']);

        $this->db->select('
            a.ordhd_id,
            a.document_no,
            a.customer_name,
            a.posting_date,
            a.status,
            a.upload_date,
            b.fullname
        ');

        $this->db->from('order_header as a');
        $this->db->join('users as b', 'b.user_id = a.upload_by', 'left');

        $this->db->order_by('a.ordhd_id', 'DESC');

        if (!empty($searchValue)) {
			$this->db->group_start();
			$this->db->like('a.document_no', $searchValue);
			$this->db->or_like('a.customer_name', $searchValue);
			$this->db->or_like('a.posting_date', $searchValue);
			$this->db->or_like('a.status', $searchValue);
			$this->db->or_like('a.upload_date', $searchValue);
			$this->db->group_end();
		}

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
}
