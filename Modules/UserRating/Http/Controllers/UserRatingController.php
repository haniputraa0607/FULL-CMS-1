<?php

namespace Modules\UserRating\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class UserRatingController extends Controller
{
    public function index(Request $request,$key = '')
    {                    
        $data = [
            'title'          => 'User rating',
            'sub_title'      => 'User rating List',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-list',
            'key'            => $key,
            'filter_title'   => 'User Rating Filter'
        ];
        $page = $request->get('page')?:1;
        $post = [];
        if($key){
            $post['outlet_code'] = $key;
        }
        $data['ratingData'] = MyHelper::post('user-rating?page='.$page,$post)['result']??[];
        $outlets = MyHelper::get('outlet/be/list')['result']??[];
        $data['outlets'] = array_map(function($var){
            return [$var['id_outlet'],$var['outlet_name']];
        },$outlets);
        $data['next_page'] = $data['ratingData']['next_page_url']?url()->current().'?page='.($page+1):'';
        $data['prev_page'] = $data['ratingData']['prev_page_url']?url()->current().'?page='.($page-1):'';
        return view('userrating::index',$data);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'User rating',
            'sub_title'      => 'User rating Detail',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-detail'
        ];
        $post = [
            'id' => $id
        ];
        $data['rating'] = MyHelper::post('user-rating/detail',$post)['result']??false;
        if(!$data['rating']){
            return back()->withErrors(['User rating not found']);
        }
        return view('userrating::show',$data);
    }
}
