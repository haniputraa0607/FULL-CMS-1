<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class CategoryController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * create category
     */
    function create(Request $request) {
        
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'New Category',
                'menu_active'    => 'product',
                'submenu_active' => 'product-category-new',
            ];

            /**
             * category parent
             */
            $catParent = MyHelper::post('product/category/be/list', ['id_parent_category' => 0]);

            if (isset($catParent['status']) && $catParent['status'] == "success") {
                $data['parent'] = $catParent['result'];
            }
            else {
                $data['parent'] = [];
            }

            return view('product::category.create',$data);
        }
        else {

            if (isset($post['id_parent_category']) && $post['id_parent_category'] == 0) {
                unset($post['id_parent_category']);
            }

            if (isset($post['product_category_photo']) && !empty($post['product_category_photo'])) {
                $post['product_category_photo'] = MyHelper::encodeImage($post['product_category_photo']);
            }

            $save = MyHelper::post('product/category/create', $post);

            return parent::redirect($save, 'Category has been created.', 'product/category');
        }
    }

    /**
     * list category
     */
    function categoryList(Request $request) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Category',
            'menu_active'    => 'product',
            'submenu_active' => 'product-category-list',
        ];

        /**
         * category product list
         */
        $category = MyHelper::get('product/category/be/list');
        // print_r($category); exit();

        if (isset($category['status']) && $category['status'] == "success") {
            $data['category'] = $category['result'];
        }
        else {
            $data['category'] = [];
        }

        return view('product::category.list', $data);
    }

    /**
     * category update
     */
    function update(Request $request, $id) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Update Category',
            'menu_active'    => 'product',
            'submenu_active' => 'product-category-list',
        ];

        /**
         * category product
         */
        $category = MyHelper::post('product/category/be/list', ['id_product_category' => $id]);

        if (isset($category['status']) && $category['status'] == "success") {
            $data['category'] = $category['result'];
        }
        else {
            $e = ['e' => 'Data category not found.'];
            return back()->witherrors($e);
        }

        /**
         * cek pos
         */
        $post = $request->except('_token');

        if (empty($post)) {
            /**
             * category product list
             */
            $category = MyHelper::post('product/category/be/list', ['id_parent_category' => 0]);

            if (isset($category['status']) && $category['status'] == "success") {
                $data['parent'] = $category['result'];
            }
            else {
                $data['parent'] = [];
            }

            // print_r($data); exit();
            return view('product::category.update', $data);
        }
        else {
            if (isset($post['id_parent_category']) && $post['id_parent_category'] == 0) {
                $post['id_parent_category'] = null;
                // unset($post['id_parent_category']);
            }

            if (isset($post['product_category_photo']) && !empty($post['product_category_photo'])) {
                $post['product_category_photo'] = MyHelper::encodeImage($post['product_category_photo']);
            }

            

            $save = MyHelper::post('product/category/update', $post);
// print_r($save); exit();
            return parent::redirect($save, 'Category has been updated.', 'product/category');
        }

    }

    /**
     * category delete
     */
    function delete(Request $request) {
        $post = $request->except('_token');

        $delete = MyHelper::post('product/category/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    // ajax sort category
    public function positionCategoryAssign(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['category_ids'])) {
            return [
                'status' => 'fail',
                'messages' => ['Category id is required']
            ];
        }

        $result = MyHelper::post('product/category/position/assign', $post);

        return $result;
    }
}
