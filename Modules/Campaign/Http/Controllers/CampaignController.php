<?php

namespace Modules\Campaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;
use Excel;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('campaign::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function campaignList(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign',
				  'sub_title'          => 'Campaign List',
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
		} else{
			$data['result'] =[];
		}
		$data['post'] = $post;
		return view('campaign::list', $data);
    }

	public function emailOutboxDetail(Request $request, $id = null){
		$data = [ 'title'             => 'Campaign Email Outbox Detail',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-email-outbox'
				];

		$post = $request->except(['_token']);
		$action = MyHelper::post('campaign/email/outbox/detail', ['id_campaign_email_sent' => $id]);

		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['post'] = $post;
			// print_r($data);exit;
			return view('campaign::email-outbox-detail', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function emailOutbox(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign Email Outbox List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-email-outbox'
				];

		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'email_sent_subject' => $post['email_sent_subject']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'email_sent_subject' => $post['email_sent_subject']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('campaign/email/outbox/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::email-outbox', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function emailQueueDetail(Request $request, $id = null){
		$data = [ 'title'             => 'Campaign Email Queue Detail',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-email-queue'
				];

		$post = $request->except(['_token']);
		$action = MyHelper::post('campaign/email/queue/detail', ['id_campaign_email_queue' => $id]);

		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['post'] = $post;
			// print_r($data);exit;
			return view('campaign::email-queue-detail', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function emailQueue(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign Email Queue List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-email-queue'
				];

		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'email_queue_subject' => $post['email_queue_subject']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'email_queue_subject' => $post['email_queue_subject']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('campaign/email/queue/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::email-queue', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function smsOutboxDetail(Request $request, $id = null){
		$data = [ 'title'             => 'Campaign SMS Outbox Detail',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-sms-outbox'
				];

		$post = $request->except(['_token']);
		$action = MyHelper::post('campaign/sms/outbox/detail', ['id_campaign_sms_sent' => $id]);

		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['post'] = $post;
			// print_r($data);exit;
			return view('campaign::sms-outbox-detail', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function smsOutbox(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign SMS Outbox List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-sms-outbox'
				];

		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'sms_sent_content' => $post['sms_sent_content']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'sms_sent_content' => $post['sms_sent_content']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('campaign/sms/outbox/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::sms-outbox', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function smsQueueDetail(Request $request, $id = null){
		$data = [ 'title'             => 'Campaign SMS Queue Detail',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-sms-queue'
				];

		$post = $request->except(['_token']);
		$action = MyHelper::post('campaign/sms/queue/detail', ['id_campaign_sms_queue' => $id]);

		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['post'] = $post;
			// print_r($data);exit;
			return view('campaign::sms-queue-detail', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function smsQueue(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign SMS Queue List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-sms-queue'
				];

		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'sms_queue_content' => $post['sms_queue_content']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'sms_queue_content' => $post['sms_queue_content']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('campaign/sms/queue/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::sms-queue', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function pushOutboxDetail(Request $request, $id = null){
		$data = [ 'title'             => 'Campaign Push Notification Outbox Detail',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-push-outbox'
				];

		$post = $request->except(['_token']);
		$action = MyHelper::post('campaign/push/outbox/detail', ['id_campaign_push_sent' => $id]);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['post'] = $post;
			// print_r($data);exit;
			return view('campaign::push-outbox-detail', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function pushOutbox(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign Push Notification Outbox List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-push-outbox'
				];

		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'push_sent_subject' => $post['push_sent_subject']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'push_sent_subject' => $post['push_sent_subject']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('campaign/push/outbox/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::push-outbox', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function pushQueueDetail(Request $request, $id = null){
		$data = [ 'title'             => 'Campaign Push Notification Queue Detail',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-push-queue'
				];

		$post = $request->except(['_token']);
		$action = MyHelper::post('campaign/push/queue/detail', ['id_campaign_push_queue' => $id]);

		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['post'] = $post;
			// print_r($data);exit;
			return view('campaign::push-queue-detail', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function pushQueue(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign Push Notification Queue List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-push-queue'
				];

		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15, 'push_queue_subject' => $post['push_queue_subject']];
			} else {
				$post = ['skip' => 0, 'take' => 15, 'push_queue_subject' => $post['push_queue_subject']];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		$action = MyHelper::post('campaign/push/queue/list', $post);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::push-queue', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
	}

	public function whatsappList(Request $request, $page = null){
		$data = [ 'title'             => 'Campaign Whatsapp Outbox List',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-whatsapp-outbox'
				];

		$post = $request->except(['_token']);
		// print_r($post);exit;
		if(!empty($post)){
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		} else {
			if(!empty($page)){
				$skip = ($page-1) * 15;
				$post = ['skip' => $skip, 'take' => 15];
			} else {
				$post = ['skip' => 0, 'take' => 15];
			}
		}

		if(strpos(url()->current(), 'outbox') !== false){
			$action = MyHelper::post('campaign/whatsapp/outbox/list', $post);
			$data['type'] = 'sent';
		}else{
			$action = MyHelper::post('campaign/whatsapp/queue/list', $post);
			$data['title'] = 'Campaign Whatsapp Queue List';
			$data['submenu_active'] = 'campaign-whatsapp-queue';
			$data['type'] = 'queue';
		}
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['count'] = $action['count'];
			$data['post'] = $post;
			return view('campaign::whatsapp-list', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
    }

	public function whatsappDetail(Request $request, $id = null){
		$data = [ 'title'             => 'Campaign Whatsapp Outbox Detail',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-whatsapp-outbox'
				];

		$post = $request->except(['_token']);
		if(strpos(url()->current(), 'outbox') !== false){
			$action = MyHelper::post('campaign/whatsapp/outbox/list', ['id_campaign_whatsapp_sent' => $id]);
			$data['type'] = 'sent';
		}else{
			$action = MyHelper::post('campaign/whatsapp/queue/list', ['id_campaign_whatsapp_queue' => $id]);
			$data['title'] = 'Campaign Whatsapp Queue Detail';
			$data['submenu_active'] = 'campaign-whatsapp-queue';
			$data['type'] = 'queue';
		}

		if(isset($action['status']) && $action['status'] == 'success'){
			$data['result'] = $action['result'];
			$data['post'] = $post;
			// print_r($data);exit;
			return view('campaign::whatsapp-detail', $data);
		} else{
			return redirect('campaign')->withErrors($action['messages']);
		}
	}

	public function create(){
		$data = [ 'title'             => 'Campaign',
				  'sub_title'         => 'New Campaign',
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

		if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
			$data['api_key_whatsapp'] = $getApiKey['result']['value'];
		}else{
			$data['api_key_whatsapp'] = null;
		}

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

	public function campaignStep1($id_campaign){
		$action = MyHelper::post('campaign/step2', ['id_campaign' => $id_campaign]);
		// dd($action);exit;
		if($action['status'] == 'success'){
			$data = [ 'title'             => 'Campaign',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-create'
				];

			$data['result'] = $action['result'];

			$getCity = MyHelper::get('city/list');
			if(isset($getCity['status']) && $getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = [];

			$getProvince = MyHelper::get('province/list');
			if(isset($getProvince['status']) && $getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = [];

			$getCourier = MyHelper::get('courier/list');
			if(isset($getCourier['status']) && $getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = [];

			$getOutlet = MyHelper::get('outlet/be/list');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

			$getProduct = MyHelper::get('product/be/list');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];

			$getTag = MyHelper::get('product/tag/list');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

			$getMembership = MyHelper::post('membership/be/list',[]);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

			$getApiKey = MyHelper::get('setting/whatsapp');
			if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
				$data['api_key_whatsapp'] = $getApiKey['result']['value'];
			}else{
				$data['api_key_whatsapp'] = null;
			}

			return view('campaign::create-step-1', $data);
		} else{
			return back()->withErrors($action['messages']);
		}
    }
	public function campaignStep1Post(Request $request, $id_campaign){
		$post = $request->except(['_token','sample_1_length','files']);
		$post['id_campaign'] = $id_campaign;
		$action = MyHelper::post('campaign/create', $post);
		// dd($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			return redirect('campaign/step2/'.$id_campaign);
		} else{
			return back()->withErrors($action['messages']);
		}
	}

    public function campaignStep2($id_campaign){
		$action = MyHelper::post('campaign/step2', ['id_campaign' => $id_campaign]);
		// print_r($action);exit;
		if($action['status'] == 'success'){
			$data = [ 'title'		  => 'Campaign',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-create'
				];
			$test = MyHelper::get('autocrm/textreplace');

			$data['result'] = $action['result'];
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}

			$getOutlet = MyHelper::get('outlet/be/list');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

			$getProduct = MyHelper::get('product/be/list');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];

			$getTag = MyHelper::get('product/tag/list');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

			$getMembership = MyHelper::post('membership/be/list',[]);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

			return view('campaign::create-step-2', $data);
		} else{
			return back()->withErrors($action['messages']);
		}
    }

    public function showRecipient(Request $request,$id_campaign){
    	if($request->input('ajax')){
    		$post=array_merge(['id_campaign' => $id_campaign],$request->input());
    	}else{
    		$post=['id_campaign' => $id_campaign];
    	}
		if($request->input('ajax')){
			$action = MyHelper::post('campaign/recipient', $post);
			$return=$post;
			$i=($post['start']??0);
			$return['recordsTotal']=$action['recordsTotal'];
			$return['recordsFiltered']=$action['recordsFiltered'];
			$return['data']=array_map(function($x) use (&$i){
				$i++;
				return [
					$i,
					$x['name'],
					$x['email'],
					$x['phone'],
					$x['gender'],
					$x['city_name'],
					$x['birthday']
				];
			},$action['result']['users']??[]);
			return $return;
		}
		$data = [ 'title'		  => 'Campaign',
			  'sub_title'       => 'Show Recipient',
			  'menu_active'       => 'campaign',
			  'submenu_active'    => ''
			];
		return view('campaign::show-recipient', $data);
    }

	public function campaignStep2Post(Request $request, $id_campaign){
		$post = $request->except(['_token','sample_1_length','files']);
		$post['id_campaign'] = $id_campaign;

		if(isset($post['campaign_email_more_recipient']))
		$post['campaign_email_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_email_more_recipient']));

		if(isset($post['campaign_sms_more_recipient']))
		$post['campaign_sms_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_sms_more_recipient']));

		if(isset($post['campaign_push_more_recipient']))
		$post['campaign_push_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_push_more_recipient']));

		if(isset($post['campaign_inbox_more_recipient']))
		$post['campaign_inbox_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_inbox_more_recipient']));

		if(isset($post['campaign_whatsapp_more_recipient']))
		$post['campaign_whatsapp_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_whatsapp_more_recipient']));

		if (isset($post['campaign_push_image'])) {
			$post['campaign_push_image'] = MyHelper::encodeImage($post['campaign_push_image']);
		}

		if (isset($post['campaign_whatsapp_content'])) {
			foreach($post['campaign_whatsapp_content'] as $key => $content){
				if($content['content'] || isset($content['content_file']) && $content['content_file']){
					if($content['content_type'] == 'image'){
						$post['campaign_whatsapp_content'][$key]['content'] = MyHelper::encodeImage($content['content']);
					}
					else if($content['content_type'] == 'file'){
						$post['campaign_whatsapp_content'][$key]['content'] = base64_encode(file_get_contents($content['content_file']));
						$post['campaign_whatsapp_content'][$key]['content_file_name'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_FILENAME);
						$post['campaign_whatsapp_content'][$key]['content_file_ext'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_EXTENSION);
						unset($post['campaign_whatsapp_content'][$key]['content_file']);
					}
				}
			}
		}
		$action = MyHelper::post('campaign/update', $post);

		if($action['status'] == 'success'){
			return redirect('campaign/step3/'.$id_campaign);
		} else{
			return back()->withErrors($action['messages']);
		}
    }

	public function campaignStep3($id_campaign){
		$action = MyHelper::post('campaign/step2', ['id_campaign' => $id_campaign]);
		// print_r($action);exit;
		if(isset($action['status']) && $action['status'] == 'success'){
			$data = [ 'title'		  => 'Campaign',
				  'menu_active'       => 'campaign',
				  'submenu_active'    => 'campaign-create'
				];
			$test = MyHelper::get('autocrm/textreplace');

			$data['result'] = $action['result'];
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}

			$setting = MyHelper::get('setting/email?is_log=0');

			if($setting['status'] == 'success'){
				$data['setting'] = $setting['result'];
			}

			$getOutlet = MyHelper::get('outlet/be/list');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

			$getProduct = MyHelper::get('product/be/list');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];

			$getTag = MyHelper::get('product/tag/list');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

			$getMembership = MyHelper::post('membership/be/list',[]);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

			return view('campaign::create-step-3', $data);
		} else{
			return back()->withErrors($action['messages']);
		}
    }

	public function campaignStep3Post(Request $request, $id_campaign){
		$action = MyHelper::post('campaign/send', ['id_campaign' => $id_campaign,'resend'=>$request->post('resend')]);
		if($action['status'] == 'success'){
			$id_campaign=$action['result']['id_campaign']??$id_campaign;
			return redirect('campaign/step3/'.$id_campaign);
		} else{
			return back()->withErrors($action['messages']);
		}
    }
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('campaign::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('campaign::edit');
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
}
