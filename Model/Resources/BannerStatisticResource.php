<?php

namespace TBNFTBanner\Model\Resources;

class BannerStatisticResource
{
    private static $instance;

    protected $wpDb;

    protected $bannerStatisticTable = 'tb_nft_banners_statistic	';

    private function __construct()
    {
        global $wpdb;
        $this->wpDb = $wpdb;
    }

    private function __wakeup()
    {

    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getAvailableBanners()
    {
        $sql = "SELECT DISTINCT banner_id FROM {$this->bannerStatisticTable}";
        $results = $this->wpDb->get_results($sql, OBJECT);
        return $results;
    }

    public function getList($params)
    {
        $where = ' WHERE 1 = 1 ';
        if (isset($params['where'])) {
            $where .= $params['where'];
        }
        $lim = $params['lim'] ?? 20;
        $offset = $params['offset'] ?? 0;
        $sql = "SELECT id, ref, views, clicks, (clicks / views) AS ckicks_per_view
                FROM {$this->bannerStatisticTable} {$where}
                ORDER BY views DESC
                LIMIT {$lim} OFFSET {$offset} 
                ";
        $results = $this->wpDb->get_results($sql, OBJECT);

        return $results;
    }

    public function getCount($params)
    {
        $where = ' WHERE 1 = 1 ';
        if (isset($params['where'])) {
            $where .= $params['where'];
        }
        $sql = "SELECT COUNT(id) as count FROM {$this->bannerStatisticTable} {$where}";
        $results = $this->wpDb->get_results($sql, OBJECT);

        $count = $results[0]->count ?? 0;
        return $count;
    }

    public function getBy($condition)
    {
        $where = 'WHERE 1 = 1 ';
        if ($condition) {
            $where .= $condition;
        }
        $sql = "SELECT id, ref, views, clicks FROM {$this->bannerStatisticTable} {$where}";

        $results = $this->wpDb->get_results($sql, OBJECT);
        return $results[0] ?? [];
    }

    public function getTotalsByBannerId($id)
    {
        $results = $this->wpDb->get_results("SELECT SUM(clicks) AS totalClicks, SUM(views) AS totalViews FROM  {$this->bannerStatisticTable} WHERE banner_id = '{$id}'");
        return $results[0] ?? [];
    }

    public function updateViews($id)
    {
        $this->wpDb->query("UPDATE {$this->bannerStatisticTable} SET views=views+1 WHERE id= {$id}");
    }

    public function updateClicks($id)
    {
        $this->wpDb->query("UPDATE {$this->bannerStatisticTable} SET clicks=clicks+1 WHERE id= {$id}");
    }

    public function insert($params)
    {
        if (isset($params['bannerId']) && isset($params['ref'])) {
            $this->wpDb->query("
            INSERT INTO {$this->bannerStatisticTable} (banner_id, ref, views) 
            VALUES ('{$params['bannerId']}', '{$params['ref']}', 1);"
            );
        }
    }

}
