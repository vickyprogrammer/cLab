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
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/ProductsModel.php';

use Application\Model\CategoryModel;
use Application\Model\ProductsModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * CategoryController class
 *
 * @package Application
 */
class CategoryController extends Controller
{
    private $CategoryModel;
    private $ProductsModel;

    public function __construct()
    {
        parent::__construct();
        $this->CategoryModel = new CategoryModel();
        $this->ProductsModel = new ProductsModel();
    }

    final public function Index(RouterRequest $req): void
    {
        $totalCategory = $this->CategoryModel->countQuery();
        $page = isset($req->params['page']) ? $req->params['page'] : 1;
        $pagination = $this->getPagination($page, $totalCategory);
        $categories = $this->CategoryModel->getAll(
            [], false,
            $pagination['limit'],
            $pagination['offset'],
            ['created_at DESC']
        );

        $this->View->assign('title', 'Categories');
        $this->View->assign('page', 'categories');
        $this->View->assign('data', [
            'user' => $req->Store['user'],
            'categories' => $categories,
            'pagination' => $pagination,
        ]);
        $this->displayPage('app/index');
    }

    final public function CreateCategory(RouterRequest $req): void
    {
        $this->CategoryModel->insertRecord((array)$req->Body);
        $this->displayJSON([
            'success' => true,
            'message' => 'Created Successfully',
        ]);
    }

    final public function DeleteCategory(RouterRequest $req): void
    {
        $itemsFound = $this->ProductsModel->countQuery($req->params);
        if ($itemsFound > 0) {
            $this->displayJSON([
                'success' => false,
                'message' => "Can't Delete a Category with Products assigned.",
            ]);
        } else {
            $this->CategoryModel->deleteRecordById($req->params['id']);
            $this->displayJSON([
                'success' => true,
                'message' => 'Category Deleted Successfully',
            ]);
        }
    }

    final public function GetCategory(RouterRequest $req): void
    {
        $category = $this->CategoryModel->getById($req->params['id']);
        $this->displayJSON([
            'success' => true,
            'data' => $category[0],
        ]);
    }

    final public function EditCategory(RouterRequest $req): void
    {
        $this->CategoryModel->updateById($req->params['id'], (array)$req->Body);
        $this->displayJSON([
            'success' => true,
            'message' => 'Category Updated Successfully',
        ]);
    }
}
