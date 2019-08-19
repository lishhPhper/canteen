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

    public function create(Content $content)
    {
        return $content
            ->header('供餐')
            ->description(trans('admin.create'))
            ->body($this->form());
    }

    public function grid()
    {
        $grid = new Grid(new ServerFood());
        $grid->disableRowSelector();
        $grid->server_time(trans('food.server_time'));
        $grid->food->name(trans('food.name'));
        $grid->food_num(trans('food.num'));
        $grid->server_type(trans('food.num'));
        $grid->created_at(trans('admin.created_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        return $grid;
    }

    public function form()
    {
        $form = new Form(new ServerFood());

        $form->display('id', 'ID');

        $form->date('server_time', trans('food.server_time'))->rules('required');
        $form->checkbox('food_id',trans('food.name'))->options('/api/food/list');
        $form->number('num', trans('food.num'))->rules('required');
        $form->select('server_type', trans('food.server_type'))->options([1 => '午餐', 2 => '晚餐'])->rules('required');

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }
}
