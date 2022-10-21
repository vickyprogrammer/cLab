<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * CategoryController
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 08/07/2020 6:30 PM
 */


namespace Application\Controller;

/**
 * Import your models here.
 */
require_once __DIR__ . '/../models/SuppliersModel.php';
require_once __DIR__ . '/../models/SuppliesModel.php';

use Application\Model\SuppliersModel;
use Application\Model\SuppliesModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * CategoryController class
 *
 * @package Application
 */
class SupplierController extends Controller
{
    private $SuppliersModel;
    private $SuppliesModel;

    public function __construct()
    {
        parent::__construct();
        $this->SuppliersModel = new SuppliersModel();
        $this->SuppliesModel = new SuppliesModel();
    }

    final public function Index(RouterRequest $req): void
    {
        $totalSuppliers = $this->SuppliersModel->countQuery();
        $page = isset($req->params['page']) ? $req->params['page'] : 1;
        $pagination = $this->getPagination($page, $totalSuppliers);
        $suppliers = $this->SuppliersModel->getAll(
            [], false,
            $pagination['limit'],
            $pagination['offset'],
            ['created_at DESC']
        );

        $this->View->assign('title', 'Suppliers');
        $this->View->assign('page', 'suppliers');
        $this->View->assign('data', [
            'user' => $req->Store['user'],
            'suppliers' => $suppliers,
            'pagination' => $pagination,
        ]);
        $this->displayPage('app/index');
    }

    final public function CreateSupplier(RouterRequest $req): void
    {
        $this->SuppliersModel->insertRecord((array)$req->Body);
        $this->displayJSON([
            'success' => true,
            'message' => 'Created Successfully',
        ]);
    }

    final public function DeleteSupplier(RouterRequest $req): void
    {
        $itemsFound = $this->SuppliesModel->countQuery($req->params);
        if ($itemsFound > 0) {
            $this->displayJSON([
                'success' => false,
                'message' => "Can't Delete a Supplier with Products supplies.",
            ]);
        } else {
            $this->SuppliersModel->deleteRecordById($req->params['id']);
            $this->displayJSON([
                'success' => true,
                'message' => 'Supplier Deleted Successfully',
            ]);
        }
    }

    final public function GetSupplier(RouterRequest $req): void
    {
        $supplier = $this->SuppliersModel->getById($req->params['id']);
        $this->displayJSON([
            'success' => true,
            'data' => $supplier[0],
        ]);
    }

    final public function EditSupplier(RouterRequest $req): void
    {
        $this->SuppliersModel->updateById($req->params['id'], (array)$req->Body);
        $this->displayJSON([
            'success' => true,
            'message' => 'Supplier Updated Successfully',
        ]);
    }
}
