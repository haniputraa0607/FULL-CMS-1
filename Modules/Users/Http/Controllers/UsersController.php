<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Exports\ArrayExport;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function listPhoneUser(){
		$query = MyHelper::get('users/list/phone', $post);
		// print_r($query);exit;
		if (isset($query['status']) && $query['status'] == "success") {
            $data = $query['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
	}
	
	public function listEmailUser(){
		$query = MyHelper::post('users/list/email', $post);
		
		if (isset($query['status']) && $query['status'] == "success") {
            $data = $query['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
	}
	
	public function listNameUser(){
		$query = MyHelper::post('users/list/name', $post);
		
		if (isset($query['status']) && $query['status'] == "success") {
            $data = $query['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
	}
	
    public function autoResponse(Request $request, $subject){
		$data = [ 'title'             => 'User Auto Response '.ucfirst(str_replace('-',' ',$subject)),
				  'menu_active'       => 'user',
				  'submenu_active'    => 'user-autoresponse-'.$subject
				];
		switch ($subject) {

			case 'complete-user-profile-point-bonus':
				$data['menu_active'] = 'profile-completion';
				$data['submenu_active'] = 'complete-user-profile-point-bonus';
				break;
						
			default:
				# code...
				break;
		}
		$query = MyHelper::get('autocrm/list');
		$test = MyHelper::get('autocrm/textreplace?log_save=0');
		$auto = null;

		$getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
		if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
			$data['api_key_whatsapp'] = $getApiKey['result']['value'];
		}else{
			$data['api_key_whatsapp'] = null;
		}
		
		$post = $request->except('_token');
		if(!empty($post)){
			if (isset($post['autocrm_push_image'])) {
				$post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
			}

			if (isset($post['whatsapp_content'])) {
				foreach($post['whatsapp_content'] as $key => $content){
					if($content['content'] || isset($content['content_file']) && $content['content_file']){
						if($content['content_type'] == 'image'){
							$post['whatsapp_content'][$key]['content'] = MyHelper::encodeImage($content['content']);
						}
						else if($content['content_type'] == 'file'){
							$post['whatsapp_content'][$key]['content'] = base64_encode(file_get_contents($content['content_file']));
							$post['whatsapp_content'][$key]['content_file_name'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_FILENAME);
							$post['whatsapp_content'][$key]['content_file_ext'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_EXTENSION);
							unset($post['whatsapp_content'][$key]['content_file']);
						}
					}
				}
			}

			$query = MyHelper::post('autocrm/update', $post);
			// print_r($query);exit;
			return back()->withSuccess(['Response updated']);
		}
		foreach($query['result'] as $autonya){
			if($autonya['autocrm_title'] == ucwords(str_replace('-',' ',$subject))){
				$auto = $autonya;
			}
		}
		
		if($auto == null) return back()->withErrors(['No such response']);
		$data['data'] = $auto;
		if($test['status'] == 'success'){
			$data['textreplaces'] = $test['result'];
			$data['subject'] = $subject;
		}

		$custom = [];
        if (isset($data['data']['custom_text_replace'])) {
            $custom = explode(';', $data['data']['custom_text_replace']);

            unset($custom[count($custom) - 1]);
        }
		
		if(stristr($request->url(), 'deals')){
			$data['deals'] = true;
			$custom[] = '%outlet_name%';
			$custom[] = '%outlet_code%';
		}
		
		$data['custom'] = $custom;
		// print_r($data);exit;
        return view('users::response', $data);
	}
	
	public function create(Request $request){
		$post = $request->except('_token');
		if(isset($post) && !empty($post)){
			// print_r($post);exit;
			if(isset($post['relationship']) && $post['relationship']=="-"){
				$post['relationship'] = null;
			}
			$query = MyHelper::post('users/create', $post);
			
			if(isset($query['status']) && $query['status'] == 'success'){
				return back()->withSuccess(['User Create Success']);
			} else{
				return back()->withErrors($query['messages']);
			}
			
		} else {
			$data = [ 'title'             => 'New User',
					  'menu_active'       => 'user',
					  'submenu_active'    => 'user-new'
					];
					
			$getCity = MyHelper::get('city/list');
			
			if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;
			
			$getProvince = MyHelper::get('province/list');
			if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;
			
			$getOutlet = MyHelper::get('outlet/be/list');
			if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = null;

			$getCelebrate = MyHelper::get('setting/be/celebrate_list');
			if($getCelebrate['status'] == 'success') $data['celebrate'] = $getCelebrate['result']; else $data['celebrate'] = null;

			$getJob = MyHelper::get('setting/be/jobs_list');
			if($getJob['status'] == 'success') $data['job'] = $getJob['result']; else $data['job'] = null;
			
			return view('users::create', $data);
		}
	}
	
	public function deleteAdminOutlet($phone, $id_outlet){
		if(!empty($phone) && !empty($id_outlet)){
			$query = MyHelper::post('users/adminoutlet/delete', ['phone' => $phone, 'id_outlet' => $id_outlet]);

			if(isset($query['status']) && $query['status'] == 'success'){
				return back()->withSuccess(['Admin Outlet Delete Success']);
			} else{
				return back()->withErrors($query['messages']);
			}
			
		} else {
			return back()->withErrors(['Admin Outlet not found']);
		}
	}
	
	public function createAdminOutlet(Request $request){
		$post = $request->except('_token');
		if(isset($post) && !empty($post)){
			// print_r($post);exit;
			$query = MyHelper::post('users/adminoutlet/create', $post);

			if(isset($query['status']) && $query['status'] == 'success'){
				return back()->withSuccess(['Admin Outlet Create Success']);
			} else{
				return back()->withErrors($query['messages']);
			}
			
		} else {
			$data = [ 'title'             => 'New Admin Outlet',
					  'menu_active'       => 'admin-outlet',
					  'submenu_active'    => 'admin-outlet-create'
					];
					
			$getOutlet = MyHelper::get('outlet/be/list');
			// print_r($getOutlet);exit;
			if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = null;
			return view('users::create_admin_outlet', $data);
		}
	}
	
	public function updateAdminOutlet(Request $request, $phone, $id_outlet){
		$post = $request->except('_token');
		if(isset($post) && !empty($post)){
			$post['phone'] = $phone;
			$post['id_outlet'][0] = $id_outlet;

			$query = MyHelper::post('users/adminoutlet/create', $post);

			if(isset($query['status']) && $query['status'] == 'success'){
				return back()->withSuccess(['Admin Outlet Update Success']);
			} else{
				return back()->withErrors($query['messages']);
			}
			
		} else {
			$data = [ 'title'             => 'Update Admin Outlet',
					  'menu_active'       => 'admin-outlet',
					  'submenu_active'    => 'admin-outlet-list'
					];

			$query = MyHelper::post('users/adminoutlet/detail', ['phone' => $phone, 'id_outlet' => $id_outlet]);
			
			if($query['status'] == 'success') $data['details'] = $query['result']; else $data['details'] = null;

			return view('users::update_admin_outlet', $data);
		}
	}
	
    public function indexAdminOutlet(Request $request){
		$post = $request->except('_token');
		$data = [ 'title'             => 'User',
				  'menu_active'       => 'admin-outlet',
				  'submenu_active'    => 'admin-outlet-list'
				];
				
		$query = MyHelper::post('users/adminoutlet/list', $post);
		// print_r($query);exit;
		if(isset($query) && $query['status'] == 'success'){
			$data['result'] = $query['result'];
		} else {
			$data['result'] = null;
		}
		
		return view('users::index-admin-outlet', $data);
	}
	
    public function index(Request $request, $page = 1)
    {
		$post = $request->except('_token');
		if(!empty(Session::get('form'))){
			if(isset($post['take'])) $takes = $post['take'];
			if(isset($post['order_field'])) $order_fields = $post['order_field'];
			if(isset($post['order_method'])) $order_methods = $post['order_method'];
			$sessionnya = Session::get('form');

			if(isset($post) && !empty($post)){
				$post = $post;
				if(isset($post['conditions'])){
					$con = $post['conditions'];
					$post['conditions'] = $con;
				} else {
					$post['conditions'] = [];
					if(isset($sessionnya['conditions'])){
						$post['conditions'] = $sessionnya['conditions'];
					}
					// if(isset($sessionnya['rule'])){
					// 	$post['rule'] = $sessionnya['rule'];
					// }
				}
				Session::put('form',$post);
			} else{
				$post = $sessionnya;
			}
			if(isset($takes) && isset($order_fields) && isset($order_methods)){
				$post['take'] = $takes;
				$post['order_field'] = $order_fields;
				$post['order_method'] = $order_methods;
				Session::put('form',$post);
			}
		}

		if(!empty($post)){
			if(isset($post['action']) && isset($post['users'])){
				//Bulk action
				$phone = [];
				foreach($post['users'] as $key => $code){
					array_push($phone, $key);
				}
				
				if($post['action'] == 'delete'){
					$action = MyHelper::post('users/delete', ['phone' => $phone]);
					if($action['status'] == 'success'){
						return back()->withSuccess($action['result']);
					} else{
						return back()->withErrors($action['messages']);
					}
				}
				
				if($post['action'] == 'phone verified'){
					$action = MyHelper::post('users/phone/verified', ['phone' => $phone]);
					if($action['status'] == 'success'){
						return back()->withSuccess($action['result']);
					} else{
						return back()->withErrors($action['messages']);
					}
				}
				
				if($post['action'] == 'phone not verified'){
					$action = MyHelper::post('users/phone/unverified', ['phone' => $phone]);
					if($action['status'] == 'success'){
						return back()->withSuccess($action['result']);
					} else{
						return back()->withErrors($action['messages']);
					}
				}
				
				if($post['action'] == 'email verified'){
					$action = MyHelper::post('users/email/verified', ['phone' => $phone]);
					if($action['status'] == 'success'){
						return back()->withSuccess($action['result']);
					} else{
						return back()->withErrors($action['messages']);
					}
				}
				
				if($post['action'] == 'email not verified'){
					$action = MyHelper::post('users/email/unverified', ['phone' => $phone]);
					if($action['status'] == 'success'){
						return back()->withSuccess($action['result']);
					} else{
						return back()->withErrors($action['messages']);
					}
				}
			}
				
			Session::put('form',$post);
		}

		$data = [ 'title'             => 'User',
				  'menu_active'       => 'user',
				  'submenu_active'    => 'user-list'
				];

		if(!isset($post['order_field'])) $post['order_field'] = 'id';
		if(!isset($post['order_method'])) $post['order_method'] = 'desc';
		if(!isset($post['take'])) $post['take'] = 10;
		$post['skip'] = 0 + (($page-1) * $post['take']);
		
		
		// print_r($post);exit;
		$getUser = MyHelper::post('users/list', $post);
		// print_r($getUser);exit;
        if ($getUser['status'] == 'success') {
            $data['content'] = $getUser['result'];
            $data['total'] = $getUser['total'];
        }
        else {
            $data['content'] = null;
            $data['total'] = null;
        }
		
		$data['begin'] = $post['skip'] + 1;
		$data['last'] = $post['take'] + $post['skip'];
			if($data['total'] <= $data['last']) $data['last'] = $data['total'];
		$data['page'] = $page;
		if($data['content'])
			$data['jumlah'] = count($data['content']);
		else $data['jumlah'] = 0;
		foreach($post as $key => $row){
			$data[$key] = $row;
		}
		
		
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
		
		$data['table_title'] = "User list order by ".$data['order_field'].", ".$data['order_method']."ending (".$data['begin']." to ".$data['jumlah']." From ".$data['total']." data)";
		
		// print_r($data);exit;
		// print_r(Session::get('form'));exit;
		return view('users::index', $data);
    }
	
	public function searchReset()
    {
		Session::forget('form');
        Session::forget('form-log');
		return back();
	}

    public function getExport(Request $request)
    {
        $post = $request->except('_token');

        if (!empty(Session::get('form'))) {
            $post = Session::get('form');
        }

        if (!isset($post['order_field'])) $post['order_field'] = 'id';
        if (!isset($post['order_method'])) $post['order_method'] = 'desc';
        if (!isset($post['take'])) $post['take'] = 999999999;
        $post['skip'] = 0;


        // print_r($post);exit;
        $export = MyHelper::post('users/list', $post);
        // print_r($export);exit;
        if ($export['status'] == 'success') {
            $data = $export['result'];
            $x = 1;
            foreach ($data as $key => $row) {
                unset($data[$key]['id']);
                unset($data[$key]['password_k']);
                unset($data[$key]['id_city']);
                unset($data[$key]['id_province']);
                unset($data[$key]['level_range_start']);
                unset($data[$key]['level_range_end']);
                unset($data[$key]['id_level']);
                unset($data[$key]['level_name']);
                unset($data[$key]['level_parameters']);
            }
            return Excel::download(new ArrayExport($data),'Users List-'.date('Y-m-d').'.xls');
        }
    }

    public function getExportActivities(Request $request)
    {
        $post = $request->except('_token');

        if (!empty(Session::get('form'))) {
            $post = Session::get('form');
        }

        if (!isset($post['order_field'])) $post['order_field'] = 'id';
        if (!isset($post['order_method'])) $post['order_method'] = 'desc';
        if (!isset($post['take'])) $post['take'] = 999999999;
        $post['skip'] = 0;


        // print_r($post);exit;
        $export = MyHelper::post('users/activity', $post);

        if ($export['status'] == 'success') {
            $data = $export['result'];
            $x = 1;
            Excel::download(new ArrayExport($data),'Log Activity List-'.date('Y-m-d').'.xls');
        }
    }
	

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($phone, Request $request)
    {
		$post = $request->except('_token');
		// print_r($post);exit;
		if($request->post('action')=='delete_inbox'&&!empty($request->post('id_inbox'))){
			$delete = MyHelper::post('inbox/delete', ['id_inbox' => $request->post('id_inbox')]);
			if(($delete['status']=='success')??false){
				return redirect('user/detail/'.$phone)->with('success',['Delete success']);
			}else{
				return back()->withErrors(['Delete Failed']);
			}
		}
		if(isset($post['password'])){
			$checkpin = MyHelper::post('users/pin/check-backend', array('phone' => Session::get('phone'), 'pin' => $post['password'], 'admin_panel' => 1));
			if($checkpin['status'] != "success")
				return back()->withErrors(['invalid_credentials' => 'Invalid PIN'])->withInput();
			else 
				Session::put('secure','yes');
		} 
		
		if(isset($post['phone'])){
			if(isset($post['birthday'])){
				$post['birthday'] = date('Y-m-d', strtotime($post['birthday']));
			}
			if(isset($post['relationship']) && $post['relationship']=="-"){
				$post['relationship'] = null;
			}
			$update = MyHelper::post('users/update', ['phone' => $phone, 'update' => $post]);
			return parent::redirect($update, 'Profile has been updated');
		}
		
		if (isset($post['photo'])) {
            $photo = MyHelper::encodeImage($post['photo']);
			$update = MyHelper::post('users/update/photo', ['phone' => $phone, 'photo' => $photo]);
			return parent::redirect($update, 'Profile Photo has been updated');
        }
		
		if (isset($post['password_new'])) {
			$post['phone'] = $phone;
			$update = MyHelper::post('users/update/password', $post);
			return parent::redirect($update, 'Password has been changed.');
        }
		
		if (isset($post['password_level'])) {
			$post['phone'] = $phone;
			// print_r($post);exit;
			$update = MyHelper::post('users/update/level', $post);
			// print_r($update);exit;
			return parent::redirect($update, 'Account Level has been changed.');
        }
		
		if (isset($post['password_permission'])) {
			$post['phone'] = $phone;
			$update = MyHelper::post('users/update/permission', $post);
			return parent::redirect($update, 'Account Permission has been changed.');
		}
		if (isset($post['is_suspended'])) {
			$post['phone'] = $phone;
			$update = MyHelper::post('users/update/suspend', $post);
			return parent::redirect($update, 'Suspend Status has been changed.');
        }
		
		if(empty(Session::get('secure'))){
			$data = [ 'title'             => 'User',
					  'menu_active'       => 'user',
					  'submenu_active'    => 'user-list',
					  'phone'    		  => $phone
					];
			return view('users::password', $data);
		}
		
		$getUser = MyHelper::post('users/detail', ['phone' => $phone]);
		// return $getUser;exit;
		$getLog = MyHelper::post('users/log?log_save=0', ['phone' => $phone, 'skip' => 0, 'take' => 50]);

		$getFeature = MyHelper::post('users/granted-feature?log_save=0', ['phone' => $phone]);

		$getFeatureAll = MyHelper::get('feature?log_save=0');
		
		$getFeatureModule = MyHelper::get('feature-module?log_save=0');
		
		$getVoucher = MyHelper::post('deals/voucher/user?log_save=0', ['phone' => $phone]);
// 		return $getVoucher;
		
		$getInbox = MyHelper::post('inbox/be/user',['phone'=>$phone]);

		$data = [ 'title'             => 'User',
				  'menu_active'       => 'user',
				  'submenu_active'    => 'user-list'
				];
		$data['profile'] = null;
		$data['log']['mobile'] = [];
		$data['log']['backend'] = [];
		$data['features'] = null;
		$data['featuresall'] = null;
		$data['featuresmodule'] = null;
		$data['voucher'] = null;
		$data['celebrates'] = MyHelper::get('setting/be/celebrate_list')['result']??[];
		$data['jobs'] = MyHelper::get('setting/be/jobs_list')['result']??[];
		if(isset($getUser['result'])){
			$data['profile'] = $getUser['result'];
// 			$data['trx'] = $getUser['trx'];
// 			$data['voucher'] = $getUser['voucher'];
		}
		if(isset($getLog['result']['mobile'])) $data['log']['mobile'] = $getLog['result']['mobile'];
		if(isset($getLog['result']['be'])) $data['log']['backend'] = $getLog['result']['be'];
		if(isset($getFeature['result'])) $data['features'] = $getFeature['result'];
		if(isset($getFeatureAll['result'])) $data['featuresall'] = $getFeatureAll['result'];
		if(isset($getFeatureModule['result'])) $data['featuresmodule'] = $getFeatureModule['result'];
		if(isset($getVoucher['result'])) $data['voucher'] = $getVoucher['result'];
		$data['inboxes'] = $getInbox['result']??[];

		$getCity = MyHelper::get('city/list?log_save=0');
		if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;
		
		$getProvince = MyHelper::get('province/list?log_save=0');
		if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;
		
		$getCourier = MyHelper::get('courier/list?log_save=0');
		if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = null;
		// print_r($data);exit;
        return view('users::detail', $data);
    }
    
    public function showAllLog($phone, Request $request)
    {
		$post = $request->except('_token');
		if(empty($post)){
			Session::forget('form_filter_log');
			// $data['']
		}
		
		$data = [ 'title'             => 'User',
			'menu_active'       => 'user',
			'submenu_active'    => 'user-list',
			'phone'             => $phone,
			'date_start'     => date('01 F Y 00:00'),
			'date_end'       => date('d F Y 23:59'),
			'rule'			=> 'and'
		];

		if(isset($post['date_start'])){
			$data['date_start'] = $post['date_start'];
		}

		if(isset($post['rule'])){
			$data['rule'] = $post['rule'];
		}

		if(isset($post['date_end'])){
			$data['date_end'] = $post['date_end'];
		}

		if(isset($post['conditions'])){
			Session::put('form_filter_log',$post['conditions']);
		}else{
			if(!empty(Session::get('form_filter_log'))){
				Session::forget('form_filter_log');
			}
		}

		if(!isset($post['pagem'])){
			$data['pagem'] = 1;
		}else{
			$data['pagem'] = $post['pagem'];
		}
	
		if(!isset($post['pageb'])){
			$data['pageb'] = 1;
		}else{
			$data['pageb'] = $post['pageb'];
		}

		if(isset($post['page'])){
			if(isset($post['tipe']) && $post['tipe'] == 'mobile'){
				$data['pagem'] = $post['page'];
			}
			if(isset($post['tipe']) && $post['tipe'] == 'backend'){
				$data['pageb'] = $post['page'];
				$data['tipe'] = 'backend';
			}
		}

		if(!empty(Session::get('form_filter_log'))){
			$data['conditions'] = Session::get('form_filter_log');
		}else{
			$data['conditions'] = [];
		}

		$getLog = MyHelper::post('users/log?log_save=0&page='.$data['pagem'], ['phone' => $phone, 'pagination' => 1, 'take' => 20, 'conditions' =>$data['conditions'], 'date_start' => $data['date_start'], 'date_end' => $data['date_end'], 'rule' => $data['rule']]);

		$data['log']['mobile'] = [];
		$data['log']['backend'] = [];

		if(isset($getLog['result']['mobile'])){
			$data['log']['mobile'] = $getLog['result']['mobile']['data'];
			$data['mobile_page'] = new LengthAwarePaginator($getLog['result']['mobile']['data'], $getLog['result']['mobile']['total'], $getLog['result']['mobile']['per_page'], $getLog['result']['mobile']['current_page'], ['path' => url('user/log/'.$phone.'?tipe=mobile&pageb='.$data['pageb'])]);
		} 
		if(isset($getLog['result']['be'])){
			$data['log']['backend'] = $getLog['result']['be']['data'];
			$data['backend_page'] = new LengthAwarePaginator($getLog['result']['be']['data'], $getLog['result']['be']['total'], $getLog['result']['be']['per_page'], $getLog['result']['be']['current_page'], ['path' => url('user/log/'.$phone.'?tipe=backend&pagem='.$data['pagem'])]);
		} 

		$profile = MyHelper::post('users/get-detail?log_save=0', ['phone' => $phone]);
		if(isset($profile['result'])){
			$data['profile'] = $profile['result'];
		}

		return view('users::log_all', $data);
	}
	
    public function showLog($phone, Request $request)
    {
		$post = $request->except('_token');
	
		$getLog = MyHelper::post('users/log', ['phone' => $phone, 'skip' => 0, 'take' => 5]);
		
		$data = [ 'title'             => 'User',
				  'menu_active'       => 'user',
				  'submenu_active'    => 'user-list',
				  'phone'             => $phone
				];
		
		if(isset($getLog['result'])) $data['log'] = $getLog['result'];

        return view('users::detail_log', $data);
    }
    
    public function showDetailLog($id, $log_type, Request $request)
    {
		$getLog = MyHelper::get('users/log/detail/'.$id.'/'.$log_type);
		$data = [];
		
		if(isset($getLog['result'])) $data = $getLog['result'];

        return $data;
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete($phone)
    {
		$deleteUser = MyHelper::post('users/delete', ['phone' => $phone]);
		if($deleteUser['status'] == 'success'){
			return back()->withSuccess($deleteUser['result']);
		} else{
			return back()->withErrors($deleteUser['messages']);
		}
	}

	public function deleteLogApp($id)
    {
		$deleteUserLog = MyHelper::post('users/delete/log', ['id_log_activities_apps' => $id]);
		if($deleteUserLog['status'] == 'success'){
			return back()->withSuccess($deleteUserLog['result']);
		} else{
			return back()->withErrors($deleteUserLog['messages']);
		}
	}
	
	public function deleteLogBE($id)
    {
		$deleteUserLog = MyHelper::post('users/delete/log', ['id_log_activities_be' => $id]);
		if($deleteUserLog['status'] == 'success'){
			return back()->withSuccess($deleteUserLog['result']);
		} else{
			return back()->withErrors($deleteUserLog['messages']);
		}
    }
	
	public function activity(Request $request, $page = 1){
		$post = $request->except('_token');

		if(!empty(Session::get('form-log'))){
			if(isset($post['take'])) $takes = $post['take'];
			if(isset($post['order_field'])) $order_fields = $post['order_field'];
			if(isset($post['order_method'])) $order_methods = $post['order_method'];
			$post = Session::get('form-log');
			
			if(isset($takes) && isset($order_fields) && isset ($order_methods)){
				$post['take'] = $takes;
				$post['order_field'] = $order_fields;
				$post['order_method'] = $order_methods;
			}
		}
		
		if(!empty($post)){
			Session::put('form-log',$post);
		}
		
		$data = [ 'title'             => 'User',
				  'menu_active'       => 'user',
				  'submenu_active'    => 'user-log'
				];
				
		if(!isset($post['order_field'])) $post['order_field'] = '';
		if(!isset($post['order_method'])) $post['order_method'] = 'desc';
		if(!isset($post['take'])) $post['take'] = 10;
		$post['skip'] = 0 + (($page-1) * $post['take']);
		
		// print_r($post);exit;
		$getLog = MyHelper::post('users/activity', $post);
		// dd($getLog);
		if(isset($getLog['status']) && $getLog['status'] == 'success') {
            $data['content']['mobile'] = $getLog['result']['mobile']['data'];
            $data['content']['be'] = $getLog['result']['be']['data'];
        }else{
		    $data['content']['mobile'] = null;
            $data['content']['be'] = null;
        }

		if(isset($getLog['status']) && $getLog['status'] == 'success') {
            $data['total']['mobile'] = $getLog['result']['mobile']['total'];
            $data['total']['be'] = $getLog['result']['be']['total'];
        }
		else {
            $data['total']['mobile'] = null;
            $data['total']['be'] = null;
        }
		
		$data['begin'] = $post['skip'] + 1;
		$data['last'] = $post['take'] + $post['skip'];

		if($data['total']['mobile'] <= $data['last']) $data['last'] = $data['total']['mobile'];
		$data['page'] = $page;
		if(!is_array($data['content']['mobile'])){
			$data['jumlah'] = null;
		}else{
			$data['jumlah'] = count($data['content']['mobile']);
		}
		foreach($post as $key => $row){
			$data[$key] = $row;
		}
		
		$data['table_title'] = "User Log Activity list order by ".$data['order_field'].", ".$data['order_method']."ending (".$data['begin']." to ".$data['jumlah']." From ".$data['total']['mobile']." data)";
		
		// print_r($data);exit;
		return view('users::log', $data);
	}
	public function favorite(Request $request, $phone){
		$post = $request->post();
		$data = [ 'title'             => 'User',
				  'subtitle'		  => 'Favorite',
				  'menu_active'       => 'user',
				  'submenu_active'    => 'user-list'
				];
		if(isset($post['password'])){
			$checkpin = MyHelper::post('users/pin/check-backend', array('phone' => Session::get('phone'), 'pin' => $post['password'], 'admin_panel' => 1));
			if($checkpin['status'] != "success")
				return back()->withErrors(['invalid_credentials' => 'Invalid PIN'])->withInput();
			else 
				Session::put('secure','yes');
		} 
		if(empty(Session::get('secure'))){
			$data = [ 'title'             => 'User',
					  'menu_active'       => 'user',
					  'submenu_active'    => 'user-list',
					  'phone'    		  => $phone
					];
			return view('users::password', $data);
		}
		$data['favorites'] = MyHelper::post('users/favorite?page='.($request->page?:1),['phone'=>$phone])['result']??[];
		return view('users::favorite', $data);
	}
}
