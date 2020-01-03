<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller as CustomController;

use App\Lib\MyHelper;

class WebviewNewsController extends Controller
{

    public function test()
    {
        return view('error', ['msg' => 'testing']);
    }
    public function detail(Request $request, $id)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        // if ($request->isMethod('get')) {
        //     return view('error', ['msg' => 'Url method is POST']);
        // }

        $news = MyHelper::postWithBearer('news/be/list', ['id_news'=> $id], $bearer);
        $totalOutlet = 0;
        $outlet = MyHelper::getWithBearer('outlet/list?log_save=0', $bearer);
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $totalOutlet = count($outlet['result']);
        }
        
        $totalOutletNews = 0;
        
        if (isset($news['status']) && $news['status'] == 'success') {
            // return $news['result'];
            $totalOutletNews = count($news['result'][0]['news_outlet']);
            return view('news::webview.news', ['news' => $news['result'], 'total_outlet' => $totalOutlet, 'total_outlet_news' => $totalOutletNews]);
        } elseif (isset($news['status']) && $news['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }
    }

    /* Webview Custom Form */
    function customFormView(Request $request, $id_news) {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $post = $request->except('_token');

        $custom_controller = new CustomController();

        $news = $custom_controller->getData(MyHelper::postWithBearer('news/get', ['id_news' => $id_news], $bearer));

        if (empty($news)) {
            return [
                'status' => 'fail',
                'messages' => ['Form is not found']
            ];
        }
        else {
            $data['form_action'] = "news/webview/custom-form/". $news['id_news'];
            // flag if user logged in or not
            $data['flag'] = 0;
            $data['user'] = [];

            // get user profile
            $user = $custom_controller->getData(MyHelper::getWithBearer('users/get', $bearer));
            if (!empty($user)) {
                // flag if user logged in or not
                $data['flag'] = 1;
                $data['user'] = $user;
            }

            if (empty($post)) {
                $data['news'] = $news;
                $data['bearer'] = $bearer;

                return view('news::webview.custom_form', $data);
            }
            else{
                $bearer = $post['bearer'];
                unset($post['bearer']);
                $auth = $post['flag'];
                unset($post['flag']);
                
                foreach ($post['news_form'] as $key => $news_form) {
                    // if field is null
                    if (!isset($news_form['input_value'])) {
                        $news_form['input_value'] = "";
                        $post['news_form'][$key]['input_value'] = "";
                    }

                    if ($news_form['input_type'] == "Image Upload" && $news_form['input_value'] != "") {
                        $post['news_form'][$key]['input_value'] = MyHelper::encodeImage($news_form['input_value']);
                    }
                    elseif ($news_form['input_type'] == "File Upload" && $news_form['input_value'] != "") {
                        $path = $news_form['input_value']->getRealPath(); 
                        $filename = $news_form['input_value']->getClientOriginalName(); 
                        // upload file
                        $file = MyHelper::postFileBearer('news/custom-form/file', 'news_form_file', $path, $filename, $bearer);

                        if ($file['status'] == 'success') {
                            $post['news_form'][$key]['input_value'] = $file['filename'];
                        }
                    }
                }

                // if user logged in
                if ($auth) {
                    $result = MyHelper::postWithBearer('news/custom-form/auth', $post, $bearer);
                }
                else {
                    $result = MyHelper::postWithBearer('news/custom-form', $post, $bearer);
                }
                
                if ($result['status']=="success") {
                    $data['messages'] = $result['messages'];
                    if ($result['messages'] == "") {
                        $data['messages'] = ["Submit form success", "Thank you"];
                    }
                    return view('news::webview.custom_form_success', $data);
                }
                else{
                    return back()->withInput()->withErrors(['Save data fail', 'Please check again your input']);
                }
            }
        }
        
    }

    // preview custom form success page
    /*public function customFormSuccess()
    {
        $data['messages'] = ["Submit form success", "Thank you"];
        return view('news::webview.custom_form_success', $data);
    }*/
}