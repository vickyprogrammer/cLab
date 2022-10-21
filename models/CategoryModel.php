<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * CategoryModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 07/07/2020 5:08 PM
 */


namespace Application\Model;

use Framework\Engine\Model;

/**
 * CategoryModel class
 *
 * @package Application
 */
class CategoryModel extends Model
{
    private $modelName = 'categories';
    static public $name = 'categories';

    private $modelSchema = [
        'id' => 'INT NOT NULL AUTO_INCREMENT',
        'name' => 'varchar(255) NOT NULL',
        'detail' => 'varchar(255)',
    ];

    public function __construct()
    {
        parent::__construct($this->modelName, $this->modelSchema, 'id');
    }
}
