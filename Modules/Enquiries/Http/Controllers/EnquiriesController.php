<?php

namespace Modules\Enquiries\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class EnquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function indexAjax(Request $request){
		$post = $request->except('_token');
		// return response()->json($post);
		$enquiries = MyHelper::post('enquiries/list', $post);

        if (isset($enquiries['status']) && $enquiries['status'] == "success") {
            $data = $enquiries['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
	}
	public function indexDetailAjax(Request $request){
		$post = $request->except('_token');
		$enquiries = MyHelper::post('enquiries/list', $post);

        if (isset($enquiries['status']) && $enquiries['status'] == "success") {
            $data = $enquiries['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
	}
	
    public function index()
    {
        $data = [
            'title'          => 'Enquiries',
            'sub_title'      => 'List',
            'menu_active'    => 'enquiries',
            'submenu_active' => 'enquiries-list',
        ];

        // get api
        $data['enquiries']    = parent::getData(MyHelper::get('enquiries/list'));

        $data['textreplaces'] = [
            ['keyword' => '%phone%','reference' => 'user phone'],
            ['keyword' => '%name%','reference' => 'user name'],
            ['keyword' => '%email%','reference' => 'user email'],
            ['keyword' => '%gender%','reference' => 'user gender'],
            ['keyword' => '%city%','reference' => 'user city'],
            ['keyword' => '%province%','reference' => 'user province'],
            ['keyword' => '%birthday%','reference' => 'user birthday'],
            ['keyword' => '%level%','reference' => 'user level'],
            ['keyword' => '%points%','reference' => 'user points'],
            ['keyword' => '%phone_verify_status%','reference' => 'user phone verify status'],
            ['keyword' => '%email_verify_status%','reference' => 'user email verify status'],
            ['keyword' => '%register_time%','reference' => 'user register time'],
            ['keyword' => '%suspend_status%','reference' => 'user suspend status'],
        ];

        return view('enquiries::index', $data);
    }

    /* UPDATE */
    function update(Request $request) {
        $post = $request->except('_token');
        $update = MyHelper::post('enquiries/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        } 
    }
	
	function reply(Request $request) {
        $post = $request->except('_token');
		if (isset($post['reply_push_image'])) {
			$post['reply_push_image'] = MyHelper::encodeImage($post['reply_push_image']);
		}
        $update = MyHelper::post('enquiries/reply', $post);
		// print_r($update);exit;
        if (isset($update['status']) && $update['status'] == "success") {
			session(['success' => ['Enquiry replied']]);
            return back();
        }
        else {
            return redirect('enquiries')->withErrors(['Failed to reply']);
        } 
    }

    /* DELETE */
    function delete(Request $request) {
        $post = $request->except('_token');
        $delete = MyHelper::post('enquiries/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        } 
    }
    
}
