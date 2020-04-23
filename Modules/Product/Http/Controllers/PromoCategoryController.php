<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class PromoCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Promo Category',
            'menu_active'    => 'product',
            'submenu_active' => 'product-promo-category-list',
        ];
        return view('product::promo_category.list',$data);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function indexAjax(Request $request)
    {
        $post = $request->except('_token');
        $raw_data = MyHelper::post('product/promo-category',$post)['result']??[];
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
            'title'          => 'Product',
            'sub_title'      => 'List Promo Category',
            'menu_active'    => 'product',
            'submenu_active' => 'product-promo-category-new',
        ];
        return view('product::promo_category.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $create = MyHelper::post('product/promo-category/create',$post);
        if($create['status'] == 'success'){
            return redirect('product/promo-category/'.$create['result']['id_product_promo_category']??'')->with('success',['Create promo category success']);
        }else{
            back()->withInput()->withErrors($create['messages']??['Create promo category fail']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Promo Category',
            'menu_active'    => 'product',
            'submenu_active' => 'product-promo-category-list',
        ];
        $raw_data = MyHelper::post('product/promo-category/show',['id_product_promo_category'=>$id])['result']??[];
        if(!$raw_data){
            return abort(404);
        }
        $data['promo_category'] = $raw_data['info'];
        $data['products'] = [];
        foreach ($raw_data['products'] as $product) {
            $data['products'][$product['product_group_code']??$product['product_code']] = $product;
        }
        return view('product::promo_category.show',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_product_promo_category'] = $id;
        $update = MyHelper::post('product/promo-category/update',$post);
        if(($update['status']??false) == 'success'){
            return back()->with('success',['Update data success']);
        }else{
            return back()->withInput()->withErrors($update['messages']??['Update data fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $delete = MyHelper::post('product/promo-category/delete',$request->except('_token'));
        if(($delete['status']??false) == 'success'){
            return back()->with('success',['Delete data success']);
        }else{
            return back()->withInput()->withErrors($update['messages']??['Delete data fail']);
        }
    }

    /**
     * Reorder position of promo category
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function reorder(Request $request)
    {
        $post = $request->except(['_token']);
        return MyHelper::post('product/promo-category/reorder',$post);
    }

    /**
     * Assign products to promo categories
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function assign(Request $request,$id) {
        $post = $request->except('_token');
        $post['id_product_promo_category'] = $id;
        $update = MyHelper::post('product/promo-category/assign',$post);
        if(($update['status']??false) == 'success'){
            return redirect("product/promo-category/$id#products")->with('success',['Update data success']);
        }else{
            return redirect("product/promo-category/$id#products")->withInput()->withErrors($update['messages']??['Update data fail']);
        }
    }
}
