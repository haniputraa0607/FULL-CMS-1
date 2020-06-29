<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;

use App\Http\Requests\loginRequest;
use App\Lib\MyHelper;
use Session;
use GoogleReCaptchaV3;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	function __construct() {
        date_default_timezone_set('Asia/Jakarta');
	}

	function login(loginRequest $request){

//        $captcha = GoogleReCaptchaV3::verifyResponse($request->input('g-recaptcha-response'))->isSuccess();
//        if (!$captcha) {
//        	return redirect()->back()->withErrors(['Recaptcha failed']);
//        }


		if(strlen($request->input('password')) != 6){
			return redirect('login')->withErrors(['Pin must be 6 digits' => 'Pin must be 6 digits'])->withInput();
		}

		$post = $request->all();
		$postLogin =  MyHelper::postLogin($request);

        if(isset($postLogin['error'])){
        	// untuk log request
			$postLoginClient =  MyHelper::postLoginClient();

			if (isset($postLoginClient['access_token'])) {
				session([
					'access_token'  => 'Bearer '.$postLoginClient['access_token']
				]);
			}
			$checkpin = MyHelper::post('users/pin/check', array('phone' => $request->input('username'), 'pin' => $request->input('password')));

			// if(isset($checkpin['status']) && $checkpin['status'] != "success")
				return redirect('login')->withErrors(['invalid_credentials' => 'Invalid username / password'])->withInput();
		}
        else{
        	if (isset($postLogin['status']) && $postLogin['status'] == "fail") {
				$postLoginClient =  MyHelper::postLoginClient();

				if (isset($postLoginClient['access_token'])) {
					session([
						'access_token'  => 'Bearer '.$postLoginClient['access_token']
					]);
				}

				$checkpin = MyHelper::post('users/pin/check', array('phone' => $request->input('username'), 'pin' => $request->input('password')));
				return redirect('login')->withErrors($postLogin['messages'])->withInput();
        	}
        	else {

				$checkpin = MyHelper::post('users/pin/check', array('phone' => $request->input('username'), 'pin' => $request->input('password')));
				session([
					'access_token'  => 'Bearer '.$postLogin['access_token'],
					'username'      => $request->input('username'),
				]);

				$getFeature = MyHelper::get('granted-feature?log_save=0');

				$features = [];

				if(isset($getFeature['status']) && $getFeature['status'] == 'success' && !empty($getFeature['result'])) {
					$features = $getFeature['result'];
				}
				else {
					// logout
					// session()->flush();
					// return redirect('login')->withErrors(['You dont have access this system.']);
				}

				$userData = null;

				while($userData == null){
					$userData = MyHelper::get('user');
				}

				$getConfig = MyHelper::get('config');

				$configs = [];

				if(isset($getConfig['status']) && $getConfig['status'] == 'success' && !empty($getConfig['result'])) {
					$configs = $getConfig['result'];
				}

	          	session([
	            	'granted_features'  => $features,
	            	'configs'  			=> $configs,
	            	'level'             => $userData['level'],
	            	'id_user'           => $userData['id'],
	            	'phone'           	=> $userData['phone'],
	            	'name'           	=> $userData['name'],
	            	'email'           	=> $userData['email'],
	            	'advert'			=> $this->iklan()
	          	]);
        	}

	        return redirect('home');
        }
    }

    function iklan() {
    	return [
			'home',
    		'news',
    		'product',
    		'outlet',
    		'contact-us',
    		'order-choose-outlet',
    		'order-choose-product',
    		'order-cart',
    		'order-shipment',
    		'order-payment',
    		'deals',
    		'inbox',
    		'voucher',
    		'history'
    	];
    }

	function getHome(Request $request, $year = null, $month = null){
		$data = [ 'title'             => 'Home',
				  'menu_active'       => 'home',
				  'submenu_active'    => ''
				];
        if (Session::get('level') != "Super Admin" && Session::get('level') != "Admin") {
            // logout
            session()->flush();
            return redirect('login')->withErrors(['You dont have access this system.']);
        }
        else{
			if($year == 'alltime'){
				$data['date_start']   = date('Y-m-d', strtotime("- 20 years"));
				$data['date_end']     = date('Y-m-d');
			} else {
				if($year == null && $month == null){
					// $data['date_start']   = date("Y-m-1");
					// $data['date_end']     = date("Y-m-t");
				}

				if($year != null && $month != null){
					$timestamp    = strtotime("".$month." ".$year."");
					$last		  = date('t', $timestamp);
					$data['date_start'] = date("".$year."-".$month."-01");
					$data['date_end'] = date("".$year."-".$month."-".$last);
				}

				if($year == 'last7days'){
					$data['date_end'] = date("Y-m-d");
					$data['date_start']= date('Y-m-d', strtotime('-7 days', strtotime($data['date_end'])));
				}
				if($year == 'last30days'){
					$data['date_end'] = date("Y-m-d");
					$data['date_start']= date('Y-m-d', strtotime('-30 days', strtotime($data['date_end'])));
				}
				if($year == 'last3months'){
					$data['date_end'] = date("Y-m-d");
					$data['date_start']= date('Y-m-d', strtotime('-3 months', strtotime($data['date_end'])));
				}
			}
			$data['month'] = $month;
			$data['year'] = $year;

			if($month == null) $data['month'] = date('m');

			$dashboard = MyHelper::post('setting/dashboard', $data);
			// dd($data);
			if(isset($dashboard['status']) && $dashboard['status'] == 'success'){
				$data['dashboard'] = $dashboard['result'];
				if($year == null && (strpos($dashboard['result']['daterange'], 'days') !== false || strpos($dashboard['result']['daterange'], 'months') !== false)){
					$data['year'] = 'last'.str_replace(' ', '', $dashboard['result']['daterange']);
				}else{
					if($year == null)$data['year'] = date('Y');
				}
			}
			else{
				$data['dashboard'] = "";
			}

            return view('home', $data);
        }
    }

	function getProfile(Request $request){
		if(empty(Session::get('secure'))){
			$data = [ 'title'             => 'User',
					  'menu_active'       => 'user',
					  'submenu_active'    => 'user-list',
					  'phone'    		  => Session::get('phone')
					];
			return view('password', $data);
		}

		$data = [ 'title'             => 'Home',
				  'menu_active'       => 'home',
				  'submenu_active'    => ''
				];
        if (Session::get('level') != "Super Admin" && Session::get('level') != "Admin") {
            // logout
            session()->flush();
            return redirect('login')->withErrors(['You dont have access this system.']);
        }
        else{
			$getUser = MyHelper::post('users/detail', ['phone' => Session::get('phone')]);
			if($getUser['status'] == 'success') $data['profile'] = $getUser['result']; else $data['profile'] = null;

			$getCity = MyHelper::get('city/list');
			if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;

			$getProvince = MyHelper::get('province/list');
			if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;

            return view('profile', $data);
        }
    }

	function getTextReplace(Request $request){
		$post = $request->except('_token');
		if(empty($post)){
			$data = [ 'title'             => 'Text Replace',
					  'menu_active'       => 'crm-setting',
					  'submenu_active'    => 'textreplace'
					];

			$replace = MyHelper::get('autocrm/textreplace/all');

			if($replace['status'] == 'success'){
				$data['textreplaces'] = $replace['result'];
			}
			// print_r($data);exit;
			return view('textreplace', $data);
		} else {
			$update = MyHelper::post('autocrm/textreplace/update',$post);
			return back()->with('success', ['Text Replace has been updated']);
		}
	}

	function getEmailHeaderFooter(Request $request){
		$post = $request->except('_token');

		if(empty($post)){
			$data = [ 'title'             => 'Email Header and Footer Settings',
					  'menu_active'       => 'crm-setting',
					  'submenu_active'    => 'email'
					];

			$emailSettings = MyHelper::post('setting', ['key-like' => 'email']);
			// print_r($emailSettings);exit;


			if($emailSettings['status'] == 'success'){
				$settings = [];
				foreach($emailSettings['result'] as $key => $row){
					$settings[$row['key']] = $row['value'];
				}
				$data['settings'] = $settings;
			}

            $getData = MyHelper::get('setting/url-email');

            if(isset($getData['status']) &&  $getData['status']=='success'){
                $data['data'] = $getData['result'];
            }else{
                $data['data'] = [];
            }
			// print_r($data);exit;
			return view('email-header-footer-settings', $data);
		} else {
			$dataToUpdate = [
			    'email_from' => $post['email_from'],
                'email_sender' => $post['email_sender'],
                'email_reply_to' => $post['email_reply_to'],
                'email_cc' => $post['email_cc'],
                'email_bcc' => $post['email_bcc'],
                'email_logo_position' => $post['email_logo_position'],
                'email_copyright' => $post['email_copyright'],
                'email_disclaimer' => $post['email_disclaimer'],
                'email_contact' => $post['email_contact']
            ];

            if (isset($post['email_logo'])) {
                $dataToUpdate['email_logo']   = MyHelper::encodeImage($post['email_logo']);
            }
			$update = MyHelper::post('setting/email/update',$dataToUpdate);

            if(isset($update['status']) &&  $update['status']=='success'){
                $allData = $request->all();
                if(isset($allData['images'])){
                    foreach($allData['images'] as $key => $value){
                        if($allData['images'][$key] !== null){
                            $allData['images'][$key] = MyHelper::encodeImage($allData['images'][$key]);
                        }
                    }
                }
                $updateUrl = MyHelper::post('setting/url-email', $allData);
                if(isset($updateUrl['status']) &&  $updateUrl['status']=='success'){
                    return back()->with('success', ['Email Header and Footer Settings has been updated']);
                }else{
                    return back()->withErrors($updateUrl['messages']);
                }
            }else{
                return back()->withErrors(['Failed update Email Header and Footer']);
            }
		}
	}

    function redirect($save, $messagesSuccess, $next=null, $view=[],$back=false) {
        if (isset($save['status']) && $save['status'] == 'success') {

            if (!empty($view)) {

            	// custom
            	if (isset($view['data'])) {
            		$data = $view['data'];
            	}

            	// from api
            	$data['result'] = $save['result'];

            	return view($view['path'], $data);
            }

            if (is_null($next)) {
                return back()->with('success', [$messagesSuccess]);
            }
            else {
                return redirect($next)->with('success', [$messagesSuccess]);
            }
        }
        else {
            if(isset($save['status']) && $save['status'] == 'fail') $e = $save['messages'];
            elseif(isset($save['errors'])) $e = $save['errors'];
            elseif(isset($save['exception'])) $e = $save['message'];
            else $e = ['e' => 'Something went wrong. Please try again.'];
            if($back){
                return redirect($next)->withErrors($e)->withInput();
            }else{
	            return back()->witherrors($e)->withInput();
            }
        }
    }

    function getData($access) {
    	if (isset($access['status']) && $access['status'] == "success") {
    		return $access['result'];
    	}
    	else {
    		return [];
    	}
	}

	public function uploadImageSummernote(Request $request, $type) {
        $post = $request->all();
        $post['type'] = $type;
        $post['image'] = MyHelper::encodeImage($post['image']);
        $myAsk = MyHelper::post('summernote/upload/image', $post);

        return $myAsk;
	}

	public function deleteImageSummernote(Request $request, $type) {
		$post = $request->all();

        $url = explode("/", $post['filename']);
        unset($url[0]);
        unset($url[1]);
        unset($url[2]);

        $image = "";

        foreach ($url as $val) {
			if($val == 'img'){
				$image = 'img/';
			}else{
				$image .= $val.'/';
			}
        }

        $image = substr($image, 0, -1);

        $post['type'] 	= $type;
		$post['image']  = $image;

        $myAsk = MyHelper::post('summernote/delete/image', $post);

        return $myAsk;
    }
}
