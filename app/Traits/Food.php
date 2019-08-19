<?php
namespace App\Traits;

trait Food
{
    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\Food();
    }

    public function foodList()
    {
        return $this->model
            ->select('id','name')
            ->get();
    }
}
