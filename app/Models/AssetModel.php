<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table            = 'assets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id', 
        'name', 
        'description', 
        'stock', 
        'available_stock', 
        'condition', 
        'image', 
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'category_id'     => 'required|is_natural_no_zero',
        'name'            => 'required|min_length[3]|max_length[255]',
        'description'     => 'permit_empty',
        'stock'           => 'required|integer|greater_than_equal_to[0]',
        'available_stock' => 'required|integer|greater_than_equal_to[0]',
        'condition'       => 'required',
        'image'           => 'permit_empty',
        'status'          => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Helper to get assets with category info
    public function getAssetsWithCategory()
    {
        return $this->select('assets.*, categories.name as category_name')
                    ->join('categories', 'categories.id = assets.category_id')
                    ->findAll();
    }
}
