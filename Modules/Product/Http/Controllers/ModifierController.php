<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class ModifierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Product Modifier',
            'sub_title'      => 'List Product Modifier',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-list',
        ];
        $page = $request->page;
        if(!$page){
            $page = 1;
        }
        $data['start'] = ($page-1)*10;
        $data['modifiers'] = MyHelper::get('product/modifier?page='.$page)['result']??[];
        $data['next_page'] = $data['modifiers']['next_page_url']?url()->current().'?page='.($page+1):'';
        $data['prev_page'] = $data['modifiers']['prev_page_url']?url()->current().'?page='.($page-1):'';
        return view('product::modifier.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Product Modifier',
            'sub_title'      => 'New Product Modifier',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-new',
        ];
        $data['types'] = MyHelper::get('product/modifier/type')['result']??[];

        $data['subject']['products'] = array_map(function($var){
            return [
                'id' => $var['id_product'],
                'text' => $var['product_code'].' - '.$var['product_name']
            ];
        },MyHelper::get('product/list')['result']??[]);

        $data['subject']['product_categories'] = array_map(function($var){
            return [
                'id' => $var['id_product_category'],
                'text' => $var['product_category_name']
            ];
        },MyHelper::get('product/category/list')['result']??[]);

        $data['subject']['brands'] = array_map(function($var){
            return [
                'id' => $var['id_brand'],
                'text' => $var['name_brand']
            ];
        },MyHelper::get('brand/list')['result']??[]);
        return view('product::modifier.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post =  $request->except('_token');
        $post['type'] = $post['type_dropdown'];
        if($post['type'] == '0'){
            $post['type'] =$post['type_textbox'];
        }
        $result = MyHelper::post('product/modifier/create',$post);
        if(($result['status']??false) == 'success'){
            return redirect('product/modifier/create')->with('success',['Success create modifier']);
        }else{
             return back()->withErrors($result['messages']??['Something went wrong']);
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
            'title'          => 'Product Modifier',
            'sub_title'      => 'Detail Product Modifier',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-list',
        ];
        $modifier = MyHelper::post('product/modifier/detail',['code'=>$id]);
        if(!($modifier['result']??false)){
            return back()->withErrors($modifier['messages']??['Something went wrong']);
        }
        $data['modifier'] = $modifier['result'];

        $data['types'] = MyHelper::get('product/modifier/type')['result']??[];

        $data['subject']['products'] = array_map(function($var){
            return [
                'id' => $var['id_product'],
                'text' => $var['product_code'].' - '.$var['product_name']
            ];
        },MyHelper::get('product/list')['result']??[]);

        $data['subject']['product_categories'] = array_map(function($var){
            return [
                'id' => $var['id_product_category'],
                'text' => $var['product_category_name']
            ];
        },MyHelper::get('product/category/list')['result']??[]);

        $data['subject']['brands'] = array_map(function($var){
            return [
                'id' => $var['id_brand'],
                'text' => $var['name_brand']
            ];
        },MyHelper::get('brand/list')['result']??[]);

        return view('product::modifier.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post =  $request->except(['_token','_method']);
        $post['type'] = $post['type_dropdown'];
        $post['id_product_modifier'] = $id;
        if($post['type'] == '0'){
            $post['type'] =$post['type_textbox'];
        }
        $result = MyHelper::post('product/modifier/update',$post);
        if(($result['status']??false) == 'success'){
            return back()->with('success',['Success update modifier']);
        }else{
             return back()->withErrors($result['messages']??['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post('product/modifier/delete',['id_product_modifier'=>$id]);
        if($result['status']=='success'){
            return redirect('product/modifier')->with('success',['Success delete modifier']);
        }
        return redirect('product/modifier')->withErrors(['Fail delete modifier']);
    }
}
