<?php

namespace TBNFTBanner\Controllers;

use TBNFTBanner\Helper\Data;

class ShortcodeCreator
{

    public function __construct()
    {
        add_shortcode('nspot_banner', [$this, 'bannerZone']);
    }


    public function bannerZone($atts): void
    {
        $bannerZone = isset($atts['bannerzone']) ? Data::clearString($atts['bannerzone']) : 'none';
        echo "<div id='{$bannerZone}'></div>";

    }


}
