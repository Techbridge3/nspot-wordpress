<?php

namespace TBNFTBanner\Controllers;

use TBNFTBanner\Helper\Data;

class ShortcodeCreator
{

    public function __construct()
    {
        add_shortcode('nspot_banner', [$this, 'bannerZone']);
    }


    public function bannerZone($atts)
    {
        $bannerZone = isset($atts['bannerzone']) ? Data::clearString($atts['bannerzone']) : 'none';
        return "<div id='{$bannerZone}'></div>";

    }


}
