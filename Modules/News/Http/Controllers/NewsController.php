<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
                'title'          => 'News',
                'sub_title'      => 'News List',
                'menu_active'    => 'news',
                'submenu_active' => 'news-list',
        ];

        // get outlet
        $data['news']    = parent::getData(MyHelper::post('news/be/list', ['admin'=> 1]));

        return view('news::index', $data);
    }
	
	public function indexAjax()
    {
		$news = MyHelper::post('news/be/list?log_save=0', ['admin'=> 1]);
		if (isset($news['status']) && $news['status'] == "success") {
            $data = $news['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }

    /* CREATE */
    public function create(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'News',
                'sub_title'      => 'New News',
                'menu_active'    => 'news',
                'submenu_active' => 'news-new',
            ];

            // get outlet
            $data['outlet']    = parent::getData(MyHelper::get('outlet/be/list'));
            $data['categories']    = parent::getData(MyHelper::post('news/be/category',['admin' => '1']));
            // get product
            $data['product']   = parent::getData(MyHelper::get('product/be/list'));
            
            return view('news::create', $data);
        }
        else {
            $news = $request->except('_token', 'id_outlet', 'id_product');
            $news['news_content_long'] = preg_replace('/(img style="width: )([0-9]+)(px)/', 'img style="width: 100%', $news['news_content_long']);

            if (isset($news['news_content_long'])) {
                // remove tag <font>
                $news['news_content_long'] =preg_replace("/<\\/?font(.|\\s)*?>/",'',$news['news_content_long']);
            }

            // slug news otomatis
            $news['news_slug'] = str_slug($news['news_title'], '_');

            $news = array_filter($news);

            if (!isset($news['news_event_location_name'])) {
                unset($news['news_event_latitude']);
                unset($news['news_event_longitude']);
            }

            // set tanggal 
            if (isset($news['news_post_date'])) {
                $news['news_post_date'] = date('Y-m-d', strtotime($news['news_post_date']))." ".date('H:i:s', strtotime($news['news_post_time']));
            }
            
            $news['news_publish_date'] = date('Y-m-d 00:00:00', strtotime($news['news_publish_date']));

            if ($news['publish_type'] == "always") {
                $news['news_expired_date'] = null;
            }
            else {
                $news['news_expired_date'] = date('Y-m-d 23:59:59', strtotime($news['news_expired_date']));
            }
            
            if (isset($news['news_event_date_start'])) {
                $news['news_event_date_start'] = date('Y-m-d', strtotime($news['news_event_date_start']));
            }

            if (isset($news['news_event_date_end'])) {
                $news['news_event_date_end'] = date('Y-m-d', strtotime($news['news_event_date_end']));
            }

            // set waktu
            if (isset($news['news_event_time_start'])) {
                $news['news_event_time_start'] = date('H:i:s', strtotime($news['news_event_time_start']));
            }

            if (isset($news['news_event_time_end'])) {
                $news['news_event_time_end'] = date('H:i:s', strtotime($news['news_event_time_end']));
            }

            // remove custom form index if the checkbox is not checked
            if ( !isset($news['custom_form_checkbox']) ) {
                unset($news['customform']);
                $news['news_button_form_expired'] = null;
            }
            else {
                // set to null if form type didn't match
                foreach ($news['customform'] as $key => $form) {
                    // autofill
                    if ( !($form['form_input_types'] == "Short Text" || $form['form_input_types'] == "Long Text" || $form['form_input_types'] == "Date") ) {
                        $news['customform'][$key]['form_input_autofill'] = null;
                    }
                    // option
                    if ( !($form['form_input_types'] == "Radio Button Choice" || $form['form_input_types'] == "Multiple Choice" || $form['form_input_types'] == "Dropdown Choice") ) {
                        $news['customform'][$key]['form_input_options'] = null;
                    }
                    // is_unique
                    if (isset($form['is_unique'])) {    // if checked
                        $news['customform'][$key]['is_unique'] = $form['is_unique'][0];
                    }
                    else{   // if unchecked
                        $news['customform'][$key]['is_unique'] = 0;
                    }
                    // if checked but hidden (input type not match)
                    if ( !($form['form_input_types'] == "Short Text" || $form['form_input_types'] == "Long Text" || $form['form_input_types'] == "Number Input") ) {
                        $news['customform'][$key]['is_unique'] = 0;
                    }

                    if (isset($form['is_required'])) {
                        $news['customform'][$key]['is_required'] = $form['is_required'][0];
                    }
                    else{
                        $news['customform'][$key]['is_required'] = 0;
                    }
                }

                $news['news_button_form_expired'] = date('Y-m-d 00:00:00', strtotime($news['news_button_form_expired']));
            }
            
            // set image
            if(isset($news['news_image_luar'])){
                $news['news_image_luar']   = MyHelper::encodeImage($news['news_image_luar']);
            }
            $news['news_image_dalam']  = MyHelper::encodeImage($news['news_image_dalam']);

            if(isset($post['news_outlet_text'])){
                $news['news_outlet_text'] = $post['news_outlet_text'];
                $news['id_outlet'] = $post['id_outlet'];
            }

            if(isset($post['news_product_text'])){
                $news['news_product_text'] = $post['news_product_text'];
                $news['id_product'] = $post['id_product'];
            }

            // dd($news);
            $save = MyHelper::post('news/create', $news);

            if (isset($save['status']) && $save['status'] == "success") {

                // simpan relasi outlet
                if (isset($post['id_outlet']))  {
                    $saveRelation = $this->saveRelation('outlet', $save['result']['id_news'], $post['id_outlet']);
                }

                // simpan relasi product
                if (isset($post['id_product'])) {
                    $saveRelation = $this->saveRelation('product', $save['result']['id_news'], $post['id_product']);
                }

                // jika nggak ada
                return redirect('news')->withSuccess(['News has been created.']);
            }
            else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    /* SAVE RELATION */
    function saveRelation($type, $id_news, $post=[]) {     
        if (!empty($post)) {
            switch ($type) {
                case 'outlet':
                    foreach ($post as $value) {
                        $data = [
                            'id_news'   => $id_news,
                            'type'      => 'outlet',
                            'id_outlet' => $value
                        ];

                        $save = MyHelper::post('news/create/relation', $data);
                    }
                    break;
                case 'product':
                    foreach ($post as $value) {
                        $data = [
                            'id_news'    => $id_news,
                            'type'       => 'product',
                            'id_product' => $value
                        ];

                        $save = MyHelper::post('news/create/relation', $data);
                    }
                    break;
                
                default:
                    return true;
                    break;
            }
        }

        return true;
    }

    /* DETAIL */
    function detail(Request $request, $id_news, $slug) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                    'title'          => 'News',
                    'sub_title'      => 'Update News',
                    'menu_active'    => 'news',
                    'submenu_active' => 'news-list',
            ];

            $news    = parent::getData(MyHelper::post('news/be/list', ['id_news' => $id_news,'admin'=>1]));
			
            if (empty($news)) {
                return back()->withErrors(['Data news not found.']);
            }
            else {
                $data['news'] = $news;
                $data['categories']    = parent::getData(MyHelper::post('news/be/category',['admin' => '1']));
            }

            // get outlet
            $data['outlet']    = parent::getData(MyHelper::get('outlet/be/list'));
            
            // get product
            $data['product']   = parent::getData(MyHelper::get('product/be/list'));
            
            // print_r($data); exit();
            return view('news::update', $data);
        }
        else {
            // filter data news
			
            $news = $request->except('_token', 'id_outlet', 'id_product');
            $news = $this->setInputForUpdate($news, $post);
            // dd($news);
            // set image
            if (isset($news['news_image_luar'])) {
                $news['news_image_luar']   = MyHelper::encodeImage($news['news_image_luar']);
            }

            if (isset($news['news_image_dalam'])) {
                $news['news_image_dalam']  = MyHelper::encodeImage($news['news_image_dalam']);
            }
            
            $news['news_content_long'] = preg_replace('/(img style="width: )([0-9]+)(px)/', 'img style="width: 100%' ,$news['news_content_long']);

            if (isset($news['news_content_long'])) {
                // remove tag <font>
                $news['news_content_long'] =preg_replace("/<\\/?font(.|\\s)*?>/",'',$news['news_content_long']);
            }
            
            // update data master news
			// print_r($news);exit;
            $update = MyHelper::post('news/update', $news);
			// print_r($update);exit;
            if (isset($update['status']) && $update['status'] == "success") {
                // simpan relasi outlet
                if (isset($post['id_outlet']))  {
                    // delete duluk
                    $deleteRelation = $this->deleteRelation('outlet', $news['id_news']);
                    // save kemudian
                    $saveRelation = $this->saveRelation('outlet', $news['id_news'], $post['id_outlet']);
                }
                else {
                    $deleteRelation = $this->deleteRelation('outlet', $news['id_news']);
                }

                // simpan relasi product
                if (isset($post['id_product'])) {
                    // delete duluk
                    $deleteRelation = $this->deleteRelation('product', $news['id_news']);
                    // save kemudian
                    $saveRelation = $this->saveRelation('product', $news['id_news'], $post['id_product']);
                }
                else {
                    $deleteRelation = $this->deleteRelation('product', $news['id_news']);
                }

                // jika nggak ada
                return back()->withSuccess(['News has been updated.']);
            }
            else {
                if (isset($update['errors'])) {
                    return back()->withErrors($update['errors'])->withInput();
                }

                if (isset($update['status']) && $update['status'] == "fail") {
                    return back()->withErrors($update['messages'])->withInput();
                }
                
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    /* FILTER */
    function setInputForUpdate($news, $post) {
        // set slug
        $news['news_slug']         = str_slug($news['news_title'], '_');
        // set tanggal 
        $news['news_publish_date'] = date('Y-m-d 00:00:00', strtotime($news['news_publish_date']));

        $news = array_filter($news);

        if ($news['publish_type'] == "always") {
            $news['news_expired_date'] = null;
        }
        else {
            $news['news_expired_date'] = date('Y-m-d 23:59:59', strtotime($news['news_expired_date']));
        }
        
        if (empty($news['news_post_date'])) {
            $news['news_post_date'] = null;
        }else{
            $news['news_post_date'] = date('Y-m-d', strtotime($news['news_post_date']))." ".date('H:i:s', strtotime($news['news_post_time']));
        }

        if (empty($post['news_video_text'])) {
            $news['news_video_text'] = null;
        }

        if (empty($post['news_video'])) {
            $news['news_video'] = null;
        }

        if (empty($post['news_outlet_text'])) {
            $news['news_outlet_text'] = null;
        }

        if (empty($post['news_product_text'])) {
            $news['news_product_text'] = null;
        }
		
		if (empty($post['news_button_form_text'])) {
            $news['news_button_form_text'] = null;
        }
		
		if (empty($post['news_button_form_expired'])) {
            $news['news_button_form_expired'] = null;
        }
        else {
            $news['news_button_form_expired'] = date('Y-m-d', strtotime($news['news_button_form_expired']));
        }

        // location
        if (empty($post['news_event_location_name'])) {
            $news['news_event_location_name'] = null;
        }

        if (empty($post['news_event_location_phone'])) {
            $news['news_event_location_phone'] = null;
        }

        if (empty($post['news_event_location_address'])) {
            $news['news_event_location_address'] = null;
        }

        if (empty($post['news_event_latitude'])) {
            $news['news_event_latitude'] = null;
        }

        if (empty($post['news_event_longitude'])) {
            $news['news_event_longitude'] = null;
        }

        if (empty($post['news_event_time_end'])) {
            $news['news_event_time_end'] = null;
        }
        else {
            $news['news_event_time_end'] = date('H:i:s', strtotime($news['news_event_time_end']));
        }

        if (empty($post['news_event_time_start'])) {
            $news['news_event_time_start'] = null;
        }
        else {
            $news['news_event_time_start'] = date('H:i:s', strtotime($news['news_event_time_start']));
        }

        if (empty($post['news_event_date_start'])) {
            $news['news_event_date_start'] = null;
        }else{
            $news['news_event_date_start'] = date('Y-m-d', strtotime($news['news_event_date_start']));
        }

        if (empty($post['news_event_date_end'])) {
            $news['news_event_date_end'] = null;
        }else{
            $news['news_event_date_end'] = date('Y-m-d', strtotime($news['news_event_date_end']));
        }

        // remove custom form index if the checkbox is not checked
        if ( !isset($news['custom_form_checkbox']) ) {
            unset($news['customform']);
            $news['news_button_form_expired'] = null;
        }
        else {
            // reorder array index
            $news['customform'] = array_values($news['customform']);
            // set to null if form type didn't match
            foreach ($news['customform'] as $key => $form) {
                // autofill
                if ( !($form['form_input_types'] == "Short Text" || $form['form_input_types'] == "Long Text" || $form['form_input_types'] == "Date") ) {
                    $news['customform'][$key]['form_input_autofill'] = null;
                }
                // option
                if ( !($form['form_input_types'] == "Radio Button Choice" || $form['form_input_types'] == "Multiple Choice" || $form['form_input_types'] == "Dropdown Choice") ) {
                    $news['customform'][$key]['form_input_options'] = null;
                }
                // is_unique
                if (isset($form['is_unique'])) {    // if checked
                    $news['customform'][$key]['is_unique'] = $form['is_unique'][0];
                }
                else{   // if unchecked
                    $news['customform'][$key]['is_unique'] = 0;
                }
                // if checked but hidden (input type not match)
                if ( !($form['form_input_types'] == "Short Text" || $form['form_input_types'] == "Long Text" || $form['form_input_types'] == "Number Input") ) {
                    $news['customform'][$key]['is_unique'] = 0;
                }

                if (isset($form['is_required'])) {
                    $news['customform'][$key]['is_required'] = $form['is_required'][0];
                }
                else{
                    $news['customform'][$key]['is_required'] = 0;
                }
            }
            $news['news_button_form_expired'] = date('Y-m-d 00:00:00', strtotime($news['news_button_form_expired']));
        }
		
        return $news;
    }

    /* DELETE RELATION */
    function deleteRelation($type, $id_news) {
        $data = [
            'type'    => $type,
            'id_news' => $id_news
        ];

        $save = MyHelper::post('news/delete/relation', $data);

        return $save;
    }

    /* DELETE NEWS */
    function delete(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('news/delete', ['id_news' => $post['id_news']]);
        
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    // preview news custom form from admin
    public function customFormPreview($id_news)
    {
        $news = parent::getData(MyHelper::post('news/get', ['id_news' => $id_news]));

        if (empty($news)) {
            return back()->withErrors(['Data news not found.']);
        }
        else {
            $data['form_action'] = "";
            $data['id_user'] = "";
            $data['user'] = [];
            $data['news'] = $news;

            return view('news::webview.custom_form', $data);
        }
    }

    public function formData($id, $slug)
    {
        $data = [
            'title'          => 'News',
            'sub_title'      => 'News Form Data',
            'menu_active'    => 'news',
            'submenu_active' => 'news-list',
            'news_form_structures' => [],
            'news_form_data' => [],
        ];

        $result = parent::getData(MyHelper::post('news/form-data', ['id_news' => $id]));

        if (empty($result)) {
            return back()->withErrors(['Form data news not found.']);
        }
        else {
            $data['news_form_structures'] = $result['news_form_structures'];
            $data['news_form_data'] = $result['news_form_data'];
        }

        return view('news::form_data', $data);
    }
}
