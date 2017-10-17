<?php

namespace App\Classes;

class Benchmark
{
    public $details;
    public $averages;
    public $sum;
    public $accounts;
    public $posts;

    public function setaverages($averages)
    {
        $this->averages = $averages;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function setAccounts($accounts)
    {
        $this->accounts = (isCollection($accounts) ? $accounts : collect($accounts));
    }

    public function setPosts($posts)
    {
        $this->posts = (isCollection($posts) ? $posts : collect($posts));
    }
}
