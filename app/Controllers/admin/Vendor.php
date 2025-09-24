<?php
namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Users as UserModel;

class Vendor extends BaseController
{
    protected $UserModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        helper(['form', 'url']);
    }

    public function getVendors()
    {
        $request = service('request');

        $draw    = $request->getVar('draw');
        $start   = $request->getVar('start');
        $length  = $request->getVar('length');
        $search  = $request->getVar('search')['value'] ?? '';
        $order   = $request->getVar('order');
        $columns = $request->getVar('columns');

        // ✅ Base query
        $builder = $this->UserModel->where('role', 'vendor');

        // ✅ Count total vendors (before filtering)
        $totalRecords = $builder->countAllResults(false);

        // ✅ Apply search filter
        if (!empty($search)) {
            $builder->groupStart()
                ->like('name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->orLike('store_name', $search)
            ->groupEnd();
        }

        // ✅ Count after filtering
        $recordsFiltered = $builder->countAllResults(false);

        // ✅ Apply ordering
        if (!empty($order)) {
            $colIndex = $order[0]['column'];
            $colName  = $columns[$colIndex]['data'];
            $dir      = $order[0]['dir'];
            $builder->orderBy($colName, $dir);
        } else {
            $builder->orderBy('id', 'DESC');
        }

        // ✅ Pagination + fetch results
        $vendors = $builder->findAll($length, $start);

        // ✅ Prepare response
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

    // ✅ Update Vendor
    public function vendorUpdate()
    {
        $id     = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $allowedStatus = ['pending','approved','rejected'];

        if (empty($id) || !in_array($status, $allowedStatus)) {
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Invalid Request'
            ]);
        }

        $updated = $this->UserModel
            ->where(['id'=> $id, 'role'=>'vendor'])
            ->set(['status' => $status])
            ->update();

        if (!$updated) {
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
