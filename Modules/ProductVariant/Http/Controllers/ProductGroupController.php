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
            'title'          => 'Product Group',
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
            'title'          => 'Product Group',
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
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('productvariant::groups.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
