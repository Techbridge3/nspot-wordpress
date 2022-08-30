<?php

namespace TBNFTBanner\Model;


class DbExporterModel
{
    public static $instanceNumber = 0;

    /**
     * Screen for show export button
     * @var string
     */
    protected  $screen;

    protected  $filename;


    public function __construct(
        $resource,
        $dataManipulator,
        $filename,
        $config
    ) {
        $this->config = $config;
        $this->filename = $filename;
        $this->dataManipulator = $dataManipulator;
        $this->resource = $resource;
        $this->registerActions();

        self::$instanceNumber ++;
    }

    public function registerActions(): void
    {
        add_action("wp_ajax_exportBannerStatistic", [$this, 'exportAjax']);
        add_action("wp_ajax_exportBannerStatistic_getTotalRows", [$this, 'getTotalRows']);
    }


    public function export($start, $offset, $id) :bool
    {
        $fileName = wp_get_upload_dir()['basedir'] . '/' . $this->filename;

        $headers = $this->resource->getFieldsLabels();

        $chunk = $this->resource->getChunk($id, $start, $offset);
        if ($chunk) {
            $this->dataManipulator->write($fileName, $start, $chunk, $headers);
        }
        return true;
    }

    public function exportAjax()
    {
        $fileName = wp_get_upload_dir()['baseurl'] . '/' . $this->filename;

        if (isset($_POST['data']['step'])
            && isset($_POST['data']['offset'])
            && isset($_POST['data']['totalRows'])
            && isset($_POST['data']['id'])
        ) {
            $start = (int)strip_tags($_POST['data']['step']);
            $offset = (int)strip_tags($_POST['data']['offset']);
            $totalRows = (int)strip_tags($_POST['data']['totalRows']);
            $id = strip_tags($_POST['data']['id']);
            $offsetToGet =  $offset < $totalRows ? $offset : $totalRows;
            $this->export($start, $offsetToGet, $id);
        }

        echo $fileName;
        die;
    }

    public function getTotalRows(): int
    {
        return $this->resource->getTotalRows();
    }

}
