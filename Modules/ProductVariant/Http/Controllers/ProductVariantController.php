<?php

namespace Modules\ProductVariant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'List Product Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-list',
        ];
        $page = $request->page?:1;
        $data['parents'] = MyHelper::post('product-variant',['rule'=>[['subject'=>'variant_type','operator'=>'=','parameter'=>'parent']]])['result']??[];
        $childs = MyHelper::post('product-variant',['rule'=>[['subject'=>'variant_type','operator'=>'=','parameter'=>'childs']]])['result']??[];
        $data['childs'] = [];
        foreach ($childs as $child) {
            $data['childs'][$child['parent']['id_product_variant']][] = $child;
        }
        return view('productvariant::variants.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $data = [
            'title'          => 'Complex Menu',
            'sub_title'      => 'New Product Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-new',
        ];
        $data['parents'] = MyHelper::post('product-variant',['rule'=>[['subject'=>'variant_type','operator'=>'=','parameter'=>'parent']]])['result']??[];
        return view('productvariant::variants.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $create = MyHelper::post('product-variant/create',$post);
        if(($create['status']??false)=='success'){
            return back()->with('success',['Success add data']);
        }else{
            return back()->withErrors($create['messages']??['Something went wrong']);
        }
        return $post;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('productvariant::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('productvariant::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return $request->except('_token');
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
    public function reorder(Request $request) {
        $post = $request->except('_token');
        $result = MyHelper::post('product-variant/reorder',$post);
        if(($result['status']??false)=='success'){
            return back()->with('success',['Success update order']);
        }
        return back()->withErrors($result['messages']??['Something went wrong']);
    }
}
