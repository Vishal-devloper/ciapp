<?php
namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\admin\UserModel;
use App\Models\admin\VendorModel;


class Vendor extends BaseController
{

    protected $UserModel;
    protected $VendorModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->VendorModel = new VendorModel();
        helper(['form', 'url']);
    }
    public function getVendors()
    {
        $users = $this->VendorModel->findAll();

        return $this->response->setJSON([
            "data" => $users
        ]);
    }


}