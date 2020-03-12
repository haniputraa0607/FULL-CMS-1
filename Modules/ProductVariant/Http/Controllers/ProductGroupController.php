<?php

namespace Modules\ProductVariant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

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
        $raw_data = MyHelper::get('product-variant/group?page='.$page)['result']??[];
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
        $product_group = MyHelper::post('product-variant/group/detail',['id_product_group'=>$id])['result']??[];
        $variants = array_map(function($var){
            $var['variants'] = explode(',', $var['variants']);
            return $var;
        }, $product_group['variants']);
        $product_group['variants'] = $variants;
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
}
