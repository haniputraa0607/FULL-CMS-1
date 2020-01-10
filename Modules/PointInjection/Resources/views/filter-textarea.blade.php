<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div id="textareaFilter" class="collapse @if($show) show @endif">
	<div class="portlet-body form">
		<div class="form-body">
			@if (isset($result))
				<label class="control-label">Add New Customer
				<br><br>
			@endif
			<div class="form-group row">
				<label class="col-md-3 control-label text-right">Phone Number</label>
				<div class="col-md-9">
                    <textarea class="form-control" name="filter_phone">{{isset($result['filter_phone'])?$result['filter_phone']:''}}{{old('filter_phone')?old('filter_phone'):''}}</textarea>
                    <p class="help-block">Comma ( , ) separated for multiple phone number</p>
				</div>
			</div>
		</div>
	</div>
</div>