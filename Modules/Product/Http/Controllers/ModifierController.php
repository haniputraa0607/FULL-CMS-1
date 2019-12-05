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
        $data['types'] = MyHelper::get('product/modifier/type')['result']??[];
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
        return view('product::modifier.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('product::modifier.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('product::modifier.edit');
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
