<?php

namespace App\Admin\Actions\Special;

use App\Models\EatLog;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchAdopt extends BatchAction
{
    public $name = '通过';

    public function handle(Collection $collection)
    {
        $EatLog = new EatLog();
        foreach ($collection as $model) {
            $model->verify_status = 1;
            $model->save();

            $EatLog->user_id = $model->user_id;
            $EatLog->appoint_id = $model->id;
            $EatLog->appoint_date = $model->appoint_date;
            $EatLog->eat_type = $model->eat_type;
            $EatLog->start_time = $model->start_time;
            $EatLog->end_time = $model->end_time;
            $EatLog->appoint_type = 2;
            $EatLog->save();
        }

        return $this->response()->success('审核成功')->refresh();
    }

}
