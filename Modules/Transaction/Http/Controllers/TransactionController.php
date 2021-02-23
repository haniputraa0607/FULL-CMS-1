<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\URL;

use App\Lib\MyHelper;
use Session;

class TransactionController extends Controller
{

	public function banksList(Request $request){
		$data = [
            'title'          => 'Bank List',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'bank',
            'submenu_active' => 'bank'
        ];

        $lists = MyHelper::get('transaction/manualpayment/bank');
		// print_r($lists);exit;
        if (isset($lists['status']) && $lists['status'] == 'success') {
            $data['lists'] = $lists['result'];
        } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
            return back()->withErrors($lists['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        return view('transaction::payment.bankList', $data);
	}

	public function banksDelete($id) {
        $delete = MyHelper::post('transaction/manualpayment/bank/delete', ['id' => $id]);
        return parent::redirect($delete, 'Bank has been deleted');
    }

	public function banksCreate(Request $request) {
        $post = $request->except('_token');
        $save = MyHelper::post('transaction/manualpayment/bank/create', $post);
        return parent::redirect($save, 'Bank has been created.');
    }

	public function banksMethodList(Request $request){
		 $data = [
            'title'          => 'Payment Method List',
            'menu_active'    => 'bank-method',
            'sub_title'      => 'bank-method',
            'submenu_active' => 'bank-method'
        ];

        $lists = MyHelper::get('transaction/manualpayment/bankmethod');

        if (isset($lists['status']) && $lists['status'] == 'success') {
            $data['lists'] = $lists['result'];
        } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
            return back()->withErrors($lists['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        return view('transaction::payment.bankMethodList', $data);
	}

	public function bankMethodsDelete($id) {
        $delete = MyHelper::post('transaction/manualpayment/bankmethod/delete', ['id' => $id]);
        return parent::redirect($delete, 'Payment Method has been deleted');
    }

	public function bankMethodsCreate(Request $request) {
        $post = $request->except('_token');
        $save = MyHelper::post('transaction/manualpayment/bankmethod/create', $post);
        return parent::redirect($save, 'Payment Method has been created.');
    }

    public function ruleTransaction() {
        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Rule Transaction',
            'submenu_active' => 'transaction-rule'
        ];

        $list = MyHelper::get('transaction/rule');

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['trash'] = [];
            $attrKey = [];
            $attrColor = [];
            foreach ($list['result']['grand_total'] as $key => $id) {
                if ($list['result']['grand_total'][$key] == 'subtotal') {
                    $data['button'][$key] = '<button id="subtotal" type="button" class="button-drag btn blue-hoki">Subtotal <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'service') {
                    $data['button'][$key] = '<button id="service" type="button" class="button-drag btn blue-madison" draggable="true" ondragstart="drag(event)">Service <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'discount') {
                    $data['button'][$key] = '<button id="discount" type="button" class="button-drag btn green-meadow" draggable="true" ondragstart="drag(event)">Discount <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'shipping') {
                    $data['button'][$key] = '<button id="shipping" type="button" class="button-drag btn btn-success" draggable="true" ondragstart="drag(event)">Shipping <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'tax') {
                    $data['button'][$key] = '<button id="tax" type="button" class="button-drag btn yellow-crusta" draggable="true" ondragstart="drag(event)">Tax <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i></button>';
                } else {
                    $data['button'][$key] = '<button type="button" id="'.$list['result']['grand_total'][$key].'" class="button-drag btn grey-cascade">Empty <i class="fa fa-question-circle tooltips" data-original-title="Value kosong" data-container="body"></i></button>';

                    if ($list['result']['grand_total'][$key] == 'emptyservice') {
                        $trash = '<button id="service" type="button" class="button-drag btn blue-madison" draggable="true" ondragstart="drag(event)">Service <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    } elseif ($list['result']['grand_total'][$key] == 'emptydiscount') {
                        $trash = '<button id="discount" type="button" class="button-drag btn green-meadow" draggable="true" ondragstart="drag(event)">Discount <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    } elseif ($list['result']['grand_total'][$key] == 'emptyshipping') {
                        $trash = '<button id="shipping" type="button" class="button-drag btn btn-success" draggable="true" ondragstart="drag(event)">Shipping <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    } else {
                        $trash = '<button id="tax" type="button" class="button-drag btn yellow-crusta" draggable="true" ondragstart="drag(event)">Tax <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    }
                }
            }

            $countData = count($list['result']['service']['data']) - 1;

            foreach ($list['result']['service']['data'] as $row => $value) {
                unset($list['result']['service']['data'][0]);
                unset($list['result']['service']['data'][$countData]);
                unset($list['result']['service']['data'][$countData - 1]);
                unset($list['result']['service']['data'][$countData - 2]);

                if ($row != $countData || $row != $countData - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['service']['attrKey'] = $attrKey;
                    $list['result']['service']['attrColor'] = $attrColor;

                    unset($list['result']['service']['attrKey'][0]);
                    unset($list['result']['service']['attrKey'][$countData]);
                    unset($list['result']['service']['attrKey'][$countData-1]);
                    unset($list['result']['service']['attrKey'][$countData-2]);

                    unset($list['result']['service']['attrColor'][0]);
                    unset($list['result']['service']['attrColor'][$countData]);
                    unset($list['result']['service']['attrColor'][$countData-1]);
                    unset($list['result']['service']['attrColor'][$countData-2]);
                }
            }

            $data['service'] = $list['result']['service'];
            $attrKey = [];
            $attrColor = [];

            $countDataDiscount = count($list['result']['discount']['data']) - 1;

            foreach ($list['result']['discount']['data'] as $row => $value) {
                unset($list['result']['discount']['data'][0]);
                unset($list['result']['discount']['data'][$countDataDiscount]);
                unset($list['result']['discount']['data'][$countDataDiscount - 1]);
                unset($list['result']['discount']['data'][$countDataDiscount - 2]);

                if ($row != $countDataDiscount || $row != $countDataDiscount - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['discount']['attrKey'] = $attrKey;
                    $list['result']['discount']['attrColor'] = $attrColor;

                    unset($list['result']['discount']['attrKey'][0]);
                    unset($list['result']['discount']['attrKey'][$countDataDiscount]);
                    unset($list['result']['discount']['attrKey'][$countDataDiscount-1]);
                    unset($list['result']['discount']['attrKey'][$countDataDiscount-2]);

                    unset($list['result']['discount']['attrColor'][0]);
                    unset($list['result']['discount']['attrColor'][$countDataDiscount]);
                    unset($list['result']['discount']['attrColor'][$countDataDiscount-1]);
                    unset($list['result']['discount']['attrColor'][$countDataDiscount-2]);
                }
            }

            $data['discount'] = $list['result']['discount'];
            $attrKey = [];
            $attrColor = [];

            $countDataTax = count($list['result']['tax']['data']) - 1;

            foreach ($list['result']['tax']['data'] as $row => $value) {
                unset($list['result']['tax']['data'][0]);
                unset($list['result']['tax']['data'][$countDataTax]);
                unset($list['result']['tax']['data'][$countDataTax - 1]);
                unset($list['result']['tax']['data'][$countDataTax - 2]);

                if ($row != $countDataTax || $row != $countDataTax - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['tax']['attrKey'] = $attrKey;
                    $list['result']['tax']['attrColor'] = $attrColor;

                    unset($list['result']['tax']['attrKey'][0]);
                    unset($list['result']['tax']['attrKey'][$countDataTax]);
                    unset($list['result']['tax']['attrKey'][$countDataTax-1]);
                    unset($list['result']['tax']['attrKey'][$countDataTax-2]);

                    unset($list['result']['tax']['attrColor'][0]);
                    unset($list['result']['tax']['attrColor'][$countDataTax]);
                    unset($list['result']['tax']['attrColor'][$countDataTax-1]);
                    unset($list['result']['tax']['attrColor'][$countDataTax-2]);
                }
            }

            $data['tax'] = $list['result']['tax'];
            $attrKey = [];
            $attrColor = [];

            $countDataPoint = count($list['result']['point']['data']) - 1;

            foreach ($list['result']['point']['data'] as $row => $value) {
                unset($list['result']['point']['data'][0]);
                unset($list['result']['point']['data'][$countDataPoint]);
                unset($list['result']['point']['data'][$countDataPoint - 1]);
                unset($list['result']['point']['data'][$countDataPoint - 2]);

                if ($row != $countDataPoint || $row != $countDataPoint - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['point']['attrKey'] = $attrKey;
                    $list['result']['point']['attrColor'] = $attrColor;

                    unset($list['result']['point']['attrKey'][0]);
                    unset($list['result']['point']['attrKey'][$countDataPoint]);
                    unset($list['result']['point']['attrKey'][$countDataPoint-1]);
                    unset($list['result']['point']['attrKey'][$countDataPoint-2]);

                    unset($list['result']['point']['attrColor'][0]);
                    unset($list['result']['point']['attrColor'][$countDataPoint]);
                    unset($list['result']['point']['attrColor'][$countDataPoint-1]);
                    unset($list['result']['point']['attrColor'][$countDataPoint-2]);
                }
            }

            $data['point'] = $list['result']['point'];
            $attrKey = [];
            $attrColor = [];

            $countDataCashback = count($list['result']['cashback']['data']) - 1;

            foreach ($list['result']['cashback']['data'] as $row => $value) {
                unset($list['result']['cashback']['data'][0]);
                unset($list['result']['cashback']['data'][$countDataCashback]);
                unset($list['result']['cashback']['data'][$countDataCashback - 1]);
                unset($list['result']['cashback']['data'][$countDataCashback - 2]);

                if ($row != $countDataCashback || $row != $countDataCashback - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['cashback']['attrKey'] = $attrKey;
                    $list['result']['cashback']['attrColor'] = $attrColor;

                    unset($list['result']['cashback']['attrKey'][0]);
                    unset($list['result']['cashback']['attrKey'][$countDataCashback]);
                    unset($list['result']['cashback']['attrKey'][$countDataCashback-1]);
                    unset($list['result']['cashback']['attrKey'][$countDataCashback-2]);

                    unset($list['result']['cashback']['attrColor'][0]);
                    unset($list['result']['cashback']['attrColor'][$countDataCashback]);
                    unset($list['result']['cashback']['attrColor'][$countDataCashback-1]);
                    unset($list['result']['cashback']['attrColor'][$countDataCashback-2]);
                }
            }

            $data['cashback'] = $list['result']['cashback'];

            $data['outlet'] = $list['result']['outlet'];
            $data['default'] = $list['result']['default_outlet']['value'];

        } else {
            return redirect('home')->withErrors(['Something went wrong']);
        }

        return view('transaction::ruleView', $data);
    }

    public function internalCourier() {
        $attrKey = [];
        $attrColor = [];
        $data = [
            'title'          => 'Internal Courier',
            'menu_active'    => 'order',
            'sub_title'      => 'Rule',
            'submenu_active' => 'internal-courier'
        ];

        $list = MyHelper::get('transaction/courier');

        if (isset($list['status']) && $list['status'] =='success') {
            $courier = explode(' ', $list['result'][0]['value']);
            $countData = count($courier);

            foreach ($courier as $row => $value) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['courier']['attrKey'] = $attrKey;
                    $list['result']['courier']['attrColor'] = $attrColor;
                    $list['result']['courier']['courier'] = $courier;
            }

            $data['list'] = $list['result'];
        } else {
            return parent::redirect($list, 'Data not valid');
        }

        return view('transaction::courier', $data);
    }

    public function ruleTransactionUpdate(Request $request) {
        $post = $request->except('_token');

        $update = MyHelper::post('transaction/rule/update', $post);
        if ($post['key'] == 'delivery' || $post['key'] == 'outlet') {
            return parent::redirect($update, 'Setting has been updated.');
        } else {
            if (isset($update['status']) && $update['status'] == 'success') {
            return 'success';
            } elseif (isset($update['status']) && $update['status'] == 'fail') {
                return 'fail';
            } else {
                return 'abort';
            }
        }

    }

    public function manualPaymentList() {
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'List',
            'submenu_active' => 'manual-payment-method-list'
        ];

        $list = MyHelper::get('transaction/manualpayment/list');

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['list'] = $list['result'];
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return view('transaction::payment.manualPaymentList', $data)->withErrors($list['messages']);
        } else {
            return view('transaction::payment.manualPaymentList', $data)->withErrors(['Data not found']);
        }

        return view('transaction::payment.manualPaymentList', $data);
    }

    public function manualPaymentCreate() {
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'New',
            'submenu_active' => 'manual-payment-method-new'
        ];

        return view('transaction::payment.manualPaymentCreate', $data);
    }

    public function manualPaymentSave(Request $request) {
        $post = $request->except('_token');

        if (isset($post['manual_payment_logo'])) {
            $post['manual_payment_logo'] = MyHelper::encodeImage($post['manual_payment_logo']);
        }

        $save = MyHelper::post('transaction/manualpayment/create', $post);

        return parent::redirect($save, 'Manual payment has been created.');

    }

    public function manualPaymentEdit($id) {
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'Update',
            'submenu_active' => 'manual-payment-method-list'
        ];

        $edit = MyHelper::post('transaction/manualpayment/edit', ['id' => $id]);

        if (isset($edit['status']) && $edit['status'] == 'success') {
            $data['list'] = $edit['result'];
        } elseif (isset($edit['status']) && $edit['status'] == 'fail') {
            return view('transaction::payment.manualPaymentList', $data)->withErrors($edit['messages']);
        } else {
            return view('transaction::payment.manualPaymentList', $data)->withErrors(['Data not found']);
        }

        return view('transaction::payment.manualPaymentEdit', $data);
    }

    public function manualPaymentUpdate(Request $request, $id) {
        $post = $request->except('_token');

        if (isset($post['manual_payment_logo'])) {
            $post['manual_payment_logo'] = MyHelper::encodeImage($post['manual_payment_logo']);
        }

        $update = MyHelper::post('transaction/manualpayment/update', ['post' => $post, 'id' => $id]);

        return parent::redirect($update, 'Manual payment has been updated');
    }

    public function manualPaymentDetail($id) {
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'Detail',
            'submenu_active' => 'manual-payment-method-list'
        ];

        $data['id_payment'] = $id;

        $detail = MyHelper::post('transaction/manualpayment/detail', ['id' => $id]);

        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['detail'] = $detail['result'];
        } elseif (isset($detail['status']) && $detail['status'] == 'fail') {
            return back()->withErrors($detail['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        return view('transaction::payment.manualPaymentDetail', $data);
    }

    public function manualPaymentDelete($id) {
        $delete = MyHelper::post('transaction/manualpayment/delete', ['id' => $id]);
        return parent::redirect($delete, 'Manual payment has been deleted');
    }

    public function manualPaymentMethod(Request $request) {
        $post = $request->except('_token');
        $save = MyHelper::post('transaction/manualpayment/method/save', $post);
        return parent::redirect($save, 'Success');
    }

    public function manualPaymentMethodDelete(Request $request) {
        $id = $request['id'];

        $delete = MyHelper::post('transaction/manualpayment/method/delete', ['id' => $id]);

        if (isset($delete['status']) && $delete['status'] == 'success') {
            return ['status' => 'success'];
        } elseif (isset($delete['status']) && $delete['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $delete['messages']];
        } else {
            return ['status' => 'fail', 'messages' => $delete['message']];
        }
    }

    public function pointUser(Request $request) {
        $data = [
            'title'          => 'Point',
            'menu_active'    => 'point',
            'sub_title'      => 'Log',
            'submenu_active' => 'point-log',
            'date_start'     => date('Y-m-01'),
            'date_end'       => date('Y-m-d')
        ];

        $list = MyHelper::post('transaction/point?page='.$request->get('page'), $data);

        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['result']['data'])) {
                $data['point']          = $list['result']['data'];
                $data['pointTotal']     = $list['result']['total'];
                $data['pointPerPage']   = $list['result']['from'];
                $data['pointUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
                $data['pointPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            }
            else {
                $data['point']          = [];
                $data['pointTotal']     = 0;
                $data['pointPerPage']   = 0;
                $data['pointUpTo']      = 0;
                $data['pointPaginator'] = false;
            }
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return view('transaction::.log.log_point', $data)->withErrors($list['messages']);
        } else {
            return view('transaction::.log.log_point', $data)->withErrors(['Data not found']);
        }

        return view('transaction::.log.log_point', $data);
    }

    public function pointUserFilter(Request $request, $date) {
        $post = $request->all();
        if (empty($post)) {
            return redirect('transaction/point');
        }

        if ($request->get('page') == null) {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            if (isset($post['conditions'])) {
                session(['conditions' => $post['conditions']]);
                session(['rule'       => $post['rule']]);
            }
        } else {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            if (!empty(session('conditions'))) {
                $post['conditions'] = session('conditions');
                $post['rule']       = session('rule');
            }
        }

        $data = [
            'title'          => 'Point',
            'menu_active'    => 'point',
            'sub_title'      => 'Log',
            'submenu_active' => 'point-log',
            'date_start'     => $post['date_start'],
            'date_end'       => $post['date_end'],
            'rule'           => $post['rule'],
        ];

        if (isset($post['conditions'])) {
            $data['conditions'] = $post['conditions'];
        }

        $list = MyHelper::post('transaction/point/filter?page='.$request->get('page'), $data);
        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['data']['data'])) {
                $data['point']          = $list['data']['data'];
                $data['pointTotal']     = $list['data']['total'];
                $data['pointPerPage']   = $list['data']['from'];
                $data['pointUpTo']      = $list['data']['from'] + count($list['data']['data'])-1;
                $data['pointPaginator'] = new LengthAwarePaginator($list['data']['data'], $list['data']['total'], $list['data']['per_page'], $list['data']['current_page'], ['path' => url()->current()]);
            }
            else {
                $data['point']          = [];
                $data['pointTotal']     = 0;
                $data['pointPerPage']   = 0;
                $data['pointUpTo']      = 0;
                $data['pointPaginator'] = false;
            }

            $data['count']      = $list['data']['total'];
            $data['rule']       = $post['rule'];
            $data['search']     = '1';

        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return back()->withErrors($list['messages']);
        } else {
            return view('transaction::.log.log_point', $data)->withErrors(['Data not found']);
        }

        return view('transaction::.log.log_point', $data);
    }

    public function balanceUser(Request $request) {
        $data = [
            'title'          => 'Balance',
            'menu_active'    => 'balance',
            'sub_title'      => 'Log',
            'submenu_active' => 'balance-log',
            'date_start'     => date('Y-m-01'),
            'date_end'       => date('Y-m-d')
        ];

        $list = MyHelper::post('transaction/balance?page='.$request->get('page'), $data);

        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['result']['data'])) {
                $data['balance']          = $list['result']['data'];
                $data['balanceTotal']     = $list['result']['total'];
                $data['balancePerPage']   = $list['result']['from'];
                $data['balanceUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
                $data['balancePaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            }
            else {
                $data['balance']          = [];
                $data['balanceTotal']     = 0;
                $data['balancePerPage']   = 0;
                $data['balanceUpTo']      = 0;
                $data['balancePaginator'] = false;
            }
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return back()->withErrors($list['messages']);
        } else {
            return view('transaction::log.log_balance', $data)->withErrors(['Data not found']);
        }

        return view('transaction::log.log_balance', $data);
    }

    public function balanceUserFilter(Request $request, $date) {
        $post = $request->all();
        if (empty($post)) {
            return redirect('transaction/balance');
        }
        // return $post;
        if ($request->get('page') == null) {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            if (isset($post['conditions'])) {
                session(['conditions' => $post['conditions']]);
                session(['rule'       => $post['rule']]);
            }
        } else {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            if (!empty(session('conditions'))) {
                $post['conditions'] = session('conditions');
                $post['rule']       = session('rule');
            }
        }

        $data = [
            'title'          => 'Balance',
            'menu_active'    => 'balance',
            'sub_title'      => 'Log',
            'submenu_active' => 'balance-log',
            'date_start'     => $post['date_start'],
            'date_end'       => $post['date_end'],
            'rule'           => $post['rule'],
        ];

        if (isset($post['conditions'])) {
            $data['conditions'] = $post['conditions'];
        }

        $list = MyHelper::post('transaction/balance/filter?page='.$request->get('page'), $data);
        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['data']['data'])) {
                $data['balance']          = $list['data']['data'];
                $data['balanceTotal']     = $list['data']['total'];
                $data['balancePerPage']   = $list['data']['from'];
                $data['balanceUpTo']      = $list['data']['from'] + count($list['data']['data'])-1;
                $data['balancePaginator'] = new LengthAwarePaginator($list['data']['data'], $list['data']['total'], $list['data']['per_page'], $list['data']['current_page'], ['path' => url()->current()]);
            }
            else {
                $data['balance']          = [];
                $data['balanceTotal']     = 0;
                $data['balancePerPage']   = 0;
                $data['balanceUpTo']      = 0;
                $data['balancePaginator'] = false;
            }

            $data['count']      = $list['data']['total'];
            $data['rule']       = $post['rule'];
            $data['search']     = '1';

        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return back()->withErrors($list['messages']);
        } else {
            return view('transaction::.log.log_balance', $data)->withErrors(['Data not found']);
        }

        return view('transaction::.log.log_balance', $data);
    }

    public function manualPaymentUnpay(Request $request, $type=null) {
        if(empty($type)){
            Session::forget('filterPaymentManual');
            $type = 'unconfirmed';
        }
        $data = [
            'title'          => 'Manual Payment Transaction',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'List',
            'submenu_active' => 'manual-payment-list',
            $type            => true,
            'type'           => $type
        ];

        $post = $request->except('_token');

        if(isset($post['page'])){
            $page =  $request->get('page');
            unset($post['page']);
        }else{
            $page = null;
        }

        if(!empty($post)){
            if(!isset($post['conditions'])){
                $post['conditions'] = [];
            }
            $data['date_start'] = $post['date_start'];
            $data['date_end'] = $post['date_end'];
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
            $data['filter'] = true;
            Session::put('filterPaymentManual',$post);

            $list = MyHelper::post('transaction/manualpayment/data/filter/'.$type, $post);

            if (isset($list['status']) && $list['status'] == 'success') {
                $data['list'] = $list['result']['data'];
                $data['page'] = $list['result']['current_page'];
                $data['to'] = $list['result']['to'];
                if(empty($data['to'])) $data['to'] = 0;
                $data['from'] = $list['result']['from'];
                if(empty($data['from'])) $data['from'] = 0;
                $data['total'] = $list['result']['total'];
            } elseif (isset($list['status']) && $list['status'] == 'fail') {
                return view('transaction::payment.manualPaymentListUnpay', $data)->withErrors(['Data not found']);
            } else {
                return view('transaction::payment.manualPaymentListUnpay', $data)->withErrors($list['messages']);
            }
        }else{
            if(!empty(Session::get('filterPaymentManual'))){
                $session = Session::get('filterPaymentManual');
                $data['date_start'] = $session['date_start'];
                $data['date_end'] = $session['date_end'];
                $data['conditions'] = $session['conditions'];
                $data['rule'] = $session['rule'];
                $data['filter'] = true;

                if(!empty($page)){
                    $list = MyHelper::post('transaction/manualpayment/data/filter/'.$type.'?page='.$page, $session);
                }else{
                    $list = MyHelper::post('transaction/manualpayment/data/filter/'.$type, $session);
                }

            }else{
                $data['date_start'] = date('Y-m-01');
                $data['date_end'] = date('Y-m-d');

                if(!empty($page)){
                    $list = MyHelper::get('transaction/manualpayment/data/'.$type.'?page='.$page);
                }else{
                    $list = MyHelper::get('transaction/manualpayment/data/'.$type);
                }
            }
            if (isset($list['status']) && $list['status'] == 'success') {
                $data['list'] = $list['result']['data'];
                $data['page'] = $list['result']['current_page'];
                $data['to'] = $list['result']['to'];
                if(empty($data['to'])) $data['to'] = 0;
                $data['from'] = $list['result']['from'];
                if(empty($data['from'])) $data['from'] = 0;
                $data['total'] = $list['result']['total'];
            } elseif (isset($list['status']) && $list['status'] == 'fail') {
                return view('transaction::payment.manualPaymentListUnpay', $data)->withErrors($list['messages']);
            } else {
                $data['list'] =[];
            }
        }
        $data['paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url('transaction/manualpayment/list/'.$type)]);

        return view('transaction::payment.manualPaymentListUnpay', $data);
    }

    public function resetFilter($type = null){
        if(empty($type)){
            $type = 'unconfirmed';
        }
        Session::forget('filterPaymentManual');
        return redirect('transaction/manualpayment/list/'.$type);
    }

    public function manualPaymentConfirm(Request $request,$id) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Manual Payment Transaction',
                'menu_active'    => 'manual-payment',
                'sub_title'      => 'Manual Payment Confirmation',
                'submenu_active' => 'manual-payment-list'
            ];

            $detail = MyHelper::post('transaction/manualpayment/data/detail', ['transaction_receipt_number' => $id]);

            if (isset($detail['status']) && $detail['status'] == 'success') {
                $data['result'] = $detail['result'];
            } else {
                return parent::redirect($detail, 'Data not valid');
            }

            return view('transaction::payment.manualPaymentConfirm', $data);
        }else{

            $confirm = MyHelper::post('transaction/manualpayment/data/confirm', $post);
            return parent::redirect($confirm, 'Transaction Payment Manual has been confirmed.');
        }

    }

    public function transactionList() {
        $data = [];
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'List Transaction',
            'submenu_active' => 'transaction-search'
        ];

        $list = MyHelper::get('transaction');

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['list'] = $list['result'];
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return view('transaction::transactionList', $data)->withErrors($list['messages']);
        } else {
            return view('transaction::transactionList', $data)->withErrors(['Data not found']);
        }

        return view('transaction::transactionList', $data);
    }

    public function transactionDetail($id, $key) {
        // $data = [];
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Detail Transaction',
            'submenu_active' => 'transaction-'.$key
        ];

        // $detail = MyHelper::post('transaction/detail', ['id_transaction' => $id, 'type' => 'trx']);
        // // return $detail;
        // if (isset($detail['status']) && $detail['status'] == 'success') {
        //     $data['data'] = $detail['result'];
        // } else {
        //     return parent::redirect($detail, 'Data not valid');
        // }

        // $grand_total = MyHelper::post('transaction/grand-total', []);
        // if (empty($grand_total)) {
        //     return view('transaction::not_found', ['messages' => ['Setting Not Found']]);
        // } else {
        //     foreach ($grand_total as $key => $value) {
        //         if ($value == 'shipping') {
        //             $grand_total[$key] = 'shipment';
        //         }

        //     }
        // }

        // $data['setting'] = $grand_total;
        // return $data;
        // return view('transaction::transactionDetail2', $data);
        // return view('transaction::transactionDetail3', $data);

        $post['id_transaction'] = $id;
        $post['type'] = 'trx';
        $post['check'] = 1;

        $check = MyHelper::post('transaction/be/detail', ['id_transaction' => $id, 'type' => 'trx', 'admin' => 1]);

        // $check = MyHelper::post('outletapp/order/detail/view?log_save=0', $data);
    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data['data'] = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        return view('transaction::transactionDetail3', $data);

    }

    public function transactionDelete($id) {
        $delete = MyHelper::post('transaction/delete', ['transaction_receipt_number' => $id]);

        return parent::redirect($delete, 'Data transaction has been delete');
    }

    public function transaction(Request $request, $key) {
        $data = [];
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'List Transaction',
            'submenu_active' => 'transaction-'.$key,
            'key'            => $key,
            'date_start'     => date('Y-m-01'),
            'date_end'       => date('Y-m-d')
        ];

        $getList = MyHelper::get('transaction/be/'.$key.'?page='.$request->get('page'));

            if (isset($getList['result']['data']) && !empty($getList['result']['data'])) {
                $data['trx']          = $getList['result']['data'];
                $data['trxTotal']     = $getList['result']['total'];
                $data['trxPerPage']   = $getList['result']['from'];
                $data['trxUpTo']      = $getList['result']['from'] + count($getList['result']['data'])-1;
                $data['trxPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
            }
            else {
                $data['trx']          = [];
                $data['trxTotal']     = 0;
                $data['trxPerPage']   = 0;
                $data['trxUpTo']      = 0;
                $data['trxPaginator'] = false;
            }

        if($getList['status'] == 'success') $data['list'] = $getList['result']; else $data['list'] = null;

        $getCity = MyHelper::get('city/list?log_save=0');
        if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;

        $getProvince = MyHelper::get('province/list?log_save=0');
        if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = null;

		$getCourier = MyHelper::get('courier/list?log_save=0');
		if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = null;

        return view('transaction::transaction.transaction_delivery', $data);
    }

    public function transactionFilter(Request $request, $key) {
        $post = $request->all();
        if (empty($post)) {
            return redirect('transaction/point');
        }

        if ($request->get('page') == null) {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            if (isset($post['conditions'])) {
                session(['conditions' => $post['conditions']]);
                session(['rule'       => $post['rule']]);
            }
        } else {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            if (!empty(session('conditions'))) {
                $post['conditions'] = session('conditions');
                $post['rule'] = session('rule');
            }
        }

        $data = [];
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'List Transaction',
            'submenu_active' => 'transaction-'.$key,
            'key'            => $key,
            'date_start'     => $post['date_start'],
            'date_end'       => $post['date_end'],
        ];

        $post['key'] = ucwords($key);
        if(!isset($post['rule'])){
            $post['rule'] = 'and';
        }
        $filter = MyHelper::post('transaction/be/filter', $post);

        if (isset($filter['status']) && $filter['status'] == 'success') {
            if (!empty($filter['data']['data'])) {

                $data['trx']          = $filter['data']['data'];
                $data['trxTotal']     = $filter['data']['total'];
                $data['trxPerPage']   = $filter['data']['from'];
                $data['trxUpTo']      = $filter['data']['from'] + count($filter['data']['data'])-1;
                $data['trxPaginator'] = new LengthAwarePaginator($filter['data']['data'], $filter['data']['total'], $filter['data']['per_page'], $filter['data']['current_page'], ['path' => url()->current()]);
            }
            else {
                $data['trx']          = [];
                $data['trxTotal']     = 0;
                $data['trxPerPage']   = 0;
                $data['trxUpTo']      = 0;
                $data['trxPaginator'] = false;
            }

            $data['list']       = $filter['data'];
            $data['conditions'] = $filter['conditions'];
            $data['count']      = $filter['count'];
            $data['rule']       = $filter['rule'];
            $data['search']     = $filter['search'];

            return view('transaction::transaction.transaction_delivery', $data);

        } elseif (isset($filter['status']) && $filter['status'] == 'fail' && isset($filter['messages'])) {
            return redirect('transaction/be/'.$key.'/'.date('Ymdhis'))->withErrors([$filter['messages']]);
        } else {
            $data['list']       = $filter['data'];
            $data['conditions'] = $filter['conditions'];
            $data['count']      = $filter['count'];
            $data['rule']       = $filter['rule'];
            $data['search']     = $filter['search'];

            return view('transaction::transaction.transaction_delivery', $data);

        }

    }

    public function adminOutlet($receipt, $phone) {
        $check = MyHelper::post('transaction/outlet', ['receipt' => $receipt, 'phone' => $phone]);

        $grand_total = MyHelper::post('transaction/grand-total', ['data' => $phone]);
        if (empty($grand_total)) {
            return view('transaction::not_found', ['messages' => ['Setting Not Found']]);
        } else {
            foreach ($grand_total as $key => $value) {
                if ($value == 'shipping') {
                    $grand_total[$key] = 'shipment';
                }

            }
        }

        $check['setting'] = $grand_total;

        if (isset($check['status']) && $check['status'] == 'success') {
            return view('transaction::admin_outlet', $check);
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('transaction::not_found', $check);
        } else {
            return view('transaction::not_found', ['messages' => ['Something Wrong']]);

        }
    }

    public function adminOutletConfirm($type, $status, $receipt, $id) {
        $update = MyHelper::post('transaction/admin/confirm', ['type' => $type, 'status' => $status, 'receipt' => $receipt, 'id' => $id]);

        if (isset($update['status']) && $update['status'] == 'success') {
            return back()->with(['success' => ['Update Success']]);
        } else {
            return back()->withErrors(['Update failed']);
        }
    }

    public function freeDelivery(Request $request) {
        $post = $request->except('_token');

        if(!empty($post)){
            $update = MyHelper::post('setting/free-delivery', $post);
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/setting/free-delivery')->with(['success' => ['Update Success']]);
            } else {
                return redirect('transaction/setting/free-delivery')->withErrors(['Update failed']);
            }
        }

        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Free Delivery',
            'submenu_active' => 'free-delivery'
        ];

        $data['result'] = [];
        $request = MyHelper::post('setting', ['key-like' => 'free_delivery']);
        if (isset($request['status']) && $request['status'] == 'success') {
            foreach($request['result'] as $key => $result){
                $data['result'][$result['key']] = $result['value'];
            }
        }

        return view('transaction::setting.free_delivery', $data);
    }

    public function goSendPackageDetail(Request $request) {
        $post = $request->except('_token');

        if(!empty($post)){
            $update = MyHelper::post('transaction/setting/go-send-package-detail', $post);
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/setting/go-send-package-detail')->with(['success' => ['Update Success']]);
            } else {
                return redirect('transaction/setting/go-send-package-detail')->withErrors(['Update failed']);
            }
        }

        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting GO-SEND Package Detail',
            'submenu_active' => 'go-send-package-detail'
        ];

        $request = MyHelper::post('setting', ['key' => 'go_send_package_detail']);
        if (isset($request['status']) && $request['status'] == 'success') {
            $data['result'] = $request['result'];
        }

        return view('transaction::setting.go_send_package', $data);
    }

    public function fakeTransaction(Request $request) {
        $post = $request->except('_token');

        if(!empty($post)){
            if(in_array(0, $post['id_user'])){
                unset($post['id_user']);
            }
            $update = MyHelper::post('transaction/dump', $post);
            // return $update;
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/create/fake')->with(['success' => ['Create '.$post['how_many'].' Data Transaction Success']]);
            } else {
                if (isset($update['errors'])) {
                    return back()->withErrors($update['errors'])->withInput();
                }

                if (isset($update['status']) && $update['status'] == "fail") {
                    return back()->withErrors($update['messages'])->withInput();
                }
                return redirect('transaction/create/fake')->withErrors(['Create Transaction Failed'])->withInput();
            }
        }

        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Create Fake Transaction',
            'submenu_active' => 'fake-transaction'
        ];

        $user = MyHelper::get('users/get-all');
        if (isset($user['status']) && $user['status'] == 'success') {
            $data['user'] = $user['result'];
        }

        return view('transaction::fake_transaction', $data);
    }

    /*================ Start POS Transaction online failed ================*/
    public function transactionPOS(Request $request) {
        $post = $request->post();
        $data = [
            'title'          => 'Transactions',
            'menu_active'    => 'transaction-online-pos',
            'sub_title'      => '[POS] All Transactions Online',
            'submenu_active' => 'transaction-online-pos-list',
            'filter_title'   => 'Filter Transaction'
        ];

        if(($post['rule']??false) && !isset($post['draw'])){
            session(['transaction_pos_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['transaction_pos_filter'=>null]);
            return back();
        }

        if(session('transaction_pos_filter')){
            $extra=session('transaction_pos_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra = [];
        }

        if ($request->wantsJson()) {
            $data = MyHelper::get('transaction/online-pos', $extra + $request->all())['result'] ?? [];
            // return \MyHelper::apiGet('product-modifier', $request->all());
            $data['recordsFiltered'] = $data['total'];
            $data['draw'] = $request->draw;
            return $data;
        }

        $outlets = MyHelper::post('outlet/be/list',['simple_result' => 1])['result'] ?? [];
        $data['outlets'] = [];

        foreach ($outlets as $outlet) {
            $data['outlets'][] = [$outlet['id_outlet'], $outlet['outlet_name']];
        }

        return view('transaction::transactionOnlinePOS.list', $data);
    }

    public function transactionFailed(Request $request) {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transactions',
            'menu_active'    => 'transaction-online-pos',
            'sub_title'      => '[POS] Transactions Online Failed',
            'submenu_active' => 'transaction-online-pos-failed'
        ];

        if ($request->wantsJson()) {
            $data = MyHelper::get('transaction/online-pos', $request->all())['result'] ?? [];
            // return \MyHelper::apiGet('product-modifier', $request->all());
            $data['recordsFiltered'] = $data['total'];
            $data['draw'] = $request->draw;
            return $data;
        }

        return view('transaction::transactionOnlinePOS.list-failed', $data);
    }

    public function getlistTransactionFailed(Request $request){
        $post = $request->except('_token');
        $draw = $post["draw"];
        $getData = MyHelper::post('transaction/online-pos',$post);

        if(isset($getData['status']) && isset($getData['status']) == 'success'){
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $getData['total'];
            $arr_result['recordsFiltered'] = $getData['total'];
            $arr_result['data'] = $getData['result'];
        }else{
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }

    public function resendTransactionFailed(Request $request){
        $post = $request->except('_token');
        $getData = MyHelper::post('transaction/online-pos/resend',$post);
        return response()->json($getData);
    }

    public function autoresponseTransactionFailed(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction-online-pos',
            'sub_title'      => '[Response] Transaction Online Failed',
            'submenu_active' => 'transaction-autoresponse-online-pos'
        ];
        $get = MyHelper::get('transaction/online-pos/autoresponse');
        if($post){
            $update = MyHelper::post('transaction/online-pos/autoresponse', $post);

            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/online-pos/autoresponse')->with(['success' => ['Update success']]);
            } else {
                if (isset($update['errors'])) {
                    return back()->withErrors($update['errors'])->withInput();
                }

                if (isset($update['status']) && $update['status'] == "fail") {
                    return back()->withErrors($update['messages'])->withInput();
                }
                return redirect('transaction/online-pos/autoresponse')->withErrors(['Update Failed']);
            }
        }else{
            if(isset($get['status']) && $get['status'] == 'success'){
                $data['result'] = $get['result'];

                $data['textreplaces'] = [];

                $custom = [];
                if (isset($get['result']['custom_text_replace'])) {
                    $custom = explode(';', $get['result']['custom_text_replace']);

                    unset($custom[count($custom) - 1]);
                }

                $data['custom'] = $custom;
            }else{
                $data['result'] = [];
            }

            return view('transaction::transactionOnlinePOS.forward_email_setting', $data);
        }
    }
    /*================ End POS Transaction online failed ================*/

    /*================ Start Setting Timer Payment Gateway ================*/
    function timerPaymentGateway(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Timer Payment Gateway',
            'submenu_active' => 'setting-timer-payment-gateway'
        ];

        if($post){
            $dataUpdate = [];
            if($post['timer_ovo'] ?? false){
                $dataUpdate['setting_timer_ovo'] = ['value', $post['timer_ovo']];
            }
            if($post['timer_shopeepay'] ?? false){
                $dataUpdate['shopeepay_validity_period'] = ['value', $post['timer_shopeepay']];
            }
            $update = MyHelper::post('setting/update2',[
                'update' => $dataUpdate
            ]);
            if(isset($update['status']) && $update['status'] == 'success'){
                return redirect('transaction/setting/timer-payment-gateway')->withSuccess(['Success update']);
            }else{
                return redirect('transaction/setting/timer-payment-gateway')->withErrors(['Failed update']);
            }
        }else{
            // setting_timer_ovo
            $data['timer_ovo'] = MyHelper::get('transaction/setting/timer-ovo')['result']['value']??'';
            $data['timer_shopeepay'] = MyHelper::post('setting',['key'=>'shopeepay_validity_period'])['result']['value']??'';
            return view('transaction::setting.timer_ovo', $data);
        }
    }
    /*================ End Setting Timer Payment Gateway ================*/
    public function availablePayment(Request $request) {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Payment Method',
            'submenu_active' => 'setting-payment-method'
        ];
        $data['payments'] = MyHelper::post('transaction/available-payment',['show_all' => 1])['result']??[];
        return view('transaction::setting.available_payment', $data);
    }
    public function availablePaymentUpdate(Request $request) {
        $post = $request->except('_token');
        $payments = [];
        foreach ($request->payments as $code => $payment) {
            $payments[] = [
                'code' => $code,
                'status' => $payment['status']??0
            ];
        }
        $data = MyHelper::post('transaction/available-payment/update',['payments' => $payments]);
        if (($data['status']??false) == 'success') {
            return back()->withSuccess(['Success update setting']);
        } else {
            return back()->withErrors(['Failed update setting']);
        }
    }

    public function availableShipment(Request $request) {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Delivery Method',
            'submenu_active' => 'setting-shipment-method'
        ];
        // return MyHelper::post('transaction/available-shipment',['show_all' => 1]);
        $data['shipments'] = MyHelper::post('transaction/available-shipment',['show_all' => 1])['result']??[];
        $settings_raw = MyHelper::post('setting',['key-like' => 'delivery_'])['result'] ?? [];
        foreach ($settings_raw as $setting) {
            $data[$setting['key']] = $setting['value'];
        }
        $data['delivery_max_cup'] = $data['delivery_max_cup'] ?? 50;
        $data['delivery_default'] = $data['delivery_default'] ?? 'price';
        return view('transaction::setting.available_shipment', $data);
    }

    public function availableShipmentUpdate(Request $request) {
        $post = $request->except('_token');
        $shipments = [];
        foreach ($request->shipments??[] as $code => $shipment) {
            $shipments[] = [
                'code' => $code,
                'status' => $shipment['status']??0
            ];
        }
        $data = MyHelper::post('transaction/available-shipment/update',[
            'deliveries' => $shipments,
            'delivery_max_cup' => $request->delivery_max_cup,
            'delivery_default' => $request->delivery_default,
        ]);
        if (($data['status']??false) == 'success') {
            return back()->withSuccess(['Success update setting']);
        } else {
            return back()->withErrors(['Failed update setting']);
        }
    }
}
