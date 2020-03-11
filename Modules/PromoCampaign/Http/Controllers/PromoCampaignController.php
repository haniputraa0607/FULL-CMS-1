<?php

namespace Modules\PromoCampaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Lib\MyHelper;
use Session;

class PromoCampaignController extends Controller
{
    public function session_mixer($request, &$post,$sess='promo_campaign_filter')
    {
        $session = session($sess);
        $session = is_array($session) ? $session : array();
        $post = array_merge($session, $post);
        session([$sess => $post]);
    }

    public function index(Request $request)
    {
        $post = $request->except('_token');

        if ($request->post('clear') == 'session') 
        {
            session(['promo_campaign_filter' => '']);
        }
        
        $this->session_mixer($request, $post);
        if (!$request->get('promo_type')) {
            unset($post['promo_type']);
        }


        $data = [
            'title'             => 'Promo Campaign List',
            'menu_active'       => 'promo-campaign',
            'submenu_active'    => 'promo-campaign-list'
        ];

        if (empty($post)) 
        {
            $get_data = MyHelper::get('promo-campaign?promo_type='.$request->get('promo_type').'&page='.$request->get('page'));
        }
        else
        {
            if (isset($post['page'])) 
            {
                $get_data = MyHelper::post('promo-campaign/filter?page='.$post['page'], $post);
            } 
            else 
            {
                $get_data = MyHelper::post('promo-campaign/filter?page='.$request->get('page'), $post);
            }
        }

        if ($request->get('status') != '') {
            $url = url()->current().'?status='.$request->get('status');
        } else {
            $url = url()->current();
        }

        // pagination data
        if(!empty($get_data['result']['data']) && $get_data['status'] == 'success' && !empty($get_data['result']['data'])){
            // $get_data['result']['data'] = array_map(function($var){
            //     $var['id_promo_campaign'] = MyHelper::createSlug($var['id_promo_campaign'],$var['created_at']);
            //     return $var;
            // },$get_data['result']['data']);
            $data['promo']            = $get_data['result']['data'];
            $data['promoTotal']       = $get_data['result']['total'];
            $data['promoPerPage']     = $get_data['result']['from'];
            $data['promoUpTo']        = $get_data['result']['from'] + count($get_data['result']['data'])-1;
            $data['promoPaginator']   = new LengthAwarePaginator($get_data['result']['data'], $get_data['result']['total'], $get_data['result']['per_page'], $get_data['result']['current_page'], ['path' => $url]);
            $data['total']            = $get_data['result']['total'];
            
        }else{
            $data['promo']          = [];
            $data['promoTotal']     = 0;
            $data['promoPerPage']   = 0;
            $data['promoUpTo']      = 0;
            $data['promoPaginator'] = false;
            $data['total']          = 0;
        }

        $getOutlet = MyHelper::get('outlet/list?log_save=0');
        if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result'];
        else $data['outlets'] = [];

        $getProduct = MyHelper::get('product/list?log_save=0');
        if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result'];
        else $data['products'] = [];

        // data product & outlet for filter
        $data['products'] = array_map(function ($x) {
            return [$x['id_product'], $x['product_name']];
        }, $data['products']);
        array_unshift($data['products'], ['0', 'All Products']);
        $data['outlets'] = array_map(function ($x) {
            return [$x['id_outlet'], $x['outlet_name']];
        }, $data['outlets']);
        array_unshift($data['outlets'], ['0', 'All Outlets']);

        // data rule for filter
        if (isset($get_data['rule'])) {
            $filter = array_map(function ($x) {
                return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
            }, $get_data['rule']);
            $data['rule'] = $filter;
        }

        return view('promocampaign::list', $data);
    }

    public function detail(Request $request, $slug) {
        // $exploded = MyHelper::explodeSlug($slug);
        // $id_promo_campaign = $exploded[0];
        // $created_at = $exploded[1];
        $id_promo_campaign = $slug;
        $post = $request->except('_token');

        if ($request->post('clear') == 'session') 
        {
            session(['report_promo_campaign_'.$id_promo_campaign => '']);
            unset($post['rule']);
            $session = session('coupon_promo_campaign_'.$id_promo_campaign);
            unset($session['rule']);
            session(['coupon_promo_campaign_'.$id_promo_campaign => $session]);

        }
        elseif($request->post('clear2') == 'session')
        {
            session(['coupon_promo_campaign_'.$id_promo_campaign => '']);
            unset($post['rule2']);
            $session = session('report_promo_campaign_'.$id_promo_campaign);
            unset($session['rule2']);
            session(['report_promo_campaign_'.$id_promo_campaign => $session]);
        }

        $this->session_mixer($request, $post,'report_promo_campaign_'.$id_promo_campaign);
        $this->session_mixer($request, $post,'coupon_promo_campaign_'.$id_promo_campaign);
        
        $post['id_promo_campaign'] = $id_promo_campaign;

        if ($request->input('coupon')=='true') 
        {
            return $this->ajaxCoupon($post);
        }
        elseif($request->input('ajax')=='true')
        {
            return $this->ajaxPromoCampaign($post);
        }

        $result = MyHelper::post('promo-campaign/detail', $post);

        if ( ($result['status']=='success')??false) {
            // $result['result']['id_promo_campaign'] = MyHelper::createSlug($result['result']['id_promo_campaign'],$result['result']['created_at']);
            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Detail',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-list',
                'result'            => $result['result']
            ];

            $data['rule']=$post['rule']??[];
            if (isset($data['rule'])) {
                $filter = array_map(function ($x) {
                    return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
                }, $data['rule']);
                $data['rule'] = $filter;
            }
            $data['rule2']=$post['rule2']??[];
            if (isset($data['rule2'])) {
                $filter = array_map(function ($x) {
                    return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
                }, $data['rule2']);
                $data['rule2'] = $filter;
            }
            $outlets = MyHelper::post('outlet/list', $post);
            $outlets = isset($outlets['status'])&&isset($outlets['status'])=='success'?$outlets['result']:[];
            $data['outlets'] = array_map(function($x){return [$x['id_outlet'],$x['outlet_name']];},$outlets);
            $data['operator']=$post['operator']??'and';
            $data['operator2']=$post['operator2']??'and';

            return view('promocampaign::detail', $data);
        }else{
            return redirect('promo-campaign')->withErrors(['Promo Campaign Not Found']);
        }
    }

    public function ajaxPromoCampaign($input){
        $return = $input;

        $return['draw']=(int)$input['draw'];
        $getPromoCampaignReport = MyHelper::post('promo-campaign/report', $input);

        if ($getPromoCampaignReport['status'] == 'success') {
            $return['recordsTotal'] = $getPromoCampaignReport['total'];
            $return['recordsFiltered'] = $getPromoCampaignReport['count'];
            $return['data'] = array_map(function($x){
                $trxUrl=url('transaction/detail/'.$x['id_transaction'].'/'.strtolower($x['transaction']['trasaction_type']));
                return [
                    $x['promo_campaign_promo_code']['promo_code'],
                    $x['user_name'].' ('.$x['user_phone'].')',
                    $x['created_at'],
                    "<a href='$trxUrl' target='_blank'>{$x['transaction']['transaction_receipt_number']}</a>",
                    $x['outlet']['outlet_name'],
                    $x['device_type']
                ];
            },$getPromoCampaignReport['result']);
            return $return;
        } else {
            $return['recordsTotal'] = 0;
            $return['recordsFiltered'] = 0;
            $return['data'] = [];
            return $return;
        }
    }

    public function ajaxCoupon($input){
        $return = $input;
        $return['draw']=(int)$input['draw'];

        $getPromoCampaignCoupon = MyHelper::post('promo-campaign/coupon', $input);

        if (($getPromoCampaignCoupon['status']??false) == 'success') {
            $return['recordsTotal'] = $getPromoCampaignCoupon['total'];
            $return['recordsFiltered'] = $getPromoCampaignCoupon['count'];
            $return['data'] = array_map(function($x){
                $status = $x['usage'] == 0 ? 'Not used' : ($x['usage'] == $x['limitation_usage'] ? 'Used' : 'Available');
                $used = $x['usage'] != 0 ? $x['usage'] : '';
                $available = $x['limitation_usage'] != 0 ? $x['limitation_usage'] - $x['usage'] : 'Unlimited';
                $max_usage = $x['limitation_usage'] != 0 ? $x['limitation_usage'] : 'Unlimited';
                return [
                    $x['promo_code'],
                    $status,
                    $used,
                    $available,
                    $max_usage
                ];
            },$getPromoCampaignCoupon['result']);
            return $return;
        } else {
            $return['recordsTotal'] = 0;
            $return['recordsFiltered'] = 0;
            $return['data'] = [];
            return $return;
        }
    }

    public function step1(Request $request, $slug=null)
    {
        // if($slug){
        //     $exploded = MyHelper::explodeSlug($slug);
            // $id_promo_campaign = $exploded[0];
            $id_promo_campaign = $slug;
        //     $created_at = $exploded[1];
        // }else{
        //     $id_promo_campaign = null;
        //     $created_at = null;
        // }
        $post = $request->except('_token');

        if (empty($post)) 
        {
            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Step 1',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-create'
            ];

            if (isset($id_promo_campaign)) 
            {
                $get_data = MyHelper::post('promo-campaign/show-step1', ['id_promo_campaign' => $id_promo_campaign]);

				if ( ($get_data['status']??false) == 'success') {
	                $data['result'] = $get_data['result']??'';
	                $data['result']['id_promo_campaign'] = $slug;

            		return view('promocampaign::create-promo-campaign-step-1', $data);
				}else{
					return redirect('promo-campaign')->withErrors(['Promo campaign not found']);
				}
            }
        }
        else
        {
            if(isset($post['id_promo_campaign'])){
                // $post['id_promo_campaign'] = MyHelper::explodeSlug($post['id_promo_campaign'])[0];
            }
            $action = MyHelper::post('promo-campaign/step1', $post);
            
            if (isset($action['status']) && $action['status'] == 'success') 
            {
                return redirect('promo-campaign/step2/' . ($slug??''));
                // return redirect('promo-campaign/step2/' . ($slug?:MyHelper::createSlug($action['promo-campaign']['id_promo_campaign'],'')));
            } 
            else 
            {
                return back()->withErrors($action['messages'])->withInput();
            }
        }
    }

    public function step2(Request $request, $slug)
    {
        // $exploded = MyHelper::explodeSlug($slug);
        // $id_promo_campaign = $exploded[0];
        // $created_at = $exploded[1];
        $post = $request->except('_token');
        $id_promo_campaign = $slug;

        if (empty($post)) {

            $get_data = MyHelper::post('promo-campaign/show-step2', ['id_promo_campaign' => $id_promo_campaign]);

            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Step 2',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-create'
            ];

            if (isset($get_data['status']) && $get_data['status'] == 'success') {

                $data['result'] = $get_data['result'];
                $data['result']['id_promo_campaign'] = $slug;

            } else {

                return redirect('promo-campaign')->withErrors($get_data['messages']);
            }

            return view('promocampaign::promo-campaign-step-2', $data);

        }else{

            $post['id_promo_campaign'] = $id_promo_campaign;
            if(isset($post['promo_warning_image'])){
	            $post['promo_warning_image'] = MyHelper::encodeImage($post['promo_warning_image']);
	        }

            $action = MyHelper::post('promo-campaign/step2', $post);

            if (isset($action['status']) && $action['status'] == 'success') {

                return redirect('promo-campaign/detail/' . $slug);
            } 
            elseif($action['messages']??false) {
                return back()->withErrors($action['messages'])->withInput();
            }
            else{
                return back()->withErrors(['Something went wrong'])->withInput();
            }
        }
    }

    public function getTag()
    {
        $action = MyHelper::post('promo-campaign/getTag', ['get' => 'Tag']);

        if (empty($action)) {
            $action = [];
        }
        return $action;
    }

    public function checkCode()
    {
        $action = MyHelper::post('promo-campaign/check', $_GET);

        return $action;
    }

    public function getData()
    {
        $action = MyHelper::post('promo-campaign/getData', ['get' => $_GET['get'], 'type' => $_GET['type']??'']);

        return $action;
    }

    public function delete(Request $request)
    {
        $post = $request->except('_token');
        if(isset($post['id_promo_campaign'])){
            // $post['id_promo_campaign'] = MyHelper::explodeSlug($post['id_promo_campaign'])[0];
        }

        $delete = MyHelper::post('promo-campaign/delete', $post);

        if ( ($delete['status']??'')=='success' ) 
        {
            return redirect()->back()->withSuccess([$delete['status']]);
        } 
        elseif ( ($delete['status']??'')=='fail' ) 
        {
            return redirect()->back()->withErrors([$delete['messages']??$delete['status']]);
        } 
        else 
        {
            return redirect()->back()->withErrors(['Something went wrong']);
        }
    }

}
