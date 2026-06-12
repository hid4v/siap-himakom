<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\CategoryModel;
use Hermawan\DataTables\DataTable;

class AssetController extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();
        
        return view('admin/assets', ['categories' => $categories]);
    }

    public function ajaxList()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('assets')
                      ->select('assets.id, assets.name, categories.name as category_name, assets.stock, assets.available_stock, assets.condition, assets.status, assets.image, assets.category_id, assets.description')
                      ->join('categories', 'categories.id = assets.category_id');

        return DataTable::of($builder)
            ->add('action', function($row) {
                return '
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-warning edit-btn rounded-3" 
                            data-id="' . $row->id . '" 
                            data-name="' . esc($row->name) . '" 
                            data-category_id="' . $row->category_id . '" 
                            data-stock="' . $row->stock . '" 
                            data-available_stock="' . $row->available_stock . '" 
                            data-condition="' . esc($row->condition) . '" 
                            data-status="' . esc($row->status) . '" 
                            data-description="' . esc($row->description) . '"
                            data-image="' . $row->image . '"
                        ><i class="bi bi-pencil-square"></i> Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn rounded-3" data-id="' . $row->id . '" data-name="' . esc($row->name) . '"><i class="bi bi-trash"></i> Hapus</button>
                    </div>
                ';
            })
            ->toJson(true);
    }

    public function store()
    {
        $assetModel = new AssetModel();

        $rules = [
            'category_id' => 'required|is_natural_no_zero',
            'name'        => 'required|min_length[3]|max_length[255]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'condition'   => 'required',
            'status'      => 'required',
            'description' => 'permit_empty',
            'image'       => 'permit_empty|is_image[image]|max_size[image,2048]|ext_in[image,png,jpg,jpeg,webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $imageName = null;
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $imageName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads/assets', $imageName);
        }

        $stock = (int)$this->request->getPost('stock');

        $data = [
            'category_id'     => $this->request->getPost('category_id'),
            'name'            => $this->request->getPost('name'),
            'description'     => $this->request->getPost('description'),
            'stock'           => $stock,
            'available_stock' => $stock, // For new assets, available stock equals total stock
            'condition'       => $this->request->getPost('condition'),
            'image'           => $imageName,
            'status'          => $this->request->getPost('status'),
        ];

        if ($assetModel->save($data)) {
            return redirect()->back()->with('success', 'Aset berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan aset.');
    }

    public function update($id)
    {
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);

        if (!$asset) {
            return redirect()->back()->with('error', 'Aset tidak ditemukan.');
        }

        $rules = [
            'category_id' => 'required|is_natural_no_zero',
            'name'        => 'required|min_length[3]|max_length[255]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'condition'   => 'required',
            'status'      => 'required',
            'description' => 'permit_empty',
            'image'       => 'permit_empty|is_image[image]|max_size[image,2048]|ext_in[image,png,jpg,jpeg,webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $imageName = $asset['image'];
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Delete old image if exists
            if ($asset['image'] && file_exists(ROOTPATH . 'public/uploads/assets/' . $asset['image'])) {
                unlink(ROOTPATH . 'public/uploads/assets/' . $asset['image']);
            }
            $imageName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads/assets', $imageName);
        }

        // Adjust stocks intelligently
        $oldStock = (int)$asset['stock'];
        $newStock = (int)$this->request->getPost('stock');
        $difference = $newStock - $oldStock;
        
        $newAvailableStock = (int)$asset['available_stock'] + $difference;
        if ($newAvailableStock < 0) {
            $newAvailableStock = 0;
        }

        $data = [
            'id'              => $id,
            'category_id'     => $this->request->getPost('category_id'),
            'name'            => $this->request->getPost('name'),
            'description'     => $this->request->getPost('description'),
            'stock'           => $newStock,
            'available_stock' => $newAvailableStock,
            'condition'       => $this->request->getPost('condition'),
            'image'           => $imageName,
            'status'          => $this->request->getPost('status'),
        ];

        if ($assetModel->save($data)) {
            return redirect()->back()->with('success', 'Aset berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Gagal mengubah aset.');
    }

    public function delete($id)
    {
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);

        if (!$asset) {
            return redirect()->back()->with('error', 'Aset tidak ditemukan.');
        }

        // Delete photo if exists
        if ($asset['image'] && file_exists(ROOTPATH . 'public/uploads/assets/' . $asset['image'])) {
            unlink(ROOTPATH . 'public/uploads/assets/' . $asset['image']);
        }

        if ($assetModel->delete($id)) {
            return redirect()->back()->with('success', 'Aset berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus aset.');
    }
}
