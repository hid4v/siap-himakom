<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use Hermawan\DataTables\DataTable;

class CategoryController extends BaseController
{
    public function index()
    {
        return view('admin/categories');
    }

    public function ajaxList()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categories')->select('id, name, description');

        return DataTable::of($builder)
            ->add('action', function($row) {
                return '
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-warning edit-btn rounded-3" data-id="' . $row->id . '" data-name="' . esc($row->name) . '" data-description="' . esc($row->description) . '"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn rounded-3" data-id="' . $row->id . '" data-name="' . esc($row->name) . '"><i class="bi bi-trash"></i> Hapus</button>
                    </div>
                ';
            })
            ->toJson(true);
    }

    public function store()
    {
        $categoryModel = new CategoryModel();

        $rules = [
            'name'        => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($categoryModel->save($data)) {
            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan kategori.');
    }

    public function update($id)
    {
        $categoryModel = new CategoryModel();

        $rules = [
            'name'        => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id'          => $id,
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($categoryModel->save($data)) {
            return redirect()->back()->with('success', 'Kategori berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Gagal mengubah kategori.');
    }

    public function delete($id)
    {
        $categoryModel = new CategoryModel();

        if ($categoryModel->delete($id)) {
            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus kategori.');
    }
}
