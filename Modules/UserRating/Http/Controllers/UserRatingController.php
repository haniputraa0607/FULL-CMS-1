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
        $data['total'] = $data['ratingData']['total']??0;
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
        return ($post['redirect']??false)?redirect($post['redirect']):back();
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

        $post['id_transaction'] = $data['rating']['id_transaction'];
        $post['type'] = 'trx';
        $post['check'] = 1;

        $check = MyHelper::post('transaction/be/detail/webview?log_save=0', $post);
        // $check = MyHelper::post('outletapp/order/detail/view?log_save=0', $data);
        if (isset($check['status']) && $check['status'] == 'success') {
            $data['data'] = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
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
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function report(Request $request)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report',
            'filter_title'   => 'User Rating Filter'
        ];
        $date_start = date('Y-m-d H:i:s',strtotime(session('rating_date_start',date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s',strtotime(session('rating_date_end',date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('rating_photos_only',0);
        $post['notes_only'] = session('rating_notes_only',0);
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $data['reportData'] = MyHelper::post('user-rating/report',$post)['result']??[];
        if(!$data['reportData']){
            return back()->withErrors(['Rating data not found']);
        }
        $ratingOk = [];
        foreach ($data['reportData']['rating_item'] as $value) {
            $ratingOk[$value['rating_value']] = $value;
        }
        $outletOk = [];
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        foreach ($data['reportData']['outlet_data'] as $value) {
            if(!$colorRand){
                $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
            }
            $randomNumber = array_rand($colorRand);
            $outletOk[$value['rating_value']][] = [
                'name' => $value['outlet_code'].' - '.$value['outlet_name'],
                'total' => $value['total'],
                'color' => $colorRand[$randomNumber]
            ];
            unset($colorRand[$randomNumber]);
        }
        $data['date_start'] = date('d F Y',strtotime($date_start));
        $data['date_end'] = date('d F Y',strtotime($date_end));
        $data['reportData']['rating_item'] = $ratingOk;
        $data['reportData']['outlet_data'] = $outletOk;
        return view('userrating::report',$data+$post);
    }
    public function setReportFilter(Request $request)
    {
        $post = $request->except('_token');
        $new_sess = [];
        if($request->post('date_start')){
            $new_sess['rating_date_start'] = str_replace('-','',$request->post('date_start',date('01 M Y')));
        }
        if($request->post('date_end')){
            $new_sess['rating_date_end'] = str_replace('-','',$request->post('date_end',date('d M Y')));
        }
        if(!is_null($request->post('photos_only'))){
            $new_sess['rating_photos_only'] = !!$request->post('photos_only');
        }
        if(!is_null($request->post('notes_only'))){
            $new_sess['rating_notes_only'] = !!$request->post('notes_only');
        }
        if(!is_null($request->post('order'))){
            $new_sess['rating_order'] = $request->post('order');
        }
        if($request->exists('search')){
            $new_sess['rating_search'] = $request->post('search');
        }
        session($new_sess);
        return back();
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportOutlet(Request $request)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report',
            'filter_title'   => 'User Rating Filter'
        ];
        $post = $request->except('_token');
        $date_start = date('Y-m-d H:i:s',strtotime(session('rating_date_start',date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s',strtotime(session('rating_date_end',date('Y-m-d H:i:s'))));
        $page = $request->get('page')?:1;
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['order'] = session('rating_order','outlet_name');
        $post['search'] = session('rating_search');
        $post['page'] = $page;
        // return $post;
        $data['outlet_data'] = MyHelper::post('user-rating/report/outlet',$post)['result']??[];
        $data['next_page'] = $data['outlet_data']['next_page_url']?url()->current().'?page='.($page+1):'';
        $data['prev_page'] = $data['outlet_data']['prev_page_url']?url()->current().'?page='.($page-1):'';
        $data['date_start'] = date('d F Y',strtotime($date_start));
        $data['date_end'] = date('d F Y',strtotime($date_end));
        return view('userrating::report_outlet',$data+$post);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportOutletDetail(Request $request,$outlet_code)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report',
            'filter_title'   => 'User Rating Filter'
        ];
        $date_start = date('Y-m-d H:i:s',strtotime(session('rating_date_start',date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s',strtotime(session('rating_date_end',date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('rating_photos_only',0);
        $post['notes_only'] = session('rating_notes_only',0);
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['outlet_code'] = $outlet_code;
        $data['reportData'] = MyHelper::post('user-rating/report/outlet',$post)['result']??[];
        if(!$data['reportData']){
            return back()->withErrors(['Rating data not found']);
        }
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        $data['date_start'] = date('d F Y',strtotime($date_start));
        $data['date_end'] = date('d F Y',strtotime($date_end));
        return view('userrating::report_outlet_detail',$data+$post);
    }
}
