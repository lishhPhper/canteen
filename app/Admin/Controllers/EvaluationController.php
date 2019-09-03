<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EvaluationLog;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Request;

class EvaluationController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('评价管理')
            ->description(trans('admin.evaluation'))
            ->body($this->grid()->render());
    }

    public function grid()
    {
        $evaluation_type = Request::get('evaluation_type');
        $grid = new Grid(new EvaluationLog());
        $grid->model()->where(function ($query) use ($evaluation_type){

        })->orderBy('created_at','desc');
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->column('id', 'ID')->sortable();
        $grid->user()->avatar(trans('admin.avatar'))->image(60, 60);
        $grid->user()->name(trans('admin.name'));
        $grid->point(trans('food.point'));
        $grid->evaluation(trans('food.evaluation'))->style('max-width:120px;');
        $grid->created_at(trans('admin.created_at'));

        $grid->disableActions();

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->where(function ($query) {
                if ($this->input == 2) {
                    $query->where('evaluation','>','');
                }
            }, '评价类型')->radio([
                '1' => '全部',
                '2' => '有内容评价',
            ]);
        });

        return $grid;
    }
}
