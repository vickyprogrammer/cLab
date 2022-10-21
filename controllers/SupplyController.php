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
require_once __DIR__ . '/../models/SupplyDetailsModel.php';
require_once __DIR__ . '/../models/SuppliesModel.php';
require_once __DIR__ . '/../models/ProductsModel.php';

use Application\Model\ProductsModel;
use Application\Model\SuppliersModel;
use Application\Model\SuppliesModel;
use Application\Model\SupplyDetailsModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * CategoryController class
 *
 * @package Application
 */
class SupplyController extends Controller
{
    private $SuppliesModel;
    private $ProductsModel;
    private $SuppliersModel;
    private $SupplyModel;

    public function __construct()
    {
        parent::__construct();
        $this->SuppliesModel = new SuppliesModel();
        $this->SuppliersModel = new SuppliersModel();
        $this->ProductsModel = new ProductsModel();
        $this->SupplyModel = new SupplyDetailsModel();
    }

    final public function Index(RouterRequest $req): void
    {
        $totalSupplies = $this->SupplyModel->countQuery();
        $page = isset($req->params['page']) ? $req->params['page'] : 1;
        $pagination = $this->getPagination($page, $totalSupplies);
        $supplies = $this->SupplyModel->getAll(
            [], false,
            $pagination['limit'],
            $pagination['offset'],
            ['created_at DESC']
        );

        $this->View->assign('title', 'Supplies');
        $this->View->assign('page', 'supplies');
        $this->View->assign('data', [
            'user' => $req->Store['user'],
            'supplies' => $supplies,
            'pagination' => $pagination,
            'products' => $this->ProductsModel->getAll(['visibility' => 1], false, 0, 0, ['name ASC']),
            'suppliers' => $this->SuppliersModel->getAll([], false, 0, 0, ['name ASC']),
        ]);
        $this->displayPage('app/index');
    }

    final public function CreateSupply(RouterRequest $req): void
    {
        $data = (array)$req->Body;
        $data['created_by'] = $req->Store['user']->id;
        $this->SuppliesModel->insertRecord($data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Created Successfully',
        ]);
    }

    final public function DeleteSupply(RouterRequest $req): void
    {
        $this->SuppliesModel->deleteRecordById($req->params['id']);
        $this->displayJSON([
            'success' => true,
            'message' => 'Supply Deleted Successfully',
        ]);
    }

    final public function GetSupply(RouterRequest $req): void
    {
        $supply = $this->SupplyModel->getAll($req->params);
        $this->displayJSON([
            'success' => true,
            'data' => $supply[0],
        ]);
    }

    final public function EditSupply(RouterRequest $req): void
    {
        $data = (array)$req->Body;
        $data['updated_by'] = $req->Store['user']->id;
        $this->SuppliesModel->updateById($req->params['id'], $data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Supply Updated Successfully',
        ]);
    }
}
