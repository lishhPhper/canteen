<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppointLog;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class AppointmentController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('预约管理')
            ->description(trans('admin.appointment'))
            ->body($this->grid()->render());
    }

    public function grid()
    {
        $grid = new Grid(new AppointLog());
        $next_date = date('Y-m-d',strtotime("+1 day"));
        $grid->model()->where('appoint_date',$next_date)->where('appoint_type',1);
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableTools();
        $grid->column('id', 'ID')->sortable();
        $grid->user()->name(trans('admin.name'));
        $grid->user()->phone(trans('admin.phone'));
        $grid->user()->department(trans('admin.department'));
        $grid->eat_type(trans('food.server_type'))->using([1 => '午餐', 2 => '晚餐']);
        $grid->appoint_date(trans('food.appoint_date'));

        $grid->disableActions();

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1/3, function ($filter) {
                // 在这里添加字段过滤器
                $filter->like('user.name', trans('admin.name'));
            });
            $filter->column(1/3, function ($filter) {
                // 在这里添加字段过滤器
                $filter->equal('user.phone', trans('admin.phone'));
            });
            $filter->column(1/3, function ($filter) {
                // 在这里添加字段过滤器
                $filter->equal('eat_type', trans('food.server_type'))->select([
                    1 => '午餐',
                    2 => '晚餐'
                ]);
            });
        });

        return $grid;
    }
}
