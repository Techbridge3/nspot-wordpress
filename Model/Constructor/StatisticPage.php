<?php

namespace TBNFTBanner\Model\Constructor;

use TBNFTBanner\Model\Abstractions\AdminPages;
use TBNFTBanner\Helper\View;

/**
 * Class ConfigPage
 * @package TechbridgeNearLogin\Model\Constructor
 */
class StatisticPage extends AdminPages
{
    const OPTIONS_GROUP = 'statistic';

    const FILE_EXTENSION = 'php';

    public $config;

    public $optionsGroup;

    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }

    public function addAdminPage()
    {
        add_submenu_page(
            'nSpot_banner_config',
            'nSpot banner statistic',
            'nSpot banner statistic',
            'manage_options',
            'nSpot_banner_statistic',
            [&$this, 'displaySettingsPage']
        );
    }

    public function displaySettingsPage()
    {
        $path = $this->config->getTemplatesPath(). '/' . self::OPTIONS_GROUP . '.' . self::FILE_EXTENSION;
        View::view($path, $this);
    }

    public function getOptions()
    {
        return get_option(self::OPTIONS_GROUP);
    }

    public function registerSettings()
    {
        // TODO: Implement registerSettings() method.
    }
}
