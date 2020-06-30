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

        $replace = MyHelper::get('autocrm/textreplace');
        if($replace['status'] == 'success'){
            $data['textreplaces'] = $replace['result'];
        }

        $data['textreplaces'][] = ['keyword' => '%enquiry_subject%','reference' => 'enquiry subject'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_message%','reference' => 'enquiry message'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_phone%','reference' => 'enquiry phone'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_name%','reference' => 'enquiry name'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_email%','reference' => 'enquiry email'];
        $data['textreplaces'][] = ['keyword' => '%visiting_time%','reference' => 'enquiry visiting time'];

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
