<?php

namespace Modules\Membership\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class MembershipController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function membershipList(Request $request)
	{
		$data = [
			'title'             => 'Membership List',
			'menu_active'       => 'membership',
			'submenu_active'    => 'membership-list'
		];

		$post = $request->except('_token');
		if (!empty($post)) {

			$post['membership'] = array_values($post['membership']);
			// dd($post);exit;
			foreach ($post['membership'] as $key => $membership) {
				if (isset($membership['membership_image'])) {
					$post['membership'][$key]['membership_image'] = MyHelper::encodeImage($membership['membership_image']);
				} else {
					$post['membership'][$key]['membership_image'] = "";
				}
				if (isset($membership['membership_next_image'])) {
					$post['membership'][$key]['membership_next_image'] = MyHelper::encodeImage($membership['membership_next_image']);
				} else {
					$post['membership'][$key]['membership_next_image'] = "";
				}
			}
			$action = MyHelper::post('membership/update', $post);
			// dd($action);exit;
			if (isset($action['status']) && $action['status'] == 'success') {
				session(['success' => ['Membership has been updated']]);
				return redirect('membership');
			} else {
				if (isset($action['messages'])) {
					return redirect('membership')->withErrors($action['messages']);
				} else {
					return redirect('membership')->withErrors(['Something went wrong.']);
				}
			}
		} else {
			$action = MyHelper::post('membership/be/list', []);
			if (isset($action['status']) && $action['status'] == 'success') {
				$data['result'] = array_map(function($var){
					$var['benefit_text']=json_decode($var['benefit_text']);
					return $var;
				},$action['result']);
				$data['post'] = $post;
				// print_r($data);exit;
				return view('membership::list', $data);
			} else {
				return view('membership::list', $data);
			}
		}
	}


	public function create(Request $request)
	{
		$post = $request->except('_token');
		$data = [
			'title'          => 'New Membership',
			'menu_active'    => 'membership',
			'submenu_active' => 'membership-new',
		];
		if (empty($post)) {
			return view('membership::create', $data);
		} else {
			// print_r($post);exit;
			$save = MyHelper::post('membership/create', $post);
			if (isset($save['status']) && $save['status'] == "success") {
				session(['success' => ['New membership has been created']]);
				return redirect('membership/create');
			} else {
				return redirect('membership/create')->withErrors($save['messages']);
			}
		}
	}

	public function update(Request $request, $id_membership)
	{
		$post = $request->except('_token');
		$data = [
			'title'          => 'Update Membership',
			'menu_active'    => 'membership',
			'submenu_active' => 'membership-list',
		];
		if (empty($post)) {
			$query = MyHelper::post('membership/be/list', ['id_membership' => $id_membership]);
			if (isset($query['status']) && $query['status'] == "success") {
				$data['data'] = $query['result'][0];
				return view('membership::update', $data);
			} else {
				return redirect('membership')->withErrors($query['messages']);
			}
		} else {
			$post['id_membership'] = $id_membership;
			$save = MyHelper::post('membership/update', $post);
			if (isset($save['status']) && $save['status'] == "success") {
				session(['success' => ['Membership has been updated']]);
				return redirect('membership');
			} else {
				if (isset($save['messages'])) {

					return redirect('membership/update/' . $id_membership)->withErrors($save['messages']);
				} else {
					return redirect('membership/update/' . $id_membership)->withErrors('Something Went Wrong.');
				}
			}
		}
	}

	public function delete($id_membership)
	{
		$save = MyHelper::post('membership/delete', ['id_membership' => $id_membership]);
		// print_r($save);exit;
		if (isset($save['status']) && $save['status'] == "success") {
			session(['success' => ['Membership has been deleted']]);
			return redirect('membership');
		} else {
			return redirect('membership')->withErrors($save['messages']);
		}
	}

	public function detailWebview(Request $request)
	{
		$bearer = $request->header('Authorization');

		if ($bearer == "") {
			return view('error', ['msg' => 'Unauthenticated']);
		}

		$data = json_decode(base64_decode($request->get('data')), true);
		$data['check'] = 1;
		$check = MyHelper::postWithBearer('membership/detail/webview?log_save=0', $data, $bearer);
		// return $check;
		if (isset($check['status']) && $check['status'] == 'success') {
			$data['result'] = $check['result'];
		} elseif (isset($check['status']) && $check['status'] == 'fail') {
			return view('error', ['msg' => 'Data failed']);
		} else {
			return view('error', ['msg' => 'Something went wrong, try again']);
		}

		return view('membership::webview.detail_membership', $data);
	}
}
