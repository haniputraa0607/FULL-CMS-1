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
        $data['product_groups'] = MyHelper::get('product-variant/group')['result']??[];
        return view('productvariant::groups.list',$data);
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
            return back()->with('success',['Success create product group']);
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
        return view('productvariant::groups.detail',$data);
    }

    public function update(Request $request) {
        $post = $request->except('_token');
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
