<?php

namespace TBNFTBanner\Controllers;

use TBNFTBanner\Model\Resources\BannerStatisticResource;

class BannerController
{
    protected $banerStatisticSource;

    public function __construct()
    {
        add_action(
            'wp_ajax_addBannerStatisticViews',
            [$this, 'addBannerStatisticViews']
        );
        add_action(
            'wp_ajax_nopriv_addBannerStatisticViews',
            [$this, 'addBannerStatisticViews']
        );
        add_action(
            'wp_ajax_addBannerStatisticClicks',
            [$this, 'addBannerStatisticClicks']
        );
        add_action(
            'wp_ajax_nopriv_addBannerStatisticClicks',
            [$this, 'addBannerStatisticClicks']
        );
        add_action('wp_footer', [$this, 'addBannerScript']);
        $this->banerStatisticSource = BannerStatisticResource::getInstance();
    }

    public function addBannerStatisticViews()
    {
        if (isset($_POST['ref']) && isset($_POST['bannerId'])) {
            $ref = strip_tags($_POST['ref']);
            $bannerId = strip_tags($_POST['bannerId']);
            $where = "AND ref = '{$ref}' AND banner_id = '{$bannerId}'";
            $bannerStatistic = $this->banerStatisticSource->getBy($where);
            if (!$bannerStatistic) {
                $this->banerStatisticSource->insert(['bannerId' => $bannerId, 'ref' => $ref]);
            } else {
                $this->banerStatisticSource->updateViews($bannerStatistic->id);
            }
        }
        echo 'success';
        die;
    }

    public function addBannerStatisticClicks()
    {
        if (isset($_POST['ref']) && isset($_POST['bannerId'])) {
            $ref = strip_tags($_POST['ref']);
            $bannerId = strip_tags($_POST['bannerId']);
            $where = "AND ref = '{$ref}' AND banner_id = '{$bannerId}'";
            $bannerStatistic = $this->banerStatisticSource->getBy($where);
            if ($bannerStatistic) {
                $this->banerStatisticSource->updateClicks($bannerStatistic->id);
            }
        }
        echo 'success';
        die;
    }

    public function addBannerScript()
    {
        $options = apply_filters('getNFTBannerConfigOptions', 'options');
        $contractID = $options['contractID'] ?? '';
        $callerPrivateKey = $options['callerPrivateKey'] ?? '';
        $callerAccountName = $options['callerAccountName'] ?? '';
        $bannerZoneId1 = $options['banner_zone_id_1'] ?? '';
        $env = $options['env'] ?? 'testnet';
        if (!$contractID || !$callerPrivateKey || !$env) {
            return false;
        }

        ?>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const contract = new window.NFTBannerContract(
                    '<?php echo $callerPrivateKey;?>',
                    '<?php echo $callerAccountName;?>',
                    '<?php echo $env;?>',
                    '<?php echo $contractID;?>',
                    '<?php echo $bannerZoneId1;?>',
                );
                contract.init();
            });
        </script>
        <?php
        return true;
    }
}

