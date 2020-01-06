<?php

namespace Modules\Campaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;
use Excel;

class AutopromotionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function list(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-list'
				];
				
		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'campaign_title' => $post['campaign_title']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'campaign_title' => $post['campaign_title']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('campaign/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::list', $data);
		} else{
			return redirect('campaign/create')->withErrors($action['messages']);
		}
    }
	
	public function create(){
		$data = [ 'title'             => 'Campaign',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-create'
				];

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

		return view('campaign::create-step-1', $data);
    }
	
	public function createPost(Request $request){
		$post = $request->except('_token');
		// print_r($post);exit;
		$action = MyHelper::post('campaign/create', $post);
		// print_r($action);exit;
		if($action['status'] == 'success'){
			return redirect('campaign/step2/'.$action['campaign']['id_campaign']);
		} else{
			return back()->withErrors($action['messages']);
		}
	}
}
