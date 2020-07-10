<?php

namespace Modules\Deals\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Deals\Http\Requests\Create;

use App\Exports\DealsExport;
use App\Imports\DealsImport;
use App\Imports\PromoWithHeadingImport;
use App\Imports\PromoWithoutHeadingImport;
use Maatwebsite\Excel\Facades\Excel;

class DealsController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
        $this->promo_campaign       = "Modules\PromoCampaign\Http\Controllers\PromoCampaignController";
    }



    /* IDENTIFIER */
    function identifier($type="") {

        if ($type == "prev") {
            $url = explode(url('/'), url()->previous());
            $url = explode("/", $url[1]);
            $url = ucwords(str_replace("-", " ", $url[1]));

            return $url;
        }
        else {
            $identifier = explode(url('/'), url()->current());
            $dealsType  = explode("/", $identifier[1]);

            return $dealsType[1];
        }

    }

    /* SAVE DEAL */
    function saveDefaultDeals($post) {
        // print_r($post);

 		if (empty($post['is_online'])) {
	        $post['product_type'] = null;
        }

        if (isset($post['deals_voucher_type'])) {
            if ( $post['deals_voucher_type'] == 'Auto generated' && $post['total_voucher_type'] == 'Unlimited') {
                $post['deals_voucher_type'] = 'Unlimited';
                $post['deals_total_voucher'] = null;
            }
        }

        unset($post['deals_promo_id_promoid']);
        unset($post['deals_promo_id_nominal']);

        if (isset($post['deals_voucher_type']) && $post['deals_voucher_type'] == "List Vouchers") {
            if (!isset($post['voucher_code'])) {
                return back()->withErrors(['Voucher code required while Voucher Type is List Voucher']);
            }
        }

        if (isset($post['deals_start']) && !empty($post['deals_start'])) {
            $post['deals_start']         = date('Y-m-d H:i:s', strtotime($post['deals_start']));
        }

        if (isset($post['deals_end']) && !empty($post['deals_end'])) {
            $post['deals_end']           = date('Y-m-d H:i:s', strtotime($post['deals_end']));
        }

        if (isset($post['deals_publish_start']) && !empty($post['deals_publish_start'])) {
            $post['deals_publish_start'] = date('Y-m-d H:i:s', strtotime($post['deals_publish_start']));
        }

        if (isset($post['deals_publish_start']) && !empty($post['deals_publish_start'])) {
            $post['deals_publish_end']   = date('Y-m-d H:i:s', strtotime($post['deals_publish_end']));
        }

        if (isset($post['deals_image'])) {
            $post['deals_image']         = MyHelper::encodeImage($post['deals_image']);
        }
        // $post['deals_type']          = 'Deals';

        if (isset($post['deals_voucher_expired']) && !empty($post['deals_voucher_expired'])) {
            $post['deals_voucher_expired'] = date('Y-m-d H:i:s', strtotime($post['deals_voucher_expired']));
        }

        if (isset($post['deals_voucher_start']) && !empty($post['deals_voucher_start'])) {
            $post['deals_voucher_start'] = date('Y-m-d H:i:s', strtotime($post['deals_voucher_start']));
        }

        $save = MyHelper::post('deals/create', $post);

        if (isset($save['status']) && $save['status'] == "success") {
        	// return $save;
        	$id_deals = $save['result']['id_deals']??$save['result']['id_deals_promotion_template'];
        	$save['result']['id_deals'] = MyHelper::createSlug($save['result']['id_deals']??$save['result']['id_deals_promotion_template'], $save['result']['created_at']);

        	if($post['deals_type'] == 'Promotion'){
                $rpage = 'promotion/deals';
        	}elseif($post['deals_type'] == 'WelcomeVoucher'){
                $rpage = 'welcome-voucher';
            }else{
                $rpage = $post['deals_type']=='Deals'?'deals':'inject-voucher';
            }

            if ($post['deals_voucher_type'] == "List Vouchers" && $post['deals_type'] != 'Promotion') {

            	$save_voucher_list = $this->saveVoucherList($id_deals, $post['voucher_code']);

            	if (($save_voucher_list['status']??false) == 'success') {
            		$redirect = redirect("$rpage/step2/{$save['result']['id_deals']}")->withSuccess(["Deals has been created."]);
            	}else{
            		$redirect = back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            	}

        		if (!empty($save_voucher_list['warnings'])) {
        			$redirect = $redirect->withWarning($save_voucher_list['warnings']);
        		}

                return $redirect;
            }
            return parent::redirect($save, 'Deals has been created.',"$rpage/step2/{$save['result']['id_deals']}");
        }else{
            return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
        }
    }

    /* SAVE HIDDEN DEALS */
    function saveHiddenDeals($post) {

        if ($post['deals_promo_id_type'] == "promoid") {
            $post['deals_promo_id'] = $post['deals_promo_id_promoid'];
        }
        else {
            $post['deals_promo_id'] = $post['deals_promo_id_nominal'];
        }

        unset($post['deals_promo_id_promoid']);
        unset($post['deals_promo_id_nominal']);

        // $post['deals_voucher_type']  = "Auto generated";
        $post['deals_start']         = date('Y-m-d H:i:s', strtotime($post['deals_start']));
        $post['deals_end']           = date('Y-m-d H:i:s', strtotime($post['deals_end']));
        $post['deals_image']         = MyHelper::encodeImage($post['deals_image']);

        if (isset($post['deals_voucher_expired']) && !empty($post['deals_voucher_expired'])) {
            $post['deals_voucher_expired'] = date('Y-m-d H:i:s', strtotime($post['deals_voucher_expired']));
        }

        $save = MyHelper::post('hidden-deals/create', $post);

        return parent::redirect($save, 'Inject Voucher has been created.');
    }

    /* IMPORT DATA FROM EXCEL */
    function importDataExcel($fileExcel, $redirect=null) {

        $path = $fileExcel->getRealPath();
        // $data = \Excel::load($path)->get()->toArray();
        $data = \Excel::toArray(new \App\Imports\FirstSheetOnlyImport(),$path);
        $data = array_map(function($x){return (Object)$x;}, $data[0]??[]);

        if (!empty($data)) {
            $data = array_unique(array_pluck($data, 'phone'));
            $data = implode(",", $data);

            // SET SESSION
            Session::flash('deals_recipient', $data);

            if (is_null($redirect)) {
                return back()->with('success', ['Data customer has been added.']);
            }
            else {
                return redirect($redirect)->with('success', ['Data customer has been added.']);
            }

        }
        else {
            return back()->withErrors(['Data customer is empty.']);
        }
    }

    function dataDeals($identifier, $type="") {

        switch ($identifier) {
            case 'deals':
                if ($type == "detail") {
                    $data = [
                        'title'          => 'Deals',
                        'sub_title'      => 'Deals Detail',
                        'menu_active'    => 'deals',
                        'submenu_active' => 'deals-list'
                    ];
                }
                elseif ($type == "import") {
                    $data = [
                        'title'          => 'Deals',
                        'sub_title'      => 'Deals Import',
                        'menu_active'    => 'deals',
                        'submenu_active' => 'deals-import'
                    ];
                }
                elseif ($type == "") {
                    $data = [
                        'title'          => 'Deals',
                        'sub_title'      => 'Deals List',
                        'menu_active'    => 'deals',
                        'submenu_active' => 'deals-list'
                    ];
                }
                else {
                    $data = [
                        'title'          => 'Deals',
                        'sub_title'      => 'Deals Create',
                        'menu_active'    => 'deals',
                        'submenu_active' => 'deals-create'
                    ];
                }

                // IDENTIFIER
                $post['deals_type'] = "Deals";
                $data['deals_type'] = "Deals";

            break;
            case 'inject-voucher':
                if ($type == "detail") {
                    $data = [
                        'title'          => 'Inject Voucher',
                        'sub_title'      => 'Inject Voucher Detail',
                        'menu_active'    => 'inject-voucher',
                        'submenu_active' => 'inject-voucher-list'
                    ];
                }
                elseif ($type == "import") {
                    $data = [
                        'title'          => 'Inject Voucher',
                        'sub_title'      => 'Inject Voucher Import',
                        'menu_active'    => 'inject-voucher',
                        'submenu_active' => 'inject-voucher-import'
                    ];
                }
                elseif ($type == "") {
                    $data = [
                        'title'          => 'Inject Voucher',
                        'sub_title'      => 'Inject Voucher List',
                        'menu_active'    => 'inject-voucher',
                        'submenu_active' => 'inject-voucher-list'
                    ];
                }
                else {
                    $data = [
                        'title'          => 'Inject Voucher',
                        'sub_title'      => 'Inject Voucher Create',
                        'menu_active'    => 'inject-voucher',
                        'submenu_active' => 'inject-voucher-create'
                    ];
                }

                // IDENTIFIER
                $post['deals_type'] = "Hidden";
                $data['deals_type'] = "Hidden";
            break;
            case 'deals-subscription':
                if ($type == "") {
                    $data = [
                        'title'          => 'Deals Subscription',
                        'sub_title'      => 'Deals Subscription List',
                        'menu_active'    => 'deals-subscription',
                        'submenu_active' => 'deals-subscription-list'
                    ];
                }
                else {
                    $data = [
                        'title'          => 'Deals Subscription',
                        'sub_title'      => 'Deals Subscription Create',
                        'menu_active'    => 'deals-subscription',
                        'submenu_active' => 'deals-subscription-create'
                    ];
                }

                // IDENTIFIER
                $post['deals_type'] = "Subscription";
                $data['deals_type'] = "Subscription";

            break;
            case 'welcome-voucher':
                if($type == "create"){
                    $data = [
                        'title'          => 'Welcome Voucher',
                        'sub_title'      => 'Welcome Voucher Create',
                        'menu_active'    => 'welcome-voucher',
                        'submenu_active' => 'welcome-voucher-create'
                    ];
                }elseif($type == "setting"){
                    $data = [
                        'title'          => 'Welcome Voucher',
                        'sub_title'      => 'Welcome Voucher Setting',
                        'menu_active'    => 'welcome-voucher',
                        'submenu_active' => 'welcome-voucher-setting'
                    ];
                }elseif($type == "detail"){
                    $data = [
                        'title'          => 'Welcome Voucher',
                        'sub_title'      => 'Welcome Voucher Detail',
                        'menu_active'    => 'welcome-voucher',
                        'submenu_active' => 'welcome-voucher-list'
                    ];
                }elseif ($type == "import") {
                    $data = [
                        'title'          => 'Welcome Voucher',
                        'sub_title'      => 'Welcome Voucher Import',
                        'menu_active'    => 'welcome-voucher',
                        'submenu_active' => 'welcome-voucher-import'
                    ];
                }else {
                    $data = [
                        'title'          => 'Welcome Voucher',
                        'sub_title'      => 'Welcome Voucher List',
                        'menu_active'    => 'welcome-voucher',
                        'submenu_active' => 'welcome-voucher-list'
                    ];
                }

                // IDENTIFIER
                $post['deals_type'] = "WelcomeVoucher";
                $data['deals_type'] = "WelcomeVoucher";
            break;
            case 'promotion':
                if($type == "create"){
                	$data = [
			            'title'          => 'Promotion',
			            'sub_title'      => 'Create Deals Promotion',
			            'menu_active'    => 'promotion',
			            'submenu_active' => 'new-deals-promotion',
					];
                }elseif($type == "setting"){
                	$data = [
			            'title'          => 'Promotion',
			            'sub_title'      => 'Deals Promotion',
			            'menu_active'    => 'promotion',
			            'submenu_active' => 'deals-promotion',
			        ];
                }else {
                    $data = [
			            'title'          => 'Promotion',
			            'sub_title'      => 'Deals Promotion',
			            'menu_active'    => 'promotion',
			            'submenu_active' => 'deals-promotion',
			        ];
                }

                // IDENTIFIER
                $post['deals_type'] = "Promotion";
                $data['deals_type'] = "Promotion";
            break;
            default:
                if ($type == "") {
                    $data = [
                        'title'          => 'Deals',
                        'sub_title'      => 'Deals Point List',
                        'menu_active'    => 'deals',
                        'submenu_active' => 'deals-point-list'
                    ];
                }
                else {
                    $data = [
                        'title'          => 'Deals',
                        'sub_title'      => 'Deals Point Create',
                        'menu_active'    => 'deals',
                        'submenu_active' => 'deals-point-create'
                    ];
                }

                // IDENTIFIER
                $post['deals_type'] = "Point";
                $data['deals_type'] = "Point";
            break;
        }

        return $kembali = [
            'data' => $data,
            'post' => $post
        ];

    }

    /* CREATE DEALS */
    function create(Create $request) {
        $post = $request->except('_token');
        $configs = session('configs');
        if (empty($post)) {
            $identifier = $this->identifier();
            $dataDeals  = $this->dataDeals($identifier, "create");
            $data       = $dataDeals['data'];

            if(MyHelper::hasAccess([97], $configs)){

                $data['brands'] = parent::getData(MyHelper::get('brand/be/list'));
            }

            if ($data['deals_type'] == 'Promotion') {
            	$data['template'] = 1;
            }

            // DATA OUTLET
        	$data['outlets'] = parent::getData(MyHelper::get('outlet/be/list'));

            if ($identifier == "deals-point") {
                return view('deals::point.create', $data);
            }

            return view('deals::deals.step1', $data);
        }
        else {
            if (isset($post['deals_description'])) {
                // remove tag <font>
                $post['deals_description'] = preg_replace("/<\\/?font(.|\\s)*?>/", '', $post['deals_description']);
            }
            // print_r($post); exit();
            /* IF HAS IMPORT DATA */
            if (isset($post['import_file']) && !empty($post['import_file'])) {
                return $this->importDataExcel($post['import_file']);
            }

            /* SAVE DEALS */
            return $this->saveDefaultDeals($post);

            // IF HAS RECIPIENT IN FORM CREATE
            // if ($post['deals_type'] == "Deals") {
            //     return $this->saveDefaultDeals($post);
            // }
            // else {
            //     return $this->saveHiddenDeals($post);
            // }
        }
    }

    /* LIST */
    function deals(Request $request) {
        $post=$request->except('_token');
        unset($post['page']);
        $identifier = $this->identifier();
        $dataDeals  = $this->dataDeals($identifier);

    	if($dataDeals['post']['deals_type'] == 'Promotion'){
            $rpage = 'promotion/deals';
    	}elseif($dataDeals['post']['deals_type'] == 'WelcomeVoucher'){
            $rpage = 'welcome-voucher';
        }else{
            $rpage = $dataDeals['post']['deals_type'] =='Deals'?'deals':'inject-voucher';
        }


        if ($request->post('clear') == 'session') 
        {
            session(['deals_filter' => '']);
        }

        $data       		= $dataDeals['data'];
        $post['deals_type'] = $dataDeals['post']['deals_type'];
        $post['web'] 		= 1;
        $post['paginate'] 	= 10;
        $post['admin']		= 1;
        $post['updated_at']	= 1;

        app($this->promo_campaign)->session_mixer($request, $post, 'deals_filter');
        if(($filter=session('deals_filter'))&&is_array($filter)){

            if($filter['rule']??false){
                $data['rule']=array_map('array_values', $filter['rule']);
            }
            if($filter['operator']??false){
                $data['operator']=$filter['operator'];
            }
            session(['deals_filter' => $post]);
        }


        if (!empty($request->except('_token','page'))) {
        	return redirect($rpage);
        	dd($request->except('_token','page'));
        }
        $get_data = MyHelper::post('deals/be/list?page='.$request->get('page'), $post);

		if(!empty($get_data['result']['data']) && $get_data['status'] == 'success' && !empty($get_data['result']['data'])){

            $data['deals']            = $get_data['result']['data'];
            $data['dealsTotal']       = $get_data['result']['total'];
            $data['dealsPerPage']     = $get_data['result']['from'];
            $data['dealsUpTo']        = $get_data['result']['from'] + count($get_data['result']['data'])-1;
            $data['dealsPaginator']   = new LengthAwarePaginator($get_data['result']['data'], $get_data['result']['total'], $get_data['result']['per_page'], $get_data['result']['current_page'], ['path' => url()->current()]);
            $data['total']            = $get_data['result']['total'];
            
        }else{
            $data['deals']          = [];
            $data['dealsTotal']     = 0;
            $data['dealsPerPage']   = 0;
            $data['dealsUpTo']      = 0;
            $data['dealsPaginator'] = false;
            $data['total']          = 0;
        }

        $outlets = parent::getData(MyHelper::get('outlet/be/list'));
        $brands = parent::getData(MyHelper::get('brand/be/list'));
        if (!empty($data['deals'])) {
        	foreach ($data['deals'] as $key => $value) {
        		$data['deals'][$key]['id_deals_decrypt'] = $value['id_deals'];
        		$data['deals'][$key]['id_deals'] = MyHelper::createSlug($value['id_deals'], $value['created_at']);
        	}
        }

        $data['outlets']=array_map(function($var){
            return [$var['id_outlet'],$var['outlet_name']];
        }, $outlets);
        $data['brands']=array_map(function($var){
            return [$var['id_brand'],$var['name_brand']];
        }, $brands);
        return view('deals::deals.list', $data);
    }

    /* DETAIL */
    function detail(Request $request, $id, $promo=null) {
        $post = $request->except('_token');
        $id_encrypt = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
        $identifier             = $this->identifier();
        $dataDeals              = $this->dataDeals($identifier, 'detail');

        if($post)
        {
            if(($post['clear']??false)=='session'){
                session(['participate_filter'.$id=>[]]);
            }else{
                session(['participate_filter'.$id=>$post]);
            }
            return back();
        }

        // print_r($identifier); exit();
        $data                   = $dataDeals['data'];
        $post                   = $dataDeals['post'];
        $post['id_deals']       = $id;
        $post['deals_promo_id'] = $promo;
        $post['web'] 			= 1;
        $post['step'] 			= 'all';
        $post['deals_type'] 	= $data['deals_type'];
        // DEALS
        $data['deals']   = parent::getData(MyHelper::post('deals/be/detail', $post));;

        if($post['deals_type'] == 'Promotion'){
            $rpage = 'promotion/deals';
    	}elseif($post['deals_type'] == 'WelcomeVoucher'){
            $rpage = 'welcome-voucher';
        }else{
            $rpage = $post['deals_type']=='Deals'?'deals':'inject-voucher';
        }

        if (empty($data['deals'])) {
            return redirect($rpage)->withErrors(['Data deals not found.']);
        }

        $data['deals']['id_deals'] = $id_encrypt;

        // DEALS USER VOUCHER
        if(($filter=session('participate_filter'.$id))&&is_array($filter))
        {
            $post=array_merge($filter,$post);
            if($filter['rule']??false){
                $data['rule']=array_map('array_values', $filter['rule']);
            }
            if($filter['operator']??false){
                $data['operator']=$filter['operator'];
            }
        }

        $user = $this->voucherUserList($id, $request->get('page'), $filter);

        foreach ($user as $key => $value) {
            $data[$key] = $value;
        }

        // VOUCHER
        $voucher = $this->voucherList($id, $request->get('page'));

        foreach ($voucher as $key => $value) {
            $data[$key] = $value;
        }

  //       // DATA BRAND
  //       $data['brands'] = parent::getData(MyHelper::get('brand/be/list'));

  //       // DATA PRODUCT
  //       // $data['product'] = parent::getData(MyHelper::get('product/be/list'));

        // DATA OUTLET
        $data['outlets'] = parent::getData(MyHelper::get('outlet/be/list'));
        if (!empty($data['deals']['deals_list_outlet'])) {
        	$list_outlet = explode(',',$data['deals']['deals_list_outlet']);
        	$data['promotion_outlets'] = [];
        	foreach ($list_outlet as $key => $value) {
        		foreach ($data['outlets'] as $key2 => $value2) {
        			if ( $value == $value2['id_outlet'] ) {
        				array_push($data['promotion_outlets'], $value2);
        				break;
        			}
        		}
        	}
        }

		$data['outlets2']=array_map(function($var){
            return [$var['id_outlet'],$var['outlet_name']];
        }, $data['outlets']);

        $getCity = MyHelper::get('city/list?log_save=0');
		if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = [];

		$getProvince = MyHelper::get('province/list?log_save=0');
		if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = [];

		$getCourier = MyHelper::get('courier/list?log_save=0');
		if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = [];

		// $getProduct = MyHelper::get('product/be/list?log_save=0');
		// if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];

		// $getTag = MyHelper::get('product/tag/list?log_save=0');
		// if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];

		$getMembership = MyHelper::post('membership/be/list?log_save=0',[]);
		if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];


        if(!empty(Session::get('filter_user'))){
            $data['conditions'] = Session::get('filter_user');
        }else{
            $data['conditions'] = [];
        }

        return view('deals::deals.detail', $data);
    }

    /* */
    /* DETAIL */
    function step1(Request $request, $id) {
        $post = $request->except('_token');
        $slug = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';

        $identifier             = $this->identifier();

        // print_r($identifier); exit();
        $dataDeals              = $this->dataDeals($identifier);
        $data                   = $dataDeals['data'];
        $post                   = $dataDeals['post'];
        $post['id_deals']       = $id;
        $post['web'] = 1;
        $post['step'] = 1;
        // DEALS
        $data['deals']   = parent::getData(MyHelper::post('deals/be/detail', $post));
        if (empty($data['deals'])) {
            return back()->withErrors(['Data deals not found.']);
        }

        $data['deals']['slug'] = $slug;

        // VOUCHER
		if ($data['deals']['deals_voucher_type'] == 'List Vouchers') {
			$is_all='is_all';
		}
        $voucher = $this->voucherList($id, $request->get('page'), ['id_deals_voucher','voucher_code'], $is_all??null);

        foreach ($voucher as $key => $value) {
            $data[$key] = $value;
        }

        // DATA BRAND
        $data['brands'] = parent::getData(MyHelper::get('brand/be/list'));

        // DATA OUTLET
        $data['outlets'] = parent::getData(MyHelper::get('outlet/be/list'));

        if(!empty(Session::get('filter_user'))){
            $data['conditions'] = Session::get('filter_user');
        }else{
            $data['conditions'] = [];
        }

        return view('deals::deals.step1', $data);
        if($post['deals_type'] == 'WelcomeVoucher'){
            return view('deals::welcome_voucher.detail', $data);
        }else{
        }
    }

    /* DETAIL */
    function step2(Request $request, $id) {
        $post = $request->except('_token');
        $slug = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';

        if (empty($post)) {
	        $identifier             = $this->identifier();
	        $dataDeals              = $this->dataDeals($identifier);

	        $data                   = $dataDeals['data'];
	        $post                   = $dataDeals['post'];
	        
	        $post['id_deals']   = $id;
	        $post['step'] 		= 2;
	        $post['deals_type'] = $data['deals_type'];

	        // DEALS
	        $deals = MyHelper::post('deals/be/detail', $post);

	        if (isset($deals['status']) && $deals['status'] == 'success') {

	            $data['result'] = $deals['result'];

	        } else {

	            return redirect('deals')->withErrors($deals['messages']);
	        }
	        $data['warning_image'] = MyHelper::post('setting', ['key' => 'promo_warning_image'])['result']['value'];

	        return view('deals::deals.step2', $data);
	        
	    }else{

            $post['id_deals'] = $id;
            if(isset($post['promo_warning_image'])){
	            $post['promo_warning_image'] = MyHelper::encodeImage($post['promo_warning_image']);
	        }

			$action = MyHelper::post('promo-campaign/step2', $post);

            if (isset($action['status']) && $action['status'] == 'success') {

            	if($post['deals_type'] == 'Promotion'){
	                $rpage = 'promotion/deals';
	        	}elseif($post['deals_type'] == 'WelcomeVoucher'){
	                $rpage = 'welcome-voucher';
	            }else{
	                $rpage = $post['deals_type']=='Deals'?'deals':'inject-voucher';
	            }

                return redirect($rpage.'/step3/' . $slug)->withSuccess(['Deals has been updated']);
            }
            elseif($action['messages']??$action['message']??false) {
                return back()->withErrors($action['messages']??$action['message'])->withInput();
            }
            else{
                return back()->withErrors(['Something went wrong'])->withInput();
            }
        }

    }

    function step3(Request $request, $id) {
        $post = $request->except('_token');
        $slug = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';

        if (empty($post)) {
	        $identifier             = $this->identifier();
	        $dataDeals              = $this->dataDeals($identifier);

	        $data                   = $dataDeals['data'];
	        $post                   = $dataDeals['post'];
	        // $data = [
	        //     'title'          => 'Deals',
	        //     'sub_title'      => 'Deals Create',
	        //     'menu_active'    => 'deals',
	        //     'submenu_active' => 'deals-create',
	        //     'deals_type' => 'Deals'
	        // ];
	        $post['id_deals']   = $id;
	        $post['step'] 		= 3;
	        $post['deals_type'] = $data['deals_type'];

	        // DEALS
	        $deals = MyHelper::post('deals/be/detail', $post);

	        if (isset($deals['status']) && $deals['status'] == 'success') {

	            $data['deals'] = $deals['result'];

	        } else {

	            return redirect('deals')->withErrors($deals['messages']);
	        }

	        return view('deals::deals.step3', $data);

	        if (empty($data['result'])) {
	            return back()->withErrors(['Data deals not found.']);
	        }
	    }else{

            $post['id_deals'] = $id;
			$action = MyHelper::post('deals/update-content', $post);

            if (isset($action['status']) && $action['status'] == 'success') {

            	if($post['deals_type'] == 'Promotion'){
	                $rpage = 'promotion/deals';
	        	}elseif($post['deals_type'] == 'WelcomeVoucher'){
	                $rpage = 'welcome-voucher';
	            }else{
	                $rpage = $post['deals_type']=='Deals'?'deals':'inject-voucher';
	            }

                return redirect($rpage.'/detail/' . $slug)->withSuccess(['Deals has been updated']);
            }
            elseif($action['messages']??false) {
                return back()->withErrors($action['messages'])->withInput();
            }
            else{
                return back()->withErrors(['Something went wrong'])->withInput();
            }
        }

    }

    /* UPDATE REQUEST */
    function updateReq(Create $request) {
        $post = $request->except('_token');

        if($post['deals_type'] == 'Promotion'){
            $rpage = 'promotion/deals';
    	}elseif($post['deals_type'] == 'WelcomeVoucher'){
            $rpage = 'welcome-voucher';
        }else{
            $rpage = $post['deals_type']=='Deals'?'deals':'inject-voucher';
        }

        if (empty($post['id_deals'])) {
            /* SAVE DEALS */
            return $this->saveDefaultDeals($post);
        }

        $slug = $post['slug']??$post['id_deals'];

        $url  = explode(url('/'), url()->previous());
        // IMPORT FILE
        if (isset($post['import_file'])) {
            $participate=$this->importDataExcel($post['import_file'], $url[1].'#participate',true);
            $post['conditions'][0]=[
                [
                    'subject'=>$post['csv_content']??'id',
                    'operator'=>'WHERE IN',
                    'parameter'=>$participate
                ],
                'rule'=>'and',
                'rule_next'=>'and',
            ];
        }
        // ADD VOUCHER CODE
        if (isset($post['voucher_code']) && empty($post['deals_title'])) {
        	$post['id_deals'] = MyHelper::explodeSlug($post['id_deals'])[0];
            // return parent::redirect($this->saveVoucherList($post['id_deals'], $post['voucher_code'], 'add'), "Voucher has been added.");
            $save_voucher_list = $this->saveVoucherList($post['id_deals'], $post['voucher_code'], 'add');

            if (($save_voucher_list['status']??false) == 'success') {
        		$redirect = redirect("$rpage/detail/{$slug}")->withSuccess(["Deals has been added."]);
        	}else{
        		$redirect = redirect("$rpage/detail/{$slug}")->withErrors($save['messages']??['Something went wrong'])->withInput();
        	}

    		if (!empty($save_voucher_list['warnings'])) {
    			$redirect = $redirect->withWarning($save_voucher_list['warnings']);
    		}

            return $redirect;

        }

        // ASSIGN USER TO VOUCHER
        if (isset($post['conditions'])) {
        	$post['id_deals'] = MyHelper::explodeSlug($post['id_deals'])[0]??'';

            $assign = $this->autoAssignVoucher($post['id_deals'], $post['conditions'], $post['amount']);
            if(isset($assign['status']) && $assign['status'] == 'success'){
                return parent::redirect($assign, $assign['result']['voucher']." voucher has been assign to ".$assign['result']['user'].' users', $url[1].'#participate');
            }else{
                if(isset($assign['status']) && $assign['status'] == 'fail') $e = $assign['messages'];
                elseif(isset($assign['errors'])) $e = $assign['errors'];
                elseif(isset($assign['exception'])) $e = $assign['message'];
                else $e = ['e' => 'Something went wrong. Please try again.'];
                return back()->witherrors($e)->withInput();
            }
        }

        // UPDATE DATA DEALS
        $post = $this->update($post);
        // SAVE
        $update = MyHelper::post('deals/update', $post);

        if ( ($update['status']??false) == 'success') {

        	if ($post['deals_voucher_type'] == "List Vouchers" && $post['deals_type'] != 'Promotion') {
                // return parent::redirect($this->saveVoucherList($post['id_deals'], $post['voucher_code']), "Deals has been updated.","$rpage/step2/{$slug}");
                $save_voucher_list = $this->saveVoucherList($post['id_deals'], $post['voucher_code']);

            	if (($save_voucher_list['status']??false) == 'success') {
            		$redirect = redirect("$rpage/step2/{$slug}")->withSuccess(["Deals has been updated."]);
            	}else{
            		$redirect = back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            	}

        		if (!empty($save_voucher_list['warnings'])) {
        			$redirect = $redirect->withWarning($save_voucher_list['warnings']);
        		}

                return $redirect;
            }

        	return redirect($rpage.'/step2/'.$slug)->withSuccess(['Deals has been updated']);
        }else{
        	return redirect($rpage.'/step1/'.$slug)->withErrors($update['messages']??['Something went wrong']);
        }
        return parent::redirect($update, $this->identifier('prev').' has been updated.', str_replace(" ", "-", strtolower($this->identifier('prev'))));
    }

    /* AUTO ASSIGN VOUCHER */
    function autoAssignVoucher($id_deals, $conditions, $amount) {
        $post = [
            'id_deals'      => $id_deals,
            'conditions'    => $conditions,
            'amount'        => $amount
        ];

        Session::put('filter_user',$post['conditions']);

        $save = MyHelper::post('hidden-deals/create/autoassign', $post);

        return $save;
    }

    /* SAVE VOUCHER LIST */
    function saveVoucherList($id_deals, $voucher_code, $add_type='update') {
        $voucher['type']         = "list";
        $voucher['id_deals']     = $id_deals;
        $voucher['add_type']     = $add_type;
        $voucher['voucher_code'] = array_filter(explode("\n", $voucher_code));

        $saveVoucher = MyHelper::post('deals/voucher/create', $voucher);

        return $saveVoucher;
    }

    /* LIST VOUCHER */
    function voucherList($id, $page, $select = null, $is_all=null) {
    	$post['select'] = $select;
    	$post['is_all'] = $is_all;
    	$post['id_deals'] = $id;

        $voucher = parent::getData(MyHelper::post('deals/voucher?page='.$page, $post));

        if (empty($is_all)) {
	        if (!empty($voucher['data'])) {
	            $data['voucher']          = $voucher['data'];
	            $data['voucherTotal']     = $voucher['total'];
	            $data['voucherPerPage']   = $voucher['from'];
	            $data['voucherUpTo']      = $voucher['from'] + count($voucher['data'])-1;
	            $data['voucherPaginator'] = new LengthAwarePaginator($voucher['data'], $voucher['total'], $voucher['per_page'], $voucher['current_page'], ['path' => url()->current()]);
	        }
	        else {
	            $data['voucher']          = [];
	            $data['voucherTotal']     = 0;
	            $data['voucherPerPage']   = 0;
	            $data['voucherUpTo']      = 0;
	            $data['voucherPaginator'] = false;
	        }
        }else{
        	if (!empty($voucher)) {
        		$data['voucher'] = $voucher;
        	}else{
        		$data['voucher'] = [];
        	}
        }

        return $data;
    }

    /* LIST VOUCHER */
    function voucherUserList($id, $page, $filter=null) {
    	$post['id_deals'] = $id;
    	if (!empty($filter)) {
    		foreach ($filter as $key => $value) {
    			$post[$key] = $value;
    		}
    	}

        $user = parent::getData(MyHelper::post('deals/user?page='.$page, $post));

        // print_r($user); exit();
        if (!empty($user['data'])) {
            $data['user']          = $user['data'];
            $data['userTotal']     = $user['total'];
            $data['userPerPage']   = $user['from'];
            $data['userUpTo']      = $user['from'] + count($user['data'])-1;
            $data['userPaginator'] = new LengthAwarePaginator($user['data'], $user['total'], $user['per_page'], $user['current_page'], ['path' => url()->current()]);
        }
        else {
            $data['user']          = [];
            $data['userTotal']     = 0;
            $data['userPerPage']   = 0;
            $data['userUpTo']      = 0;
            $data['userPaginator'] = false;
        }

        return $data;
    }

    /* UPDATE DATA DEALS */
    function update($post) {
        // print_r($post); exit();
        if (isset($post['deals_promo_id_type'])) {
            if ($post['deals_promo_id_type'] == "promoid") {
                $post['deals_promo_id'] = $post['deals_promo_id_promoid'];
            }
            else {
                $post['deals_promo_id'] = $post['deals_promo_id_nominal'];
            }
        }

        unset($post['deals_promo_id_promoid']);
        unset($post['deals_promo_id_nominal']);

        if (isset($post['deals_voucher_type'])) {
            if ( $post['deals_voucher_type'] == 'Auto generated' && $post['total_voucher_type'] == 'Unlimited') {
                $post['deals_voucher_type'] = 'Unlimited';
                $post['deals_total_voucher'] = null;
            }
        }

        if(isset($post['deals_start'])){
            $post['deals_start']         = date('Y-m-d H:i:s', strtotime($post['deals_start']));
        }

        if(isset($post['deals_end'])){
            $post['deals_end']           = date('Y-m-d H:i:s', strtotime($post['deals_end']));
        }

        if (isset($post['deals_publish_start'])) {
            $post['deals_publish_start'] = date('Y-m-d H:i:s', strtotime($post['deals_publish_start']));
        }

        if (isset($post['deals_publish_end'])) {
            $post['deals_publish_end']   = date('Y-m-d H:i:s', strtotime($post['deals_publish_end']));
        }

        if (isset($post['deals_description'])) {
            // remove tag <font>
            $post['deals_description'] = preg_replace("/<\\/?font(.|\\s)*?>/", '', $post['deals_description']);
        }

        if (isset($post['deals_image'])) {
            $post['deals_image']         = MyHelper::encodeImage($post['deals_image']);
        }

        if (isset($post['deals_voucher_start']) && !empty($post['deals_voucher_start'])) {
            $post['deals_voucher_start'] = date('Y-m-d H:i:s', strtotime($post['deals_voucher_start']));
        }

        if (isset($post['deals_voucher_expired']) && !empty($post['deals_voucher_expired'])) {
            $post['deals_voucher_expired'] = date('Y-m-d H:i:s', strtotime($post['deals_voucher_expired']));
        }

        if (isset($post['id_outlet'])) {
            $post['id_outlet'] = array_filter($post['id_outlet']);
        }

        if (isset($post['deals_voucher_duration'])) {
            if (empty($post['deals_voucher_duration'])) {
                $post['deals_voucher_duration'] = null;
            }
        }

        if (isset($post['deals_voucher_expired'])) {
            if (empty($post['deals_voucher_expired'])) {
                $post['deals_voucher_expired'] = null;
            }
        }

        if (isset($post['deals_voucher_price_point'])) {
            if (empty($post['deals_voucher_price_point'])) {
                $post['deals_voucher_price_point'] = null;
            }
        }

        if (isset($post['deals_voucher_price_cash'])) {
            if (empty($post['deals_voucher_price_cash'])) {
                $post['deals_voucher_price_cash'] = null;
            }
        }

        return $post;
    }

    /* DELETE VOUCHER */
    function deleteVoucher(Request $request) {
        $post    = $request->except('_token');
        $voucher = MyHelper::post('deals/voucher/delete', ['id_deals_voucher' => $post['id_deals_voucher']]);

        if (isset($voucher['status']) && $voucher['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /* DELETE DEAL */
    function deleteDeal(Request $request) {
        $post    = $request->except('_token');
        $post['id_deals'] = MyHelper::explodeSlug($post['id_deals'])[0]??'';
        $voucher = MyHelper::post('deals/delete', ['id_deals' => $post['id_deals']]);

        if (isset($voucher['status']) && $voucher['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /* TRX DEALS */
    function transaction(Request $request) {
        $data = [
            'title'          => 'Deals',
            'sub_title'      => 'Deals Transaction',
            'menu_active'    => 'deals-transaction',
            'submenu_active' => ''
        ];

        $request->session()->forget('date_start');
        $request->session()->forget('date_end');
        $request->session()->forget('id_outlet');
        $request->session()->forget('id_deals');

        $post = [
            'date_start' => date('Y-m-d', strtotime("- 7 days")),
            'date_end'   => date('Y-m-d')
        ];

        // TRX
        $trx = $this->getDataDealsTrx($request->get('page'), $post);

        foreach ($trx as $key => $value) {
            $data[$key] = $value;
        }

        $data['outlet']    = parent::getData(MyHelper::get('outlet/be/list?log_save=0'));
        $data['dealsType'] = parent::getData(MyHelper::post('deals/be/list', ['deals_type_array' => ["Deals", "Hidden"], 'web' => 1]));
        // $data['dealsType'] = parent::getData(MyHelper::get('deals/be/list'));


        foreach ($post as $key => $value) {
            $data[$key] = $value;
        }

        // print_r($data); exit();
        return view('deals::deals.transaction', $data);
    }

    function transactionFilter(Request $request) {
        $data = [
            'title'          => 'Deals',
            'sub_title'      => 'Deals Transaction',
            'menu_active'    => 'deals-transaction',
            'submenu_active' => ''
        ];

        $post = $request->except('_token');

        if (empty($post)) {
            return redirect('deals/transaction');
        }

        if (isset($post['page'])) {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            $post['id_outlet']  = session('id_outlet');
            $post['id_deals']   = session('id_deals');
        }
        else {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            session(['id_outlet'  => $post['id_outlet']]);
            session(['id_deals'   => $post['id_deals']]);
        }

        $trx = $this->getDataDealsTrx($request->get('page'), $post);

        foreach ($trx as $key => $value) {
            $data[$key] = $value;
        }

        foreach ($post as $key => $value) {
            $data[$key] = $value;
        }

        $data['outlet']    = parent::getData(MyHelper::get('outlet/be/list?log_save=0'));
        $data['dealsType'] = parent::getData(MyHelper::post('deals/be/list', ['deals_type' => ["Deals", "Hidden"]]));
        // $data['dealsType'] = parent::getData(MyHelper::get('deals/be/list'));

        return view('deals::deals.transaction', $data);
    }

    /* TRX */
    function getDataDealsTrx($page, $post) {
        $post['date_start'] = date('Y-m-d', strtotime($post['date_start']));
        $post['date_end']   = date('Y-m-d', strtotime($post['date_end']));

        if (isset($post['id_outlet'])) {
            if ($post['id_outlet'] == "all") {
                unset($post['id_outlet']);
            }
        }

        if (isset($post['id_deals'])) {
            if ($post['id_deals'] == "all") {
                unset($post['id_deals']);
            }
        }

        $post  = array_filter($post);
        $deals = parent::getData(MyHelper::post('deals/transaction?page='.$page, $post));

        if (!empty($deals['data'])) {
            $data['deals']          = $deals['data'];
            $data['dealsTotal']     = $deals['total'];
            $data['dealsPerPage']   = $deals['from'];
            $data['dealsUpTo']      = $deals['from'] + count($deals['data'])-1;
            $data['dealsPaginator'] = new LengthAwarePaginator($deals['data'], $deals['total'], $deals['per_page'], $deals['current_page'], ['path' => url()->current()]);
        }
        else {
            $data['deals']          = [];
            $data['dealsTotal']     = 0;
            $data['dealsPerPage']   = 0;
            $data['dealsUpTo']      = 0;
            $data['dealsPaginator'] = false;
        }

        return $data;
    }

    /*** DEALS SUBSCRIPTION ***/
    // create deals subscription
    public function subscriptionCreate(Create $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $identifier = $this->identifier();
            $dataDeals  = $this->dataDeals($identifier, "create");
            $data       = $dataDeals['data'];

            // DATA PRODUCT
            $data['products'] = parent::getData(MyHelper::get('product/be/list?log_save=0'));

            // DATA OUTLET
            $data['outlet'] = parent::getData(MyHelper::get('outlet/be/list?log_save=0'));

            return view('deals::subscription.subscription_create', $data);
        }
        else {
            /* SAVE DEALS */
            $post = $this->checkDealsSubscriptionInput($post);
            // dd($post);

            // call api
            $save = MyHelper::post('deals-subscription/create', $post);
            // dd($save);

            return parent::redirect($save, 'Deals has been created.');
        }
    }

    // check deals subscription
    private function checkDealsSubscriptionInput($post) {
        if (isset($post['deals_voucher_type']) && $post['deals_voucher_type']=="Unlimited") {
            $post['deals_total_voucher'] = 0;
        }

        if (isset($post['deals_start']) && !empty($post['deals_start'])) {
            $post['deals_start']         = date('Y-m-d H:i:s', strtotime($post['deals_start']));
        }
        if (isset($post['deals_end']) && !empty($post['deals_end'])) {
            $post['deals_end']           = date('Y-m-d H:i:s', strtotime($post['deals_end']));
        }

        if (isset($post['deals_publish_start']) && !empty($post['deals_publish_start'])) {
            $post['deals_publish_start'] = date('Y-m-d H:i:s', strtotime($post['deals_publish_start']));
        }
        if (isset($post['deals_publish_start']) && !empty($post['deals_publish_start'])) {
            $post['deals_publish_end']   = date('Y-m-d H:i:s', strtotime($post['deals_publish_end']));
        }

        if (isset($post['deals_image'])) {
            $post['deals_image']         = MyHelper::encodeImage($post['deals_image']);
        }

        $post['deals_type'] = 'Subscription';
        $post['deals_promo_id_type'] = null;

        return $post;
    }

    // list deals subscription
    public function subscriptionDeals(Request $request) {

        $identifier = $this->identifier();
        $dataDeals  = $this->dataDeals($identifier);

        $data       = $dataDeals['data'];
        $post       = $dataDeals['post'];

        $data['deals'] = parent::getData(MyHelper::post('deals/be/list', $post));
        // dd($data, $post);

        return view('deals::subscription.subscription_list', $data);
    }

    // detail deals subscription
    public function subscriptionDetail(Request $request, $id_deals) {
        $post = $request->except('_token');

        $identifier             = $this->identifier();
        $dataDeals              = $this->dataDeals($identifier);

        $data                   = $dataDeals['data'];
        $post                   = $dataDeals['post'];
        $post['id_deals']       = $id_deals;
        $post['deals_type']     = "Subscription";

        // DEALS
        $data['deals']   = parent::getData(MyHelper::post('deals/be/list', $post));
        if (empty($data['deals'])) {
            return back()->withErrors(['Data deals not found.']);
        }
        $data['subscriptions_count'] = count($data['deals'][0]['deals_subscriptions']);
        // dd($data['deals'], $data['subscriptions_count']);

        // DEALS USER VOUCHER
        $user = $this->voucherUserList($id_deals, $request->get('page'));
        foreach ($user as $key => $value) {
            $data[$key] = $value;
        }

        // VOUCHER
        $voucher = $this->voucherList($id_deals, $request->get('page'));
        foreach ($voucher as $key => $value) {
            $data[$key] = $value;
        }

        // DATA PRODUCT
        $data['products'] = parent::getData(MyHelper::get('product/be/list?log_save=0'));

        // DATA OUTLET
        $data['outlet'] = parent::getData(MyHelper::get('outlet/be/list?log_save=0'));

        // dd($data);
        return view('deals::subscription.subscription_detail', $data);
    }

    // update deals subscription
    public function subscriptionUpdate(Create $request) {
        $post = $request->except('_token');
        $url  = explode(url('/'), url()->previous());

        // CHECK DATA DEALS
        $post = $this->checkDealsSubscriptionInput($post);

        // UPDATE
        $update = MyHelper::post('deals-subscription/update', $post);

        return parent::redirect($update, $this->identifier('prev').' has been updated.', str_replace(" ", "-", strtolower($this->identifier('prev'))));
    }

    public function deleteSubscriptionDeal($id_deals)
    {
        $delete = MyHelper::get('deals-subscription/delete/'.$id_deals);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return $delete;
        }
    }

    /* ====================== Start Welcome Voucher ====================== */
    function welcomeVoucherCreate(Create $request) {
        $post = $request->except('_token');
        $configs = session('configs');
        if (empty($post)) {
            $identifier = $this->identifier();
            $dataDeals  = $this->dataDeals($identifier, "create");
            $data       = $dataDeals['data'];

            if(!MyHelper::hasAccess([97], $configs)){
                $outlet = MyHelper::get('outlet/be/list');
                if(isset($outlet['status']) && $outlet['status'] == 'success'){
                    $data['outlets'] = $outlet['result'];
                }else{
                    $data['outlets'] = [];
                }
            }
            // DATA BRAND
            $data['brands'] = parent::getData(MyHelper::post('brand/be/list', ['web' => 1]));

            // DATA PRODUCT
            $data['product'] = parent::getData(MyHelper::get('product/be/list?log_save=0'));

            return view('deals::welcome_voucher.create', $data);
        }
        else {

            if (isset($post['deals_description'])) {
                $post['deals_description'] = preg_replace("/<\\/?font(.|\\s)*?>/", '', $post['deals_description']);
            }

            /* IF HAS IMPORT DATA */
            if (isset($post['import_file']) && !empty($post['import_file'])) {
                return $this->importDataExcel($post['import_file']);
            }

            /* SAVE DEALS */
            return $this->saveDefaultDeals($post);
        }
    }

    function welcomeVoucherSetting(Request $request){
        $post = $request->except('_token');
        $identifier = $this->identifier();
        $dataDeals  = $this->dataDeals($identifier, "setting");
        $data       = $dataDeals['data'];
        if($post){
            $updateSetting =  MyHelper::post('deals/welcome-voucher/setting/update', $post);
            if($updateSetting){
                return redirect('welcome-voucher/setting')->withSuccess(['Setting Welcome Voucher has been updated.']);
            }else{
                return redirect('welcome-voucher/setting')->withErrors(['Setting Welcome Vouche failed.']);
            }
        }
        $setting = MyHelper::post('deals/welcome-voucher/setting', $post);
        $listDeals = MyHelper::post('deals/welcome-voucher/list/deals', ['deals_type' => 'WelcomeVoucher', 'web' => 1]);

        if(isset($setting['status']) && $setting['status'] == 'success'){
            $data['setting'] = $setting['data']['setting'];
            $data['deals'] = $setting['data']['deals'];
        }else{
            $data['setting'] = [];
            $data['deals'] = [];
        }

        if(isset($listDeals['status']) && $listDeals['status'] == 'success'){
            $data['all_deals'] = $listDeals['result'];
        }else{
            $data['all_deals'] = [];
        }

        return view('deals::welcome_voucher.setting', $data);
    }

    function welcomeVoucherUpdateStatus(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('deals/welcome-voucher/setting/update/status', $post);
        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update status welcome pack'];
        }
    }
    /* ====================== End Welcome Voucher ====================== */

    public function updateComplete(Request $request)
    {
    	$post = $request->except('_token');
    	$slug = $post['id_deals'];
        $post['id_deals'] = MyHelper::explodeSlug($post['id_deals'])[0]??'';
		$update = MyHelper::post('deals/update-complete', $post);

		if($post['deals_type'] == 'Promotion'){
            $rpage = 'promotion/deals';
    	}elseif($post['deals_type'] == 'WelcomeVoucher'){
            $rpage = 'welcome-voucher';
        }else{
            $rpage = $post['deals_type']=='Deals'?'deals':'inject-voucher';
        }

		if ( ($update['status']??false) == 'success' )
		{
			return redirect($rpage.'/detail/'.$slug)->withSuccess(['Deals has been completed'])	;
		}
		elseif ( ($update['status']??false) == 'fail' )
		{
			if ( !empty($update['step']) )
			{
				return redirect($rpage.'/step'.$update['step'].'/'.$slug)->withErrors($update['messages']);
			}
			else
			{
				return redirect()->back()->withErrors($update['messages']);
			}
		}
		else
		{
			return ['status' => 'fail', 'messages' => 'Something went wrong'];
		}
    }

    /* get list of deals that haven't ended yet */
    public function listActiveDeals(Request $request) {
        $post = $request->except('_token');
        $post['select'] = ['id_deals', 'deals_title', 'deals_second_title'];

        $deals = MyHelper::post('deals/list/active?log_save=0', $post);
		if (isset($deals['status']) && $deals['status'] == "success") {
            $data = $deals['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }

    public function exportDeals(Request $request)
    {
    	$post = $request->except('_token');
    	$slug = $post['id_deals'];
        $post['id_deals'] = MyHelper::explodeSlug($post['id_deals'])[0]??'';
        $post['step'] = 'all';
        
        $deals = MyHelper::post('deals/export',$post);

		if (($deals['status']??false) == 'success') {
        	
	        $data = new DealsExport($deals['result']);

	        return Excel::download($data,'Config_Deals_'.($deals['result']['rule'][0][1]??'').'_'.date('Ymdhis').'.xls');
        }
        else{

	    	return back()->withErrors($post['messages']??['Something went wrong']);
        }
    }

    public function importDeals(Request $request)
    {
    	$post = $request->except('_token');
    	$identifier     = $this->identifier();
        $dataDeals      = $this->dataDeals($identifier, 'import');

    	if (empty($post)) {
        	$data = $dataDeals['data'];
            
            return view('deals::deals.import', $data);
        }
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $import = new PromoWithoutHeadingImport();
            $data1 = \Excel::import($import,$request->file('import_file'))??[];
            $data2 = \Excel::toArray(new PromoWithHeadingImport(),$request->file('import_file'))??[];
            $data = [];
			foreach ($import->sheetNames as $key => $value) {
				$data[$value] = $data2[$key];
			}

			$rule = [];
			foreach ($import->sheetData[0]??[] as $key => $value) {
				$rule[$value[0]] = $value[1];
			}
			$data['rule'] = $rule;

            if(!empty($data)){
            	unset($post['import_file']);
            	$post['data'] = $data;

                $import = MyHelper::post('deals/import', $post);

                if($dataDeals['data']['deals_type'] == 'Promotion'){
	                $rpage = 'promotion/deals';
	        	}elseif($dataDeals['data']['deals_type'] == 'WelcomeVoucher'){
	                $rpage = 'welcome-voucher';
	            }else{
	                $rpage = $dataDeals['data']['deals_type']=='Deals'?'deals' : 'inject-voucher';
	            }

				if (($import['status']??false) == 'success') 
				{
					$slug = MyHelper::createSlug($import['deals']['id_deals'], $import['deals']['created_at']);

					$rpage = $rpage.'/detail/'.$slug;

					$redirect = redirect($rpage)->withSuccess($import['messages']);
					if (!empty($import['warning'])) {
						$redirect->withWarning($import['warning']??[]);
					}
					return $redirect;
				}
				else
				{
					return redirect($rpage.'/import')->withErrors($import['messages']??['Import failed - Something went wrong'])->withInput();
				}
            }
            else
            {
                return [
                    'status'=>'fail',
                    'messages'=>['File empty']
                ];
            }
        }

        return [
            'status'=>'fail',
            'messages'=>['Something went wrong']
        ];
    }
}
