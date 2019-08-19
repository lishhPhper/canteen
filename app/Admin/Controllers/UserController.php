<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use App\Models\WebUser;

class UserController extends Controller
{
    use HasResourceActions;

    private $userModel;

    public function __construct()
    {
        $this->userModel = WebUser::class;
    }

    /**
     * Index interface.
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('用户')
            ->description(trans('admin.user'))
            ->body($this->grid()->render());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->userModel());
        $grid->disableRowSelector();
        $grid->id('ID')->sortable();
        $grid->name(trans('admin.name'));
        $grid->phone(trans('admin.phone'));
        $grid->department(trans('admin.department'));
        $grid->column('face_id',trans('admin.face_id'))->display(function () {
            if (!empty($this->face_id)) {
                return '已采集';
            }
            return '未采集';
        });

        $grid->disableCreateButton();
        $grid->disableActions();

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1/3, function ($filter) {
                // 在这里添加字段过滤器
                $filter->like('name', trans('admin.name'));
            });
            $filter->column(1/3, function ($filter) {
                // 在这里添加字段过滤器
                $filter->equal('phone', trans('admin.phone'));
            });
            $filter->column(1/3, function ($filter) {
                // 在这里添加字段过滤器
                $filter->in('type', '筛选类别')->select([
                    '1,2' => '全部',
                    '1' => '普通员工',
                    '2' => '白名单'
                ]);
            });
        });

        return $grid;
    }
}
