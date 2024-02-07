<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function index()
    {
        // Variabel $perPage untuk setting banyak data per halaman
        $perPage = 1;

        /**
         * Ambil nilai search dan filter product
         * dari method GET untuk filter data tampil
         */
        $search = $this->request->getVar('search');
        $category_id = $this->request->getVar('category_id');

        /**
         * Ambil semua data tabel products dan join tabel categories
         * untuk mendapatkan category_name tabel categories
         * berdasarkan category_id tabel products
         */
        $productModel = $this->productModel;
        $productModel->select('products.*, c.name category_name');
        $productModel->join('categories c', 'products.category_id = c.id');

        /**
         * Menerapkan filter dan search pada query builder
         * jika terdapat nilai $search dan $filter
         */
        if (!empty($category_id)) {
            $productModel->where('products.category_id', $category_id);
        }
        if (!empty($search)) {
            $productModel->like('products.name', $search, 'both');
        }

        $products = $productModel->paginate($perPage);
        $pager = $productModel->pager;

        // Ambil semua data table categories
        $categoryModel = new \App\Models\CategoryModel();
        $categories = $categoryModel->findAll();


        // Ambil data halaman
        $currentPage = $pager->getCurrentPage();

        // Ambil total data
        $perPage = $pager->getPerPage();

        // Ambil nomor awal
        $startNumber = ($currentPage - 1) * $perPage + 1;

        $data = [
            'products' => $products,
            'pager' => $pager,
            'categories' => $categories,
            'category_id' => $category_id,
            'search' => $search,
            'startNumber' => $startNumber
        ];


        return view('admin/product/index', $data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return ResponseInterface
     */
    public function new()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->builder()
            ->select("name, id")
            ->get()
            ->getResultArray();

        return view('admin/product/new', [
            'categories' => $categories
        ]);
    }

    public function show($id = null)
    {
        $productId = $this->productModel->find($id);

        if (!$productId) {
            return redirect()->to('/admin/product')->with('error', 'Product Not Found');
        }

        $builder = $this->productModel->builder();
        $builder->select('products.*, c.name category_name');
        $builder->join('categories c', 'products.category_id = c.id');
        $builder->where('products.id', $productId['id']);
        $product = $builder->get();
        $product = $product->getRowArray();

        return view('admin/product/show', ['product' => $product]);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        // Setting rule untuk validasi request input
        $rules = [
            'category_id' => ['label' => 'Category', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'sku' => ['label' => 'SKU', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|in_list[active,inactive]'],
            'image' => [
                'label' => 'Image',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                ]
            ],
            'description' => ['label' => 'Description', 'rules' => 'required'],
        ];

        // Setting pesan error validasi
        $message = [
            'name' => ['required' => 'please fill the {field} field'],
            'status' => [
                'required' => 'please fill the {field} field',
                'in_list' => 'Choose one from {field}'
            ]
        ];

        /* 
            Jika validasi gagal akan redirect ke halaman form input data product 
            dengan mengirim pesan error dan input terakhir user. 
            simpan data tidak akan dilanjutkan
        */
        if (!$this->validate($rules, $message)) {
            return redirect()->back()->withInput();
        }

        $image = $this->request->getFile('image'); // Ambil file upload dari input file form
        $filename = $image->getRandomName(); // Generate nama file gambar

        $data = $this->request->getVar(); // Ambil semua nilai dari input form
        $data['image'] = $filename; // Isi nilai image berdasarkan generate nama file
        $this->productModel->insert($data); // Simpan data ke database

        $image->move('img/uploads', $filename); // Upload gambar ke folder img/uploads

        return redirect()->to('admin/product')->with('message', 'Product has been added');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/product')->with('error', 'Product Not Found');
        }

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $data = [
            'product' => $product,
            'categories' => $categories,
        ];

        return view('admin/product/edit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $image = $this->request->getFile('image');

        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/product')->with('error', 'Product Not Found');
        }

        // Setting rule untuk validasi request input
        $rules = [
            'category_id' => ['label' => 'Category', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'sku' => ['label' => 'SKU', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|in_list[active,inactive]'],
            'description' => ['label' => 'Description', 'rules' => 'required'],
        ];

        /**
         * Cek, upload gambar / ganti gambar atau tidak
         * jika upload, akan diberi rules validasi
         */
        if ($image->isValid()) {
            $rules['image'] = [
                'label' => 'Image',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                ]
            ];

            // Ambil nilai input oldImage untuk hapus file
            $oldImage = $this->request->getVar('oldImage');
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = $this->request->getVar(); // Ambil semua nilai dari input form

        // Jika upload gambar baru
        if ($image->isValid()) {
            // Generate nama file gambar
            $filename = $image->getRandomName();

            // Isi nilai image berdasarkan generate nama file
            $data['image'] = $filename;

            // Hapus file / gambar lama jika ganti gambar
            unlink('img/uploads/' . $oldImage);

            // Upload gambar baru ke folder img/uploads
            $image->move('img/uploads', $filename);
        }

        $this->productModel->update($product['id'], $data); // Update data ke database

        return redirect()->to('admin/product')->with('message', 'Product has been updated');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/product')->with('error', 'Product Not Found');
        }

        // Ambil nama gambar lama dari tabel product
        $oldImage = $product['image'];

        // Hapus file / gambar lama
        unlink('img/uploads/' . $oldImage);

        // Hapus data dari database
        $this->productModel->delete($product['id']);

        return redirect('admin/product')->with('message', 'Product has been deleted');
    }
}
