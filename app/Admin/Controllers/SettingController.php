<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Service\Service;
use App\Service\SettingService;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function create(Content $content)
    {
        return $content
            ->header('系统设置')
            ->description(trans('admin.setting'))
            ->body($this->form());
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $message = SettingService::settParam($params);
        return Service::MessageBagReturn($message,'/admin/setting/create');
    }

    public function form()
    {
        $SettingModel = new Setting();
        $form = new Form($SettingModel);
        $set_data = Setting::pluck('value','key');
        $form->number('max_reservation_num', '平台预约最大人数')->default($set_data['max_reservation_num'])->rules('required');
        $form->fieldset('午餐预约时间', function (Form $form) use ($set_data) {
            $form->time('lunch_reservation_start_time', '开启时间')->default($set_data['lunch_reservation_start_time'])->rules('required');
            $form->time('lunch_reservation_end_time', '结束时间')->default($set_data['lunch_reservation_end_time'])->rules('required');
        });

        $form->fieldset('晚餐预约时间', function (Form $form) use ($set_data) {
            $form->time('night_reservation_start_time', '开启时间')->default($set_data['night_reservation_start_time'])->rules('required');
            $form->time('night_reservation_end_time', '结束时间')->default($set_data['night_reservation_end_time'])->rules('required');
        });
        $form->divider();
        $form->number('dining_lot', '就餐时间批次')->default($set_data['dining_lot'])->rules('required');
        $form->time('first_lunch_time', '午餐首批用餐时间')->default($set_data['first_lunch_time'])->rules('required');
        $form->time('first_night_time', '晚餐首批用餐时间')->default($set_data['first_night_time'])->rules('required');
        $form->number('eat_interval', '批次间隔时间(分钟)')->default($set_data['eat_interval'])->rules('required');
        $form->radio('special_eat', '特殊就餐自动审核')->default($set_data['special_eat'])->options([1 => '是', 0 => '否'])->rules('required');

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }
}
