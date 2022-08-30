<?php

namespace TBNFTBanner\Model\Abstractions;

/**
 * Class DbExportModel
 *
 * @package TBMycredCoupons\admin\Model\Resource
 */
abstract class AbstractDbExportModel extends AbstractDataExportModel
{
    protected $wpDb;

    protected $fields;

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function getWpDb()
    {
        if (!$this->wpDb) {
            global $wpdb;

            $this->wpDb = $wpdb;
        }
        return $this->wpDb;
    }
}
