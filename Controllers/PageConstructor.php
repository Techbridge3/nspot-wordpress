<?php

namespace TBNFTBanner\Controllers;

use TBNFTBanner\Model\Constructor\ConfigPage;
use TBNFTBanner\Model\Constructor\StatisticPage;

/**
 * Class PageConstructor
 * @package TBNFTBanner
 */
class PageConstructor
{
    /**
     * pages pool
     *
     * @var array
     */
    protected $pages = [];

    /**
     * PageConstructor constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->pageCreator($config);
    }

    /**
     * @param $config
     */
    protected function pageCreator($config)
    {
        $this->pages['config'] = new ConfigPage($config);
        $this->pages['statistic'] = new StatisticPage($config);
    }
}
