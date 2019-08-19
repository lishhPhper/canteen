<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class FoodController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('菜品')
            ->description(trans('admin.food'))
            ->body($this->grid()->render());
    }

    public function create(Content $content)
    {
        return $content
            ->header('菜品')
            ->description(trans('admin.create'))
            ->body($this->form());
    }

    public function edit(Content $content, $id)
    {
        return $content
            ->header('菜品')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    public function grid()
    {
        $grid = new Grid(new Food());
        $grid->disableRowSelector();
        $grid->disableFilter();
        $grid->name(trans('food.name'));
        $grid->num(trans('food.num'));
        $grid->created_at(trans('admin.created_at'));

        $grid->quickSearch('name');
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        return $grid;
    }

    public function form()
    {
        $form = new Form(new Food());

        $form->display('id', 'ID');

        $form->text('name', trans('food.name'))->rules('required');
        $form->number('num', trans('food.num'))->rules('required');
        $form->image('img_url', trans('food.img_url'))->uniqueName()->rules('required');

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }
}
