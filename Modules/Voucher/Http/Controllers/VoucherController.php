<?php

namespace Modules\Voucher\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class VoucherController extends Controller
{
    public function voucherList() {
        $data = [
            'title'          => 'Voucher',
            'menu_active'    => 'voucher',
            'sub_title'      => 'Voucher List',
            'submenu_active' => 'voucher-list'
        ];

        $data['list']    = parent::getData(MyHelper::get('voucher/list'));    

        return view('voucher::index', $data);
    }

    /* DETAIL DAN UPDATE JADI SATU*/
    public function update(Request $request, $id) {
        
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Voucher',
                'menu_active'    => 'voucher',
                'sub_title'      => 'Voucher List',
                'submenu_active' => 'voucher-list'
            ];

            $voucher = parent::getData(MyHelper::post('voucher/list', ['id_voucher' => $id, 'admin' => 1]));
            // print_r($voucher); exit();

            if (!empty($voucher)) {
                $data['voucher'] = $voucher;

                $data['product']   = parent::getData(MyHelper::get('product/be/list'));
                $data['treatment'] = parent::getData(MyHelper::get('treatment/list'));
                $data['outlet']    = parent::getData(MyHelper::get('outlet/be/list'));

                // print_r($data); exit();
                $jumlah             = count($data['outlet']);
                $jumlahVocherOutlet = count($data['voucher'][0]['outlets']);

                if ($jumlah == $jumlahVocherOutlet) {
                    $data['all'] = 1;
                }
                else {
                    $data['all'] = 0;
                }

                return view('voucher::detail', $data);
            }
            else {
                return back()->withErrors(['Data not found']);
            }
        }
        else {
            // kecuali id outlet
            $outlet = $post['id_outlet']; print_r($outlet);
            
            $post = $request->except('_token', 'id_outlet', 'outlet');
            // filter
            $post = array_filter($post);
            
            /* cek relasi */
            if ($post['related'] == "product") {
                $post['id_treatment'] = null;
            }

            if ($post['related'] == "treatment") {
                $post['id_product'] = null;
            }

            unset($post['related']);
            
            // kalo pilih all
            $all = array_search("all", $outlet); 
            

            // pengecekan yang sangat efak
            if (is_integer($all)) {

                // panggil api, semua outlet
                $outlet = array_filter(explode("|", $request->input('outlet')));
            }

            /* save voucher duluk */
            $save = MyHelper::post('voucher/update', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                // delete relation
                $deleteRelation = MyHelper::post('voucher/relation/delete', ['id_voucher' => $post['id_voucher']]);

                /* save outletnya */
                foreach ($outlet as $key => $value) {
                    $data = [
                        'id_voucher' => $post['id_voucher'],
                        'id_outlet'  => $value
                    ];

                    // save
                    $saveRelation = MyHelper::post('voucher/relation/create', $data);

                    if (isset($saveRelation['status']) && $saveRelation['status'] == "success") {
                        continue;
                    }
                    else {
                        return redirect('voucher')->withErrors(['Voucher has been updated.', 'Outlet not saved.']);
                    }

                }

                return redirect('voucher')->withSuccess(['Voucher has been updated.']);
            }
            else {
                return parent::redirect($save, 'Voucher has been updated', 'voucher');                
            }
        }
    }

    /* CREATE */
    public function create(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Voucher',
                'menu_active'    => 'voucher',
                'sub_title'      => 'New Voucher',
                'submenu_active' => 'voucher-new'
            ];

            $data['product']   = parent::getData(MyHelper::get('product/be/list'));
            $data['treatment'] = parent::getData(MyHelper::get('treatment/list'));
            $data['outlet']    = parent::getData(MyHelper::get('outlet/be/list'));

            return view('voucher::create', $data);
        }
        else {
            // kecuali id outlet
            $outlet = $post['id_outlet'];
            
            $post = $request->except('_token', 'id_outlet', 'outlet');
            // filter
            $post = array_filter($post);

            /* cek relasi */
            if ($post['related'] == "product") {
                $post['id_treatment'] = null;
            }

            if ($post['related'] == "treatment") {
                $post['id_product'] = null;
            }

            unset($post['related']);
            
            // kalo pilih all
            $all = array_search("all", $outlet); 

            // pengecekan yang sangat efak
            if (is_integer($all)) {
                // panggil api, semua outlet
                $outlet = array_filter(explode("|", $request->input('outlet')));         
            }

            /* save voucher duluk */
            $save = MyHelper::post('voucher/create', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                /* save outletnya */
                foreach ($outlet as $key => $value) {
                    $data = [
                        'id_voucher' => $save['result']['id_voucher'],
                        'id_outlet'  => $value
                    ];

                    // save
                    $saveRelation = MyHelper::post('voucher/relation/create', $data);

                    if (isset($saveRelation['status']) && $saveRelation['status'] == "success") {
                        continue;
                    }
                    else {
                        return redirect('voucher')->withErrors(['Voucher has been created.', 'Outlet not saved.']);
                    }

                }

                return redirect('voucher')->withSuccess(['Voucher has been created.']);
            }
            else {
                return parent::redirect($save, 'Voucher has been created', 'voucher');                
            }
        }   
    }

    /* DELETE */
    public function delete(Request $request) {
        $post = $request->except('_token');
        $delete = MyHelper::post('voucher/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }   
    }

}
