<?php

namespace TBNFTBanner\Model\Abstractions;

/**
 * Class AbstractDataExportModel
 * @package lnwDataExporter\Model\Abstraction
 */
abstract class AbstractDataExportModel
{
    protected $wpDb;

    public function getWpDb()
    {
        if (!$this->wpDb) {
            global $wpdb;

            $this->wpDb = $wpdb;
        }
        return $this->wpDb;
    }

    abstract public function getTotalRows($id);

    abstract public function getChunk($fields, $offset, $limit);
}
