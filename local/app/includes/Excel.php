<?php

use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\JsonableInterface;

class Excel implements ArrayableInterface, JsonableInterface {

    protected $objPHPExcel;

    public function __construct($file) {
        if ($file instanceof \SplFileInfo) {
            $filename = $file->getRealPath();
        } else {
            $filename = $file;
        }
        $this->objPHPExcel = PHPExcel_IOFactory::load($filename);
        $this->objPHPExcel->setActiveSheetIndex(0);
    }

    public function setActiveSheetIndex($index) {
        $this->objPHPExcel->setActiveSheetIndex($index);
    }

    /**
     * Create array from worksheet
     *
     * @param mixed $nullValue Value returned in the array entry if a cell doesn't exist
     * @param boolean $calculateFormulas Should formulas be calculated?
     * @param boolean $formatData  Should formatting be applied to cell values?
     * @param boolean $returnCellRef False - Return a simple array of rows and columns indexed by number counting from zero
     *                               True - Return rows and columns indexed by their actual row and column IDs
     * @return array
     */
    public function toArray($nullValue = null, $calculateFormulas = true, $formatData = false) {

        $rows = $this->objPHPExcel->getActiveSheet()->toArray($nullValue, $calculateFormulas, $formatData, false);
        $headers = array_shift($rows);

        array_walk($rows, function(&$values) use($headers) {
            $values = array_combine($headers, $values);
        });
        return $rows;
    }

    public function toJson($options = 0, $nullValue = null, $calculateFormulas = true, $formatData = false) {
        return json_encode($this->toArray($nullValue, $calculateFormulas, $formatData), $options);
    }

}
