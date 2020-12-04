@include('promocampaign::report_filter')
@section('report')

@yield('filter')
<table id="reportTable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Promo Code</th>
            <th>Used By</th>
            <th>Used At</th>
            <th>Receipt Number</th>
            <th>Outlet</th>
            <th>Device</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection
@section('more_script')
<script type="text/javascript">
    $('#reportTable').DataTable( {
        language: {
            aria: {
                sortAscending: ": activate to sort column ascending",
                sortDescending: ": activate to sort column descending"
            },
            emptyTable: "No data available in table",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries found",
            infoFiltered: "(filtered1 from _MAX_ total entries)",
            lengthMenu: "_MENU_ entries",
            search: "Search:",
            zeroRecords: "No matching records found"
        },
        buttons: [{
            extend: "print",
            className: "btn dark btn-outline",
            exportOptions: {
                 columns: "thead th:not(.noExport)"
            },
        }, {
          extend: "copy",
          className: "btn blue btn-outline",
          exportOptions: {
               columns: "thead th:not(.noExport)"
          },
        },{
          extend: "pdf",
          className: "btn yellow-gold btn-outline",
          exportOptions: {
               columns: "thead th:not(.noExport)"
          },
        }, {
            extend: "excel",
            className: "btn green btn-outline",
            exportOptions: {
                 columns: "thead th:not(.noExport)"
            },
        }, {
            extend: "csv",
            className: "btn purple btn-outline ",
            exportOptions: {
                 columns: "thead th:not(.noExport)"
            },
        }, {
          extend: "colvis",
          className: "btn red",
          exportOptions: {
               columns: "thead th:not(.noExport)"
          },
        }],
        responsive: {
            details: {
                type: "column",
                target: "tr"
            }
        },
        order: [0, "asc"],
        lengthMenu: [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"]
        ],
        pageLength: 10,
        dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        searching   : false,
        serverSide  : true,
        ajax: {
            url: '{{url('promo-campaign/detail/'.$result['id_promo_campaign'].'?ajax=true')}}',
            type: 'GET'
        }
    } )
</script>
@yield('child-script')
@endsection