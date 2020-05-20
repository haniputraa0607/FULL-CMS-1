<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
                'title'          => 'News Category',
                'sub_title'      => 'News Category List',
                'menu_active'    => 'news',
                'submenu_active' => 'news-category',
        ];

        // get category
        $data['categories']    = $this->getData(MyHelper::post('news/be/category',['all'=>1, 'admin' => '1']));
        return view('news::category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
                'title'          => 'News Category',
                'sub_title'      => 'New News Category',
                'menu_active'    => 'news',
                'submenu_active' => 'news-category-new',
        ];

        return view('news::category.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post   = $request->all();

        $update = MyHelper::post('news/category/create', ['category_name'=>$post['category_name']]);
        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('news/category')->with('success',['Create category success']);
        }
        else {
            return redirect('news/category')->withErrors(['Create category fail']);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('news::category.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('news::category.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $post   = $request->all();

        $update = MyHelper::post('news/category/update', ['id_news_category'=>$post['id_news_category'],'category_name'=>$post['category_name']]);
        if (isset($update['status']) && $update['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */

    function delete(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('news/category/delete', ['id_news_category' => $post['id_news_category']]);
        
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }
}
