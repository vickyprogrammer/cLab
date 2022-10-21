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
require_once __DIR__ . '/../models/SuppliersModel.php';
require_once __DIR__ . '/../models/ProductsModel.php';
require_once __DIR__ . '/../models/SuppliesModel.php';

use Framework\Engine\Model;

/**
 * SupplyDetailsModel class
 *
 * @package Application
 */
class SupplyDetailsModel extends Model
{
    static public $name = 'SupplyDetails';
    private $modelName = 'SupplyDetails';

    public function __construct()
    {
        parent::__construct($this->modelName);
        $this->buildModelView(
            (new SuppliesModel())->getModelName(),
            (new SuppliersModel())->getModelName(),
            (new ProductsModel())->getModelName(),
            (new UsersModel())->getModelName()
        );
    }

    final public function buildModelView(string $supply, string $supplier, string $product, string $user): void
    {
        $this->createView(
            $this->modelName,
            <<<SQL
SELECT S1.id, S1.supplier_id, S2.name AS supplier_name, S1.product_id, P.name AS product_name,
P.brand AS product_brand, P.pack_size AS product_pack_size, P.batch AS product_batch,
P.expiry_date AS product_expiry_date, P.unit AS product_unit,
S1.quantity, S1.unit_price, CONCAT("₦", FORMAT(S1.unit_price, 2)) AS amount, S1.created_by,
CONCAT(U.first_name, " ", U.last_name) AS created_by_name, (S1.unit_price * S1.quantity) AS total,
CONCAT("₦", FORMAT(S1.unit_price * S1.quantity, 2)) AS total_amount, S1.created_at,
S1.updated_at
FROM ((($supply AS S1
LEFT JOIN $supplier AS S2 ON S1.supplier_id = S2.id)
LEFT JOIN $product AS P ON S1.product_id = P.id)
LEFT JOIN $user AS U ON S1.created_by = U.id)
SQL
        );
    }
}
