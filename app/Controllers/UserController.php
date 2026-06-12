<?php

namespace App\Controllers;

use App\Models\UserModel;
use Hermawan\DataTables\DataTable;

class UserController extends BaseController
{
    public function index()
    {
        return view('admin/users');
    }

    public function ajaxList()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users')->select('id, name, email, role');

        return DataTable::of($builder)
            ->add('action', function($row) {
                // Prevent self-deletion
                $deleteBtn = '';
                if ($row->id != session()->get('id')) {
                    $deleteBtn = '<button class="btn btn-sm btn-danger delete-btn rounded-3" data-id="' . $row->id . '" data-name="' . esc($row->name) . '"><i class="bi bi-trash"></i> Hapus</button>';
                }
                return '
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-warning edit-btn rounded-3" data-id="' . $row->id . '" data-name="' . esc($row->name) . '" data-email="' . esc($row->email) . '" data-role="' . $row->role . '"><i class="bi bi-pencil-square"></i> Edit</button>
                        ' . $deleteBtn . '
                    </div>
                ';
            })
            ->toJson(true);
    }

    public function store()
    {
        $userModel = new UserModel();

        $rules = [
            'name'     => 'required|min_length[3]|max_length[255]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,member]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ];

        if ($userModel->save($data)) {
            return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan pengguna.');
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'role' => 'required|in_list[admin,member]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id'    => $id,
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Prevent self-role modification to non-admin
        if ($id == session()->get('id') && $data['role'] !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role admin Anda sendiri.');
        }

        if ($userModel->save($data)) {
            // Update current user name session if changed
            if ($id == session()->get('id')) {
                session()->set('name', $data['name']);
                session()->set('email', $data['email']);
            }
            return redirect()->back()->with('success', 'Data pengguna berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Gagal mengubah data pengguna.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();

        if ($id == session()->get('id')) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($userModel->delete($id)) {
            return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus pengguna.');
    }
}
