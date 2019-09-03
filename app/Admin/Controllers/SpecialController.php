<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Special\BatchAdopt;
use App\Admin\Actions\Special\BatchRefuse;
use App\Admin\Extensions\Tools\ReleasePost;
use App\Http\Controllers\Controller;
use App\Models\AppointLog;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class SpecialController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('特殊预约管理')
            ->description(trans('admin.special'))
            ->body($this->grid()->render());
    }


    public function release(Request $request)
    {
        foreach (AppointLog::find($request->get('ids')) as $item) {
            $item->verify_status = $request->get('action');
            $item->save();
        }
    }

    public function grid()
    {
        $grid = new Grid(new AppointLog());
        $date = date('Y-m-d');
        $next_date = date('Y-m-d',strtotime("+2 day"));
        $grid->model()->whereBetween('appoint_date',[$date, $next_date])->where('verify_status',0)->where('appoint_type',2);
        $grid->disableCreateButton();
        $grid->disableExport();
//        $grid->disableTools();
        $grid->column('id', 'ID')->sortable();
        $grid->user()->name(trans('admin.name'));
        $grid->user()->phone(trans('admin.phone'));
        $grid->user()->department(trans('admin.department'));
        $grid->desc(trans('food.desc'));
        // 不存在的`full_name`字段
        $grid->column('appoint_time','预约时间')->display(function () {
            return $this->appoint_date . "<br/>" . substr($this->start_time,0,5). '-' . substr($this->end_time,0,5);
        });
        $grid->verify_status(trans('food.verify_status'))->using(['0' => '未审核', '1' => '审核通过', '2' => '拒绝通过']);
        $grid->disableActions();

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
                $batch->add(new BatchAdopt());
                $batch->add(new BatchRefuse());
            });
        });
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
                // 在这里添加字段过滤器
                $filter->like('user.name', trans('admin.name'));
            });
            $filter->column(1/2, function ($filter) {
                // 在这里添加字段过滤器
                $filter->equal('user.phone', trans('admin.phone'));
            });
        });

        return $grid;
    }
}
