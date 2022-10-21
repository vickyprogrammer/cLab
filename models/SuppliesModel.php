<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * SuppliesModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 09/07/2020 5:39 PM
 */


namespace Application\Model;

use Framework\Engine\Model;

/**
 * SuppliesModel class
 *
 * @package Application
 */
class SuppliesModel extends Model
{
    public $view = 'SupplyDetails';
    private $modelName = 'supplies';
    static public $name = 'supplies';

    private $modelSchema = [
        'id' => 'INT NOT NULL AUTO_INCREMENT',
        'supplier_id' => 'INT NOT NULL',
        'product_id' => 'INT NOT NULL',
        'quantity' => 'INT NOT NULL',
        'unit_price' => 'double(9,2) NOT NULL',
        'created_by' => 'INT NOT NULL',
        'updated_by' => 'INT',
    ];

    public function __construct()
    {
        parent::__construct($this->modelName, $this->modelSchema, 'id');
    }
}
