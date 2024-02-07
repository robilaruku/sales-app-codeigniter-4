<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthenticationController extends BaseController
{
    public function index()
    {
        return view('admin/index');
    }

    public function register()
    {
        // Validasi input form
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect('register')->withInput();
        }

        // tampung semua nilai input setelah validasi sukses
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),

            // Enkripsi password
            'password' => hash('md5', $this->request->getVar('password')),
        ];

        // Input data ke tabel user menggunakan  query builder
        $db = \Config\Database::connect();
        $usersTable = $db->table('users');
        $usersTable->insert($data);

        return redirect('/')->with('message', 'Create account successfully, please login !');
    }

    public function login()
    {
        // Validasi input form
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect('/')->withInput();
        }

        $email = $this->request->getVar('email');
        $password = hash('md5', $this->request->getVar('password'));

        // Cari data dari tabel users berdasar input form
        $db = \Config\Database::connect();
        $usersTable = $db->table('users');
        $usersTable->where('email', $email)
                   ->where('password', $password);
                
        $user = $usersTable->get()->getRowArray();

        // Jika data tidak ditemukan maka akan kembali ke halaman login
        if (empty($user)) {
            return redirect('/')->with('error', 'Login failed !');
        }

        // User ditemukan, Set session login
        $user['login'] = true;

        // Set session['user'] untuk menampung data user
        session()->set($user);
        
        // jika data ditemukan akan masuk ke halaman home.php
        return redirect()->to('admin');
    }

    public function logout() 
    {
        session_unset();
        session()->destroy();

        return redirect()->to('/');
    }
}
