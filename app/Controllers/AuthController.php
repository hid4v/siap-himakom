<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'id'         => $user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ];
            session()->set($sessionData);
            
            return redirect()->to('/dashboard')->with('success', 'Selamat datang kembali, ' . esc($user['name']) . '!');
        }

        return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register');
    }

    public function storeRegister()
    {
        $validationRules = [
            'name'             => 'required|min_length[3]|max_length[255]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        $validationMessages = [
            'email' => [
                'is_unique' => 'Email tersebut sudah terdaftar.',
            ],
            'password_confirm' => [
                'matches' => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        
        $userData = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'member', // Default registration is member
        ];

        if ($userModel->save($userData)) {
            return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal melakukan registrasi, coba lagi nanti.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}
