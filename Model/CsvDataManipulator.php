<?php

namespace TBNFTBanner\Model;

use League\Csv\Writer;

class CsvDataManipulator
{
    protected $fileName;

    public function read()
    {
        // TODO: Implement read() method.
    }

    public function write($file, $start, $data, $fields)
    {
        if ($start > 0) {
            $writer = Writer::createFromPath($file, 'a');
        } else {
            $writer = Writer::createFromPath($file, 'w+');
            $writer->insertOne($fields);
        }
        $writer->insertAll(new \ArrayIterator($data));
    }
}
