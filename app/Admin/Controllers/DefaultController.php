<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EatLog;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\MessageBag;

class DefaultController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('违约管理')
            ->description(trans('admin.default'))
            ->body($this->grid()->render());
    }

    public function grid()
    {
        $grid = new Grid(new EatLog());
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableTools();
        $grid->column('id', 'ID')->sortable();
        $grid->name(trans('admin.name'));
        $grid->phone(trans('admin.phone'));
        $grid->department(trans('admin.department'));
        $grid->appoint_date('违约日期');
        $grid->column('default_type','违约类型')->display(function () {
            // 普通预约
            if($this->appoint_type == 1){
                if(!$this->is_click){
                    $status_text = '未到食堂就餐';
                }elseif (!$this->is_face && $this->is_click == 1){
                    $status_text = '未刷脸就餐';
                }else{
                    $status_text = '已完成';
                }
            }
            // 特殊预约
            if($this->appoint_type == 2){
                if(!$this->is_face){
                    $status_text = '未刷脸就餐';
                }else{
                    $status_text = '已完成';
                }
            }
            return $status_text;
        });


        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
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

    public function destroy($id)
    {
        $info = EatLog::findOrFail($id);
        $info->default = 2;
        $info->save();
        $success = new MessageBag([
            'title'   => '已移除',
            'message' => '移除成功',
        ]);
        return redirect('/admin/default')->with(compact('success'));
    }
}
