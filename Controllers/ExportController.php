<?php

namespace TBNFTBanner\Controllers;

use TBNFTBanner\Model\CsvDataManipulator;
use TBNFTBanner\Model\DbExporterModel;
use TBNFTBanner\Model\Resources\ExportSourceModel;

class ExportController
{
    public function __construct($config)
    {
        new DbExporterModel(new ExportSourceModel(), new CsvDataManipulator(), 'nspot_export.csv', $config);
    }
}