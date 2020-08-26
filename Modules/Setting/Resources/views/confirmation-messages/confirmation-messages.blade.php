
@extends('layouts.main')

@section('page-script')
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('.appender').on('click','.appender-btn',function(){
    			var value=$(this).data('value');
    			var target=$(this).parents('.appender').data('target');
    			var newValue=$(target).val()+" "+value;
    			$(target).val(newValue);
    			$(target).focus();
    		});
    	});
    </script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Confirmation Messages</a>
		</li>
	</ul>
</div>
<br>

@include('layouts.notifications')

    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Confirmation Messages</span>
						</div>
					</div>
					<div class="portlet-body">

						<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Confirmation Messages
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil saat konfirmasi pengambilan deals" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" id="payment_messages" name="payment_messages" value="{{ old('payment_messages',$msg['payment_messages']??'') }}" required><br/>
										<div class="row appender" data-target="#payment_messages">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%deals_title%' with deals name" data-value="%deals_title%">%deals_title%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Confirmation Cash Messages
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil saat konfirmasi pembelian deals menggunakan cash" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="payment_messages_cash" value="{{ old('payment_messages_cash',$msg['payment_messages_cash']??'') }}" id="payment_messages_cash" required><br>
										<div class="row appender" data-target="#payment_messages_cash">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%cash%' with deals price cash" data-value="%cash%">%cash%</span>
											</div>
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%deals_title%' with deals name" data-value="%deals_title%">%deals_title%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Confirmation Point Messages
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil saat konfirmasi pembelian deals menggunakan point" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="payment_messages_point" value="{{ old('payment_messages_point',$msg['payment_messages_point']??'') }}" id="payment_messages_point" required><br>
										<div class="row appender" data-target="#payment_messages_point">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%point%' with deals price point" data-value="%point%">%point%</span>
											</div>
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%deals_title%' with deals name" data-value="%deals_title%">%deals_title%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Confirmation Success Messages
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil saat pembelian deals berhasil" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="payment_success_messages" value="{{ old('payment_success_messages',$msg['payment_success_messages']??'') }}" required>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Confirmation Fail Messages
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil apabila point kurang saat pembelian deals" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="payment_fail_messages" value="{{ old('payment_fail_messages',$msg['payment_fail_messages']??'') }}" required>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Confirmation Fail Messages (Ovo)
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil apabila pembelian deals dengan metode pembayaran ovo gagal" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="payment_ovo_fail_messages" value="{{ old('payment_ovo_fail_messages',$msg['payment_ovo_fail_messages']??'') }}" required>
									</div>
								</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection