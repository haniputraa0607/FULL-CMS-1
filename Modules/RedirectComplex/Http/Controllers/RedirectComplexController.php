<?php

namespace Modules\RedirectComplex\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class RedirectComplexController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
    	$data = [
            'title'          => 'Redirect Complex',
            'sub_title'      => 'Redirect Complex List',
            'menu_active'    => 'redirect-complex',
            'submenu_active' => 'redirect-complex-list',
        ];

        $getData = parent::getData(MyHelper::get('redirect-complex/be/list'));

        if (!empty($getData['data'])) {
            $data['data']          = $getData['data'];
            $data['dataTotal']     = $getData['total'];
            $data['dataPerPage']   = $getData['from'];
            $data['dataUpTo']      = $getData['from'] + count($getData['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getData['data'], $getData['total'], $getData['per_page'], $getData['current_page'], ['path' => url()->current()]);
        }
        else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        return view('redirectcomplex::list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
    	$post = $request->except('_token');
    	$configs = session('configs');

    	$data = [
            'title'          => 'Redirect Complex',
            'sub_title'      => 'Redirect Complex Create',
            'menu_active'    => 'redirect-complex',
            'submenu_active' => 'redirect-complex-create',
        ];

        if (empty($post)) {
        	if(MyHelper::hasAccess([97], $configs)){
                $data['brands'] = parent::getData(MyHelper::get('brand/be/list'));
            }
        	return view('redirectcomplex::create', $data);
        }
        else {
        	$create = MyHelper::post('redirect-complex/create', $post);

        	if (($create['status']??false) == 'success') {
        		return redirect('redirect-complex/edit/'.$create['result']['id_redirect_complex_reference'])->withSuccess(['Redirect Complex has been created']);
        	}
        	else {
        		return redirect()->back()->withErrors($messages??['failed to insert data']);
        	}
        }

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
        return view('redirectcomplex::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $post = $request->except('_token');

    	$data = [
            'title'          => 'Redirect Complex',
            'sub_title'      => 'Redirect Complex List',
            'menu_active'    => 'redirect-complex',
            'submenu_active' => 'redirect-complex-list',
        ];

        if (empty($post)) {

        	$data['data'] = parent::getData(MyHelper::post('redirect-complex/be/edit', ['id_redirect_complex_reference' => $id]));

        	if (empty($data['data'])) {
        		return redirect('redirect-complex')->withErrors(['data not found']); 
        	}
        	return view('redirectcomplex::create', $data);
        }
        else {

        	$update = MyHelper::post('redirect-complex/update', $post);
        	
        	if (($update['status']??false) == 'success') {
        		return redirect('redirect-complex/edit/'.$id)->withSuccess(['Redirect Complex has been updated']);
        	}
        	else {
        		return redirect()->back()->withErrors($messages??['failed to update data']);
        	}
        }
    }

    function delete(Request $request) 
    {
        $post   = $request->all();

        $delete = MyHelper::post('redirect-complex/delete', ['id_redirect_complex_reference' => $post['id_redirect_complex_reference']]);
        
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    function listActive(Request $request) 
    {
        $post = $request->except('_token');
        $post['select'] = ['id_redirect_complex_reference', 'name'];

        $data = parent::getData(MyHelper::post('redirect-complex/be/list/active?log_save=0', $post));

		return response()->json($data);
    }

    function getMasterData(Request $request)
    {
    	$post = $request->except('_token');
        $action = MyHelper::post('redirect-complex/getData', $post);

        return $action;
    }
}
