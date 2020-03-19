<?php

namespace Modules\ProductVariant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Excel;
use App\Exports\ProductExport;
use App\Imports\ProductImport;


use App\Lib\MyHelper;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'List Product Group',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-group-list',
        ];
        $page = $request->page?:1;
        $data['product_groups'] = [];
        return view('productvariant::groups.list',$data);
    }

    public function indexImage(Request $request) {
        
        $data = [
            'title'             => 'Complex Menu',
            'sub_title'         => 'List Product Group Image',
            'menu_active'       => 'product-variant',
            'submenu_active'    => 'image-product-group',
            'child_active'      => 'image-product-group-list',
        ];
        $page = $request->page?:1;
        if ($request->page) {
            $page = $request->page?:1;
            $raw_data = MyHelper::get('product-variant/group?page='.$page)['result']??[];
            $data['data'] = $raw_data['data'];
            $data['total'] = $raw_data['total']??0;
            $data['from'] = $raw_data['from']??0;
            $data['order_by'] = $raw_data['order_by']??0;
            $data['order_sorting'] = $raw_data['order_sorting']??0;
            $data['last_page'] = !($raw_data['next_page_url']??false);
            return $data;
        } elseif ($request->file('file')) {
            $name = explode('.',$request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product-variant/group/photoAjax', ['name' => $name, 'photo' => $post, 'detail' => 0]);
            return $save;
        }
        $data['product_groups'] = [];
        return view('productvariant::groups.list_image',$data);
    }
    
    public function indexImageDetail(Request $request) {
        
        $data = [
            'title'             => 'Complex Menu',
            'sub_title'         => 'List Product Group Image',
            'menu_active'       => 'product-variant',
            'submenu_active'    => 'image-product-group',
            'child_active'      => 'image-detail-product-group-list',
        ];
        $page = $request->page?:1;
        if ($request->page) {
            $page = $request->page?:1;
            $raw_data = MyHelper::get('product-variant/group?page='.$page)['result']??[];
            $data['data'] = $raw_data['data'];
            $data['total'] = $raw_data['total']??0;
            $data['from'] = $raw_data['from']??0;
            $data['order_by'] = $raw_data['order_by']??0;
            $data['order_sorting'] = $raw_data['order_sorting']??0;
            $data['last_page'] = !($raw_data['next_page_url']??false);
            return $data;
        } elseif ($request->file('file')) {
            $name = explode('.',$request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product-variant/group/photoAjax', ['name' => $name, 'photo' => $post, 'detail' => 1]);
            return $save;
        }
        $data['product_groups'] = [];
        return view('productvariant::groups.list_image_detail',$data);
    }

    public function indexAjax(Request $request) {
        $page = $request->page?:1;
        $raw_data = MyHelper::post('product-variant/group',['page'=>$page,'keyword'=>$request->keyword])['result']??[];
        $data['data'] = $raw_data['data'];
        $data['total'] = $raw_data['total']??0;
        $data['from'] = $raw_data['from']??0;
        $data['order_by'] = $raw_data['order_by']??0;
        $data['order_sorting'] = $raw_data['order_sorting']??0;
        $data['last_page'] = !($raw_data['next_page_url']??false);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'New Product Group',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-group-new',
        ];
        $data['products'] = MyHelper::post('product-variant/available-product',[])['result']??[];
        $data['categories'] = MyHelper::get('product/category/be/list')['result']??[];
        return view('productvariant::groups.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        if($post['product_group_photo']??false){
            $post['product_group_photo'] = MyHelper::encodeImage($post['product_group_photo']);
        }
        if($post['product_group_image_detail']??false){
            $post['product_group_image_detail'] = MyHelper::encodeImage($post['product_group_image_detail']);
        }
        $create = MyHelper::post('product-variant/group/create',$post);
        if(($create['status']??false) == 'success'){
            if($post['variant_type'] == 'single'){
                $result = redirect('product-variant/group/'.$create['result']['id_product_group'])->with('success',['Success create new product group']);
            }else{
                $result = redirect('product-variant/group/'.$create['result']['id_product_group'].'#variants')->with('success',['Success create new product group']);
            }
            return $result;
        }else{
            return back()->withErrors($create['messages']??['Failed create product group'])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'Detail Product Group',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-group-list',
        ];
        $data['categories'] = MyHelper::get('product/category/be/list')['result']??[];
        $data['promo_categories'] = MyHelper::get('product/promo-category')['result']??[];
        $product_group = MyHelper::post('product-variant/group/detail',['id_product_group'=>$id])['result']??[];
        $variants = array_map(function($var){
            $var['variants'] = explode(',', $var['variants']);
            return $var;
        }, $product_group['variants']);
        $product_group['variants'] = $variants;
        $product_group['promo_category'] = array_column($product_group['promo_category'], 'id_product_promo_category');
        $data['product_group'] = $product_group;
        $data['variants_tree'] = MyHelper::get('product-variant/tree')['result']??[];
        $data['products'] = MyHelper::post('product-variant/available-product',['id_product_group'=>$id])['result']??[];
        $data['is_general'] = false;
        $data['id_product'] = null;
        if(count($data['product_group']['variants']??[]) === 1){
            $id_general = [];
            foreach ($data['variants_tree'] as $variants){
                foreach ($variants['childs']??[] as $variant) {
                    if(in_array($variant['product_variant_code'],['general_type','general_size'])){
                        $id_general[] = $variant['id_product_variant'];
                        break;
                    }
                }
            }
            $pv = $data['product_group']['variants'][0]['variants'];
            $data['is_general'] = !array_diff($pv,$id_general);
            $data['id_product'] = $data['product_group']['variants'][0]['id_product'];
        }
        return view('productvariant::groups.detail',$data);
    }

    public function update(Request $request,$id) {
        $post = $request->except('_token');
        $post['id_product_group'] = $id;
        if($post['product_group_photo']??false){
            $post['product_group_photo'] = MyHelper::encodeImage($post['product_group_photo']);
        }
        if($post['product_group_image_detail']??false){
            $post['product_group_image_detail'] = MyHelper::encodeImage($post['product_group_image_detail']);
        }
        $request = MyHelper::post('product-variant/group/update',$post);
        if(($request['status']??false)=='success'){
            if($request['switch']??false){
                return redirect('product-variant/group/'.$id.'#variants')->with('success',['Success update data']);
            }
            return back()->with('success',['Success update data']);
        }else{
            return back()->withInput()->withErrors($request['messages']??['Failed update data']);
        }
    }

    /**
     * Assign products to product group
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function assign(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_product_group'] = $id;
        $update = MyHelper::post('product-variant/group/assign',$post);
        if(($update['status']??false) == 'success'){
            return redirect('product-variant/group/'.$id.'#variants')->with('success',['Success update']);
        }
        return redirect('product-variant/group/'.$id.'#variants')->withErrors($update['messages']??['Something went wrong']);
    }
    /**
     * View reorder product group
     * @param  Request $request [description]
     * @return            [description]
     */
    public function reorder(Request $request) {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'Manage Product Group Position',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-group-reorder',
        ];

        $catParent = MyHelper::get('product/category/be/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        }
        else {
            $data['category'] = [];
        }

        $product = MyHelper::get('product-variant/group');

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        // dd($data);

        return view('productvariant::groups.manage-position', $data);
    }

    // ajax sort product
    public function reorderAjax(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['id_product_group'])) {
            return [
                'status' => 'fail',
                'messages' => ['Product id is required']
            ];
        }
        $result = MyHelper::post('product-variant/group/reorder', $post);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request){
        $post = $request->except('_token');
        $request = MyHelper::post('product-variant/group/delete',$post);
        if(($request['status']??false)=='success'){
            return back()->with('success',['Success delete data']);
        }else{
            return back()->withInput()->withErrors($request['messages']??['Failed delete data']);
        }
    }

    /**
     * Export product
     */
    public function export(Request $request,$type) {
        $post = $request->except('_token');
        $data = MyHelper::post('product-variant/group/export',['type'=>$type]+$post)['result']??[];
        if(!$data){
            return back()->withErrors(['Something went wrong']);
        }
        $tab_title = 'List Products';
        switch ($type) {
            case 'global':
                $tab_title = 'List Products';
                if(!$data['products']){
                    $data['products'] = [
                        [
                            'product_group_code' => '001',
                            'product_group_name' => 'Product 1',
                            'product_group_description' => 'Example product 1'
                        ],
                        [
                            'product_group_code' => '002',
                            'product_group_name' => 'Product 2',
                            'product_group_description' => 'Example product 2'
                        ],
                        [
                            'product_group_code' => '003',
                            'product_group_name' => 'Product 3',
                            'product_group_description' => 'Example product 3'
                        ],
                    ];
                }
                break;

            case 'detail':
                $tab_title = 'Product Detail';
                if(!$data['products']){
                    $data['products'] = [
                        [
                            'product_category_name' => 'Snacks',
                            'product_group_position' => '1',
                            'product_group_code' => '001',
                            'product_group_name' => 'Product 1',
                            'product_group_description' => 'Example product 1'
                        ],
                        [
                            'product_category_name' => 'Snacks',
                            'product_group_position' => '2',
                            'product_group_code' => '002',
                            'product_group_name' => 'Product 2',
                            'product_group_description' => 'Example product 2'
                        ],
                        [
                            'product_category_name' => 'Drinks',
                            'product_group_position' => '1',
                            'product_group_code' => '003',
                            'product_group_name' => 'Product 3',
                            'product_group_description' => 'Example product 3'
                        ],
                    ];
                }
                break;
            
            default:
                # code...
                break;
        }
        return Excel::download(new ProductExport($data['products'],$tab_title),date('YmdHi').'_'.$type.'.xlsx');
    }

    /**
     * Import product
     */
    public function import(Request $request,$type) {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data['products'] = \Excel::toArray(new ProductImport(),$request->file('import_file'))[0]??[];
            if(!empty($data)){
                $code_brand = '';
                $import = MyHelper::post('product-variant/group/import', [
                    'type' => $type,
                    'data' => $data
                ]);
                return $import;
            }else{
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

    /**
     * Import product
     */
    public function importView(Request $request,$type) {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'Import Product',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-group-import',
            'type'           => $type
        ];
        switch ($type) {
            case 'global':
                $data['sub_title'] = 'Import Product Group Global';
                $data['submenu_active'] = 'product-group-import-global';
                $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
                break;

            case 'detail':
                $data['sub_title'] = 'Import Detail Product Group';
                $data['submenu_active'] = 'product-group-import-detail';
                $products = MyHelper::post('product/be/list', ['admin_list' => 1])['result']??[];
                if(!$products){
                    return redirect('product/import/global')->withErrors(['Product list empty','Upload global list product first']);
                }
                $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
                break;

            default:
                return abort(404);
                break;
        }

        return view('productvariant::groups.import',$data);
    }

    /**
     * Manage Product Category
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function category(Request $request) {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'Manage Category',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-group-manage-category'
        ];

        $data['categories'] = MyHelper::get('product/category/be/list')['result']??[];
        $data['all_category'] = array_column($data['categories'], 'id_product_category');
        $data['products'] = MyHelper::post('product-variant/group',['target'=>'manage_category'])['result']??[];
        return view('productvariant::groups.manage-category',$data);
    }

    /**
     * Manage Product Category
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function categoryUpdate(Request $request) {
        $post = $request->except('_token');
        $update = MyHelper::post('product-variant/group/category/update',$post);
        if(($update['status']??false) == 'success'){
            return back()->with('success',['Success update category']);
        }else{
            return back()->withErrors($update['messages']??['Failed update category'])->withInput();
        }
    }
}
