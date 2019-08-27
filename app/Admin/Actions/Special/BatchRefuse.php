<?php

namespace App\Admin\Actions\Special;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchRefuse extends BatchAction
{
    public $name = '拒绝';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $model->verify_status = 2;
            $model->save();
        }

        return $this->response()->success('审核成功')->refresh();
    }

}
