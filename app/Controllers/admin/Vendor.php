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
        $request = service('request');

    $draw   = $request->getVar('draw');
    $start  = $request->getVar('start');
    $length = $request->getVar('length');
    $search = $request->getVar('search')['value'];
        $order   = $request->getVar('order');
    $columns = $request->getVar('columns');
    // Total records
    $totalRecords = $this->VendorModel->countAllResults(false);

    // Filtering
    if (!empty($search)) {
        $this->VendorModel->groupStart()
            ->like('name', $search)
            ->orLike('email', $search)
            ->orLike('phone', $search)
            ->orLike('store_name', $search)
            ->groupEnd();
    }

    $recordsFiltered = $this->VendorModel->countAllResults(false);
    if (!empty($order)) {
        $colIndex = $order[0]['column'];          // column index
        $colName  = $columns[$colIndex]['data'];  // column name
        $dir      = $order[0]['dir'];             // asc or desc
        $this->VendorModel->orderBy($colName, $dir);
    } else {
        // Default sort by ID DESC
        $this->VendorModel->orderBy('id', 'DESC');
    }
    // Pagination
    $vendors = $this->VendorModel->findAll($length, $start);

    $data = [];
    foreach ($vendors as $row) {
        $data[] = [
            "id"         => $row['id'],
            "name"       => $row['name'],
            "email"      => $row['email'],
            "phone"      => $row['phone'],
            "store_name" => $row['store_name'],
            "status"     => $row['status']
        ];
    }

    return $this->response->setJSON([
        "draw"            => intval($draw),
        "recordsTotal"    => $totalRecords,
        "recordsFiltered" => $recordsFiltered,
        "data"            => $data
    ]);
    }

    // Update Vendor
    public function vendorUpdate(){
        $id=$this->request->getPost('id');
        $status=$this->request->getPost('status');
        $allowedStatus=['pending','approved','rejected'];
        if(empty($id) || !in_array($status,$allowedStatus)){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Invalid Request'
            ]);
        }
        $insertId=$this->VendorModel->where('id', $id)->set(['status' => $status])->update();
        if(!$insertId){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Error when updating vendor'
            ]);
        }
        return $this->response->setJSON([
            'status'=>'success',
            'message'=>'Vendor Updated Successfully'
        ]);
    }


}