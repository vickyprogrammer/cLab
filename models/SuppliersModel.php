<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * SuppliersModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 09/07/2020 5:36 PM
 */


namespace Application\Model;

use Framework\Engine\Model;

/**
 * SuppliersModel class
 *
 * @package Application
 */
class SuppliersModel extends Model
{
    private $modelName = 'suppliers';
    static public $name = 'suppliers';

    private $modelSchema = [
        'id' => 'INT NOT NULL AUTO_INCREMENT',
        'name' => 'varchar(255) NOT NULL',
        'address' => 'varchar(255)',
        'phone' => 'varchar(255)',
        'email' => 'varchar(255)',
        'other' => 'varchar(255)',
    ];

    public function __construct()
    {
        parent::__construct($this->modelName, $this->modelSchema, 'id');
    }
}
