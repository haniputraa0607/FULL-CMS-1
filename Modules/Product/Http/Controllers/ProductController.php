<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Excel;
use Session;

use App\Exports\ArrayExport;
use App\Exports\MultisheetExport;
use App\Imports\ExcelImport;
use App\Imports\FirstSheetOnlyImport;

class ProductController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
        $this->tag  = "Modules\Product\Http\Controllers\TagController";
    }

    // get category and position
    public function positionAssign(Request $request) {
        $data = [
            'title'          => 'Manage Product Position',
            'sub_title'      => 'Assign Products Position',
            'menu_active'    => 'product',
            'submenu_active' => 'product-position',
        ];

        $catParent = MyHelper::get('product/category/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        }
        else {
            $data['category'] = [];
        }

        $product = MyHelper::get('product/list');

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        // dd($data);

        return view('product::product.product-position', $data);
    }

    // ajax sort product
    public function positionProductAssign(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['product_ids'])) {
            return [
                'status' => 'fail',
                'messages' => ['Product id is required']
            ];
        }
        $result = MyHelper::post('product/position/assign', $post);

        return $result;
    }

    public function categoryAssign(Request $request) {
		$post = $request->except('_token');

		$data = [
            'title'          => 'Manage Product Category',
            'sub_title'      => 'Assign Products to Categories',
            'menu_active'    => 'product',
            'submenu_active' => 'product-category',
        ];

		if (!empty($post)) {
			$update = MyHelper::post('product/category/assign', $post);

			if (isset($update['status']) && $update['status'] == 'success') {
				// print_r($update);exit;
				return parent::redirect($update, 'Product categories has been updated.', 'product/category/assign');
			} elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
				return back()->withErrors($update['messages']);
			} else {
				return back()->witherrors(['Update Failed']);
			}
		}

		$catParent = MyHelper::get('product/category/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        }
		else {
            $data['category'] = [];
        }

        $product = MyHelper::get('product/list');

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }

        return view('product::product.product-category', $data);

	}

    public function importProduct() {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Import Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-import',
        ];

        return view('product::product.import', $data);
    }

    public function example()
    {
        $listProduct = MyHelper::get('product/list');
        $listOutlet = MyHelper::post('outlet/list', ['admin' => 1, 'type' => 'export']);
        $dataPrice = [];

        if (isset($listProduct['status']) && $listProduct['status'] == 'fail') {
            $dataProduct = [];
        } elseif (!isset($listProduct['status'])) {
            return back()->witherrors(['Something went wrong']);
        } else {
            $dataProduct = $listProduct;
        }

        if (isset($listOutlet['status']) && $listOutlet['status'] == 'fail') {
            $dataOutlet = [];
        } elseif (!isset($listOutlet['status'])) {
            return back()->witherrors(['Something went wrong']);
        } else {
            $dataOutlet = $listOutlet;
        }

        if (!empty($dataOutlet)) {
            $dataOutlet = json_decode(json_encode($listOutlet['result'], JSON_NUMERIC_CHECK), true);
        }

        if (!empty($dataProduct)) {
            foreach ($listProduct['result'] as $key => $value) {
                unset($listProduct['result'][$key]['id_product']);
                unset($listProduct['result'][$key]['id_product_category']);
                unset($listProduct['result'][$key]['created_at']);
                unset($listProduct['result'][$key]['updated_at']);
                unset($listProduct['result'][$key]['product_category']);
                unset($listProduct['result'][$key]['product_discounts']);
                unset($listProduct['result'][$key]['photos']);
            }

            $dataProduct = json_decode(json_encode($listProduct['result'], JSON_NUMERIC_CHECK), true);
        } else {

            $dataProduct[] = [
                'product_code'        => null,
                'product_name'        => null,
                'product_name_pos'    => null,
                'product_description' => null,
                'product_video'       => null,
                'product_weight'      => null,
            ];

            $dataProduct = json_decode(json_encode($dataProduct, JSON_NUMERIC_CHECK), true);
            return Excel::download(new ArrayExport($dataProduct),'product');
        }
        $excelData=[];
        // $excelData['Product']=$dataProduct;
        $excelData['Product']=array_map(function($x){
            // $x['category']=$x['category']['product_category_name'];
            $x['category']=$x['category']['id_product_category'];
            // $x['product_purchase_limitations']=$x['product_purchase_limitations']['product_purchase_limitation'];
            unset($x['product_purchase_limitations']);
            return $x;
        }, $dataProduct);
        //return $dataOutlet;
        foreach ($dataOutlet as $key => $value) {
            foreach ($value['product_prices'] as $row => $price) {
                $data = [
                    'product_code'       => $price['product']['product_code'],
                    'outlet_code'        => $value['outlet_code'],
                    'product_price'      => $price['product_price'],
                    'product_visibility' => $price['product_visibility']
                ];

                array_push($dataPrice, $data);
            }
            $outlet_name = substr($value['outlet_name'],0,31);
            $excelData[$outlet_name]=$dataPrice;
            $dataPrice = [];
        }
        return Excel::download(new MultisheetExport($excelData),'products.xlsx');
    }

    public function importProductSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product/import', ['data' => $data]);
            }
        }

        return parent::redirect($import, 'Product has been updated.', 'product');
    }

    /**
     * get category
     */
    function category() {
        $data = [];

        $catParent = MyHelper::get('product/category/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            return $data = $catParent['result'];
        }
        return $data;
    }

    /**
     * create product
     */
    function create(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'New Product',
                'menu_active'    => 'product',
                'submenu_active' => 'product-new',
            ];

            $data['parent'] = $this->category();
            $tags = MyHelper::get('product/tag/list');
            $data['tags'] = parent::getData($tags);
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            return view('product::product.create', $data);
        }
        else {
            if (isset($post['next'])) {
                $next = 1;
                unset($post['next']);
            }

            if (isset($post['id_product_category']) && $post['id_product_category'] == 0) {
                unset($post['id_product_category']);
            }

            // print_r($post);exit;

            if (isset($post['photo'])) {
                $post['photo']      = MyHelper::encodeImage($post['photo']);
            }

            $save = MyHelper::post('product/create', $post);

            if (isset($save['status']) && $save['status'] == 'success') {
                if (isset($post['id_tag']))  {
                    $saveRelation = app($this->tag)->createProductTag($save['result']['id_product'], $post['id_tag']);
                }
            }

            if (isset($next)) {
                return parent::redirect($save, 'Product has been created.', 'product/detail/'.$post['product_code'].'#photo');
            }
            else {
                return parent::redirect($save, 'Product has been created.');
            }
        }
    }

    /**
     * list
     */
    function listProduct(Request $request) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list',
        ];

        $product = MyHelper::post('product/list', ['admin_list' => 1]);
		// print_r($product);exit;
        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        // dd($data);

        return view('product::product.list', $data);

    }

	function listProductAjax(Request $request) {
        $product = MyHelper::get('product/list?log_save=0');

        if (isset($product['status']) && $product['status'] == "success") {
            $data = $product['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }

    /**
     * detail
     */
    function detail(Request $request, $code) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Product Detail',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list',
        ];

        $product = MyHelper::post('product/list', ['product_code' => $code, 'outlet_prices' => 1]);
        // dd($product);
        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $e = ['e' => 'Data product not found.'];
            return back()->witherrors($e);
        }

        $post = $request->except('_token');

        if (empty($post)) {
            $data['parent'] = $this->category();
            $tags = MyHelper::get('product/tag/list');
            $data['tags'] = parent::getData($tags);
			$outlet = MyHelper::post('outlet/list', ['admin' => 1, 'id_product' => $data['product'][0]['id_product']]);
            // return $outlet;
			if (isset($outlet['status']) && $outlet['status'] == 'success') {
				$data['outlet'] = $outlet['result'];
            }

            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];

            $nextId = MyHelper::get('product/next/'.$data['product'][0]['id_product']);
            if (isset($nextId['result']['product_code'])) {
                $data['next_id'] = $nextId['result']['product_code'];
            }
            else {
                $data['next_id'] = null;
            }

			// dd($outlet);exit;

            return view('product::product.detail', $data);
        }
        else {
			// print_r($post);exit;

			 /**
             * update info
             */
            if (isset($post['id_product_category'])) {
                // kalo 0 => uncategorize
                if ($post['id_product_category'] == 0  || empty($post['id_product_category'])) {
                    $post['id_product_category'] = null;
                }

                if (isset($post['photo'])) {
                    $post['photo'] = MyHelper::encodeImage($post['photo']);
                }

                // update data
                $save = MyHelper::post('product/update', $post);

                unset($post['photo']);

                // update product tag
                if (isset($save['status']) && $save['status'] == 'success') {
                    // delete dulu
                    $deleteRelation = app($this->tag)->deleteAllProductTag($post['id_product']);
					// print_r($deleteRelation);exit;
                    // baru simpan
                    if (isset($post['id_tag']))  {
                        $saveRelation = app($this->tag)->createProductTag($post['id_product'], $post['id_tag']);
                    }
                }

                return parent::redirect($save, 'Product info has been updated.', 'product/detail/'.$post['product_code'].'#info');
            }

            /**
             * jika price
             */
			if (isset($post['product_visibility'])) {
				$save = MyHelper::post('product/price/update', $post);
				// print_r($save);exit;
                return parent::redirect($save, 'Product price & visibility setting has been updated.', 'product/detail/'.$code.'#price');
			}

			/**
             * jika diskon
             */
            if (isset($post['type_disc'])) {
                unset($post['type_disc']);

                $post = array_filter($post);

                if (isset($post['discount_days'])) {
                    $post['discount_days'] = implode(",", $post['discount_days']);
                }

                if (isset($post['discount_time_start'])) {
                    $post['discount_time_start'] = date('H:i:s', strtotime($post['discount_time_start']));
                }

                if (isset($post['discount_time_end'])) {
                    $post['discount_time_end'] = date('H:i:s', strtotime($post['discount_time_end']));
                }

                $save = MyHelper::post('product/discount/create', $post);
                return parent::redirect($save, 'Product discount has been added.', 'product/detail/'.$code.'#discount');
            }

            /**
             * jika foto
             */
            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo']);
                /**
                 * save
                 */
                $save          = MyHelper::post('product/photo/create', $post);
                return parent::redirect($save, 'Product photo has been added.', 'product/detail/'.$code.'#photo');
            }

            /**
             * jika ada id_product_photo => untuk sorting
             */
            if (isset($post['id_product_photo'])) {
                for ($x= 0; $x < count($post['id_product_photo']); $x++) {
                    $data = [
                        'id_product_photo' => $post['id_product_photo'][$x],
                        'product_photo_order' => $x+1,
                    ];

                    /**
                     * save product photo
                     */
                    $save = MyHelper::post('product/photo/update', $data);

                    if (!isset($save['status']) || $save['status'] != "success") {
                        return redirect('product/detail/'.$code.'#photo')->witherrors(['Something went wrong. Please try again.']);
                    }
                }

                return redirect('product/detail/'.$code.'#photo')->with('success', ['Photo\'s order has been updated']);
            }

        }
    }

    /**
     * delete photo
     */
    function deletePhoto(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('product/photo/delete', ['id_product_photo' => $post['id_product_photo']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /**
     * delete discount
     */
    function deleteDiscount(Request $request) {
        $post   = $request->all();
        $delete = MyHelper::post('product/discount/delete', ['id_product_discount' => $post['id_product_discount']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /**
     * update
     */
    function update(Request $request) {
        $post = $request->except('_token');
        $save = MyHelper::post('product/update', $post);

        if (isset($save['status']) && $save['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /**
     * delete product
     */
    function delete(Request $request) {
        $post = $request->except('_token');
        $delete = MyHelper::post('product/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    public function price(Request $request, $key = null)
    {
        $data = [
            'title'          => 'Order',
            'sub_title'      => 'Outlet Product Price',
            'menu_active'    => 'product-price',
            'submenu_active' => 'product-price',
        ];

        $post = $request->except('_token');
        if(isset($post['page'])){
            $page = $post['page'];
            unset($post['page']);
        }

        if(array_key_exists('product_name', $post)){
            if($post['product_name'] != NULL){
                $data['product_name'] = $post['product_name'];
                Session::put('search_product_name',  $data['product_name']);
            }else{
                Session::forget('search_product_name');
            }
        }
        unset($post['product_name']);

        if ($post) {
            return $this->priceProcess($post);
        }
        $data['admin'] = 1;
        $outlet = MyHelper::post('outlet/list', $data);
        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlet'] = $outlet['result'];
        } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
            return back()->witherrors([$outlet['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        $data['pagination'] = true;
        $data['orderBy'] = 'product_name';

        if(!isset($data['product_name']) && Session::get('search_product_name')){
            $data['product_name'] = Session::get('search_product_name');
        }

        if(isset($page)){
            $product = MyHelper::post('product/list?page='.$page, $data);
        }else{
            $product = MyHelper::post('product/list', $data);
        }
        if (isset($product['status']) && $product['status'] == 'success') {
            $data['product'] = $product['result']['data'];
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlet'][0]['id_outlet'];
        }

        return view('product::product.price', $data);
    }

    /* PROSES HARGA */
    function priceProcess($post)
    {
        $price = array_filter($post['price']);
        if (!empty($price)) {
            foreach ($price as $key => $value) {
                $data = [
                    'id_product'            => $post['id_product'][$key],
                    'product_price'         => $value,
                    'product_price_base'    => $post['price_base'][$key],
                    'product_price_tax'     => $post['price_tax'][$key],
                    'product_visibility'    => $post['visible'][$key],
                    'product_stock_status'  => $post['product_stock_status'][$key],
                    'id_outlet'             => $post['id_outlet'],
                ];
                $save = MyHelper::post('product/prices', $data);
                if (isset($save['status']) && $save['status'] != "success") {
                    return back()->witherrors(['Product price failed to update']);
                }
            }
        }

        return back()->with('success', ['Product price has been updated.']);
    }

    public function updateAllowSync(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('product/update/allow_sync', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update product allow sync'];
        }
    }

    public function updateVisibility(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('product/update/visibility/global', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update product visibility'];
        }
    }

    public function visibility(Request $request, $key = null)
    {
        $visibility = strpos(url()->current(), 'visible');
        if($visibility <= 0){
            $visibility = 'Hidden';
        }else{
            $visibility = 'Visible';
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => $visibility.' Product List',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list-'.lcfirst($visibility),
            'visibility'     => $visibility
        ];

        $post = $request->except('_token');

        if($key == null && empty($post)){
            Session::forget('idVisibility');
            Session::forget('idVisibility_allOutlet');
            Session::forget('idVisibility_allProduct');
        }

        if(isset($post['page'])){
            $page = $post['page'];
            unset($post['page']);
        }else{
            $page = null;
        }

        // Proses update visibility
        if ($post) {
            $ses = Session::get('idVisibility');
            if($ses){
                if(!$page) $page = 1;
                foreach ($ses as $key => $value1) {
                    foreach ($value1 as $i => $value2) {
                       foreach ($value2 as $j => $value) {
                            if($key == (int)$post['key'] && $i == (int)$page){
                            }else{
                                $post['id_visibility'][] = $value;
                           }
                       }
                    }
                }
            };
            if($visibility == 'Hidden'){
                $post['visibility'] = 'Visible';
            }else{
                $post['visibility'] = 'Hidden';
            }
            $save = MyHelper::post('product/update/visibility', $post);
            Session::forget('idVisibility');
            Session::forget('idVisibility_allOutlet');
            Session::forget('idVisibility_allProduct');
            if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Product visibility has been updated.', 'product/'.strtolower($visibility).'/'.$post['key']);
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }

                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }

        }

        $outlet = MyHelper::get('outlet/list');
        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlet'] = $outlet['result'];
        } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
            return back()->witherrors([$outlet['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlet'][0]['id_outlet'];
        }

        if($page){
            $product = MyHelper::post('product/list?page='.$page, ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = $page;
        }else{
            $product = MyHelper::post('product/list', ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = 1;
        }
        // dd($product);
        if(Session::get('idVisibility')){
            $ses = Session::get('idVisibility');
            if(isset($ses[$data['key']]) && isset($ses[$data['key']][$data['page']])){
                $data['id_visibility'] = $ses[$data['key']][$data['page']];
            }else{
                $data['id_visibility'] = [];
            }
        }else{
            $data['id_visibility'] = [];
        }

        if(!empty(Session::get('idVisibility_allOutlet'))){
            $data['allOutlet'] = Session::get('idVisibility_allOutlet');
        }

        if(!empty(Session::get('idVisibility_allProduct'))){
            $ses = Session::get('idVisibility_allProduct');
            if(isset($ses[$data['key']]))
            $data['allProduct'] = $ses[$data['key']];
        }

        if (isset($product['status']) && $product['status'] == 'success') {
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
            $data['product'] = $product['result']['data'];
            $data['total'] = $product['result']['total'];
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }
        return view('product::product.visibility', $data);
    }

    // menyimpan id_product & id_outlet yang di select ke session
    public function addIdVisibility(Request $request)
    {
        $post = $request->except('_token');
        $idVisibility = Session::get('idVisibility');
        $ses_allProduct = Session::get('idVisibility_allProduct');
        $countProduct = 0;

        if($post['checked'] == "true"){
            // select all product in all outlet
            if(isset($post['allOutlet'])){
                Session::put('idVisibility_allOutlet', true);
                $outlet = MyHelper::get('outlet/list');
                if (isset($outlet['status']) && $outlet['status'] == 'success') {
                    foreach ($outlet['result'] as $o => $dataOutlet) {
                        $ses_allProduct[$dataOutlet['id_outlet']] = true;
                        $product = MyHelper::post('product/list', ['visibility' => $post['visibility'], 'id_outlet' => $dataOutlet['id_outlet']]);
                        if (isset($product['status']) && $product['status'] == 'success') {
                            $page = 1;
                            $i = 1;
                            $idVisibility[$dataOutlet['id_outlet']][$page] = [];
                            foreach ($product['result'] as $key => $value) {
                                $idVisibility[$dataOutlet['id_outlet']][$page][] = $value['id_product'].'/'.$dataOutlet['id_outlet'];
                                if($i % 10 == 0){
                                    $page++;
                                }
                                $i++;
                                $countProduct++;
                            }
                        }
                    }
                }
            }
            // select all product in 1 outlet
            else if(isset($post['allProduct'])){
                $ses_allProduct[$post['key']] = true;
                Session::put('idVisibility_allProduct',$ses_allProduct);
                $product = MyHelper::post('product/list', ['visibility' => $post['visibility'], 'id_outlet' => $post['key']]);
                if (isset($product['status']) && $product['status'] == 'success') {
                    $page = 1;
                    $i = 1;
                    $idVisibility[$post['key']][$page] = [];
                    foreach ($product['result'] as $key => $value) {
                        $idVisibility[$post['key']][$page][] = $value['id_product'].'/'.$post['key'];
                        if($i % 10 == 0){
                            $page++;
                        }
                        $i++;
                        $countProduct++;
                    }
                }
            }else{
                $idVisibility[$post['key']][$post['page']] = explode(',',$post['id_visibility']);
            }
        }
        // for uncheck
        else{
            if(isset($post['allOutlet'])){
                $idVisibility = null;
                Session::forget('idVisibility');
                Session::forget('idVisibility_allOutlet');
                Session::forget('idVisibility_allProduct');
            } else if(isset($post['allProduct'])){
                unset($idVisibility[$post['key']]);
                unset($ses_allProduct[$post['key']]);
                Session::forget('idVisibility_allOutlet');
            }
        }
        Session::put('idVisibility_allProduct',$ses_allProduct);
        Session::put('idVisibility', $idVisibility);
        return Session::get('idVisibility');
    }

    public function photoDefault(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'Photo Default',
                'menu_active'    => 'product',
                'submenu_active' => 'product-photo-default',
            ];

            $data['photo'] = env('S3_URL_API').'img/product/item/default.png?';

            return view('product::product.photo-default', $data);
        }else{
            $post['photo'] = MyHelper::encodeImage($post['photo']);
            $default = MyHelper::post('product/photo/default', ['photo' => $post['photo']]);
            if (isset($default['status']) && $default['status'] == 'success') {
                return parent::redirect($default, 'Product Photo Default has been updated.', 'product/photo/default');
            } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
                return back()->witherrors([$outlet['messages']]);
            } else {
                return back()->witherrors(['Product Not Found']);
            }
        }
    }

    public function updateVisibilityProduct(Request $request){
        $post = $request->except('_token');
        $post['id_visibility'] = explode(',', $post['id_visibility']);
        $save = MyHelper::post('product/update/visibility', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            $data = ['status' => 'success'];
        }
        else {
            $data = ['status' => 'fail'];
            if(isset($save['messages'])){
                $data['messages'] = $save['messages'];
            }
        }
		return response()->json($data);
    }

}
