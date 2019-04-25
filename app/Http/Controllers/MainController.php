<?php

namespace App\Http\Controllers;
use App\Http\Requests\Filter;
use App\MainService;

class MainController extends Controller
{
    public function actionIndex(Filter $request){
        $main_service = new MainService($request);
        $data = $main_service->filterHandle();
        return view('main',['films'=>$data['films'],'directors'=>$data['directors'],
            'rate'=>$data['rate'],'genres'=>$data['genres']]);
    }
}
