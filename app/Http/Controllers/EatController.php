<?php

namespace App\Http\Controllers;

use App\Service\EatService;
use Illuminate\Http\Request;

class EatController extends Controller
{
    public function dinnerLog(Request $request)
    {
        $page = $request->get('page',1);
        $pagesize = $request->get('pagesize',15);
        $user_id = $request->user->id;
        $EatService = new EatService();
        return $this->success('', $EatService->getDinnerLog($user_id, $page, $pagesize));
    }

    public function setEvaluation(Request $request)
    {
        $params = $request->all();
        $user_id = $request->user->id;
        $EatService = new EatService();
        $result = $EatService->setDinnerEvaluation($user_id, $params);
        return $this->success($result['msg'],$result['data'],$result['result']);
    }

    public function evaluationLog(Request $request)
    {
        $page = $request->get('page',1);
        $pagesize = $request->get('pagesize',15);
        $user_id = $request->user->id;
        $EatService = new EatService();
        return $this->success('', $EatService->getEvaluationLog($user_id, $page, $pagesize));
    }

    public function adminEvaluationLog(Request $request)
    {
        $page = $request->get('page',1);
        $pagesize = $request->get('pagesize',15);
        $EatService = new EatService();
        return $this->success('', $EatService->getAdminEvaluationLog($page, $pagesize));
    }
}
