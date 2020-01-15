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
            'title'          => 'User Rating',
            'sub_title'      => 'User Rating List',
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
        if(session('rating_list_filter')){
            $post=session('rating_list_filter');
            $data['rule']=array_map('array_values', $post['rule']);
            $data['operator']=$post['operator'];
        }
        $data['ratingData'] = MyHelper::post('user-rating?page='.$page,$post)['result']??[];
        $outlets = MyHelper::get('outlet/be/list')['result']??[];
        $data['total'] = count($data['ratingData']['data']??[]);
        $data['outlets'] = array_map(function($var){
            return [$var['id_outlet'],$var['outlet_name']];
        },$outlets);
        $data['next_page'] = $data['ratingData']['next_page_url']?url()->current().'?page='.($page+1):'';
        $data['prev_page'] = $data['ratingData']['prev_page_url']?url()->current().'?page='.($page-1):'';
        return view('userrating::index',$data);
    }

    public function setFilter(Request $request)
    {
        $post = $request->except('_token');
        if($post['rule']??false){
            session(['rating_list_filter'=>$post]);
        }elseif($post['clear']??false){
            session(['rating_list_filter'=>null]);
            session(['rating_list_filter'=>null]);
        }
        return back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'User Rating Detail',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-list'
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

    public function setting(Request $request) {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'User Rating Setting',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'rating-setting'
        ];
        $ratings = MyHelper::post('setting',['key-like'=>'rating'])['result']??[];
        $popups = MyHelper::post('setting',['key-like'=>'popup'])['result']??[];
        $data['rating'] = [];
        $data['popup'] = [];
        $data['options'] = MyHelper::get('user-rating/option')['result']??[];
        foreach ($ratings as $rating) {
            $data['setting'][$rating['key']] = $rating;
        }
        foreach ($popups as $popup) {
            $data['setting'][$popup['key']] = $popup;
        }
        return view('userrating::setting',$data);
    }

    public function settingUpdate(Request $request) {
        $data = [
            'popup_min_interval' => ['value',$request->post('popup_min_interval')],
            'popup_max_refuse' => ['value',$request->post('popup_max_refuse')],
            'rating_question_text' => ['value_text',substr($request->post('rating_question_text'),0,40)]
        ];
        $update = MyHelper::post('setting/update2',['update'=>$data]);
        if(($update['status']??false)=='success'){
            return redirect('user-rating/setting#tab_setting')->with('success',['Success update setting']);
        }else{
            return redirect('user-rating/setting#setting')->withInput()->withErrors(['Failed update setting']);
        }
    }
}
