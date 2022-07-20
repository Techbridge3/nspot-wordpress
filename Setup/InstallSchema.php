<?php

namespace TBNFTBanner\Setup;

use TBNFTBanner\Model\Abstractions\InstallSchema as InstallSchemaAbstraction;

class InstallSchema extends InstallSchemaAbstraction
{
    const VERSION = 'tb_nft_banners_version';

    public function getSetupVersion()
    {
        $version = get_option(self::VERSION);
        if (!$version) {
            $version = '0.0.1';
            add_option(self::VERSION, $version, '', 'no');
        }
        return $version;
    }

    public function updateSetupVersion($version)
    {
        update_option(self::VERSION, $version);
    }

    protected function installSchemes()
    {
        if (!is_null($this->version)) {
            if ($this->version < '0.0.2') {
                $this->installScheme();
                $this->updateSetupVersion('0.0.2');
            }
            if ($this->version < '0.0.3') {
                $this->addIndexes();
                $this->updateSetupVersion('0.0.3');
            }
        }
    }

    protected function installScheme()
    {
        $table = 'tb_nft_banners_statistic';
        $fields = [
            "id int NOT NULL AUTO_INCREMENT",
            "banner_id text NOT NULL",
            "ref text NOT NULL",
            "views int NOT NULL DEFAULT 0",
            "clicks int NOT NULL DEFAULT 0",
            "UNIQUE KEY id (id)"
        ];
        $this->createTable($table, $fields);
    }

    protected function addIndexes()
    {
        $table = 'tb_nft_banners_statistic';
        $query = "create index banner_id_idx on {$table}(banner_id(50)) using HASH;";

        $this->wpDb->query($query);
    }

}
