<?php

namespace App\Http\Controllers;

use App\Service\AppointService;
use Illuminate\Http\Request;

class AppointController extends Controller
{
    public function index()
    {
        $AppointService = new AppointService();
        return $this->success('', $AppointService->getReservationInfo());
    }

    public function confirm(Request $request)
    {
        $type = $request->post('type',0);
        $user_id = $request->user->id;
        $AppointService = new AppointService();
        $result = $AppointService->setAppiont($user_id,$type);
        return $this->success($result['msg'],$result['data'],$result['result']);
    }

    public function special()
    {
        $AppointService = new AppointService();
        return $this->success('', $AppointService->timeTable());
    }

    public function arraignment(Request $request)
    {
        $params = $request->all();
        $user_id = $request->user->id;
        $AppointService = new AppointService();
        $result = $AppointService->arraignmentSpecial($user_id, $params);
        return $this->success($result['msg'],$result['data'],$result['result']);
    }

    public function myReservation(Request $request)
    {
        $type = $request->get('type',1);
        $user_id = $request->user->id;
        $AppointService = new AppointService();
        return $this->success('', $AppointService->getMyReservation($user_id, $type));
    }

    public function reservationDetail(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type',1);
        $AppointService = new AppointService();
        return $this->success('', $AppointService->getReservationDetail($id,$type));
    }

    public function cancel(Request $request)
    {
        $id = $request->get('id');
        $AppointService = new AppointService();
        $result = $AppointService->cancelReservation($id);
        return $this->success($result['msg'],$result['data'],$result['result']);
    }

    public function refresh(Request $request)
    {
        $id = $request->get('id');
        $AppointService = new AppointService();
        $result = $AppointService->refreshReservation($id);
        return $this->success($result['msg'],$result['data'],$result['result']);
    }

    public function verifyList(Request $request)
    {
        $page = $request->get('page',1);
        $pagesize = $request->get('pagesize',15);
        $AppointService = new AppointService();
        return $this->success('', $AppointService->getVerifyList($page, $pagesize));
    }

    public function setVerify(Request $request)
    {
        $params = $request->all();
        $AppointService = new AppointService();
        $result = $AppointService->setVerifyStatus($params);
        return $this->success($result['msg'],$result['data'],$result['result']);
    }

    public function verifyResult(Request $request)
    {
        $page = $request->get('page',1);
        $pagesize = $request->get('pagesize',15);
        $AppointService = new AppointService();
        return $this->success('', $AppointService->getVerifyResult($page, $pagesize));
    }

    public function normalTotal(Request $request)
    {
        $eat_type = $request->get('eat_type',1);
        $page = $request->get('page',1);
        $pagesize = $request->get('pagesize',15);
        $AppointService = new AppointService();
        return $this->success('', $AppointService->getNormalTotal($eat_type, $page, $pagesize));
    }
}
