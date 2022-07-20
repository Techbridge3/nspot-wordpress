<?php

namespace TBNFTBanner\Model\Constructor;

use TBNFTBanner\Model\Abstractions\AdminPages;
use TBNFTBanner\Helper\View;

/**
 * Class ConfigPage
 * @package TBNFTBanner\Model\Constructor
 */
class ConfigPage extends AdminPages
{
    const OPTIONS_GROUP = 'nft-banner-config';

    const FILE_EXTENSION = 'php';

    public $config;

    public string $optionsGroup;

    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
        $this->optionsGroup = $this->getOptionsGroup();
        $this->setUp();
    }

    public function addAdminPage()
    {
        add_menu_page(
            'nSpot Banner config',
            'nSpot Banner config',
            'manage_options',
            'nSpot_banner_config',
            [&$this, 'displaySettingsPage']
        );
    }

    public function setUp()
    {
        add_filter('getNFTBannerConfigOptions', [$this, 'getOptions']);
    }

    public function getOptionsGroup()
    {
        return self::OPTIONS_GROUP;
    }

    public function registerSettings()
    {
        register_setting(
            self::OPTIONS_GROUP, self::OPTIONS_GROUP
        );
    }

    public function displaySettingsPage()
    {
        $path = $this->config->getTemplatesPath(). '/' . self::OPTIONS_GROUP . '.' . self::FILE_EXTENSION;
        View::view($path, $this);
    }

    public function getOptions()
    {
        $options = get_option(self::OPTIONS_GROUP);
        return $options;
    }
}
