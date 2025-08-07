<?php

namespace App\Controllers;

class E_admin extends BaseController
{
    public function dashboard(): string
    {   
        helper('url');
        return view('ecommerce/admin/dashboard');
    }
    public function profile(): string
    {   
        helper('url');
        return view('ecommerce/admin/profile');
    }
    public function map_google(): string
    {   
        helper('url');
        return view('ecommerce/admin/map_google');
    }
    public function error(): string
    {   
        helper('url');
        return view('ecommerce/admin/error');
    }
    public function basic_table(): string
    {   
        helper('url');
        return view('ecommerce/admin/basic_table');
    }
    public function fontawesome(): string
    {   
        helper('url');
        return view('ecommerce/admin/fontawesome');
    }
    public function blank(): string
    {   
        helper('url');
        return view('ecommerce/admin/blank');
    }
}
