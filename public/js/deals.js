var key = 1;
var kelas = 1;

$('.content').click(function() {
	var count = $('.content-count').length+1;
	var listItem = '\
	<div class="form-group content-count bottom-border">\
        <div id="accordion'+count+'">\
            <div class="col-md-6 content-title">\
                <div class="input-group">\
                    <span class="input-group-addon sortable-handle">\
                        <a>\
                            <i class="fa fa-arrows-v"></i>\
                        </a>\
                    </span>\
                    <input type="text" class="form-control" name="content_title[]"  placeholder="Content Title" required maxlength="20">\
                    <input type="hidden" name="id_deals_content[]" value="0">\
                    <input type="hidden" name="content_order[]" value="0">\
                    <span class="input-group-addon">\
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion'+count+'" aria-expanded="true" href="#collapse_'+count+'">\
                            <i class="fa fa-chevron-down"></i>\
                            <i class="fa fa-chevron-right"></i>\
                        </a>\
                    </span>\
                </div>\
            </div>\
            <div class="col-md-3">\
                    <input type="checkbox" class="make-switch visibility-switch" checked data-on="success" data-on-color="success" data-on-text="Visible" data-off-text="Hidden" data-size="normal" name="visible['+count+'][]">\
            </div>\
            <div class="col-md-1 p-l-30px">\
                <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline removeRepeater"><i class="fa fa-close"></i></a>\
            </div>\
            <div class="col-md-12 accordion-body collapse in" id="collapse_'+count+'">\
                <div class="form-group mt-repeater">\
                    <div>\
                        <div id="contentDetail'+count+'" class="sortable-detail-'+count+'">\
                        </div>\
                    </div>\
                </div>\
                <div class="form-group mt-repeater">\
                    <div class="p-l-40px">\
                        <a href="javascript:;" data-repeater-create class="btn btn-success" onclick="addDetail('+count+')"><i class="fa fa-plus"></i> Add new detail</a>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>';

	$('#contentTarget').append(listItem).fadeIn(3000);

    $('.visibility-switch').bootstrapSwitch();

    $('.sortable-detail-'+count).sortable({
        handle: '.sortable-detail-handle-'+count,
        connectWith: '.sortable-detail-'+count,
        axis: 'y'
    });

	$("body").on('click', ".removeRepeater", function() {
	  	var mbok = $(this).parent().parent().parent();
	  	mbok.remove();
	});
});

function addDetail(no) {
	var count = $('#contentDetail'+no+' > div').length;
	var id = count;
	var result = id+1;

	var listDetail = '\
    <div class="detail'+result+''+no+'">\
        <div data-repeater-item class="mt-overflow content-detail">\
            <div class="mt-repeater-cell">\
                <div class="col-md-1 sortable-detail-handle-'+no+'">\
                    <a href="javascript:;" class="btn btn-grey "><i class="fa fa-arrows-v"></i></a>\
                </div>\
                <div class="col-md-9 p-l-30px">\
                    <textarea type="text" placeholder="Content Detail" class="form-control" name="content_detail['+no+'][]" required style="resize:vertical;"/></textarea>\
                    <input type="hidden" name="content_detail_order['+no+'][]" value="0">\
                    <input type="hidden" name="id_content_detail['+no+'][]" value="0">\
                </div>\
                <div class="col-md-1">\
                    <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteDetail('+result+''+no+')">\
                        <i class="fa fa-close"></i>\
                    </a>\
                </div>\
            </div>\
        </div>\
    </div>';

	$('#contentDetail'+no).append(listDetail).fadeIn(3000);
}

function deleteDetail(no) {
	$('.detail'+no).remove();
}