<?php

namespace Modules\CustomPage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class CustomPageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'             => 'Settings',
            'sub_title'         => 'Custom Page',
            'menu_active'       => 'custom-page',
            'submenu_active'    => 'custom-page-list'
        ];

        $action = MyHelper::get('custom-page/list');

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
        } else {
            $data['result'] = [];
        }

        return view('custompage::index', $data);
    }

    /**
     * Show the form for creating a create resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'             => 'Settings',
            'sub_title'         => 'Custom Page',
            'menu_active'       => 'custom-page',
            'submenu_active'    => 'custom-page-create'
        ];

        // get outlet
        $data['outlet']    = $this->getData(MyHelper::get('outlet/list'));

        // get product
        $data['product']   = $this->getData(MyHelper::get('product/list'));

        return view('custompage::form', $data);
    }

    /**
     * Store a creately created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        
        $post['custom_page_description'] = preg_replace('/(img style="width: )([0-9]+)(px)/', 'img style="width: 100%', $post['custom_page_description']);

        if (isset($post['custom_page_description'])) {
            // remove tag <font>
            $post['custom_page_description'] = preg_replace("/<\\/?font(.|\\s)*?>/", '', $post['custom_page_description']);
        }

        $post = array_filter($post);

        if (!isset($post['custom_page_event_location_name'])) {
            unset($post['custom_page_event_latitude']);
            unset($post['custom_page_event_longitude']);
        }

        // set tanggal 
        if (isset($post['custom_page_post_date'])) {
            $post['custom_page_post_date'] = date('Y-m-d', strtotime($post['custom_page_post_date'])) . " " . date('H:i:s', strtotime($post['custom_page_post_time']));
        }

        if (isset($post['custom_page_event_date_start'])) {
            $post['custom_page_event_date_start'] = date('Y-m-d', strtotime($post['custom_page_event_date_start']));
        }

        if (isset($post['custom_page_event_date_end'])) {
            $post['custom_page_event_date_end'] = date('Y-m-d', strtotime($post['custom_page_event_date_end']));
        }

        if (isset($post['custom_page_button_form'])) {
            if (isset($post['custom_page_button_form_text_button'])) {
                $post['custom_page_button_form_text'] = json_encode(['value' => $post['custom_page_button_form_text_value'], 'button' => $post['custom_page_button_form_text_button']]);
            } else {
                $post['custom_page_button_form_text'] = json_encode(['value' => $post['custom_page_button_form_text_value']]);
            }
        }
        // set waktu
        if (isset($post['custom_page_event_time_start'])) {
            $post['custom_page_event_time_start'] = date('H:i:s', strtotime($post['custom_page_event_time_start']));
        }

        if (isset($post['custom_page_event_time_end'])) {
            $post['custom_page_event_time_end'] = date('H:i:s', strtotime($post['custom_page_event_time_end']));
        }

        // remove custom form index if the checkbox is not checked
        if (!isset($post['custom_form_checkbox'])) {
            unset($post['customform']);
        } else {
            // set to null if form type didn't match
            foreach ($post['customform'] as $key => $form) {
                $post['customform'][$key]['custom_page_image_header']  = MyHelper::encodeImage($form['custom_page_image_header']);
            }
        }

        if (isset($post['custom_page_icon_image']) && $post['custom_page_icon_image'] != null) {
            $post['custom_page_icon_image'] = MyHelper::encodeImage($post['custom_page_icon_image']);
        }
        
        $action = MyHelper::post('custom-page/create', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('custom-page/detail/' . $action['result']['id_custom_page']);
        } else {
            return back()->withInput()->withErrors($action['messages']);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id_custom_page)
    {
        $data = [
            'title'             => 'Settings',
            'sub_title'         => 'Custom Page',
            'menu_active'       => 'custom-page',
            'submenu_active'    => 'custom-page-create'
        ];

        $action = MyHelper::post('custom-page/detail', ['id_custom_page' => $id_custom_page]);
        
        $action['result']['custom_page_button_form_text_button'] = json_decode($action['result']['custom_page_button_form_text'], true)['button'];
        $action['result']['custom_page_button_form_text_value'] = json_decode($action['result']['custom_page_button_form_text'], true)['value'];
        
        $data['detail'] = $action['result'];

        // get outlet
        $data['outlet']    = $this->getData(MyHelper::get('outlet/list'));

        // get product
        $data['product']   = $this->getData(MyHelper::get('product/list'));

        return view('custompage::form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id_custom_page)
    {
        $data = [
            'title'             => 'Settings',
            'sub_title'         => 'Custom Page',
            'menu_active'       => 'custom-page',
            'submenu_active'    => 'custom-page-create'
        ];

        $action = MyHelper::post('custom-page/detail', ['id_custom_page' => $id_custom_page]);

        $data['result'] = $action['result'];

        // get outlet
        $data['outlet']    = $this->getData(MyHelper::get('outlet/list'));

        // get product
        $data['product']   = $this->getData(MyHelper::get('product/list'));

        return view('custompage::form', $data);
    }

    function getData($access)
    {
        if (isset($access['status']) && $access['status'] == "success") {
            return $access['result'];
        } else {
            return [];
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id_custom_page)
    {
        $post = $request->except('_token');

        if (isset($post['custom_page_icon_image']) && $post['custom_page_icon_image'] != null) {
            $post['custom_page_icon_image'] = MyHelper::encodeImage($post['custom_page_icon_image']);
        }

        // remove custom form index if the checkbox is not checked
        if (!isset($post['custom_form_checkbox'])) {
            unset($post['customform']);
        } else {
            // set to null if form type didn't match
            foreach ($post['customform'] as $key => $form) {
                if (is_string($form['custom_page_image_header'])) {
                    $post['customform'][$key]['custom_page_image_header'] = $form['custom_page_image_header'];
                } else {
                    $post['customform'][$key]['custom_page_image_header'] = MyHelper::encodeImage($form['custom_page_image_header']);
                }
            }
        }

        $post['custom_page_description'] = preg_replace('/(img style="width: )([0-9]+)(px)/', 'img style="width: 100%', $post['custom_page_description']);

        if (isset($post['custom_page_description'])) {
            // remove tag <font>
            $post['custom_page_description'] = preg_replace("/<\\/?font(.|\\s)*?>/", '', $post['custom_page_description']);
        }

        $post['id_custom_page'] = $id_custom_page;

        $action = MyHelper::post('custom-page/update', $post);

        if ($action['status'] == 'success') {
            return redirect('custom-page/detail/' . $action['result']['id_custom_page']);
        } else {
            return back()->withErrors($action['messages']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id_custom_page)
    {
        $action = MyHelper::post('custom-page/delete', ['id_custom_page' => $id_custom_page]);

        return redirect('custom-page');
    }

    public function webviewCustomPage(Request $request, $id_custom_page)
    {
        $bearer = $request->header('Authorization');

        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $action = MyHelper::getWithBearer('custom-page/webview/' . $id_custom_page . '?log_save=0', $bearer);

        if (isset($action['result'])) {
            $data['result'] = $action['result'];
            return view('custompage::webview.information', $data);
        } else {
            return view('custompage::webview.information', ['result' => null]);
        }
    }
}
