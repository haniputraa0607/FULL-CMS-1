<?php

namespace Modules\InboxGlobal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;

class InboxGlobalController extends Controller
{
	public function indexAjax()
    {
		$post = ['skip' => 0, 'take' => 300];
		$action = MyHelper::post('inboxglobal/list', $post);
		if (isset($action['status']) && $action['status'] == "success") {
            $data = $action['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }
	
    public function inboxGlobalList(Request $request, $page = null){
		$data = [ 'title'             => 'Inbox Global List',
				  'menu_active'       => 'inboxglobal',
				  'submenu_active'    => 'inboxglobal-list'
				];
				
		$post = $request->except(['_token']);
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'inbox_global_subject' => $post['inbox_global_subject']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'inbox_global_subject' => $post['inbox_global_subject']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('inboxglobal/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;

            $getCity = MyHelper::get('city/list?log_save=0');
            if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = [];

            $getProvince = MyHelper::get('province/list?log_save=0');
            if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = [];

            $getCourier = MyHelper::get('courier/list?log_save=0');
            if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = [];

            $getOutlet = MyHelper::get('outlet/list?log_save=0');
            if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

            $getProduct = MyHelper::get('product/be/list?log_save=0');
            if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];

            $getTag = MyHelper::get('product/tag/list?log_save=0');
            if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

            $getMembership = MyHelper::post('membership/be/list?log_save=0',[]);
            if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

			return view('inboxglobal::list', $data);
		} else{
			return redirect('inboxglobal/create')->withErrors($action['messages']);
		}
    }
	
	public function delete($id_inbox_global){
		$delete = MyHelper::post('inboxglobal/delete', ['id_inbox_global' => $id_inbox_global]);
		// print_r($delete);exit;
		if($delete['status'] == 'success'){
			return back()->withSuccess($delete['result']);
		} else{
			return back()->withErrors($delete['messages']);
		}
    }
	
	public function edit(Request $request, $id_inbox_global){
		$data = [ 'title'             => 'Update Inbox Global',
				  'menu_active'       => 'inboxglobal',
				  'submenu_active'    => 'inboxglobal-list'
				];
		$post = $request->except(['_token','files']);
		if(!empty($post)){
			// print_r($post);exit;
			$post['id_inbox_global'] = $id_inbox_global;
			$action = MyHelper::post('inboxglobal/update', $post);
			// print_r($action);exit;
			if($action['status'] == 'success'){
				 return redirect('inboxglobal')->withSuccess(['Inbox Global has been updated.']);
			} else{
				return back()->withErrors($action['messages']);
			}
			
		} else {
			$action = MyHelper::post('inboxglobal/detail', ['id_inbox_global' => $id_inbox_global]);
			// print_r($action);exit;
			if (isset($action['status']) && $action['status'] == "success") {
				$data['inbox'] = $action['result'];
			}
			else {
				$data['inbox'] = [];
			}
			
			$getCity = MyHelper::get('city/list');
			if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = [];
			
			$getProvince = MyHelper::get('province/list');
			if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = [];
			
			$getCourier = MyHelper::get('courier/list');
			if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = [];
			
			$getOutlet = MyHelper::get('outlet/be/list');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];
			
			$getProduct = MyHelper::get('product/be/list');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];
			
			$getTag = MyHelper::get('product/tag/list');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];
			
			$getMembership = MyHelper::post('membership/be/list', []);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];
			
			$test = MyHelper::get('autocrm/textreplace');
		
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}
			return view('inboxglobal::update', $data);
		}
    }
	
	public function create(Request $request){
		$data = [ 'title'             => 'Create Inbox Global',
				  'menu_active'       => 'inboxglobal',
				  'submenu_active'    => 'inboxglobal-create'
				];
		$post = $request->except(['_token','files']);
		if(!empty($post)){
			// print_r($post);exit;
			$action = MyHelper::post('inboxglobal/create', $post);
			// dd($action);exit;
			if($action['status'] == 'success'){
				 return redirect('inboxglobal')->withSuccess(['Inbox Global has been created.']);
			} else{
				return back()->withErrors($action['messages']);
			}
			
		} else {
			
			$getCity = MyHelper::get('city/list');
			if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = [];
			
			$getProvince = MyHelper::get('province/list');
			if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = [];
			
			$getCourier = MyHelper::get('courier/list');
			if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = [];
			
			$getOutlet = MyHelper::get('outlet/be/list');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];
			
			$getProduct = MyHelper::get('product/be/list');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];
			
			$getTag = MyHelper::get('product/tag/list');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];
			
			$getMembership = MyHelper::post('membership/be/list', []);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];
			
			$test = MyHelper::get('autocrm/textreplace');
		
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}
			
			return view('inboxglobal::create', $data);
		}
    }
}
