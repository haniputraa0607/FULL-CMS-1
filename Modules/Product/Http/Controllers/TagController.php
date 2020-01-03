<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class TagController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * create tag
     */
    function create(Request $request) {
        $post = $request->except('_token');
        $save = MyHelper::post('product/tag/create', $post);
        if(isset($post['ajax'])){
            return $save;
        } 
        return parent::redirect($save, 'Tag has been created.', 'product/tag');
    }

    /**
     * list tag
     */
    function list(Request $request) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Tag List',
            'menu_active'    => 'product',
            'submenu_active' => 'product-tag-list',
        ];

        $tags = MyHelper::get('product/tag/list');
        if (isset($tags['status']) && $tags['status'] == "success") {
            $data['tag'] = $tags['result'];
        }
        else {
            $data['tag'] = [];
        }
        
        return view('product::tag.list', $data);
    }

    /**
     * tag update
     */
    function update(Request $request) {
        $post = $request->except('_token');
        $save = MyHelper::post('product/tag/update', $post);
        return parent::redirect($save, 'Tag has been updated.', 'product/tag');

    }

    /**
     * tag delete
     */
    function delete(Request $request) {
        $post = $request->except('_token');

        $delete = MyHelper::post('product/tag/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

     /* CREATE PRODUCT TAG FROM PRODUCT */
     function createProductTag($id_product, $post=[]) {     
        if (!empty($post)) {
            foreach ($post as $value) {
                $data = [
                    'id_product'   => $id_product,
                    'id_tag' => $value
                ];
                $save = MyHelper::post('product/product-tag/create', $data);
            }
        }

        return true;
    }

     /* CREATE PRODUCT TAG FROM TAG */
     function createTagProduct(Request $request) {     
        $post = $request->except('_token');
        if (!empty($post)) {
            foreach ($post['id_product'] as $value) {
                $data = [
                    'id_product'   => $value,
                    'id_tag' => $post['id_tag']
                ];
                $save = MyHelper::post('product/product-tag/create', $data);

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                if (!isset($save['status'])) {
                    return back()->withErrors($save['message'])->withInput();
                }
                
            }
        }

        return parent::redirect($save, 'Product tag has been added.');
    }

    /* DELETE PRODUCT TAG */
    function deleteAllProductTag($id_product) {
        $data = [
            'id_product' => $id_product
        ];

        $save = MyHelper::post('product/product-tag/delete', $data);

        return $save;
    }

    function listProductTag(Request $request, $id) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Tag List',
            'menu_active'    => 'product',
            'submenu_active' => 'product-tag-list',
        ];

        $tag = MyHelper::post('product/tag/list', ['id_tag' => $id]);
        // dd($tag);
        if (isset($tag['status']) && $tag['status'] == "success") {
            $data['tag'] = $tag['result'];

            $product = MyHelper::post('product/be/list', $data);
            if (isset($product['status']) && $product['status'] == "success") {
                $data['products'] = $product['result'];
            }
            else {
                $data['products'] = [];
            }
        }
        else {
            $e = ['e' => 'Data Tag not found.'];
            return back()->witherrors($e);
        }
        
        return view('product::tag.list_product', $data);
    }

    function deleteProductTag(Request $request) {
        $post = $request->except('_token');

        $delete = MyHelper::post('product/product-tag/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }
}
