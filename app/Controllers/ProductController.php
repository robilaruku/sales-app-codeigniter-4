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
        $productModel = $this->productModel;
        $productModel->select('products.*, c.name category_name');
        $productModel->join('categories c', 'products.category_id = c.id');

        $products = $productModel->findAll();

        $data = [
            'products' => $products
        ];

        return view('admin/product/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
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

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
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

        /* 
            Jika validasi gagal akan redirect ke halaman form input data product 
            dengan mengirim pesan error dan input terakhir user. 
            simpan data tidak akan dilanjutkan
        */
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $image = $this->request->getFile('image'); // Ambil file upload dari input file form
        $filename = $image->getRandomName(); // Generate nama file gambar

        $data = $this->request->getVar(); // Ambil semua nilai dari input form
        $data['image'] = $filename; // Isi nilai image berdasarkan generate nama file
        $this->productModel->insert($data); // Simpan data ke database

        $image->move('img/uploads', $filename); // Upload gambar ke folder img/uploads

        return "data saved";
        // return redirect()->to('admin/product')->with('message', 'Product has been added');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
