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
require_once __DIR__ . '/../models/OrderDetailsModel.php';
require_once __DIR__ . '/../models/OrdersModel.php';
require_once __DIR__ . '/../models/ProductStockModel.php';

use Application\Model\OrderDetailsModel;
use Application\Model\OrdersModel;
use Application\Model\ProductStockModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * CategoryController class
 *
 * @package Application
 */
class OrderController extends Controller
{
    private $OrdersModel;
    private $ProductsModel;
    private $OrderDetailsModel;

    public function __construct()
    {
        parent::__construct();
        $this->OrdersModel = new OrdersModel();
        $this->ProductsModel = new ProductStockModel();
        $this->OrderDetailsModel = new OrderDetailsModel();
    }

    final public function Index(RouterRequest $req): void
    {
        $totalOrders = $this->OrderDetailsModel->countQuery();
        $page = isset($req->params['page']) ? $req->params['page'] : 1;
        $pagination = $this->getPagination($page, $totalOrders);
        $orders = $this->OrderDetailsModel->getAll(
            [], false,
            $pagination['limit'],
            $pagination['offset'],
            ['created_at DESC']
        );

        $this->View->assign('title', 'Orders');
        $this->View->assign('page', 'orders');
        $this->View->assign('data', [
            'user' => $req->Store['user'],
            'orders' => $orders,
            'pagination' => $pagination,
            'products' => $this->ProductsModel->getAll(['visibility' => 1], false, 0, 0, ['name ASC']),
        ]);
        $this->displayPage('app/index');
    }

    final private function getProductById($id, array $products): \stdClass
    {
        foreach ($products as $product) {
            if ($product->id == $id) {
                return $product;
            }
        }
    }

    final public function CreateOrder(RouterRequest $req): void
    {
        $data = (array)$req->Body;
        $ids = json_decode($data['product_ids'], true);
        $qty = json_decode($data['product_qty']);
        $records = [];
        $products = $this->ProductsModel->getAllIn('id', $ids);
        foreach ($ids as $key => $id) {
            $record = [];
            $product = $this->getProductById($id, $products);
            $record['ref'] = $data['ref'];
            $record['receiver'] = $data['receiver'];
            $record['quantity'] = $qty[$key];
            $record['product_id'] = $product->id;
            $record['unit_price'] = $product->price;
            $record['approved_by'] = $data['approved_by'];
            $record['created_by'] = $req->Store['user']->id;
            $records[] = $record;
        }
        $this->OrdersModel->insertManyRecord($records);
        $this->displayJSON([
            'success' => true,
            'message' => 'Created Successfully',
        ]);
    }

    final public function DeleteOrder(RouterRequest $req): void
    {
        $this->OrdersModel->deleteRecordById($req->params['id']);
        $this->displayJSON([
            'success' => true,
            'message' => 'Order Deleted Successfully',
        ]);
    }

    final public function GetOrder(RouterRequest $req): void
    {
        $order = $this->OrderDetailsModel->getAll($req->params);
        $this->displayJSON([
            'success' => true,
            'data' => $order[0],
        ]);
    }

    final public function EditOrder(RouterRequest $req): void
    {
        $data = (array)$req->Body;
        $product = $this->ProductsModel->getById($data['product_id'])[0];
        $data['unit_price'] = $product->price;
        $data['updated_by'] = $req->Store['user']->id;
        $this->OrdersModel->updateById($req->params['id'], $data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Order Updated Successfully',
        ]);
    }
}
