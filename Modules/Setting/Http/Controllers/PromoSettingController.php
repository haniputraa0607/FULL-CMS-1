<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;

use Illuminate\Pagination\LengthAwarePaginator;

class PromoSettingController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function warningImage(Request $request)
    {
    	$post = $request->except('_token');
    	$data = [
            'title'          => 'Warning Image',
            'sub_title'      => 'Warning Image',
            'menu_active'    => 'warning-image',
            'submenu_active' => ''
        ];
        $data['warning_image'] = MyHelper::post('setting', ['key' => 'promo_warning_image'])['result']['value'];

        if (empty($post)) {

        	return view('setting::promo-setting.promo_setting', $data);
        }else{
        	if(isset($post['promo_warning_image'])){
	            $post['promo_warning_image'] = MyHelper::encodeImage($post['promo_warning_image']);
	        }

	        $result = MyHelper::post('setting/promo-warning-image', $post);

	        if ($result['status']??false) {
	        	if ($result['status'] == 'success') {
        			return redirect('promo-setting/warning-image')->withSuccess(['Promo warning image has been updated']);
	        	}else{
        			return redirect('promo-setting/warning-image')->withErrors(['Promo warning image update failed']);
	        	}

	        }else{
        		return redirect('promo-setting/warning-image')->withErrors(['Something went wrong']);
	        }
	    }
    }

    public function promoCashback(Request $request)
    {
    	$post = $request->except('_token');
    	$data = [
            'title'          => 'Promo Setting',
            'sub_title'      => 'Cashback',
            'menu_active'    => 'promo-cashback-setting',
            'submenu_active' => ''
        ];

        $data['cashback'] = MyHelper::get('promo-setting/cashback')['result']??'';

        if (empty($post)) 
        {
        	return view('setting::promo-setting.promo_cashback_setting', $data);
        }
        else
        {
	        $result = MyHelper::post('promo-setting/cashback', $post);

	        if ($result['status']??false) {
	        	if ($result['status'] == 'success') {
        			return redirect('promo-setting/cashback')->withSuccess(['Promo Cashback Setting has been updated']);
	        	}else{
        			return redirect('promo-setting/cashback')->withErrors(['Promo Cashback Setting update failed']);
	        	}

	        }else{
        		return redirect('promo-setting/cashback')->withErrors(['Something went wrong']);
	        }
	    }	
    }
}