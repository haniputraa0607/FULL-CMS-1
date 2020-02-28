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
            'title'          => 'Promo Setting',
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
        			return view('setting::promo-setting.promo_setting', $data)->withSuccess(['Promo warning image has been updated']);
	        	}else{
        			return view('setting::promo-setting.promo_setting', $data)->withErrors(['Promo warning image update failed']);
	        	}

	        }else{
        		return view('setting::promo-setting.promo_setting', $data)->withErrors(['Something went wrong']);
	        }
	    }
    }
}