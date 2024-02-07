<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\ProductModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransactionController extends BaseController
{
    public function index()
    {
        $perPage = 5;

        $trx_date = $this->request->getVar('trx_date');
        $product_id = $this->request->getVar('product_id');

        $transactionModel = new TransactionModel();
        $transactionModel->select('transactions.*, p.name product_name');
        $transactionModel->join('Products p', 'transactions.product_id = p.id');

        if (!empty($product_id)) {
            $transactionModel->where('transactions.product_id', $product_id);
        }
        if (!empty($trx_date)) {
            $transactionModel->where('transactions.trx_date', $trx_date);
        }

        $transactions = $transactionModel->paginate($perPage);
        $pager = $transactionModel->pager;

        // Ambil semua data table categories
        $productModel = new ProductModel;
        $products = $productModel->findAll();

        // Ambil data halaman
        $currentPage = $pager->getCurrentPage();

        // Ambil total data
        $perPage = $pager->getPerPage();
        
        // Ambil nomor awal
        $startNumber = ($currentPage - 1) * $perPage + 1;

        $data = [
            'transactions' => $transactions,
            'pager' => $pager,
            'products' => $products,
            'product_id' => $product_id,
            'trx_date' => $trx_date,
            'startNumber' => $startNumber
        ];
        
        return view('admin/transaction/index', $data);
    }

    public function new()
    {
        return view('admin/transaction/new');
    }

    public function import()
    {
        // Setting rules validasi
        $rules = [
            'excel' => ['label' => 'File', 'rules' => 'uploaded[excel]|ext_in[excel,xls,xlsx]'],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/trx/new')->withInput();
        }

        $excel = $this->request->getFile('excel');
        $extension = $excel->getClientExtension();
        if ($extension == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls;
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        }

        $spreadsheet = $render->load($excel);
        $transactions = $spreadsheet->getActiveSheet()->toArray();

        foreach ($transactions as $index => $transaction) {
            // Skip baris header
            if ($index == 0) {
                continue;
            }

            $data = [
                'product_id' => $transaction[0],
                'trx_date' => $transaction[1],
                'price' => $transaction[2],
            ];

            $transactionModel = new TransactionModel();
            $transactionModel->insert($data);
        }

        // return "data imported";
        return redirect('admin/trx')->with('message', 'Transaction has been imported');
    }

    public function export()
    {
        $transactionModel = new TransactionModel();
        $transactionModel->select('transactions.*, p.name product_name');
        $transactionModel->join('Products p', 'transactions.product_id = p.id');
        $transactions = $transactionModel->findAll();

        $spreadsheet = new Spreadsheet();

        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Product')
            ->setCellValue('C1', 'Date')
            ->setCellValue('D1', 'Price');

        $column = 2;

        // tulis data mobil ke cell
        foreach ($transactions as $x => $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $x + 1)
                ->setCellValue('B' . $column, $data['product_name'])
                ->setCellValue('C' . $column, $data['trx_date'])
                ->setCellValue('D' . $column, $data['price']);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'data_transaction_' . date('Y-m-d_H-i-s');

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');

        $writer->save('php://output');
    }
}
