<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $currentTime = date('Y-m-d H:i:s');

        // 1. Seed Users
        $usersData = [
            [
                'name'       => 'Admin HIMAKOM',
                'email'      => 'admin@himakom.org',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'name'       => 'Member HIMAKOM',
                'email'      => 'member@himakom.org',
                'password'   => password_hash('member123', PASSWORD_DEFAULT),
                'role'       => 'member',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ]
        ];
        $db->table('users')->insertBatch($usersData);

        // 2. Seed Categories
        $categoriesData = [
            [
                'id'          => 1,
                'name'        => 'Multimedia',
                'description' => 'Aset pendukung presentasi, display, dan pemutaran media.'
            ],
            [
                'id'          => 2,
                'name'        => 'Elektronik',
                'description' => 'Aset berupa perangkat elektronik pendukung kegiatan umum.'
            ],
            [
                'id'          => 3,
                'name'        => 'Dokumentasi',
                'description' => 'Aset untuk keperluan dokumentasi foto dan video.'
            ],
            [
                'id'          => 4,
                'name'        => 'Perlengkapan Acara',
                'description' => 'Perlengkapan fisik pendukung dekorasi, panggung, dan operasional acara.'
            ]
        ];
        $db->table('categories')->insertBatch($categoriesData);

        // 3. Seed Assets
        $assetsData = [
            [
                'category_id'     => 3, // Dokumentasi
                'name'            => 'Kamera DSLR Canon EOS 200D',
                'description'     => 'Kamera DSLR dengan lensa kit 18-55mm, cocok untuk dokumentasi acara luar ruangan.',
                'stock'           => 3,
                'available_stock' => 3,
                'condition'       => 'Sangat Baik',
                'image'           => null,
                'status'          => 'tersedia',
                'created_at'      => $currentTime,
                'updated_at'      => $currentTime,
            ],
            [
                'category_id'     => 1, // Multimedia
                'name'            => 'Proyektor Epson EB-X400',
                'description'     => 'Proyektor tingkat kecerahan 3300 lumens, resolusi XGA, include kabel HDMI dan VGA.',
                'stock'           => 2,
                'available_stock' => 2,
                'condition'       => 'Baik',
                'image'           => null,
                'status'          => 'tersedia',
                'created_at'      => $currentTime,
                'updated_at'      => $currentTime,
            ],
            [
                'category_id'     => 1, // Multimedia
                'name'            => 'Tripod Takara ECO-196A',
                'description'     => 'Tripod kamera / HP ringan dengan tinggi maksimal 1.45m.',
                'stock'           => 5,
                'available_stock' => 5,
                'condition'       => 'Baik',
                'image'           => null,
                'status'          => 'tersedia',
                'created_at'      => $currentTime,
                'updated_at'      => $currentTime,
            ],
            [
                'category_id'     => 2, // Elektronik
                'name'            => 'Wireless Mic Shure SVX24',
                'description'     => 'Mic wireless UHF dual channel dengan jangkauan sinyal hingga 50 meter.',
                'stock'           => 4,
                'available_stock' => 4,
                'condition'       => 'Sangat Baik',
                'image'           => null,
                'status'          => 'tersedia',
                'created_at'      => $currentTime,
                'updated_at'      => $currentTime,
            ],
            [
                'category_id'     => 4, // Perlengkapan Acara
                'name'            => 'Sound System Portable Baretone 15 Inch',
                'description'     => 'Speaker aktif portable bertenaga baterai, sudah termasuk 2 mic wireless genggam.',
                'stock'           => 1,
                'available_stock' => 1,
                'condition'       => 'Baik',
                'image'           => null,
                'status'          => 'tersedia',
                'created_at'      => $currentTime,
                'updated_at'      => $currentTime,
            ]
        ];
        $db->table('assets')->insertBatch($assetsData);
    }
}
