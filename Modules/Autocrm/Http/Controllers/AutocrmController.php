<?php

namespace Modules\Autocrm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;

class AutocrmController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
		$data = [ 'title'             => 'Auto CRM',
				  'menu_active'       => 'autocrm',
				  'submenu_active'    => ''
				];
		$query = MyHelper::get('autocrm/list');
		$test = MyHelper::get('autocrm/textreplace');

		$data['data'] = $query['result'];
		if($test['status'] == 'success'){
			$data['textreplaces'] = $test['result'];
		}

        return view('autocrm::index', $data);
    }

    public function email(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }

	public function sms(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }

	public function push(Request $request){
		$post = $request->except('_token');
		if (isset($post['autocrm_push_image'])) {
			$post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
		}
		// print_r($post);exit;
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }

	public function inbox(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }

	public function forward(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }

    public function mediaOn($media, $id){
		$post = [];
		$post['id_autocrm'] = $id;
		if($media == 'email') $post['autocrm_email_toogle'] = '1';
		if($media == 'sms') $post['autocrm_sms_toogle'] = '1';
		if($media == 'push') $post['autocrm_push_toogle'] = '1';
		if($media == 'inbox') $post['autocrm_inbox_toogle'] = '1';
		if($media == 'forward') $post['autocrm_forward_toogle'] = '1';

		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('autocrm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('autocrm::edit');
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
    public function destroy()
    {
    }
    public function autoResponse(Request $request, $type, $subject){
		$post = $request->except('_token');
		if(!empty($post)){
			if(!isset($post['attachment_mail'])){
				$post['attachment_mail']=0;
			}
			if(!isset($post['attachment_forward'])){
				$post['attachment_forward']=0;
			}

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

		$data = [ 'title'             => ucfirst($type),
				  'sub_title'         => ' Auto Response '.ucwords(str_replace('-',' ',$subject)),
				  'menu_active'       => $type,
				  'submenu_active'    => $type.'-autoresponse-'.$subject,
				  'type' 			  => $type
				];

		if($data['type'] == 'enquiries'){
			$data['type'] = "";
			$data['attachment'] = '1';
		}

		switch ($subject){
			case 'update-promo-campaign':
			case 'create-promo-campaign':
			case 'update-deals':
			case 'create-deals':
			case 'update-inject-voucher':
			case 'create-inject-voucher':
			case 'update-welcome-voucher':
			case 'create-welcome-voucher':
			case 'update-news':
			case 'create-news':
				$data['forwardOnly'] = true;
				break;
		}

		$query = MyHelper::post('autocrm/list', ['autocrm_title' => ucwords(str_replace('-',' ',$subject))]);
		if(!isset($query['result'])) return back()->withErrors(['No such response']);
		$data['data'] = $query['result'];

		$textReplace = MyHelper::get('autocrm/textreplace?log_save=0');
		if($textReplace['status'] == 'success'){
			$data['textreplaces'] = $textReplace['result'];
			$data['subject'] = $subject;
		}

		$getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
		if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
			$data['api_key_whatsapp'] = $getApiKey['result']['value'];
		}else{
			$data['api_key_whatsapp'] = null;
		}

		$custom = [];
        if (isset($data['data']['custom_text_replace'])) {
			$custom = explode(';', $data['data']['custom_text_replace']);
			if($custom[count($custom) - 1] == ''){
				unset($custom[count($custom) - 1]);
			}
        }

		if(stristr($request->url(), 'deals')){
			$data['deals'] = true;
		}

		$data['custom'] = $custom;
		// print_r($data);exit;
        return view('users::response', $data);
	}

	public function list(){
		$data = [ 'title'             => 'Auto CRM',
				  'sub_title'         => 'Auto CRM List',
				  'menu_active'       => 'autocrm',
				  'submenu_active'    => 'autocrm-list'
				];
		$query = MyHelper::get('autocrm/cron/list');
		$test = MyHelper::get('autocrm/textreplace');
		$data['result'] = parent::getData($query);
		if($test['status'] == 'success'){
			$data['textreplaces'] = $test['result'];
		}

        return view('autocrm::list', $data);
	}

	public function create(Request $request){
		$post = $request->except('_token');
		if(empty($post)){
			$data = [ 'title'             => 'Auto CRM',
					  'sub_title'         => 'New Auto CRM',
					  'menu_active'       => 'autocrm',
					  'submenu_active'    => 'autocrm-new'
					];

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

			$getMembership = MyHelper::post('membership/be/list?log_save=0', []);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

			$test = MyHelper::get('autocrm/textreplace?log_save=0');
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}

			$getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
			if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
				$data['api_key_whatsapp'] = $getApiKey['result']['value'];
			}else{
				$data['api_key_whatsapp'] = null;
			}

			$data['data'] =[];
			$data['conditions'] = "";
			$data['rule'] = "";
			return view('autocrm::create', $data);
		}else{
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

			$query = MyHelper::post('autocrm/cron/create', $post);
			// dd($query);
			return parent::redirect($query, 'Auto CRM has been created.', 'autocrm');
		}
	}

	public function detail(Request $request, $id_autocrm){
		$post = $request->except('_token');
		if(empty($post)){

			$data = [ 'title'             => 'Auto CRM',
				      'sub_title'         => 'Detail Auto CRM',
					  'menu_active'       => 'autocrm',
					  'submenu_active'    => 'autocrm-list'
					];
			$post['id_autocrm'] = $id_autocrm;
			$query = MyHelper::post('autocrm/cron/list', $post);
			// dd($query);
			if(isset($query['status']) && $query['status'] == 'success'){
				$data['result'] = $query['result'];
			}else{
				return redirect('autocrm')->withErrors(['Data not found.']);
			}

			if(count($data['result']) > 0){
				$data['conditions'] = $data['result']['autocrm_rule_parents'];
			}else{
				$data['conditions'] = [];
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

			$getMembership = MyHelper::post('membership/be/list?log_save=0', []);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

			$test = MyHelper::get('autocrm/textreplace?log_save=0');
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}else{
				$data['textreplaces'] = [];
			}

			$getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
			if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
				$data['api_key_whatsapp'] = $getApiKey['result']['value'];
			}else{
				$data['api_key_whatsapp'] = null;
			}

			return view('autocrm::create', $data);
		}else{
			unset($post['files']);
			$post['id_autocrm'] = $id_autocrm;
			if (isset($post['autocrm_push_image'])) {
				$post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
			}
			if(isset($post['radiomonth'])) unset($post['radiomonth']);

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

			$query = MyHelper::post('autocrm/cron/update', $post);
			// dd($query);
			return parent::redirect($query, 'Auto CRM has been updated.', 'autocrm/edit/'.$id_autocrm);
		}
	}

	function deleteAutocrmCron(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('autocrm/cron/delete', ['id_autocrm' => $post['id_autocrm']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

}
