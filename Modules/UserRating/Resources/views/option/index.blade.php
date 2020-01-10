@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .select2-selection__arrow b{
        display:none !important;
    }
    .select2-selection{
        padding-right: 0 !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }

  /* Firefox */
  input[type=number] {
      -moz-appearance:textfield;
  }
</style>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script>
    stars =['1','2','3','4','5'];
    db = {!!json_encode($data)!!};
    template = '<tr>\
    <td>\
    <div class="form-inline" style="white-space: nowrap;">\
    <select name="rule[::n::][value][]" multiple class="select2a form-control" style="width: 150px" data-placeholder="Star selected" required>\
    ::stars::\
    </select>\
    </div>\
    </td>\
    <td>\
    <div class="form-group">\
    <input type="text" class="form-control" name="rule[::n::][question]" placeholder="Question for user" value="::question::" required>\
    </div>\
    </td>\
    <td style="width: 200px">\
    ::options::\
    ::addOptionBtn::\
    <td width="1%">\
    <button type="button" data-id="::n::" class="btn red deleteRule"><i class="fa fa-trash-o"></i> Delete Rule</button>\
    </td>\
    </tr>';
    function getSelected() {
        var result = [];
        for(var i=0;i<db.length;i++){
            var vrb = db[i];
            result = result.concat(vrb.value);
        }
        return result;
    }
    function replace(template,replacer,current) {
        var last = current == db.length;
        var htmlStars = '';
        var htmlOptions = '';
        var selected = getSelected();
        for(var i=0;i<stars.length;i++){
            var vrb = stars[i];
            if(replacer.value !== null && replacer.value.includes(vrb)){
                htmlStars+='<option value="'+vrb+'" selected>'+vrb+'</option>';
            }else if(selected.indexOf(vrb)==-1){
                htmlStars+='<option value="'+vrb+'">'+vrb+'</option>';
            }
        }
        replacer.options.forEach(function(vrb,ix){
            htmlOptions+=('<div class="input-group" style="margin-bottom: 5px">\
                <input type="text" class="form-control" placeholder="Option" name="rule[::n::][options]['+ix+']" value="::option::" data-id-option="'+ix+'" required>\
                <div class="input-group-btn">\
                <button type="button" data-id="'+(current-1)+'" data-id-option="'+ix+'" class="btn red deleteOption"><i class="fa fa-times"></i></button>\
                </div>\
                </div>').replace('::option::',vrb);
        })                        
        return template.replace('::stars::',htmlStars).replace('::question::',replacer.question).replace('::options::',htmlOptions).replace('::addOptionBtn::',replacer.options.length<6?'<button type="button" data-id="::n::" class="btn blue addOption"><i class="fa fa-plus"></i> Add Option</button></td>':'').replace(/::n::/g,current-1);
    }
    function render() {
        console.log('render');
        if(!db.length){
            return addRule();
        }
        stars = ['1','2','3','4','5'];
        var html='';
        current = 0;
        db.forEach(function(vrb){
            current++;
            html+=replace(template,vrb,current);
        });
        $('#questionBody').html(html);
        $('.select2a').select2();
    }
    function addRule() {
        if(!(document.getElementById('questionForm').reportValidity())){
            return false;
        }
        if(getSelected().length >= 5){
            toastr.warning("All star already defined");
            return false;
        }
        db.push({
            'value':[],
            'question':'',
            'options':['']
        });
        if(getSelected().length >= 5){
            $('#btnAddRule').attr('disabled','disabled');
        }else{
            $('#btnAddRule').removeAttr('disabled');
        }
        render();
    }
    function addOption(id) {
        if(db[id].options.length >= 6){
            toastr.warning("Maximum options total already reached(6).");
            return false;
        }
        db[id].options.push('');
        render();
    }
    $(document).ready(function(){
        $('.select2').select2();
        render();
        $('#btnAddRule').on('click',addRule);
        $('#questionBody').on('click','.deleteRule',function(){
            db.splice($(this).data('id'),1);
            render();
        });
        $('#questionBody').on('click','.addOption',function(){
            addOption($(this).data('id'));
        });
        $('#questionBody').on('click','.deleteOption',function(){
            var oldOption = db[$(this).data('id')].options;
            oldOption.splice($(this).data('id-option'),1);
            db[$(this).data('id')].options = oldOption;
            if(!db[$(this).data('id')].options.length){
                return addOption($(this).data('id'));
            }
            render();
        });
        $('#questionBody').on('change','select,input',function(){
            var cmd = $(this).attr('name').replace('rule','db').replace(/\[([a-z]+)\]/g,"['$1']") + ' = ' + JSON.stringify($(this).val()) + ';';
            if(cmd.includes('[]')){
                cmd = cmd.replace('[]','');
            }
            eval(cmd);
            if(cmd.includes('value')){
                console.log($(this).data('state'))
                if($(this).data('state')!=='unselected'){
                    render();
                }
            }
        });
        $('#questionBody').on("select2:unselecting",'.select2a', function(e) {
            $(this).data('state', 'unselected');
        }).on("select2:opening",'.select2a', function(e) {
            if($(this).data('state')==='unselected'){
                $(this).data('state','');
                render();
                return false;
            }
        });
    });
</script>
@endsection

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{ $title }}</span>
            @if (!empty($sub_title))
            <i class="fa fa-circle"></i>
            @endif
        </li>
        @if (!empty($sub_title))
        <li>
            <span>{{ $sub_title }}</span>
        </li>
        @endif
    </ul>
</div><br>

@include('layouts.notifications')

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark sbold uppercase font-blue">Rating Option Rule</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form id="questionForm" action="#" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 100px">Star</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="questionBody">
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn blue" type="button" id="btnAddRule"><i class="fa fa-plus"></i> Add Rule</button>
                <button class="btn green" type="submit" id="btnSave"><i class="fa fa-check"></i> Save</button>
            </div>
        </form>
    </div>
</div>
@endsection