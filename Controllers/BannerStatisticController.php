<?php

namespace TBNFTBanner\Controllers;

use TBNFTBanner\Model\Resources\BannerStatisticResource;

class BannerStatisticController
{
    protected $banerStatisticSource;

    public function __construct()
    {
        $this->banerStatisticSource = BannerStatisticResource::getInstance();
    }

    public function getAvailableBanners()
    {
        return $this->banerStatisticSource->getAvailableBanners();
    }

    public function getList($params)
    {
        return $this->banerStatisticSource->getList($params);
    }

    public function getCount($params)
    {
        return $this->banerStatisticSource->getCount($params);
    }

    public function getTotalsByBannerId($id)
    {
        return $this->banerStatisticSource->getTotalsByBannerId($id);
    }

}

