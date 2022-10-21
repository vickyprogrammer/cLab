<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * OrdersModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 09/07/2020 5:49 PM
 */


namespace Application\Model;

use Framework\Engine\Model;

/**
 * OrdersModel class
 *
 * @package Application
 */
class OrdersModel extends Model
{
    private $modelName = 'orders';
    static public $name = 'orders';

    private $modelSchema = [
        'id' => 'INT NOT NULL AUTO_INCREMENT',
        'ref' => 'varchar(255) NOT NULL',
        'receiver' => 'varchar(255) NOT NULL',
        'product_id' => 'INT NOT NULL',
        'quantity' => 'INT NOT NULL',
        'unit_price' => 'double(9,2) NOT NULL',
        'approved_by' => 'varchar(255) NOT NULL',
        'created_by' => 'INT NOT NULL',
        'updated_by' => 'INT',
    ];

    public function __construct()
    {
        parent::__construct($this->modelName, $this->modelSchema, 'id');
    }
}
