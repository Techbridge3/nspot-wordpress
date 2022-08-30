<?php

namespace TBNFTBanner\Model\Resources;

use TBNFTBanner\Controllers\BannerStatisticController;
use TBNFTBanner\Model\Abstractions\AbstractDbExportModel;

class ExportSourceModel extends AbstractDbExportModel
{

    protected BannerStatisticController $statisticController;

    public function __construct()
    {
        $this->statisticController = new BannerStatisticController();
    }

    public function getTotalRows($id)
    {
        $this->statisticController->getCount(['where' => "AND banner_id = '{$id}'"]);
    }

    public function getFieldsLabels()
    {
        return [
            'id' => 'ID',
            'ref' => 'Ref',
            'views' => 'Views',
            'clicks' => 'Clicks',
            'clicks_per_view' => 'Clicks per view'
        ];
    }


    final public function getChunk($id, $offset = 0, $limit = 500)
    {
        $list = $this->statisticController->getList([
                'lim' => $limit,
                'offset' => $offset,
                'where' => "AND banner_id = '{$id}'"]
        );
        $data = [];
        if (!empty($list)) {
            foreach ($list as $statistic) {
                    $data[] = [
                        'id' => $statistic->id,
                        'ref' => $statistic->ref,
                        'views' => $statistic->views,
                        'clicks' => $statistic->clicks,
                        'ckicks_per_view' => $statistic->ckicks_per_view,
                    ];
                }
            }
        return $data;
    }
}
