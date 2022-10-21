<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * SupplyDetailsModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 12/07/2020 11:23 AM
 */


namespace Application\Model;


require_once __DIR__ . '/../models/UsersModel.php';
require_once __DIR__ . '/../models/OrdersModel.php';
require_once __DIR__ . '/../models/ProductsModel.php';

use Framework\Engine\Model;

/**
 * SupplyDetailsModel class
 *
 * @package Application
 */
class OrderDetailsModel extends Model
{
    static public $name = 'OrderDetails';
    private $modelName = 'OrderDetails';

    public function __construct()
    {
        parent::__construct($this->modelName);
        $this->buildModelView(
            (new OrdersModel())->getModelName(),
            (new ProductsModel())->getModelName(),
            (new UsersModel())->getModelName()
        );
    }

    final public function buildModelView(string $order, string $product, string $user): void
    {
        $this->createView(
            $this->modelName,
            <<<SQL
SELECT O.id, O.ref, O.approved_by, O.receiver, O.product_id, P.name AS product_name, P.brand AS product_brand,
P.pack_size AS product_pack_size, P.batch AS product_batch, P.expiry_date AS product_expiry_date,
P.unit AS product_unit, O.quantity, O.unit_price, CONCAT("₦", FORMAT(O.unit_price, 2)) AS amount, O.created_by,
CONCAT(U.first_name, " ", U.last_name) AS created_by_name, (O.unit_price * O.quantity) AS total,
CONCAT("₦", FORMAT(O.unit_price * O.quantity, 2)) AS total_amount, O.created_at,
O.updated_at, CONCAT(UU.first_name, " ", UU.last_name) AS updated_by_name
FROM ((($order AS O
LEFT JOIN $product AS P ON O.product_id = P.id)
LEFT JOIN $user AS U ON O.created_by = U.id)
LEFT JOIN $user AS UU ON O.created_by = UU.id)
SQL
        );
    }
}
