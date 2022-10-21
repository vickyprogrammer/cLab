<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * ProductsModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 07/07/2020 3:54 PM
 */


namespace Application\Model;

use Framework\Engine\Model;

/**
 * ProductsModel class
 *
 * @package Application
 */
class ProductsModel extends Model
{
    private $modelName = 'products';
    static public $name = 'products';

    private $modelSchema = [
        'id' => 'INT NOT NULL AUTO_INCREMENT',
        'sku' => 'varchar(255) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'brand' => 'varchar(255)',
        'pack_size' => 'varchar(255)',
        'batch' => 'varchar(255)',
        'expiry_date' => 'varchar(255)',
        'unit' => 'varchar(255)',
        'category' => 'INT NOT NULL',
        'detail' => 'varchar(255)',
        'price' => 'double(9,2) NOT NULL',
        'visibility' => 'INT NOT NULL DEFAULT 1',
        'created_by' => 'INT NOT NULL',
        'updated_by' => 'INT',
    ];

    public function __construct()
    {
        parent::__construct($this->modelName, $this->modelSchema, 'id');
    }
}
