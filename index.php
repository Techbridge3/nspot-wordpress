<?php
/**
 * Plugin Name: nPspot wordpress
 * Description: plugin for show nSpot banner
 * Version: 0.0.2
 * Author: Techbridge
 * Author URI: https://techbridge.ca/
 */

use TBNFTBanner\Model\Constructor\Constructor;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    _e('Install composer for current work');
    exit;
}

$constructor = Constructor::getInstance();
