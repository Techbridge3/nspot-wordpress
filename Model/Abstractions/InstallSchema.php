<?php

namespace TBNFTBanner\Model\Abstractions;

abstract class InstallSchema
{
    protected $version;

    protected $wpDb;

    public function __construct()
    {
        global $wpdb;
        $this->wpDb = $wpdb;
        $this->version = $this->getSetupVersion();
        $this->installSchemes();
    }

    abstract protected function installSchemes();

    abstract public function getSetupVersion();

    protected function createTable(string $table, array $fields)
    {
        if (!$this->isTableExists($table)) {
            $fields = implode(',', $fields);
            $charset_collate = "DEFAULT CHARACTER SET {$this->wpDb->charset} COLLATE {$this->wpDb->collate}";
            $sql = "CREATE TABLE  {$table}($fields) {$charset_collate};";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            return dbDelta($sql);
        }
        return false;
    }

    protected function isTableExists($table)
    {
        $query = "SHOW TABLES LIKE '{$table}'";
        if ($this->wpDb->get_var($query) != $table) {
            return false;
        }
        return true;
    }

    protected function isColumnExists($columnName, $tableName)
    {
        global $wpdb;
        $column = $wpdb->get_results(
            "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
                   WHERE table_name = '{$tableName}' 
                   AND column_name = '{$columnName}'
                   ");
        return $column;
    }
}
