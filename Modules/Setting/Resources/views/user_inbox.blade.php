<div class="tab-pane" id="user_inbox">
    <div class="row" style="margin-top:20px">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-blue ">
                        <i class="icon-settings font-blue ">
                        </i>
                        <span class="caption-subject bold uppercase">
                            User Inbox Setting
                        </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form action="{{url('setting/user_inbox')}}" class="form-horizontal" enctype="multipart/form-data" method="POST" role="form">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="text-right col-md-4">
                                    Inbox time limit
                                </label>
                                <div class="col-md-3">
                                	<div class="input-group">
	                                    <input class="form-control" min="0" name="inbox_max_days" type="number" value="{{$inbox_max_days}}">
                                		<span class="input-group-addon">Days</span>
                                	</div>
                                </div>
                            </div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue" id="checkBtn">Save</button>
							</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>