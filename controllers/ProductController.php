<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * ProductController
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 07/07/2020 4:42 PM
 */


namespace Application\Controller;

/**
 * Import your models here.
 */
require_once __DIR__ . '/../models/ProductsModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/ProductStockModel.php';

use Application\Model\CategoryModel;
use Application\Model\ProductsModel;
use Application\Model\ProductStockModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * ProductController class
 *
 * @package Application
 */
class ProductController extends Controller
{
    private $ProductsModel;
    private $CategoryModel;
    private $StockModel;

    public function __construct()
    {
        parent::__construct();
        $this->ProductsModel = new ProductsModel();
        $this->CategoryModel = new CategoryModel();
        $this->StockModel = new ProductStockModel();
    }

    final public function Index(RouterRequest $req): void
    {
        $totalProducts = $this->StockModel->countQuery(['visibility' => 1]);
        $page = isset($req->params['page']) ? $req->params['page'] : 1;
        $pagination = $this->getPagination($page, $totalProducts);
        $products = $this->StockModel->getAll(
            ['visibility' => 1], false,
            $pagination['limit'],
            $pagination['offset'],
            ['sku']
        );

        $this->View->assign('title', 'Products');
        $this->View->assign('page', 'products');
        $this->View->assign('data', [
            'user' => $req->Store['user'],
            'products' => $products,
            'pagination' => $pagination,
            'categories' => $this->CategoryModel->getAll([], false, 0, 0, ['name ASC']),
        ]);
        $this->displayPage('app/index');
    }

    final public function CreateProduct(RouterRequest $req): void
    {
        $data = (array)$req->Body;
        $data['created_by'] = $req->Store['user']->id;
        $this->ProductsModel->insertRecord($data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Created Successfully',
        ]);
    }

    final public function UploadProducts(RouterRequest $req): void
    {
        $data = (array)$req->Body;
        foreach($data as $key => $record) {
            $row = (array)$record;
            $row['created_by'] = $req->Store['user']->id;
            $data[$key] = $row;
        }
        $this->ProductsModel->insertManyRecord($data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Uploaded Successfully',
        ]);
    }

    final public function DeleteProduct(RouterRequest $req): void
    {
        $product = $this->StockModel->getAll($req->params)[0];
        if ($product->stock == null) {
            $this->ProductsModel->deleteRecordById($req->params['id']);
        } else {
            $this->ProductsModel->updateById($req->params['id'], ['visibility' => 0]);
        }
        $this->displayJSON([
            'success' => true,
            'message' => 'Product Deleted Successfully',
        ]);
    }

    final public function GetProduct(RouterRequest $req): void
    {
        $product = $this->StockModel->getAll($req->params)[0];
        $this->displayJSON([
            'success' => true,
            'data' => $product,
        ]);
    }

    final public function EditProduct(RouterRequest $req): void
    {
        $data = (array)$req->Body;
        $data['updated_by'] = $req->Store['user']->id;
        $this->ProductsModel->updateById($req->params['id'], $data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Product Updated Successfully',
        ]);
    }
}
