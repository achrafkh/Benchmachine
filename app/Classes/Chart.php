<?php

namespace App\Classes;

class Chart
{
    public $id;
    public $data;
    public $colors;
    public $labels;
    public $total;
    public $avg;
    public $title;
    public $class;
    public $title_en = true;
    public $label;

    /**
     * Chart constructor.
     */
    public function __construct()
    {
        $this->class = 'col-md-6';
        $this->colors = config('utils.colors');
    }

}
