<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * ReportController
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 13/11/2020 9:58 PM
 */


namespace Application\Controller;

/**
 * Import your models here.
 */
require_once __DIR__ . '/../models/ProductStockModel.php';
require_once __DIR__ . '/../models/SuppliersModel.php';
require_once __DIR__ . '/../models/SupplyDetailsModel.php';
require_once __DIR__ . '/../models/OrderDetailsModel.php';

use Application\Model\OrderDetailsModel;
use Application\Model\ProductStockModel;
use Application\Model\SuppliersModel;
use Application\Model\SupplyDetailsModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * ReportController class
 *
 * @package Application
 */
class ReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    final public function Order(RouterRequest $req): void
    {
        $params = $req->params;
        $orderModel = new OrderDetailsModel();
        $where = [];
        if ($params['filter'] && $params['value']) {
            $where[$params['filter']] = ['=', $params['value']];
        }
        if ($params['from']) {
            $where[] = 'created_at;>=;' . $params['from'];
        }
        if ($params['to']) {
            $where[] = 'created_at;<=;' . $params['to'];
        }
        $rows = $orderModel->getAll($where);
        $headers = [
            'created_at' => 'Date', 'ref' => 'From', 'receiver' => 'Receiver', 'approved_by' => 'Approved By',
            'product_name' => 'Product', 'quantity' => 'Quantity', 'amount' => 'Unit Price', 'total_amount' => 'Total',
        ];
        $data = [];
        $footer = ['quantity' => 0, 'amount' => 0, 'total_amount' => 0];
        $report = count($rows) > 0 ? [
            'title' => $params['title'],
            'from' => $rows[0]->created_at,
            'to' => $rows[count($rows) - 1]->created_at,
        ] : $params;
        foreach ($rows as $row) {
            $data[] = [
                'created_at' => date('M d, Y', strtotime($row->created_at)),
                'ref' => $row->ref,
                'receiver' => $row->receiver,
                'approved_by' => $row->approved_by,
                'product_name' => $row->product_name,
                'quantity' => $row->quantity . ' ' . $row->product_unit,
                'amount' => $row->amount,
                'total_amount' => $row->total_amount,
            ];
            $footer['quantity'] += $row->quantity;
            $footer['amount'] += $row->unit_price;
            $footer['total_amount'] += $row->total;
        }
        $data[] = [
            'created_at' => '<strong>Total</strong>',
            'ref' => '<strong>-</strong>',
            'receiver' => '<strong>-</strong>',
            'approved_by' => '<strong>-</strong>',
            'product_name' => '<strong>-</strong>',
            'quantity' => '<strong>' . number_format($footer['quantity']) . ' ' . $row->product_unit . '</strong>',
            'amount' => '<strong>₦' . number_format($footer['amount'], 2) . '</strong>',
            'total_amount' => '<strong>₦' . number_format($footer['total_amount'], 2) . '</strong>',
        ];
        $this->View->assign('title', $params['title']);
        $this->View->assign('params', $report);
        $this->View->assign('headers', $headers);
        $this->View->assign('data', $data);
        $this->displayPage('app/report');
    }

    final public function Supplies(RouterRequest $req): void
    {
        $params = $req->params;
        $suppliesModel = new SupplyDetailsModel();
        $where = [];
        if ($params['filter'] && $params['value']) {
            $where[$params['filter']] = ['=', $params['value']];
        }
        if ($params['from']) {
            $where[] = 'created_at;>=;' . $params['from'];
        }
        if ($params['to']) {
            $where[] = 'created_at;<=;' . $params['to'];
        }
        $rows = $suppliesModel->getAll($where);
        $headers = [
            'created_at' => 'Date', 'supplier_name' => 'Supplier', 'product_name' => 'Product',
            'quantity' => 'Quantity', 'amount' => 'Unit Price', 'total_amount' => 'Total',
        ];
        $data = [];
        $footer = [
            'quantity' => 0, 'amount' => 0, 'total_amount' => 0,
        ];
        $report = count($rows) > 0 ? [
            'title' => $params['title'],
            'from' => $rows[0]->created_at,
            'to' => $rows[count($rows) - 1]->created_at,
        ] : $params;
        foreach ($rows as $row) {
            $data[] = [
                'created_at' => date('M d, Y', strtotime($row->created_at)),
                'supplier_name' => $row->supplier_name,
                'product_name' => $row->product_name,
                'quantity' => $row->quantity . ' ' . $row->product_unit,
                'amount' => $row->amount,
                'total_amount' => $row->total_amount,
            ];
            $footer['quantity'] += $row->quantity;
            $footer['amount'] += $row->unit_price;
            $footer['total_amount'] += $row->total;
        }
        $data[] = [
            'created_at' => '<strong>Total</strong>',
            'supplier_name' => '<strong>-</strong>',
            'product_name' => '<strong>-</strong>',
            'quantity' => '<strong>' . number_format($footer['quantity']) . ' ' . $row->product_unit . '</strong>',
            'amount' => '<strong>₦' . number_format($footer['amount'], 2) . '</strong>',
            'total_amount' => '<strong>₦' . number_format($footer['total_amount'], 2) . '</strong>',
        ];
        $this->View->assign('title', $params['title']);
        $this->View->assign('params', $report);
        $this->View->assign('headers', $headers);
        $this->View->assign('data', $data);
        $this->displayPage('app/report');
    }

    final public function Supplier(RouterRequest $req): void
    {
        $params = $req->params;
        $supplierModel = new SuppliersModel();
        $where = [];
        if ($params['filter'] && $params['value']) {
            $where[$params['filter']] = ['=', $params['value']];
        }
        if ($params['from']) {
            $where[] = 'created_at;>=;' . $params['from'];
        }
        if ($params['to']) {
            $where[] = 'created_at;<=;' . $params['to'];
        }
        $rows = $supplierModel->getAll($where);
        $headers = [
            'name' => 'Name', 'phone' => 'Phone Number', 'email' => 'Email Address', 'address' => 'Address',
        ];
        $data = [];
        $report = count($rows) > 0 ? [
            'title' => $params['title'],
            'from' => $rows[0]->created_at,
            'to' => $rows[count($rows) - 1]->created_at,
        ] : $params;
        foreach ($rows as $row) {
            $data[] = [
                'name' => $row->name,
                'phone' => $row->phone,
                'email' => $row->email,
                'address' => $row->address,
            ];
        }
        $this->View->assign('title', $params['title']);
        $this->View->assign('params', $report);
        $this->View->assign('headers', $headers);
        $this->View->assign('data', $data);
        $this->displayPage('app/report');
    }

    final public function Product(RouterRequest $req): void
    {
        $params = $req->params;
        $productModel = new ProductStockModel();
        $where = [];
        if ($params['filter'] && $params['value']) {
            $where[$params['filter']] = ['=', $params['value']];
        }
        if ($params['from']) {
            $where[] = 'created_at;>=;' . $params['from'];
        }
        if ($params['to']) {
            $where[] = 'created_at;<=;' . $params['to'];
        }
        $rows = $productModel->getAll($where);
        $headers = [
            'sku' => 'SKU', 'name' => 'Name', 'brand' => 'Brand', 'category_name' => 'Category', 'stock_in' => 'In',
            'stock_out' => 'Out', 'stock' => 'Stock', 'amount' => 'Price', 'stock_price' => 'Stock Price',
        ];
        $data = [];
        $footer = ['stock_in' => 0, 'stock_out' => 0, 'stock' => 0, 'amount' => 0, 'stock_price' => 0];
        $report = count($rows) > 0 ? [
            'title' => $params['title'],
            'from' => $rows[0]->created_at,
            'to' => $rows[count($rows) - 1]->created_at,
        ] : $params;
        foreach ($rows as $row) {
            $data[] = [
                'sku' => $row->sku, 'name' => $row->name, 'brand' => $row->brand,
                'category_name' => $row->category_name, 'stock_in' => $row->stock_in,
                'stock_out' => $row->stock_out, 'amount' => $row->amount,
                'stock' => ($row->stock_in - $row->stock_out) . ' ' . $row->unit,
                'stock_price' => '₦' . number_format(($row->stock_in - $row->stock_out) * $row->price, 2),
            ];
            $footer['stock_in'] += $row->stock_in;
            $footer['stock_out'] += $row->stock_out;
            $footer['amount'] += $row->price;
            $footer['stock'] += $row->stock_in - $row->stock_out;
            $footer['stock_price'] += ($row->stock_in - $row->stock_out) * $row->price;
        }
        $data[] = [
            'sku' => '<strong>Total</strong>',
            'name' => '<strong>-</strong>',
            'brand' => '<strong>-</strong>',
            'category_name' => '<strong>-</strong>',
            'stock_in' => '<strong>' . number_format($footer['stock_in']) . '</strong>',
            'stock_out' => '<strong>' . number_format($footer['stock_out']) . '</strong>',
            'amount' => '<strong>₦' . number_format($footer['amount'], 2) . '</strong>',
            'stock' => '<strong>' . number_format($footer['stock']) . ' ' . $row->unit . '</strong>',
            'stock_price' => '<strong>₦' . number_format($footer['stock_price'], 2) . '</strong>',
        ];
        $this->View->assign('title', $params['title']);
        $this->View->assign('params', $report);
        $this->View->assign('headers', $headers);
        $this->View->assign('data', $data);
        $this->displayPage('app/report');
    }
}
