<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $month = [];
        $total = [];
        
        // Ambil data transaction menggunakan query builder
        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $builder->select('MONTHNAME(trx_date) month, sum(product_id) total')
            ->groupBy('MONTHNAME(trx_date)')
            ->orderBy('MONTH(trx_date)');

        /**
         * Hasil yang didapat field month dan total 
         * dalam bentuk array multidimensi
         */
        $result = $builder->get()->getResultArray();

        // Mengelompokkan hasil array kedalam variabel masing2
        foreach ($result as $transaction) {
            $month[] = $transaction['month'];
            $total[] = $transaction['total'];
        }

        // Ambil data 3 terakhir dari tabel transactions
        $transactions = $builder->select('transactions.*, p.name product_name')
                                ->join('products p', 'transactions.product_id = p.id')
                                ->orderBy('transactions.trx_date', 'DESC')
                                ->get(3)
                                ->getResultArray();

        $chart = [
            'months' => $month,
            'totals' => $total,
            'transactions' => $transactions
        ];

        return view('admin/dashboard', $chart);
    }
}
