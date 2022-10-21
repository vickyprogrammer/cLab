<?php
/**
 * Copyright: 2019 - Model
 *
 * Licence: MIT
 *
 * The model parent class
 *
 * @summary Model class
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-30 09:14:25
 * Last modified  : 2019-10-03 14:39:19
 */


namespace Framework\Engine {

    use PDO;
    use PDOException;

    /**
     * The framework controller class
     */
    class Model
    {
        /**
         * Static database connection
         *
         * @var PDO
         */
        static $dbConnection;

        /**
         * Associative array containing the table schema.
         *
         * @var array
         */
        private $schema;

        /**
         * primary key
         *
         * @var string
         */
        private $primaryKey;

        /**
         * The schema name.
         *
         * @var string
         */
        private $modelName;

        /**
         * The Database name.
         *
         * @var string
         */
        private $dbName;

        /**
         * The class constructor
         * @param string $modelName
         * @param array $modelSchema
         * @param string $primaryKey
         */
        public function __construct(string $modelName, array $modelSchema = null, string $primaryKey = 'id')
        {
            $dbConfig = parse_ini_file('./configs/database.conf');

            if (!isset(self::$dbConnection)) {
                try {
                    self::$dbConnection = new PDO(
                        $dbConfig['db_driver'] .
                        ':host=' . $dbConfig['db_host'] .
                        ';port=' . $dbConfig['db_port'],
                        $dbConfig['db_user'],
                        $dbConfig['db_pass'],
                        [
//                        PDO::ATTR_PERSISTENT => true,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        ]
                    );
                    $this->setDbName($dbConfig['db_name']);
                } catch (PDOException $e) {
                    handleError($e);
                }
            }

            $this->modelName = $modelName;
            $this->primaryKey = $primaryKey;

            if ($modelSchema) {
                $this->setSchema($modelSchema);
            }
        }

        /**
         * @param string $dbName
         * @return void
         */
        private function setDbName(string $dbName): void
        {
            $this->dbName = $dbName;
            $res = self::$dbConnection->query("CREATE DATABASE IF NOT EXISTS $dbName");
            if ($res === false) {
                handleError(self::$dbConnection->errorInfo());
            }
            $this->selectDb();
        }

        private function selectDb(): void
        {
            $res = self::$dbConnection->query("USE {$this->dbName}");
            if ($res === false) {
                handleError(self::$dbConnection->errorInfo());
            }
        }

        /**
         * Get the model schema.
         *
         * @return array
         */
        final public function getSchema(): array
        {
            return $this->schema;
        }

        /**
         * Create a new schema.
         *
         * @param array $schema
         */
        final public function setSchema(array $schema): void
        {
            $schema['created_at'] = 'TIMESTAMP NOT NULL DEFAULT NOW()';
            $schema['updated_at'] = 'TIMESTAMP';
            $this->schema = $schema;

            $str = "CREATE TABLE IF NOT EXISTS `$this->modelName` (";
            foreach ($schema as $column => $shape) {
                $str .= " $column $shape,";

                if ($column === $this->primaryKey) {
                    $str .= " PRIMARY KEY({$this->primaryKey}),";
                }
            }
            $str = explode(',', $str);
            array_pop($str);
            $str = implode(',', $str);
            $str .= ' ) CHARSET=utf8;';

            $res = self::$dbConnection->query($str);
            if ($res === false) {
                handleError(self::$dbConnection->errorInfo());
            }
        }

        /**
         * Creates a view in the database
         * @param string $name
         * @param string $sqlQuery
         */
        final public function createView(string $name, string $sqlQuery): void
        {
            $query = "CREATE OR REPLACE VIEW $name AS $sqlQuery";
            $res = self::$dbConnection->query($query);
            if (!$res) {
                handleError(self::$dbConnection->errorInfo());
            }
        }

        /**
         * Get primary key
         *
         * @return  string
         */
        final public function getPrimaryKey(): string
        {
            return $this->primaryKey;
        }

        /**
         * Return array of all the rows with any of the specified ids in the model table
         *
         * @param string $field
         * @param array $values
         * @param int $limit
         * @param int $offset
         * @param array $orderBy
         * @param string|null $tableName
         * @return array|void
         */
        final public function getAllIn(string $field, array $values, int $limit = 0, int $offset = 0, array $orderBy = [], string $tableName = null): array
        {
            $name = $tableName ? $tableName : $this->modelName;
            $query = "SELECT * FROM $name WHERE $field IN";
            $data = [];
            $placeholder = [];

            foreach ($values as $value) {
                $placeholder[] = "?";
                $data[] = $value;
            }

            $query .= " (" . implode(',', $placeholder) . ")";

            if ($orderBy && count($orderBy) > 0) {
                $query .= " ORDER BY " . implode(', ', $orderBy);
            }
            if ($limit > 0) {
                $query .= " LIMIT $limit OFFSET $offset";
            }
            $res = self::$dbConnection->prepare($query);
            if ($res->execute($data)) {
                return $res->fetchAll();
            }
            handleError($res->errorInfo());
        }

        /**
         * Return array of all the rows in the model table
         *
         * @param array $where
         * @param bool $or
         * @param int $limit
         * @param int $offset
         * @param array $orderBy
         * @param string|null $tableName
         * @return array|void
         */
        final public function getAll(array $where = [], bool $or = false, int $limit = 0, int $offset = 0, array $orderBy = [], string $tableName = null): array
        {
            $name = $tableName ? $tableName : $this->modelName;
            $query = "SELECT * FROM $name";
            $data = [];
            if ($where && count($where) > 0) {
                $conditions = [];
                $query .= " WHERE";
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        $conditions[] = $key . $value[0] . "?";
                        $data[] = $value[1];
                    } elseif (is_string($value) && (count(explode(';', $value)) === 3)) {
                        $vals = explode(';', $value);
                        $conditions[] = $vals[0] . $vals[1] . "?";
                        $data[] = $vals[2];
                    } else {
                        $conditions[] = $key . "=?";
                        $data[] = $value;
                    }
                }
                $glue = $or ? ' OR ' : ' AND ';
                $query .= " " . implode($glue, $conditions);
            }
            if ($orderBy && count($orderBy) > 0) {
                $query .= " ORDER BY " . implode(', ', $orderBy);
            }
            if ($limit > 0) {
                $query .= " LIMIT $limit OFFSET $offset";
            }
            $res = self::$dbConnection->prepare($query);
            if ($res->execute($data)) {
                return $res->fetchAll();
            }
            handleError($res->errorInfo());
        }

        /**
         * Count the result of a query
         * @param array $where
         * @param bool $or
         * @param string|null $tableName
         * @return int
         */
        final public function countQuery(array $where = [], bool $or = false, string $tableName = null): int
        {
            $name = $tableName ? $tableName : $this->modelName;
            $query = "SELECT COUNT(id) AS count FROM $name";
            $data = [];
            if ($where && count($where) > 0) {
                $conditions = [];
                $query .= " WHERE";
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        $conditions[] = $key . $value[0] . "?";
                        $data[] = $value[1];
                    } elseif (is_string($value) && (count(explode(';', $value)) === 3)) {
                        $vals = explode(';', $value);
                        $conditions[] = $vals[0] . $vals[1] . "?";
                        $data[] = $vals[2];
                    } else {
                        $conditions[] = $key . "=?";
                        $data[] = $value;
                    }
                }
                $glue = $or ? ' OR ' : ' AND ';
                $query .= " " . implode($glue, $conditions);
            }
            $res = self::$dbConnection->prepare($query);
            if ($res->execute($data)) {
                return $res->fetchAll()[0]->count;
            }
            handleError($res->errorInfo());
        }

        /**
         * Return a record with the specified id
         *
         * @param integer $id
         * @return array|void
         */
        final public function getById(int $id): array
        {
            $res = self::$dbConnection->prepare("SELECT * FROM {$this->getModelName()} WHERE id=?");
            if ($res->execute([$id])) {
                return $res->fetchAll();
            }
            handleError($res->errorInfo());
        }

        /**
         * Get the model name.
         *
         * @return string
         */
        final public function getModelName(): string
        {
            return $this->modelName;
        }

        /**
         * Return a record with the specified primary key value
         *
         * @param mixed $key
         * @return array|void
         */
        final public function getByPrimaryKey($key): array
        {
            $res = self::$dbConnection->prepare("SELECT * FROM {$this->getModelName()} WHERE {$this->primaryKey}=?");
            if ($res->execute([$key])) {
                return $res->fetchAll();
            }
            handleError($res->errorInfo());
        }

        /**
         * Return records with the specified value in the specified field
         *
         * @param string $field
         * @param mixed $value
         * @return array|void
         */
        final public function getByField(string $field, $value): array
        {
            $res = self::$dbConnection->prepare("SELECT * FROM {$this->getModelName()} WHERE {$field}=?");
            if ($res->execute([$value])) {
                return $res->fetchAll();
            }
            handleError($res->errorInfo());
        }

        /**
         * @param string $fieldName
         * @param mixed $fieldValue
         * @param array $UpdateValues
         * @return bool
         */
        final public function updateByField(string $fieldName, $fieldValue, array $UpdateValues): bool
        {
            $str = [];
            $data = [];
            $UpdateValues['updated_at'] = date('Y-m-d H:i:s');
            foreach ($UpdateValues as $field => $value) {
                $str[] = "{$field}=?";
                $data[] = $value;
            }

            $data[] = $fieldValue;
            $res = self::$dbConnection->prepare("UPDATE {$this->getModelName()} SET " . implode(',', $str) . " WHERE {$fieldName}=?");
            if (!$res->execute($data)) {
                handleError($res->errorInfo());
                die();
            }
            $res = null;
            return true;
        }

        /**
         * Update values in a table where the id is found
         * @param integer $id
         * @param array $values
         * @return bool
         */
        final public function updateById(int $id, array $values): bool
        {
            $str = [];
            $data = [];
            $values['updated_at'] = date('Y-m-d H:i:s');
            foreach ($values as $field => $value) {
                $str[] = "{$field}=?";
                $data[] = $value;
            }

            $data[] = $id;
            $res = self::$dbConnection->prepare("UPDATE {$this->getModelName()} SET " . implode(',', $str) . " WHERE id=?");
            if (!$res->execute($data)) {
                handleError($res->errorInfo());
                die();
            }
            $res = null;
            return true;
        }

        /**
         * Insert a record into the database
         *
         * @param array $values
         * @return bool
         */
        final public function insertRecord(array $values): bool
        {
            $fields = implode(',', array_keys($values));
            $vals = [];
            $data = [];
            foreach ($values as $value) {
                $data[] = '?';
                $vals[] = $value;
            }

            $res = self::$dbConnection->prepare("INSERT INTO {$this->getModelName()} ($fields) VALUES(" . implode(',', $data) . ")");
            if (!$res->execute($vals)) {
                handleError($res->errorInfo());
                die();
            }
            $res = null;
            return true;
        }

        /**
         * Generate placeholders
         * 
         * @param integer $count
         * @return string
         */
        final private function placeholders($count = 0): string
        {
            $result = [];
            if($count > 0){
                for($x = 0; $x < $count; $x++){
                    $result[] = '?';
                }
            }
        
            return implode(',', $result);
        }

        /**
         * Insert many record into the database
         *
         * @param array $values
         * @return bool
         */
        final public function insertManyRecord(array $records): bool
        {
            $fields = implode(',', array_keys($records[0]));
            $vals = [];
            $data = [];
            foreach ($records as $record) {
                $data[] = "({$this->placeholders(count($record))})";
                $vals = array_merge($vals, array_values($record));
            }

            $res = self::$dbConnection->prepare("INSERT INTO {$this->getModelName()} ($fields) VALUES " . implode(',', $data));
            if (!$res->execute($vals)) {
                handleError($res->errorInfo());
                die();
            }
            $res = null;
            return true;
        }

        /**
         * Delete a record by id
         * @param int $id
         * @return bool
         */
        final public function deleteRecordById(int $id): bool
        {
            $query = "DELETE FROM {$this->getModelName()} WHERE id=?";
            $res = self::$dbConnection->prepare($query);
            if (!$res->execute([$id])) {
                handleError($res->errorInfo());
                die();
            }
            $res = null;
            return true;
        }
    }
}
