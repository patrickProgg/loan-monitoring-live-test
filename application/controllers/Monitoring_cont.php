<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
            0 => 'a.id',
            1 => 'a.full_name',
            2 => 'a.address',
            3 => 'a.date_added',
            4 => 'contact_no',
            5 => 'loan_count'
        ];

        $orderColumn = $columns[$orderColumnIndex];

        $this->db->select('
            a.id,
            a.full_name,
            a.address,
            a.date_added,
            a.contact_no_1,
            a.contact_no_2,
            CONCAT(a.contact_no_1, " | ", a.contact_no_2) AS contact_no,
            COUNT(b.id) AS loan_count
        ');

        $this->db->from('tbl_client as a');
        $this->db->join('tbl_loan as b', 'b.cl_id = a.id', 'left');

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

}
