<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * UsersModel
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 04/07/2020 10:43 AM
 */


namespace Application\Model;

use Framework\Engine\Model;

/**
 * UsersModel class
 *
 * @package Application
 */
class UsersModel extends Model
{
    private $modelName = 'users';
    static public $name = 'users';

    private $modelSchema = [
        'id' => 'INT NOT NULL AUTO_INCREMENT',
        'email' => 'VARCHAR(255) NOT NULL UNIQUE',
        'first_name' => 'VARCHAR(255)',
        'last_name' => 'VARCHAR(255)',
        'phone' => 'VARCHAR(255)',
        'password' => 'VARCHAR(255) NOT NULL',
        'role' => 'INT NOT NULL DEFAULT 0',
    ];

    public function __construct()
    {
        parent::__construct($this->modelName, $this->modelSchema, 'id');
    }
}
