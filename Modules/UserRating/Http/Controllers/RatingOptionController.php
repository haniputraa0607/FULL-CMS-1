<?php

namespace Modules\UserRating\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class RatingOptionController extends Controller
{
    public function index(Request $request)
    {                    
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Rating Option Rule',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'rating-option'
        ];
        $data['data'] = MyHelper::get('user-rating/option')['result']??[];
        return view('userrating::option.index',$data);
    }

    public function store(Request $request){
        $result = MyHelper::post('user-rating/option/update',$request->except('_token'));
        if(($result['status']??false)!='success'){
            return back()->withInput()->withErrors($result['messages']??['Something went wrong']);
        }
        return back()->with('success',['Success update rating option']);
    }
}
