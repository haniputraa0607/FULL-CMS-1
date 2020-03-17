@section('is-style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

	 /* INFINITE SCROLL START */
	.is-container{
		overflow: hidden;
	}
	.table-infinite{
		max-height: 75vh;
		overflow: auto;
		position: relative;
	}
	.table-infinite thead{
		position: sticky;
		top: 0;
		background: white;
		border-bottom: 1px solid grey;
	}
	.table-infinite table{
		border-collapse: separate;
		margin: 0;
	}
	.lds-facebook {
		display: inline-block;
		position: relative;
		width: 80px;
		height: 30px;
	}
	.lds-facebook div {
		display: inline-block;
		position: absolute;
		left: 8px;
		width: 16px;
		background: #32c5d2;
		animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
	}
	.lds-facebook div:nth-child(1) {
		left: 8px;
		animation-delay: -0.24s;
	}
	.lds-facebook div:nth-child(2) {
		left: 32px;
		animation-delay: -0.12s;
	}
	.lds-facebook div:nth-child(3) {
		left: 56px;
		animation-delay: 0;
	}
	@keyframes lds-facebook {
		0% {
			top: 0px;
			height: 32px;
		}
		50%, 100% {
			top: 8px;
			height: 16px;
		}
	}

	.table-infinite th[data-order]{
		cursor: pointer;
	}

	.table-infinite th[data-order] span{
		display: none;
	}

	.table-infinite th[data-order] span.sort-inactive{
		display: inline;
	}

	.table-infinite th[data-order].active span.sort-inactive{
		display: none;
	}

	.table-infinite th[data-order].active.asc span.sort-asc{
		display: inline;
	}

	.table-infinite th[data-order].active.desc span.sort-desc{
		display: inline;
	}
	 /* INFINITE SCROLL END */
</style>
@endsection
@section('is-script')
<script>
	// INFINITE SCROLL START
	var template = {
		trx: function(item){
			return `
			<tr class="page${item.page}">
				<td>${item.increment}</td>
				<td>${new Date(item.created_at).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",timeStyle:"medium",hour:"2-digit",minute:"2-digit"})}</td>
				<td><a href="{{url('transaction/detail')}}/${item.id_transaction}/${item.trasaction_type}" target="_blank">${item.transaction_receipt_number}</a></td>
				<td><a href="{{url('user/detail/')}}/${item.phone}" target="_blank">${item.name} (${item.phone})</a></td>
				<td><span class="price">${item.transaction_grandtotal}</span></td>
				<td><span class="price">${item.referrer_bonus}</span></td>
				<td><span class="price">${item.referred_bonus}</span></td>
				<td>${item.referrer_name}</td>
			</tr>
			`;
		},
		code: function(item){
			return `
			<tr class="page${item.page}">
				<td>${item.increment}</td>
				<td><a href="{{url('user/detail/')}}/${item.phone}" target="_blank">${item.name} (${item.phone})</a></td>
				<td>${item.referral_code}</td>
				<td>${item.number_transaction}</td>
				<td><span class="price">${item.cashback_earned}</span></td>
				<td><a href="{{url('referral/report/user')}}/${item.phone}" target="_blank" class="btn blue">Detail</a></td>
			</tr>
			`;
		}
	};
	function addMore(table) {
		if(!(table.data('is-last') || table.data('is-loading'))){
			table.find('tbody').append(`<tr class="loading-row"><td colspan="${table.find('thead tr').children().length}" class="text-center"><div class="lds-facebook"><div></div><div></div><div></div></div></td></tr>`);
			table.data('is-loading',1);
			$.post({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
				},
				url: table.data("url"),
				data: {
					ajax:1,
					page: table.data('page')+1,
					keyword: table.parents('.is-container').find('.search-field').val()
				},
				success: function(response){
					table.find('.loading-row').remove();
					var from = response.from;
					response.data.forEach(function(item){
						item.page = (table.data('page')+1);
						item.increment = from;
						table.find('tbody').append(template[table.data('template')](item));
						from++;
					});
					if(table.data('callback') && typeof(window[table.data('callback')]) == 'function'){
						window[table.data('callback')](table,response);
					}
					if(response.last_page){
						table.find('tbody').append(`<tr class="loading-row"><td colspan="${table.find('thead tr').children().length}" class="text-center text-muted">${(table.data('page')+1 == 1 && response.data.length == 0)?'No Data Found':'End'}</td></tr>`);
						table.data('is-last',1);
					}else{
						table.data('is-loading',0);
						table.data('page',(table.data('page')+1));
						table.parents('.table-infinite').trigger('scroll');
					}
				},
				error: function(event){
					table.find('.loading-row').remove();
					table.find('tbody').append(`<tr class="loading-row"><td colspan="${table.find('thead tr').children().length}" class="text-center text-muted">Failed fetch data. <a href="{{url()->current()}}">Reload page</a></td></tr>`);
					table.data('is-last',1);
					table.data('is-loading',0);
				}
			});
		}
	}
	function ISReset(table) {
		table.find('tbody').html('');
		table.data('page',0);
		table.data('is-loading',0);
		table.data('is-last',0);
		$('.table-infinite').trigger('scroll');
	}
	$(document).ready(function(){
		$('.table-infinite').on('scroll resize', function(){
			var s = $(this).scrollTop();
			var table = $(this).find('table');
			var d = table.height();
			var c = $(this).height();
			var maxRefresh = c/2;
			var bottom = d - (s + c);
		    //var scrollPercent = (s / (d - c)) * 100;
		    if(bottom <= maxRefresh && (maxRefresh > 0 || table.data('page') < 1)){
		    	addMore(table);
		    }
		})
		$('.table-infinite').trigger('scroll');
		$('.table-infinite').on('click','th',function(){
			if($(this).data('order')){
				var postdata = {
					order_by : $(this).data('order'),
					order_sorting : $(this).data('order_sorting')?'asc':'desc',
					'_token' : "{{csrf_token()}}",
					type: $(this).parents('table').data('template'),
					ajax:true
				};
				$(this).parents('table').find('th').removeClass('active');
				$(this).parents('table').find('th').removeClass('asc');
				$(this).parents('table').find('th').removeClass('desc');
				$(this).addClass('active');
				$(this).addClass($(this).data('order_sorting')?'asc':'desc');
				$(this).data('order_sorting',!$(this).data('order_sorting'));
				$.post({
					url: "{{url('referral/report')}}",
					data: postdata,
					success:response => {
						if(response.status == 'success'){
							ISReset($(this).parents('table'));
						}else{
							alert("Failed apply filter");
						}
					},
					error: function(err){
						alert("Failed apply filter");
					}
				});				
			}
		});
		$('.is-container .filter-form').on('submit',function(e){
			e.preventDefault();
			ISReset($(this).parents('.is-container').find('table'));
		});
		$('.table-infinite th[data-order]').prepend('<span class="sort-inactive"><i class="fa fa-sort text-muted"></i></span><span class="sort-asc"><i class="fa fa-sort-alpha-asc"></i></span><span class="sort-desc"><i class="fa fa-sort-alpha-desc"></i></span> ');
	});
	// INFINITE SCROLL END	
</script>
@endsection
