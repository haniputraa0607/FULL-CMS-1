<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

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
            'filter_title'   => 'Filter Product Modifier',
        ];
        if(session('product_modifier_filter')){
            $post=session('product_modifier_filter');
            $data['rule']=array_map('array_values', $post['rule']);
            $data['operator']=$post['operator'];
        }else{
            $post = [];
        }
        $page = $request->page;
        if(!$page){
            $page = 1;
        }
        $data['start'] = ($page-1)*10;
        $data['modifiers'] = MyHelper::post('product/modifier?page='.$page,$post)['result']??[];
        $data['total'] = $data['modifiers']['total'];
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
        if($post['rule']??false){
            session(['product_modifier_filter'=>$post]);
            return redirect('product/modifier');
        }
        if($post['clear']??false){
            session(['product_modifier_filter'=>null]);
            return redirect('product/modifier');
        }
        $post['type'] = $post['type_dropdown'];
        if($post['type'] == '0'){
            $post['type'] =$post['type_textbox'];
        }
        $result = MyHelper::post('product/modifier/create',$post);
        if(($result['status']??false) == 'success'){
            return redirect('product/modifier/create')->with('success',['Success create modifier']);
        }else{
            return back()->withErrors($result['messages']??['Something went wrong'])->withInput();
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
        if($request->isMethod('patch')){
            $modifier = MyHelper::post('product/modifier/detail',['id_product_modifier'=>$id])['result']??false;
            if(!$modifier){
                return ['status'=>'fail'];
            }
            $post += $modifier;
            $post['patch'] = 1;
            $result = MyHelper::post('product/modifier/update',$post);
            return $result;
        }
        $post['type'] = $post['type_dropdown'];
        $post['id_product_modifier'] = $id;
        if($post['type'] == '0'){
            $post['type'] =$post['type_textbox'];
        }
        $result = MyHelper::post('product/modifier/update',$post);
        if(($result['status']??false) == 'success'){
            return redirect('product/modifier/'.$post['code'])->with('success',['Success update modifier']);
        }else{
            if(stristr($result['message']??'', 'SQLSTATE[23000]')){
                $result['message'] = 'Another modifier with code "'.$post['code'].'" aready exist';
            }
            return back()->withErrors($result['messages']??[$result['message']??'Something went wrong'])->withInput();
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
    /**
     * Get list product modifiers
     * @return view list modifiers price
     */
    public function listPrice(Request $request,$id_outlet=null)
    {
        $outlets = MyHelper::get('outlet/list')['result']??[];
        if(!$outlets){
            return back()->withErrors(['Something went wrong']);
        }
        if(!$id_outlet || !in_array($id_outlet,array_column($outlets, 'id_outlet'))){
            $outlet = $outlets[0]['id_outlet']??false;
            if(!$outlet){
                return back()->withErrors(['Something went wrong']);
            }
            return redirect('product/modifier/price/'.$outlet);
        }
        $data = [
            'title'          => 'Product Modifier',
            'sub_title'      => 'Product Modifier Prices',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-price',
        ];
        $page = $request->page;
        if(!$page){
            $page = 1;
        }
        $data['key'] = $id_outlet;
        $data['outlets'] = $outlets;
        $data['modifiers'] = MyHelper::post('product/modifier/list-price?page='.$page,['id_outlet'=>$id_outlet])['result']??[];

        $data['paginator'] = new LengthAwarePaginator($data['modifiers']['data'], $data['modifiers']['total'], $data['modifiers']['per_page'], $data['modifiers']['current_page'], ['path' => url()->current()]);
        
        $data['start'] = ($page-1)*10;
        $data['next_page'] = $data['modifiers']['next_page_url']?url()->current().'?page='.($page+1):'';
        $data['prev_page'] = $data['modifiers']['prev_page_url']?url()->current().'?page='.($page-1):'';
        return view('product::modifier.price',$data);
    }

    /**
     * update price product modifiers
     * @return view list modifiers price
     */
    public function updatePrice(Request $request,$id_outlet=null)
    {
        $post = $request->except('_token');
        $post['id_outlet'] = $id_outlet;
        $result = MyHelper::post('product/modifier/update-price',$post);
        if(($result['status']??false)=='success'){
            return back()->with('success',['Success update price']);
        }else{
            return $result;
            return back()->withErrors(['Fail update price']);
        }
    }
}
