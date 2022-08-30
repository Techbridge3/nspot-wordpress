<?php

use TBNFTBanner\Controllers\BannerStatisticController;
use TBNFTBanner\Helper\View;

$statisticController = new BannerStatisticController();
$banners = $statisticController->getAvailableBanners();

$bannerId = $_GET['banner_id'] ?? null;

$defaultUrl = site_url('/wp-admin/admin.php?page=nSpot_banner_statistic');
?>
<?php ob_start(); ?>
<?php if (!$banners): ?>
    <h1><?php echo __('No statistic yet'); ?></h1>
<?php else: ?>
    <div><?php _e('Please select a banner'); ?></div>
    <form method="get" action="<?php echo $defaultUrl; ?>" class="settings-form">
        <label>
            <input type="hidden" name="page" value="nSpot_banner_statistic">
            <select name='banner_id'>
                <?php foreach ($banners as $banner): ?>
                    <?php
                    $selected = '';
                    if ($banner->banner_id == $bannerId) {
                        $selected = 'selected = "selected"';
                    }
                    ?>
                    <option <?php echo $selected; ?>
                            value="<?php echo $banner->banner_id; ?>"><?php echo $banner->banner_id; ?></option>
                <?php endforeach; ?>
            </select>

        </label>
        <button><?php _e('Submit'); ?></button>
    </form>
    <?php
    $list = [];
    $count = 0;
    $pages = 0;
    if ($bannerId) {
        $limit = 10;
        $count = $statisticController->getCount(['where' => "AND banner_id = '{$bannerId}'"]);
        $curPage = (isset($_GET['p']) && (int)$_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = $limit * ($curPage - 1);
        $list = $statisticController->getList([
                'lim' => $limit,
                'offset' => $offset,
                'where' => "AND banner_id = '{$bannerId}'"]
        );
        if ($count > 0) {
            $pages = (int)ceil($count / $limit);
        }
    }
    $totals = $statisticController->getTotalsByBannerId($bannerId);
    ?>
    <div>
        <?php if (!empty($list)): ?>
            <div>
                <span>total: <?php echo $count;?></span>
                <?php echo View::renderParts('export_button.php', [
                    'buttonName' => 'Export',
                    'buttonID' => 'banners_export',
                    'action' => 'exportBannerStatistic',
                    'step' => 0,
                    'offset' => 30,
                    'id' => $bannerId,
                    'totalRows' => $count,
                ]);?>
            </div>
            <table class="blueTable" style="width: 100%;">
                <tr>
                    <th>
                        <?php _e('id'); ?>
                    </th>
                    <th>
                        <?php _e('ref'); ?>
                    </th>
                    <th>
                        <?php _e('views'); ?>
                    </th>
                    <th>
                        <?php _e('clicks'); ?>
                    </th>
                    <th>
                        <?php _e('clicks per view'); ?>
                    </th>
                </tr>
                <?php foreach ($list as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item->id; ?>
                        </td>
                        <td>
                            <?php echo $item->ref; ?>
                        </td>
                        <td>
                            <?php echo $item->views; ?>
                        </td>
                        <td>
                            <?php echo $item->clicks; ?>
                        </td>
                        <td>
                            <?php echo $item->ckicks_per_view; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div>
                <?php foreach ($totals as $k => $total): ?>
                    <b><?php echo "{$k} : $total"; ?>; </b>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h1><?php echo __('No statistic yet'); ?></h1>
        <?php endif; ?>

    </div>

    <br/>
    <?php if ($pages > 1): ?>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <?php if ($curPage == $i): ?>
                <b><?php echo $i; ?></b>
            <?php else: ?>
                <a href="<?php echo "{$defaultUrl}&banner_id={$bannerId}&p={$i}"; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>
<?php endif; ?>
<style>
    table.blueTable {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
    }

    table.blueTable td, table.blueTable th {
        border: 1px solid #AAAAAA;
        padding: 3px 2px;
    }

    table.blueTable tbody td {
        font-size: 13px;
    }

    table.blueTable thead th {
        font-size: 15px;
        font-weight: bold;
        border-left: 2px solid #D0E4F5;
    }

    table.blueTable thead th:first-child {
        border-left: none;
    }

    table.blueTable tfoot {
        font-size: 14px;
        font-weight: bold;
        border-top: 2px solid #444444;
    }
</style>
<?php return ob_get_clean(); ?>
