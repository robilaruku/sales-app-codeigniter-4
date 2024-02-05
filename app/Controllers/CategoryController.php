<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class CategoryController extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();

        $categories = $categoryModel->findAll();

        return view('admin/category/index', [
            'categories' => $categories
        ]);
    }

    public function new()
    {
        return view('admin/category/new');
    }

    public function store()
    {
        // Setting rule untuk validasi request input
        $rules = [
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|in_list[active,inactive]']
        ];

        // Setting pesan error validasi
        $message = [
            'name' => ['required' => 'please fill the {field} field'],
            'status' => [
                'required' => 'please fill the {field} field',
                'in_list' => 'Choose one from {field}'
            ]
        ];

        if (!$this->validate($rules, $message)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'status' => $this->request->getVar('status'),
        ];

        $categoryModel = new CategoryModel();
        $categoryModel->insert($data);

        return redirect()->to('/admin/category')->with('message', 'Caetgory Successfully Saved');
    }

    public function show($id = null)
    {
        $category = new CategoryModel();

        $category = $category->find($id);

        if (!$category) {
            return redirect()->to('/admin/category')->with('error', 'Category Not Found');
        }

        return view('admin/category/show', [
            'category' => $category
        ]);
    }

    public function edit($id = null)
    {
        $category = new CategoryModel();

        $category = $category->find($id);

        if (!$category) {
            return redirect()->to('/admin/category')->with('error', 'Category Not Found');
        }

        return view('admin/category/edit', [
            'category' => $category
        ]);
    }

    public function update($id = null)
    {
        $categoryModel = new CategoryModel();

        $category = $categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/admin/category')->with('error', 'Category Not Found');
        }

        // Setting rule untuk validasi request input
        $rules = [
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|in_list[active,inactive]']
        ];

        // Setting pesan error validasi
        $message = [
            'name' => ['required' => 'please fill the {field} field'],
            'status' => [
                'required' => 'please fill the {field} field',
                'in_list' => 'Choose one from {field}'
            ]
        ];

        if (!$this->validate($rules, $message)) {
            return redirect()->back()->withInput();
        }

        // Validasi sukses dan menyiapkan data untuk dikirim ke database
        $data = [
            'name' => $this->request->getVar('name'),
            'status' => $this->request->getVar('status'),
        ];

        $categoryModel = new CategoryModel();
        $categoryModel->update($category['id'], $data);

        return redirect()
            ->to('admin/category')
            ->with('message', 'Category has been updated');
    }

    public function delete($id = null)
    {
        $categoryModel = new CategoryModel();

        $category = $categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/admin/category')->with('error', 'Category Not Found');
        }

        $categoryModel->delete($category['id']);

        return redirect()->to('admin/category')
            ->with('message', 'Category successfully deleted');
    }
}
