<?php

namespace Modules\RedirectComplex\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

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

    	$data = [
            'title'          => 'Redirect Complex',
            'sub_title'      => 'Redirect Complex Create',
            'menu_active'    => 'redirect-complex',
            'submenu_active' => 'redirect-complex-create',
        ];

        if (empty($post)) {
        	return view('redirectcomplex::create', $data);
        }
        else {
        	$create = MyHelper::post('redirect-complex/create', $post);
        	dd($create);
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
    public function edit($id)
    {
        return view('redirectcomplex::edit');
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
