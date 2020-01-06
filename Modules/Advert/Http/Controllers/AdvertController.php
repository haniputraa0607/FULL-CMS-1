<?php

namespace Modules\Advert\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;
use Session;
use Modules\Advert\Http\Requests\Create;

class AdvertController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    function index(Create $request, $key) {

        if (in_array($key, Session::get('advert'))) {
            $post = $request->except('_token');
            $type = $this->type();

            if (empty($post)) {
                $data = [
                    'title'          => ucwords($type),
                    'sub_title'      => 'Advertise',
                    'menu_active'    => 'advert',
                    'submenu_active' => $type,
                ];

                $data['page']   = $type;
                $data['advert'] = parent::getData(MyHelper::post('advert', ['page' => $type]));
                $data['news'] = parent::getData(MyHelper::post('news/be/list', ['admin' => 1]));
                return view('advert::index', $data);
            }
            else {
                if (isset($post['rearange'])) {
                    return $this->rearange($post);
                }

                if (isset($post['img_top'])) {
                    $post['img_top'] = MyHelper::encodeImage($post['img_top']);
                }

                if (isset($post['img_bottom'])) {
                    $post['img_bottom'] = MyHelper::encodeImage($post['img_bottom']);
                }
                
                if ($post['type'] == "text_top" || $post['type'] == "text_bottom") {
                    if (stristr($post['value'], "<p><br></p>") || empty($post['value'])) {
                        return parent::redirect(MyHelper::post('advert/delete', $post), 'Data advert has been updated', url()->current().'#'.$post['current']);
                    }
                }
                
                return parent::redirect(MyHelper::post('advert/create', $post), 'Data advert has been updated.', url()->current().'#'.$post['current']);
            }
        }

        return redirect('home')->withErrors(['Advert is not available']);
        
    }

    /* REARANGE PICTURE */
    function rearange($post) {
        for ($i=0; $i < count($post['id_advert']); $i++) { 
            $data = [
                'id_advert' => $post['id_advert'][$i],
                'order'     => $i + 1
            ];

            $update = MyHelper::post('advert/create', $data);

            if (isset($update['status']) && $update['status'] != "success") {
                return back()->withErrors(['Failed update data advert.']);
            }
        }

        return parent::redirect($update, 'Data advert has been updated.', url()->current().'#'.$post['current']);
    }

    /* DEFINE TYPE */
    function type() {
        $currentUrl = url()->current();
        $arrUrl     = explode('/', $currentUrl);
        $url        = end($arrUrl);
        // $url        = prev($arrUrl);

        return $url;
    }

    /* DELETE ADVERT */
    function delete(Request $request) {
        $post    = $request->except('_token');

        $advert = MyHelper::post('advert/delete', ['id_advert' => $post['id_advert']]);

        if (isset($advert['status']) && $advert['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

}
