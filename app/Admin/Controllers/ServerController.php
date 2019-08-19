<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServerFood;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ServerController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('供餐')
            ->description(trans('admin.server'))
            ->body($this->grid()->render());
    }

    public function create()
    {

    }

    public function grid()
    {
        $grid = new Grid(new ServerFood());
        $grid->disableRowSelector();
        $grid->name(trans('food.name'));
        $grid->num(trans('food.num'));
        $grid->created_at(trans('admin.created_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        return $grid;
    }
}
