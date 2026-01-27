<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Masterfile_cont extends CI_Controller
class Masterfile_cont extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('Masterfile_mod');
    }

    public function extract_from_nav()
    {
        $vendor = $this->Masterfile_mod->get_vendorCode_from_nav();
        $items = $this->Masterfile_mod->get_items_from_nav($vendor);

        $item_codes = [];

        foreach ($items as $item) {
            if (!isset($item['item_code'])) continue;

            $item_code = $item['item_code'];
            $item_codes[] = $item_code;

            $this->db->where('item_code', $item_code);
            $exists = $this->db->get('item_masterfile')->row();

            if ($exists) continue;

            $data = [
                'item_code' => $item['item_code'],
                'item_desc' => $item['item_desc'],
                'vend_code' => $item['vend_code']
            ];
            $this->db->insert('item_masterfile', $data);
        }

        $barcodes = $this->Masterfile_mod->get_barcodeCode_from_nav($item_codes);

        foreach ($barcodes as $data) {
            $item_code = $data['item_code'];
            $barcode = $data['barcode'];
            $uom = $data['uom'];

            $this->db->where('item_code', $item_code);
            $this->db->where('barcode', $barcode);
            $this->db->where('uom', $uom);
            $query = $this->db->get('item_barcodes');

            if ($query->num_rows() == 0) {
                // Not found, insert it
                $this->db->insert('item_barcodes', [
                    'barcode' => $barcode,
                    'item_code' => $item_code,
                    'uom' => $uom
                ]);
            } else {
                continue;
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Items and barcodes inserted successfully.']);
    }


    public function get_items()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order = $this->input->post('order');
            $search = $this->input->post('search');

            $column_index = isset($order[0]['column']) ? $order[0]['column'] : 0;
            $sort_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';

            $data = $this->Masterfile_mod->getData($start, $length, $column_index, $sort_direction, $search);

            $response = [
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => $data['total_records'],
                "recordsFiltered" => $data['filtered_records'],
                "data" => $data['data']
            ];
            echo json_encode($response);
        }
    }

    public function syncItemCode_from_nav()
    {
        if ($this->input->is_ajax_request()) {
            $item_code = $this->input->post('item_code');


            if (!$item_code) {
                echo json_encode(['status' => 'error', 'message' => 'No item_code provided.']);
                return;
            }

            $item_data = $this->Masterfile_mod->update_items_from_nav($item_code);
            if (empty($item_data)) {
                echo json_encode(['status' => 'error', 'message' => 'Item not found in NAV.']);
                return;
            }

            $update_item = [
                'item_desc' => $item_data['item_desc']
            ];

            $this->db->where('item_code', $item_code);
            $this->db->update('item_masterfile', $update_item);

            $barcodes = $this->Masterfile_mod->get_barcodeCode_from_nav([$item_code]);

            foreach ($barcodes as $data) {
                $item_code = $data['item_code'];
                $barcode = $data['barcode'];
                $uom = $data['uom'];

                $this->db->where('item_code', $item_code);
                $this->db->where('barcode', $barcode);
                $this->db->where('uom', $uom);
                $query = $this->db->get('item_barcodes');

                if ($query->num_rows() == 0) {
                    $this->db->insert('item_barcodes', [
                        'barcode' => $barcode,
                        'item_code' => $item_code,
                        'uom' => $uom
                    ]);
                } else {
                    continue;
                }
            }

            echo json_encode(['status' => 'success', 'message' => 'Item and barcode synced successfully.']);
        }
    }

    function getLineData()
    {
        if ($this->input->is_ajax_request()) {
            $item_code = $this->input->post('item_code');
            $limit   = $this->input->post('length');
            $start   = $this->input->post('start');
            $search  = $this->input->post('search')['value'];
            $draw    = intval($this->input->post('draw'));

            $order_column_index = $this->input->post('order')[0]['column'];
            $order_column_dir   = $this->input->post('order')[0]['dir'];

            // Define columns mapping
            $columns = [
                0 => 'barcode',
                1 => 'uom'
            ];
            $order_column = isset($columns[$order_column_index]) ? $columns[$order_column_index] : 'barcode';

            // Base query
            $this->db->from('item_barcodes');
            $this->db->where('item_code', $item_code);

            if (!empty($search)) {
                $this->db->group_start()
                    ->like('barcode', $search)
                    ->or_like('uom', $search)
                    ->group_end();
            }

            // Filtered count
            $filtered_query = clone $this->db;
            $recordsFiltered = $filtered_query->count_all_results();

            // Ordering and limit
            $this->db->order_by($order_column, $order_column_dir);
            $this->db->limit($limit, $start);

            $query = $this->db->get();
            $data = $query->result_array();

            // var_dump($data);

            // Total count
            $this->db->from('item_barcodes');
            $this->db->where('item_code', $item_code);
            $recordsTotal = $this->db->count_all_results();

            // Response
            echo json_encode([
                'draw'            => $draw,
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data
            ]);
        }
    }

    public function generate_pdf_barcode()
    {
        ob_start();
        $title = "WMS-URC Item Barcode";
        $barcode = $this->input->post('barcode');

        $this->ppdf = new TCPDF('L', 'mm', array(70, 70), true, 'UTF-8', false);
        $this->ppdf->SetTitle($title . ' ' . $barcode);
        $this->ppdf->SetMargins(5, 10, 5); // Adjusted for better layout
        $this->ppdf->setPrintHeader(false);
        $this->ppdf->setPrintFooter(false);
        $this->ppdf->AddPage();

        // Barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => true,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 12,
        );

        // Write 1D barcode (e.g., CODE128)
        $this->ppdf->Ln(5);
        $this->ppdf->write1DBarcode($barcode, 'C128', '', '', '', 30, 0.6, $style, 'C');

        // Output PDF
        ob_clean();
        $this->ppdf->Output("{$title} {$barcode}.pdf", 'I'); // I = inline
        exit;
    }
}
