<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div id="csvFilter" class="collapse @if($show) show @endif">
<div class="portlet-body form">
	<div class="form-body">
		<div class="form-group row">
			<label class="col-md-3 control-label text-right">Sample File</label>
			<div class="col-md-9">
				<a href="{{Module::asset('pointinjection:sample_data.csv')}}"> <i class="fa fa-file-o"></i> Sample CSV file </a>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-md-3 control-label text-right">CSV File @if(!$show) <span class="required" aria-required="true"> * </span> @endif</label>
			<div class="col-md-9">
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="input-group input-large">
						<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
							<i class="fa fa-file fileinput-exists"></i>&nbsp;
							<span class="fileinput-filename"> </span>
						</div>
						<span class="input-group-addon btn default btn-file">
							<span class="fileinput-new"> Select file </span>
							<span class="fileinput-exists"> Change </span>
							<input type="file" name="import_file" accept=".csv" @if($type == 'csv' && !$show) required @endif> </span>
							<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>