<?php

namespace TBNFTBanner\Model\Constructor;

use TBNFTBanner\Controllers\BannerController;
use TBNFTBanner\Controllers\ExportController;
use TBNFTBanner\Controllers\ShortcodeCreator;
use TBNFTBanner\Model\Config;
use TBNFTBanner\Controllers\PageConstructor;
use TBNFTBanner\Setup\InstallSchema;

/**
 * Init all main functionality
 *
 * Class Constructor
 * @package TBLNCCertificate\Model\Constructor
 */
class Constructor
{
    /**
     * Self Constructor object.
     * @var $_instance
     */
    private static $_instance;

    /**
     * @var Config
     */
    private $config;

    /**
     * protect singleton  clone
     */
    private function __clone()
    {

    }

    /**
     * Method to use native functions as methods
     *
     * @param $name
     * @param $arguments
     * @return bool|mixed
     */
    public function __call($name, $arguments)
    {
        if (function_exists($name)) {
            return call_user_func_array($name, $arguments);
        }
        return false;
    }

    /**
     * protect singleton __wakeup
     */
    private function __wakeup()
    {

    }

    private function __construct()
    {
        $this->config = new Config();
        $this->setupSchemes();
        $this->setUpActions();
    }

    protected function setupSchemes()
    {
        new InstallSchema();
    }


    public function addFrontendStuffs()
    {
        $this->addScripts();
        $this->initFrontendControllers();
    }

    /**
     * Method to register plugin scripts
     */
    public function addScripts()
    {
        add_action('wp_footer', function() {
            wp_enqueue_script(
                'tb-nft-banner',
                $this->config->getScriptsPath() . 'index.js',
                ['jquery'],
                $this->config->getVersion()
            );
        });
    }

    protected function initFrontendControllers()
    {
        new PageConstructor($this->config);
        new BannerController();
        new ShortcodeCreator();
    }
    public function addAdminStuffs()
    {
        new ExportController($this->config);
    }


    /**
     * Method to setup WP actions.
     */
    private function setUpActions()
    {
        add_action('plugins_loaded', [&$this, 'setPageTemplates']);
        add_action('init', [&$this, 'registerPostType']);
        add_action('admin_init', [&$this, 'addAdminStuffs']);
        add_action('init', [&$this, 'addFrontendStuffs']);
        add_action('init', [&$this, 'addScripts']);
        add_action('wp_head', [&$this, 'addVariables']);

    }

    public function addVariables()
    {
        ?>
            <script>window.ajaxurl = '<?php echo site_url() .'/wp-admin/admin-ajax.php'?>';</script>
        <?php
    }

    public function setPageTemplates()
    {
    }

    /**
     * Register custom post types
     */
    public function registerPostType()
    {
        $posts = $this->config->getConfig('posts');
        foreach ($posts as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            $this->register_post_type($key, $item['args']);
        }
    }


    /**
     * Get self object
     *
     * @return Constructor object
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
