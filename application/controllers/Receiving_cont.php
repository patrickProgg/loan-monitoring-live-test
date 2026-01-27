<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Receiving_cont extends CI_Controller
class Receiving_cont extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Receiving_mod');
    }

    public function fetch_data_header()
    {
        $search = $this->input->post('search');
        $startDate  = $this->input->post('startDate'); 
		$endDate    = $this->input->post('endDate');   

        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-01'); 
            $endDate   = date('Y-m-t');  
        }

        $vendor = $this->Receiving_mod->get_data_header_from_nav($startDate, $endDate);

        $existing_docnos = $this->db->select('doc_no')->from('purch_rcpt_header')->get()->result_array();
        $existing_docnos = array_column($existing_docnos, 'doc_no');
    
        $vendor = array_filter($vendor, function($v) use ($existing_docnos) {
            return !in_array($v['doc_no'], $existing_docnos);
        });


        if (!empty($search)) {
            $search = strtolower($search); 
            $vendor = array_filter($vendor, function ($row) use ($search) {
                return 
                    (isset($row['doc_no']) && stripos($row['doc_no'], $search) !== false) ||
                    (isset($row['vendor_code']) && stripos($row['vendor_code'], $search) !== false) ||
                    (isset($row['posting_date']) && stripos($row['posting_date'], $search) !== false) ||
                    (isset($row['vendor_name']) && stripos($row['vendor_name'], $search) !== false);
            });
        }
        

        $recordsFiltered = count($vendor);

        // Paginate
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $data = array_slice($vendor, $start, $length);

        echo json_encode([
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => count($vendor),
            'recordsFiltered' => $recordsFiltered,
            'data' => array_values($data)
        ]);
    }

    public function upload_data_lines()
    {
        $data = $this->input->post('data');

        $data_lines = $this->Receiving_mod->get_data_lines_from_nav($data['doc_no']);
        
        $data_header = [
            'doc_no'       => $data['doc_no'],
            'vendor_code'  => $data['vendor_code'],
            'vendor_name'  => $data['vendor_name'],
            'posting_date' => $data['posting_date'],
            'pr_type'      => "purchase receipt",
            'upload_date'  => date('Y-m-d'),
            'upload_by'    => $this->session->userdata('user_id')
        ];
        
        $this->db->insert('purch_rcpt_header', $data_header);

        $header_id = $this->db->insert_id();

        foreach ($data_lines as $line) {
            $line_data = [
                'prhd_id'      => $header_id,       
                'item_code'      => $line['item_code'],
                'item_desc'    => $line['item_desc'],
                'item_uom'     => $line['item_uom'],
                'item_qty'       => $line['item_qty'],
            ];
        
            $this->db->insert('purch_rcpt_line', $line_data);
        }

        echo json_encode(['status' => "success"]);

    }
    
    // public function fetch_txt_files()
    // {
    //     $directory = '\\\\172.16.161.206\\MMS_Txt\\WMS_urc';
    //     $username = 'public';
    //     $password = 'public';

    //     $cmd = 'net use ' . $directory . ' /user:' . $username . ' ' . $password . ' >nul 2>&1';
    //     exec($cmd);

    //     $allFiles = [];

    //     if (is_dir($directory)) {
    //         foreach (scandir($directory) as $file) {
    //             if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
    //                 $allFiles[] = [
    //                     'filename' => $file,
    //                     'path'     => $directory . '\\' . $file
    //                 ];
    //             }
    //         }
    //     }

    //     $search = $this->input->post('search');

    //     if (!empty($search)) {
    //         $allFiles = array_filter($allFiles, function ($file) use ($search) {
    //             return stripos($file['filename'], $search) !== false;
    //         });
    //     }

    //     $recordsFiltered = count($allFiles);

    //     // Paginate
    //     $start = intval($this->input->post('start'));
    //     $length = intval($this->input->post('length'));
    //     $data = array_slice($allFiles, $start, $length);

    //     // Return response
    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode([
    //             'draw' => intval($this->input->post('draw')),
    //             'recordsTotal' => count($allFiles),
    //             'recordsFiltered' => $recordsFiltered,
    //             'data' => array_values($data)
    //         ]));
    // }

    public function fetch_txt_files_header()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? (int)$order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) && in_array(strtolower($order[0]['dir']), ['asc', 'desc']) ? $order[0]['dir'] : 'asc';

            $data = $this->Receiving_mod->getData($start, $length, $column_index, $sort_direction, $search);

            foreach ($data['data'] as &$row) {
                $user = $this->Receiving_mod->getUser($row['upload_by']);
                $row['uploader'] = $user; // e.g., 'John Doe'
            }

            $response = [
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }


    // public function move_txt_file()
    // {
    //     $data = $this->input->post('data');

    //     $baseDir = '\\\\172.16.161.206\\MMS_Txt\\WMS_urc';
    //     $source = $baseDir . '\\' . $filename;
    //     $destinationDir = $baseDir . '\\uploaded';
    //     $destination = $destinationDir . '\\' . $filename;

    //     $username = 'public';
    //     $password = 'public';

    //     $dateTimeNow = date('Y-m-d H:i:s');
    //     $user_id = $this->session->userdata('user_id');

    //     $cmd = 'net use ' . $baseDir . ' /user:' . $username . ' ' . $password . ' >nul 2>&1';
    //     exec($cmd);

    //     if (!file_exists($source)) {
    //         echo json_encode(['status' => 'error', 'message' => 'File not found.']);
    //         return;
    //     }

    //     $lines = file($source, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    //     if (!$lines || count($lines) < 2) {
    //         echo json_encode(['status' => 'error', 'message' => 'File has invalid format.']);
    //         return;
    //     }

    //     $rawHeader = trim($lines[0]);
    //     $header = explode('"|"', $rawHeader);
    //     $header[0] = ltrim($header[0], '"');
    //     $header[count($header) - 1] = rtrim($header[count($header) - 1], '"');
    //     $header = array_map('trim', $header);

    //     $doc_no = $header[0];

    //     $exists = $this->db
    //         ->where('doc_no', $doc_no)
    //         ->count_all_results('purch_rcpt_header');

    //     if ($exists > 0) {
    //         if (!is_dir($destinationDir)) {
    //             mkdir($destinationDir, 0777, true);
    //         }

    //         if (!rename($source, $destination)) {
    //             echo json_encode(['status' => 'warning', 'message' => 'File already exists in DB. Failed to move file.']);
    //             return;
    //         }

    //         echo json_encode(['status' => 'info', 'message' => 'File already exists in DB. File moved only.']);
    //         return;
    //     }


    //     if (count($header) < 4) {
    //         echo json_encode(['status' => 'error', 'message' => 'Header format invalid.']);
    //         return;
    //     }

    //     $headerData = [
    //         'doc_no'        => $header[0],
    //         'vendor_code'   => $header[1],
    //         'vendor_name'   => $header[2],
    //         'posting_date'  => date('Y-m-d', strtotime($header[3])),
    //         'upload_date'   => $dateTimeNow,
    //         'upload_by'     => $user_id,
    //     ];

    //     $this->db->trans_start();

    //     $insertHeader = $this->db->insert('purch_rcpt_header', $headerData);

    //     if (!$insertHeader) {
    //         echo json_encode(['status' => 'error', 'message' => 'Header not inserted.']);
    //         return;
    //     }

    //     $prhd_id = $this->db->insert_id();

    //     $lineData = [];

    //     for ($i = 2; $i < count($lines); $i++) {
    //         $rawLine = trim($lines[$i]);

    //         if ($rawLine === '') continue;

    //         $line = explode('"|"', $rawLine);
    //         $line[0] = ltrim($line[0], '"');
    //         $line[count($line) - 1] = rtrim($line[count($line) - 1], '"');
    //         $line = array_map('trim', $line);

    //         $expiry = !empty($line[5]) ? date('Y-m-d', strtotime($line[5])) : '0000-00-00';

    //         if (count($line) < 6) {
    //             continue;
    //         }

    //         $lineData[] = [
    //             'prhd_id'     => $prhd_id,
    //             'item_code'   => $line[0],
    //             'item_desc'   => $line[1],
    //             'item_uom'    => $line[2],
    //             'item_qty'    => $line[3],
    //             'lot_no'      => $line[4],
    //             'expiry_date' =>  $expiry
    //         ];
    //     }

    //     $this->db->insert_batch('purch_rcpt_line', $lineData);

    //     $this->db->trans_complete();

    //     if ($this->db->trans_status() === FALSE) {
    //         echo json_encode(['status' => 'error', 'message' => 'Transaction failed.']);
    //         return;
    //     }

    //     if (!is_dir($destinationDir)) {
    //         mkdir($destinationDir, 0777, true);
    //     }

    //     if (!rename($source, $destination)) {
    //         echo json_encode(['status' => 'warning', 'message' => 'Data saved but failed to move file.']);
    //         return;
    //     }

    //     echo json_encode([
    //         'status'  => 'success',
    //         'message' => 'File processed and moved successfully.',
    //         'doc_no'  => $header[0],
    //         'lines'   => count($lines) - 1
    //     ]);
    // }

    public function fetch_lines()
    {
        $prhd_id = $this->input->post('id');
        $limit   = $this->input->post('length');
        $start   = $this->input->post('start');
        $search  = $this->input->post('search')['value'];
        $draw    = intval($this->input->post('draw'));

        $order_column_index = $this->input->post('order')[0]['column'];
        $order_column_dir   = $this->input->post('order')[0]['dir'];

        $columns = [
            0 => 'item_code',
            1 => 'item_desc',
            2 => 'item_uom',
            3 => 'item_qty',
            4 => 'status',
            5 => 'expiry_date'
        ];
        $order_column = isset($columns[$order_column_index]) ? $columns[$order_column_index] : 'item_code';

        $this->db->from('purch_rcpt_line');
        $this->db->where('prhd_id', $prhd_id);

        if (!empty($search)) {
            $this->db->group_start()
                ->like('item_code', $search)
                ->or_like('item_desc', $search)
                ->or_like('item_uom', $search)
                ->or_like('status', $search)
                ->or_like('expiry_date', $search)
                ->group_end();
        }

        $filtered_query = clone $this->db;
        $recordsFiltered = $filtered_query->count_all_results();

        $this->db->order_by($order_column, $order_column_dir);
        $this->db->limit($limit, $start);

        $query = $this->db->get();
        $data = $query->result_array();

        $this->db->from('purch_rcpt_line');
        $this->db->where('prhd_id', $prhd_id);
        $recordsTotal = $this->db->count_all_results();

        echo json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        ]);
    }

    function getUser()
    {
        $id = $this->input->post('user_id');
        $uploader = $this->Receiving_mod->getUser($id);

        echo json_encode($uploader);
    }

    function update_expiry_date()
    {
        $prln_id = $this->input->post('prln_id');
        $expiry_date   = $this->input->post('expiry_date');
        
        $this->db->where('prln_id', $prln_id);
        $this->db->update('purch_rcpt_line', ['expiry_date' => $expiry_date]);

        echo json_encode(['status' => "success"]);
    }
}
