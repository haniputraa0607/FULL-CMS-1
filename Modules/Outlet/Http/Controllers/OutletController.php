<?php

namespace Modules\Outlet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Lib\MyHelper;
use Excel;
use Validator;

use App\Exports\MultisheetExport;
use App\Imports\FirstSheetOnlyImport;

class OutletController extends Controller
{
    /**
     * list
     */
    public function index(Request $request) {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet List',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list',
        ];

        // outlet
        $outlet = MyHelper::post('outlet/be/list', ['all_outlet' => 1]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            $data['outlet'] = [];
        }

        return view('outlet::list', $data);
    }

	public function indexAjax(Request $request) {
        $post = $request->except('_token');

        if($post){

        }
        $outlet = MyHelper::get('outlet/be/list?log_save=0');

		if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data = $outlet['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }

    public function indexAjaxFilter(Request $request, $type) {
        $post['latitude'] = 0;
        $post['longitude'] = 0;
        if($type == 'Order'){
            $post['type'] = 'transaction';
        }
        $outlet = MyHelper::post('outlet/be/filter?log_save=0', $post);
        if (isset($outlet['result'])) {
            $data = $outlet['result'];
        }
        else {
            $data = [];
        }
        return response()->json($data);
    }


    /**
     * create
     */
    public function create(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {

            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'New Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-new',
            ];

            // province
            $data['province'] = $this->getPropinsi();
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];

            return view('outlet::create', $data);
        }
        else {
            if(isset($post['ampas'])){
                unset($post['ampas']);
            }
            if (isset($post['next'])) {
                $next = 1;
                unset($post['next']);
            }
            //cek pin confirmation
            if($post['outlet_pin'] != null){
                $validator = Validator::make($request->all(), [
                    'outlet_pin' => 'required|confirmed|min:6|max:6',
                ],[
                    'confirmed' => 'Re-type PIN does not match',
                    'min'       => 'PIN must 6 digit',
                    'max'       => 'PIN must 6 digit'
                ]);

                if ($validator->fails()) {
                    return back()
                            ->withErrors($validator)
                            ->withInput();
                }
            }

            if(!empty($post['outlet_open_hours'])) $post['outlet_open_hours'] = date('H:i:s', strtotime($post['outlet_open_hours']));
            if(!empty($post['outlet_open_hours'])) $post['outlet_close_hours'] = date('H:i:s', strtotime($post['outlet_close_hours']));

            $post = array_filter($post);

            $save = MyHelper::post('outlet/create', $post);
            // return $save;
            if (isset($save['status']) && $save['status'] == "success") {
                if (isset($next)) {
                    return parent::redirect($save, 'Outlet has been created.', 'outlet/detail/'.$save['result']['outlet_code'].'#photo');
                }
                else {
                    return parent::redirect($save, 'Outlet has been created.', 'outlet/list');
                }
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }

                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
               }

        }
    }

    /*
    Detail
    */
    function detail(Request $request, $code) {

        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Detail Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-list',
            ];

            $outlet = MyHelper::post('outlet/be/list', ['outlet_code' => $code,'admin' => 1, 'qrcode' => 1]);
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            // return $outlet;

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet']    = $outlet['result'];
                $product = MyHelper::get('product/be/list/price/'.$outlet['result'][0]['id_outlet']);

                if (isset($product['status']) && $product['status'] == "success") {
                    $data['product']    = $product['result'];
                }
                else {
                    $data['product'] = [];
                }
            }
            else {
                $e = ['e' => 'Data outlet not found.d'];
                return back()->witherrors($e);
            }


            // province
            $data['province'] = $this->getPropinsi();
            // return $data;
            // print_r($data); exit();
            return view('outlet::detail', $data);
        }
        else {

            //change pin
            // return $post;
            if(isset($post['outlet_pin'])){
                $validator = Validator::make($request->all(), [
                    'outlet_pin' => 'required|confirmed|min:6|max:6',
                ],[
                    'confirmed' => 'Re-type PIN does not match',
                    'min'       => 'PIN must 6 digit',
                    'max'       => 'PIN must 6 digit'
                ]);

                if ($validator->fails()) {
                    return redirect('outlet/detail/'.$code.'#pin')
                                ->withErrors($validator)
                                ->withInput();
                }else{
                    $save = MyHelper::post('outlet/update/pin', $post);
                    return parent::redirect($save, 'Outlet pin has been changed.', 'outlet/detail/'.$code.'#pin');
                }
            }

            // photo
            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo']);

                // save
                $save          = MyHelper::post('outlet/photo/create', $post);
                return parent::redirect($save, 'Outlet photo has been added.', 'outlet/detail/'.$code.'#photo');
            }

            // order photo
            if (isset($post['id_outlet_photo'])) {
                for ($x= 0; $x < count($post['id_outlet_photo']); $x++) {
                    $data = [
                        'id_outlet_photo' => $post['id_outlet_photo'][$x],
                        'outlet_photo_order' => $x+1,
                    ];

                    /**
                     * save product photo
                     */
                    $save = MyHelper::post('outlet/photo/update', $data);

                    if (!isset($save['status']) || $save['status'] != "success") {
                        return redirect('outlet/detail/'.$code.'#photo')->witherrors(['Something went wrong. Please try again.']);
                    }
                }

                return redirect('outlet/detail/'.$code.'#photo')->with('success', ['Photo\'s order has been updated']);
            }

            // update
            if (isset($post['id_outlet'])) {
                if(!empty($post['outlet_open_hours'])) $post['outlet_open_hours']  = date('H:i:s', strtotime($post['outlet_open_hours']));
                if(!empty($post['outlet_open_hours'])) $post['outlet_close_hours'] = date('H:i:s', strtotime($post['outlet_close_hours']));

                $post = array_filter($post);
                $save = MyHelper::post('outlet/update', $post);

                if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Outlet has been updated.', 'outlet/detail/'.$code.'#info');
                }else {
                       if (isset($save['errors'])) {
                           return back()->withErrors($save['errors'])->withInput();
                       }

                       if (isset($save['status']) && $save['status'] == "fail") {
                           return back()->withErrors($save['messages'])->withInput();
                       }

                       return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }

            }
        }
    }

    /*
    Manage Location
     */
    public function manageLocation(Request $request){
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Manage Location',
            'menu_active'    => 'outlet',
            'submenu_active' => 'manage-location',
        ];
        $page=$request->input('page')??1;
        $data['take']=10;
        $post=[];
        if(session('outlet_location_filter')){
            $post=session('outlet_location_filter');
            $data['rule']=array_map('array_values', $post['rule']);
            $data['operator']=$post['operator'];
        }
        if(session('outlet_location_take')){
            $post['take']=session('outlet_location_take')??10;
            $data['take']=$post['take'];
        }
        $post['order_field']=session('outlet_location_order_field')??'outlet_name';
        $data['order_field']=$post['order_field'];
        $post['order_method']=session('outlet_location_order_method')??'asc';
        $data['order_method']=$post['order_method'];
        $req=MyHelper::post('outlet/be/list?page='.$page,$post);
        $data['total']=$req['result']['total']??0;
        $data['outlets']=$req['result']['data']??[];
        $data['next_page_url']=($req['result']['next_page_url']??false)?url()->current().'?page='.($page+1):null;
        $data['prev_page_url']=$page>1?url()->current().'?page='.($page-1):null;
        $data['outlets']=$req['result']['data']??[];
        $data['cities']=MyHelper::get('city/list')['result']??[];
        return view('outlet::manage_location',$data);
    }

    public function manageLocationPost(Request $request){
        $post=$request->except('_token');
        if($post['rule']??false){
            session(['outlet_location_filter'=>$post]);
            return redirect('outlet/manage-location?page=1');
        }
        if($post['take']??false){
            session(['outlet_location_take'=>$post['take']]);
            session(['outlet_location_order_method'=>$post['order_method']??'asc']);
            session(['outlet_location_order_field'=>$post['order_field']??'outlet_name']);
            return redirect('outlet/manage-location?page=1');
        }
        if($post['clear']??false){
            session(['outlet_location_take'=>null]);
            session(['outlet_location_filter'=>null]);
            return redirect('outlet/manage-location?page=1');
        }
        // clear filter
        session(['outlet_location_filter'=>null]);
        // set order by last update first
        session(['outlet_location_order_method'=>$post['order_method']??'desc']);
        session(['outlet_location_order_field'=>$post['order_field']??'updated_at']);
        $req=MyHelper::post('outlet/batch-update',$post);
        if(($req['status']??false)=='success'){
            return redirect('outlet/manage-location?page='.($post['page']??'1'))->with('success',['Update success']);
        }else{
            return back()->withErrors(['Something went wrong. Please try again.']);
        }
    }

   public function updateStatus(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('outlet/update/status', $post);
        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update outlet status'];
        }
    }

    /*
    Propinsi
    */
    function getPropinsi() {
        $province = MyHelper::get('province/list');

        if (isset($province['status']) && $province['status'] == "success") {
            return $province['result'];
        }
        else {
            return [];
        }
    }

    // get city
    function getCity(Request $request) {
        $post = $request->except('_token');

        $query = MyHelper::post('city/list', $post);

        return $query;
    }

    /**
     * delete photo
     */
    function deletePhoto(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/photo/delete', ['id_outlet_photo' => $post['id_outlet_photo']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /* DELETE OUTLET */
    function delete(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/delete', ['id_outlet' => $post['id_outlet']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    public function Holiday(Request $request) {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet Holliday',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-holiday',
        ];
        $outlet = MyHelper::get('outlet/be/list');

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            return redirect('outlet/create')->withErrors('Create Outlet First');
        }

        $holiday = MyHelper::get('outlet/holiday/list');
        if (isset($holiday['status']) && $holiday['status'] == "success") {
            $data['holiday'] = $holiday['result'];
        }
        else {
            $data['holiday'] = [];
        }
        return view('outlet::outlet_holiday', $data);
    }

    public function createHoliday(Request $request) {
        $post = $request->except('_token');
        if (empty($post)) {

            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Holliday',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-holiday',
            ];

            $outlet = MyHelper::get('outlet/be/list');

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet'] = $outlet['result'];
            }
            else {
                return redirect('outlet/create')->withErrors('Create Outlet First');
            }

            return view('outlet::holiday', $data);
        }
        else {

            $post = array_filter($post);

            $save = MyHelper::post('outlet/holiday/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Outlet Holiday has been created.');
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }

                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
               }
        }
    }

    function deleteHoliday(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/holiday/delete', ['id_holiday' => $post['id_holiday']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    function detailHoliday(Request $request, $id_holiday) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Holliday',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-holiday',
            ];

            $holiday = MyHelper::post('outlet/holiday/list', ['id_holiday' => $id_holiday]);


            if (isset($holiday['status']) && $holiday['status'] == "success") {
                $data['holiday']    = $holiday['result'][0];
            }
            else {
                $e = ['e' => 'Data outlet holiday not found.'];
                return back()->witherrors($e);
            }

            $outlet = MyHelper::get('outlet/be/list');

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet'] = $outlet['result'];
            }
            else {
                $e = ['e' => 'Data outlet not found.'];
                return redirect('outlet/list')->witherrors($e);
            }

            return view('outlet::outlet_holiday_update', $data);
        }
        //update
        else {

            $post['id_holiday'] = $id_holiday;
            $save = MyHelper::post('outlet/holiday/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Outlet Holiday has been updated.', 'outlet/holiday');
            }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    function import(Request $request) {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Export & Import Outlet',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-import',
        ];

        return view('outlet::import', $data);
    }

    function importOutlet(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Import Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-import',
            ];

            return view('outlet::import', $data);
        }else{
            if($request->file('import_file')){

                $path = $request->file('import_file')->getRealPath();
                $name = $request->file('import_file')->getClientOriginalName();
                $dataimport = Excel::toArray(new FirstSheetOnlyImport(),$request->file('import_file'));
                $dataimport = array_map(function($x){return (Object)$x;}, $dataimport[0]??[]);
                $save = MyHelper::post('outlet/import', ['data_import' => $dataimport]);

                if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, $save['message'], 'outlet/list');
                }else {
                    if (isset($save['errors'])) {
                        return back()->withErrors($save['errors'])->withInput();
                    }

                    if (isset($save['status']) && $save['status'] == "fail") {
                        return back()->withErrors($save['messages'])->withInput();
                    }
                    return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }else{
                return back()->withErrors(['File is required.'])->withInput();
            }
        }
    }

    function exportForm(Request $request) {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Export Outlet',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-export',
        ];

        $data['brands'] = MyHelper::get('brand/be/list')['result']??[];

        return view('outlet::export', $data);
    }

    function exportData(Request $request) {
        $post=$request->except('_token');
        $outlet = MyHelper::post('outlet/export',$post);
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data = new MultisheetExport($outlet['result']);
            return Excel::download($data,'Data_Outlets_'.date('Ymdhis').'.xls');

        }else {
            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }

    }

    function createAdminOutlet(Request $request, $outlet_code) {
        $post = $request->except('_token');
        if (empty($post)) {

            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Admin',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-list',
            ];
            // get user
            $user = MyHelper::post('users/list',$post);
            if (isset($user['status']) && $user['status'] == "success") {
                $data['users'] = $user['result'];
            }
            else {
                $data['users'] = [];
            }
            return view('outlet::create_admin_outlet', $data);
        }
        else {

            $post['outlet_code'] = $outlet_code;
            unset($post['user']);
            $post = array_filter($post);
            $save = MyHelper::post('outlet/admin/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Admin Outlet has been created.', 'outlet/detail/'.$outlet_code.'#admin');
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }

                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
               }
        }
    }

    function deleteAdminOutlet(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/admin/delete', $post);
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    function detailAdminOutlet(Request $request, $outlet_code, $id_user_outlet){
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet Admin',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list',
        ];
        $post['outlet_code'] = $outlet_code;
        $post['id_user_outlet'] = $id_user_outlet;
        $get = MyHelper::post('outlet/admin/detail', $post);
        if (isset($get['status']) && $get['status'] == "success") {
            $data['user_outlet'] = $get['result'];
        }else {
            if (isset($get['errors'])) {
                return back()->withErrors($get['errors'])->withInput();
            }

            if (isset($get['status']) && $get['status'] == "fail") {
                return back()->withErrors($get['messages'])->withInput();
            }

            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }

        return view('outlet::edit_admin_outlet', $data);
    }

    function updateAdminOutlet(Request $request, $outlet_code) {
        $post = $request->except('_token');

        $post = array_filter($post);
        $save = MyHelper::post('outlet/admin/update', $post);
        if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Admin Outlet has been updated.', 'outlet/detail/'.$outlet_code.'#admin');
        }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
    }

    public function getUser(Request $request) {
        $post = $request->except('_token');
        if(isset($post['q'])){
            $post['conditions'][0] = array(
                ['subject' => 'name', 'operator' => 'like', 'parameter' => $post['q']],
                ['subject' => 'email', 'operator' => 'like', 'parameter' => $post['q']],
                ['subject' => 'phone', 'operator' => 'like', 'parameter' => $post['q']]
            );
            $post['conditions'][0]['rule'] = 'or';
            $post['conditions'][0]['rule_next'] = 'or';
            unset($post['q']);
        }

        $user = parent::getData(MyHelper::post('users/list', $post));

        return $user;
    }

    public function scheduleSave(Request $request)
    {
        $post = $request->except('_token');

        $save = MyHelper::post('outlet/schedule/save', $post);
        // return $save;
        if (isset($save['status']) && $save['status'] == 'success') {
            return back()->with(['success' => ['Update schedule success']]);
        }

        return back()->withErrors(['Update failed']);
    }

    public function qrcodePrint()
    {
        $outlet = MyHelper::post('outlet/be/list', ['qrcode'=>true]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            $data['outlet'] = [];
        }
        return view('outlet::qrcode', $data);
    }

    public function qrcodeView(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet QRCode',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-qrcode',
        ];

        if(isset($post['page'])){
            $outlet = MyHelper::post('outlet/be/list?page='.$post['page'], ['qrcode'=>true, 'qrcode_paginate'=>true]);
        }else{
            $outlet = MyHelper::post('outlet/be/list', ['qrcode'=>true, 'qrcode_paginate'=>true]);
        }

        $data['from'] = 0;
        $data['to'] = 0;
        $data['total'] = 0;
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['paginator'] = new LengthAwarePaginator($outlet['result']['data'], $outlet['result']['total'], $outlet['result']['per_page'], $outlet['result']['current_page'], ['path' => url()->current()]);
            $data['outlet'] = $outlet['result']['data'];
            $data['from'] = $outlet['result']['from'];
            $data['to'] = $outlet['result']['to'];
            $data['total'] = $outlet['result']['total'];
        }
        else {
            $data['outlet'] = [];
        }
        return view('outlet::qrcode_view', $data);
    }

    public function ajaxHandler(Request $request){
        $post=$request->except('_token');
        $outlets=MyHelper::post('outlet/ajax_handler', $post);
        return $outlets;
    }

    public function maxOrder(Request $request,$outlet_code=null) {
        $outlets = MyHelper::get('outlet/be/list')['result']??[];
        if(!$outlets){
            return back()->withErrors(['Something went wrong']);
        }
        if(!$outlet_code || !in_array($outlet_code,array_column($outlets, 'outlet_code'))){
            $outlet = $outlets[0]['outlet_code']??false;
            if(!$outlet){
                return back()->withErrors(['Something went wrong']);
            }
            return redirect('outlet/max-order/'.$outlet);
        }
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => '',
            'menu_active'    => 'max-order',
            'submenu_active' => 'max-order',
            'filter_title'   => 'Filter Product',
        ];
        if(session('maxx_order_filter')){
            $post=session('maxx_order_filter');
            $data['rule']=array_map('array_values', $post['rule']);
            $data['operator']=$post['operator'];
        }else{
            $post = [];
        }
        $data['outlets'] = $outlets;
        $data['key'] = $outlet_code;
        $page = $request->page;
        if(!$page){
            $page = 1;
        }
        $post['outlet_code'] = $outlet_code;
        $result = MyHelper::post('outlet/max-order?page='.$page,$post)['result']??false;
        if(!$result){
            return MyHelper::post('outlet/max-order?page='.$page,$post);
            return back()->withErrors(['Something went wrong']);
        }
        $data['total'] = $result['products']['total'];
        $data['start'] = $result['products']['from'];
        $data['data'] =$result;
        $data['paginator'] = new LengthAwarePaginator($result['products']['data'], $result['products']['total'], $result['products']['per_page'], $result['products']['current_page'], ['path' => url()->current()]);
        return view('outlet::max_order',$data);
    }
    public function maxOrderUpdate(Request $request,$outlet_code) {
        $post = $request->except('_token');
        if($post['rule']??false){
            session(['maxx_order_filter'=>$post]);
            return redirect('outlet/max-order/'.$outlet_code);
        }
        if($post['clear']??false){
            session(['maxx_order_filter'=>null]);
            return redirect('outlet/max-order/'.$outlet_code);
        }
        $post['outlet_code'] = $outlet_code;

        $update = MyHelper::post('outlet/max-order/update',$post);

        if(($update['status']??false) == 'success'){
            return back()->with('success',['Success update maximum order']);
        }else{
            return back()->withErrors($update['messages']??['Something went wrong']);
        }
    }
}
