<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('dashboard');
    }
        public function form(): string
    {
        return view('form');
    }
        public function list(): string
    {
        return view('list');
    }
    public function login(): string
    {
        return view('login');
    }
}
