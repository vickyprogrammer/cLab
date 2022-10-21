<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * StatsModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 14/07/2020 8:42 AM
 */


namespace Application\Model;

require_once __DIR__ . '/ProductsModel.php';
require_once __DIR__ . '/SuppliesModel.php';
require_once __DIR__ . '/OrdersModel.php';
require_once __DIR__ . '/SuppliersModel.php';

use Framework\Engine\Model;
use function Framework\Engine\handleError;

/**
 * StatsModel class
 *
 * @package Application
 */
class StatsModel extends Model
{
    private $modelName = 'stats';
    private $products;
    private $supplies;
    private $orders;
    private $suppliers;

    public function __construct()
    {
        parent::__construct($this->modelName);
        $this->products = new ProductsModel();
        $this->supplies = new SuppliesModel();
        $this->orders = new OrdersModel();
        $this->suppliers = new SuppliersModel();
    }

    final public function getIncomeChart(): array
    {
        $month = date("m");
        $year = date("Y");
        $sql = <<<SQL
SELECT
    SUM(O.quantity) AS quantity,
    COUNT(O.id) AS total,
    DATE_FORMAT(O.created_at, "%D") AS label
FROM {$this->orders->getModelName()} AS O
WHERE YEAR(O.created_at) = $year
AND MONTH(O.created_at) = $month
GROUP BY label ORDER BY O.created_at ASC
SQL;
        $res = Model::$dbConnection->prepare($sql);
        if (!$res->execute()) {
            handleError($res->errorInfo());
        }
        return $res->fetchAll();
    }

    final public function getExpensesChart(): array
    {
        $month = date("m");
        $year = date("Y");
        $sql = <<<SQL
SELECT
    SUM(S.quantity) AS quantity,
    COUNT(S.id) AS total,
    DATE_FORMAT(S.created_at, "%D") AS label
FROM {$this->supplies->getModelName()} AS S
WHERE YEAR(S.created_at) = $year
AND MONTH(S.created_at) = $month
GROUP BY label ORDER BY S.created_at ASC
SQL;
        $res = Model::$dbConnection->prepare($sql);
        if (!$res->execute()) {
            handleError($res->errorInfo());
        }
        return $res->fetchAll();
    }

    final public function getStats(): object
    {
        $sql = <<<SQL
SELECT
    (SELECT FORMAT(COUNT(P.id), 0) FROM {$this->products->getModelName()} AS P WHERE P.visibility=1) AS products,
    (SELECT FORMAT(SUM(S.quantity), 0) FROM {$this->supplies->getModelName()} AS S) AS stock_in,
    (SELECT FORMAT(SUM(O.quantity), 0) FROM {$this->orders->getModelName()} AS O) AS stock_out,
    (SELECT FORMAT(COUNT(SU.id), 0) FROM {$this->suppliers->getModelName()} AS SU) AS suppliers,
    (SELECT CONCAT("₦", FORMAT(SUM(O1.unit_price * O1.quantity), 2)) FROM {$this->orders->getModelName()} AS O1) AS income,
    (SELECT CONCAT("₦", FORMAT(SUM(S1.unit_price * S1.quantity), 2)) FROM {$this->supplies->getModelName()} AS S1) AS expenses
SQL;
        $res = Model::$dbConnection->prepare($sql);
        if (!$res->execute()) {
            handleError($res->errorInfo());
        }
        return $res->fetchAll()[0];
    }
}
