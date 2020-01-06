<?php

namespace Modules\SpinTheWheel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class SpinTheWheelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function list()
    {
        $data = [
            'title'          => 'Spin The Wheel',
            'sub_title'      => 'Item List',
            'menu_active'    => 'spinthewheel',
            'submenu_active' => 'spinthewheel-list'
        ];
        
        $post['deals_type'] = 'Spin';
        $spin_item = MyHelper::post('deals/be/list', $post);
        if (isset($spin_item['status']) && $spin_item['status'] == "success") {
            $data['items'] = $spin_item['result'];
        }
        else {
            $data['items'] = [];
        }

        return view('spinthewheel::list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');
        
        $data = [
            'title'          => 'Spin The Wheel',
            'sub_title'      => 'New Item',
            'menu_active'    => 'spinthewheel',
            'submenu_active' => 'spinthewheel-new'
        ];
    
        if (!empty($post)) {
            $post['deals_type'] = "Spin";
            $post['deals_promo_id_type'] = "promoid";
            $post['deals_voucher_type'] = "Unlimited";
            if ($post['deals_voucher_expired']!=null) {
                $date = $post['deals_voucher_expired'];
                $post['deals_voucher_expired'] = date('Y-m-d', strtotime($date));
            }
            // dd($post);

            $save = MyHelper::post('deals/create', $post);

            if (!isset($save['status']) || $save['status'] != "success") {
                return redirect()->back()->withInput()->withErrors(['Something went wrong. Please try again.']);
            }

            return redirect('/spinthewheel/create')->withSuccess(['Spin the wheel item has been created.']);
        }

        return view('spinthewheel::create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id_deals)
    {
        $data = [
            'title'          => 'Spin The Wheel',
            'sub_title'      => 'Edit Item',
            'menu_active'    => 'spinthewheel',
            'submenu_active' => 'spinthewheel-list'
        ];
        
        $post['id_deals'] = $id_deals;
        $post['deals_type'] = "Spin";
        $spin_item = MyHelper::post('deals/be/list', $post);

        if (isset($spin_item['status']) && $spin_item['status'] == "success") {
            $data['item'] = $spin_item['result'][0];
            $data['item']['duration'] = "duration";
            if ($data['item']['deals_voucher_expired']!=null) {
                $data['item']['duration'] = "dates";
            }
        }
        else {
            return redirect('/spinthewheel/list')->withErrors(['Item not found.']);
        }

        return view('spinthewheel::update', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');
        
        $data = [
            'title'          => 'Spin The Wheel',
            'sub_title'      => 'Edit Item',
            'menu_active'    => 'spinthewheel',
            'submenu_active' => 'spinthewheel-list'
        ];
    
        $post['deals_type'] = "Spin";
        $post['deals_promo_id_type'] = "promoid";
        $post['deals_voucher_type'] = "Unlimited";
        if ($post['deals_voucher_expired']!=null) {
            $date = $post['deals_voucher_expired'];
            $post['deals_voucher_expired'] = date('Y-m-d', strtotime($date));
        }

        $update = MyHelper::post('deals/update', $post);

        if (!isset($update['status']) || $update['status'] != "success") {
            return redirect()->back()->withInput()->withErrors(['Something went wrong. Please try again.']);
        }

        return redirect('/spinthewheel/edit/'.$post['id_deals'])->withSuccess(['Spin the wheel item has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $post['deals_type'] = 'Spin';

        $item = MyHelper::post('deals/delete', $post);
        // dd($item);
        return $item;
    }

    public function setting(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Spin The Wheel',
            'sub_title'      => 'Setting',
            'menu_active'    => 'spinthewheel',
            'submenu_active' => 'spinthewheel-setting'
        ];

        $post_list['deals_type'] = 'Spin';
        $spin_item = MyHelper::post('deals/be/list', $post_list);
        if (isset($spin_item['status']) && $spin_item['status'] == "success") {
            $data['items'] = $spin_item['result'];
        }
        else {
            return redirect('/spinthewheel/create')->withErrors(['Spin the wheel item is empty.', 'Please add first.']);
        }

        if (empty($post)) {
            // get data
            $spinthewheel = MyHelper::get('spinthewheel/setting');

            if (isset($spinthewheel['status']) && $spinthewheel['status'] == "success") {
                $result = $spinthewheel['result'];
                $data['spin_the_wheel_point'] = $result['spin_the_wheel_point'];
                $data['spin_weighted_items']  = $result['spin_weighted_items'];
            }
            else {
                return redirect()->back()->withErrors(['Failed to get data.']);
            }
        }
        else {
            // submit data
            if ( !isset($post['spin_weighted_items']) ) {
                return redirect()->back()->withErrors(['Failed to save data.', 'Item should not be empty.']);
            }

            $save = MyHelper::post('spinthewheel/setting', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('/spinthewheel/setting')->withSuccess(['Spin the wheel setting has been updated.']);
            }
            else {
                return redirect()->back()->withErrors($save['messages']);
            }
        }

        return view('spinthewheel::setting', $data);
    }
}
