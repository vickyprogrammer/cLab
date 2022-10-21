<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * ProductStockModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 12/07/2020 11:59 AM
 */


namespace Application\Model;

require_once __DIR__ . '/ProductsModel.php';
require_once __DIR__ . '/CategoryModel.php';
require_once __DIR__ . '/OrdersModel.php';
require_once __DIR__ . '/SuppliesModel.php';
require_once __DIR__ . '/UsersModel.php';

use Framework\Engine\Model;

/**
 * ProductStockModel class
 *
 * @package Application
 */
class ProductStockModel extends Model
{
    static public $name = 'ProductStock';
    private $modelName = 'ProductStock';

    public function __construct()
    {
        parent::__construct($this->modelName);
        $this->buildModelView(
            (new ProductsModel())->getModelName(),
            (new CategoryModel())->getModelName(),
            (new OrdersModel())->getModelName(),
            (new SuppliesModel())->getModelName(),
            (new UsersModel())->getModelName()
        );
    }

    final public function buildModelView(string $product, string $category, string $order, string $supplies, string $user): void
    {
        $this->createView(
            $this->modelName,
            <<<SQL
SELECT P.id, P.sku, P.name, P.brand, P.unit, P.pack_size, P.batch, P.expiry_date,
P.visibility, P.category, C.name AS category_name,
(SELECT SUM(S.quantity) FROM $supplies AS S WHERE product_id=P.id) AS stock_in,
(SELECT SUM(O.quantity) FROM $order AS O WHERE product_id=P.id)AS stock_out,
P.detail, P.price, CONCAT("₦", FORMAT(P.price, 2)) AS amount, P.created_by,
CONCAT(U.first_name, " ", U.last_name) AS create_user_name, P.updated_by,
CONCAT(UU.first_name, " ", UU.last_name) AS update_user_name, P.created_at, P.updated_at
FROM ((($product AS P
LEFT JOIN $category AS C ON P.category = C.id)
LEFT JOIN $user AS U ON P.created_by = U.id)
LEFT JOIN $user AS UU ON P.updated_by = U.id)
GROUP BY P.id
SQL
        );
    }
}
