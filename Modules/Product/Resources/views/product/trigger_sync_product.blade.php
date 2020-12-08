@extends('layouts.main')

@section('page-style')
@endsection

@section('page-script')
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Product</span>
                    <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Trigger Sync Product Price</span>
            </li>
        </ul>
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Trigger Sync Product Price</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="m-heading-1 border-green m-bordered">
                This page is used to trigger synchronous product price, which is usually done at night by cron.
            </div>
            <form action="{{url()->current()}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Trigger Sync Product Price</button>
            </form>
        </div>
    </div>

    <!--begin::Modal-->
	<div class="modal fade" id="m_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						New Tag
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="recipient-name" class="form-control-label">
								Tag Name:
							</label>
							<input type="text" class="form-control" id="tag_name">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary" data-dismiss="modal" id="close_modal">
						Cancel
					</button>
					<button type="button" class="btn btn-primary" id="new_tag">
						Save
					</button>
				</div>
			</div>
		</div>
	</div>
<!--end::Modal-->
@endsection