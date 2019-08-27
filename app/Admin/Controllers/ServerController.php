<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServerFood;
use App\Service\ServerFoodService;
use App\Traits\Food;
use App\Traits\ServerFood as TServerFood;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Table;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class ServerController extends Controller
{
    use HasResourceActions;
    use Food,TServerFood;

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

    public function store(Request $request)
    {
        $params = $request->all();
        $message = ServerFoodService::saveServerFood($params);
        if(!$message['status']){
            $error = new MessageBag([
                'title'   => '保存失败',
                'message' => $message['msg'],
            ]);
            return redirect('/admin/server')->with(compact('error'));
        }else{
            $success = new MessageBag([
                'title'   => '保存成功',
                'message' => $message['msg'],
            ]);
            return redirect('/admin/server')->with(compact('success'));
        }
    }

    public function edit(Content $content, $id, Request $request)
    {
        return $content
            ->header('用户')
            ->description(trans('admin.create'))
            ->body($this->editForm()->edit($id));
    }

    public function update(Request $request, $id)
    {
        $params = $request->all();
        $message = ServerFoodService::updateServerFood($params);
        if(!$message['status']){
            $error = new MessageBag([
                'title'   => '编辑失败',
                'message' => $message['msg'],
            ]);
            return redirect('/admin/server')->with(compact('error'));
        }else{
            $success = new MessageBag([
                'title'   => '编辑成功',
                'message' => $message['msg'],
            ]);
            return redirect('/admin/server')->with(compact('success'));
        }
    }

    public function grid()
    {
        $grid = new Grid(new ServerFood());
        $grid->model()->orderBy('server_time','desc');
        $grid->disableRowSelector();
        $grid->column('id', 'ID')->sortable();
        $grid->food()->name(trans('food.name'));
        $grid->food_num(trans('food.num'));
        $grid->server_time(trans('food.server_time'));
        $grid->server_type(trans('food.server_type'))->using([1 => '午餐', 2 => '晚餐']);
        $grid->created_at(trans('admin.created_at'));
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableColumnSelector();

        // 自定义添加和编辑按钮
        $grid->tools(function (Grid\Tools $tools){
            $tools->append('<a class="btn btn-sm btn-success" style="float: right;" href="/admin/server/create"><i class="fa fa-plus"></i>&nbsp;次日配餐</a>');
        });
//        $grid->tools(function (Grid\Tools $tools){
//            $tools->append('<a class="btn btn-sm btn-danger" style="float: right;margin-right: 10px;" href="/admin/server/edit"><i class="fa fa-edit"></i>&nbsp;修改配餐</a>');
//        });
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
                // 在这里添加字段过滤器
                $filter->date('server_time', trans('food.server_time'));
            });
            $filter->column(1/2, function ($filter) {
                // 在这里添加字段过滤器
                $filter->equal('server_type', trans('food.server_type'))->select([
                    1 => '午餐',
                    2 => '晚餐'
                ]);
            });
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $server_info = ServerFood::findOrFail($actions->getKey());
            if ($server_info->server_time != date('Y-m-d',strtotime("+1 day"))) {
                $actions->disableEdit();
            }
        });


        return $grid;
    }

    public function form()
    {
        $form = new Form(new ServerFood());

        $form->display('id', 'ID');

        $form->date('server_time', trans('food.server_time'))->default(date('Y-m-d',strtotime("+1 day")))->rules('required');
        $form->checkbox('food_id',trans('food.name'))->options($this->foodList());
        $form->number('food_num', trans('food.num'))->rules('required');
        $form->select('server_type', trans('food.server_type'))->options([1 => '午餐', 2 => '晚餐'])->rules('required');

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }

    public function editForm()
    {
        $form = new Form(new ServerFood());

        $form->hidden('id', 'ID');
        $form->hidden('ids', 'ID');
        $form->date('server_time', trans('food.server_time'))->rules('required')->readonly();
        $form->checkbox('food_id_value',trans('food.name'))->options($this->foodList());
        $form->number('food_num', trans('food.num'))->rules('required')->readonly();
        $form->select('server_type', trans('food.server_type'))->options([1 => '午餐', 2 => '晚餐'])->rules('required')->readonly();

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }
}
