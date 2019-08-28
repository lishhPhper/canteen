<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use App\Models\WebUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class UserInfoController extends Controller
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
     * Create interface.
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('用户')
            ->description(trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->userModel);
        $grid->disableRowSelector();
        $grid->disablePagination();
        $grid->model()
            ->select('type',DB::raw('COUNT(*) as type_count'))
            ->groupBy('type')->orderBy('type', 'asc');
        $grid->column('type','类别')->display(function () {
            if ($this->type == 1) {
                return '普通员工';
            }
            return '白名单';
        });
        $grid->column('type_count','数量');
        $grid->column('updated_at',trans('admin.updated_at'))->display(function () {
            return date('Y-m-d H:i:s');
        });

        $grid->disableActions();
        $grid->disableFilter();
        $grid->disableColumnSelector();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $form = new Form(new $this->userModel);

        $form->display('id', 'ID');

        $form->text('name', trans('admin.name'))->rules('required');
        $form->mobile('phone', trans('admin.phone'))->options(['mask' => '99999999999'])->rules('required|numeric',[
            'numeric'   => '必须是数字',
        ]);
        $form->password('password', trans('admin.password'))->rules('required | min:6 | alpha_num',[
            'min'   => '最少6位长度',
            'alpha_dash'   => '必须是完全是字母、数字',
        ]);
        $form->text('department', trans('admin.department'))->rules('required');
        $form->select('type', '选择用户类型')->options([1 => '普通员工', 2 => '白名单', 3 => '管理员'])->rules('required');

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        $form->saving(function (Form $form) {
            $count = DB::table('users')->where('phone',$form->phone)->count();
            if($count > 0){
                $error = new MessageBag([
                    'title'   => '保存失败',
                    'message' => '手机号码已存在',
                ]);
                return back()->with(compact('error'));
            }
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });

        return $form;
    }
}
