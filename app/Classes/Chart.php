<?php

namespace App\Classes;

class Chart
{
    public $id;
    public $data;
    public $colors;
    public $labels;
    public $title;
    public $title_en = true;
    public $label;

    /**
     * Chart constructor.
     */
    public function __construct()
    {
        $this->colors = config('utils.colors');
    }

}
