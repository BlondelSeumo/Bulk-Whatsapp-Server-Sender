(function ($) {
	"use strict";

  
    // menu item
    var arrayjson = $('#menu-data').val();
    // sortable list options
    var sortableListOptions = {
    	placeholderCss: {'background-color': "#377DFF1A"}
    };

    var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions});
    editor.setForm($('#frmEdit'));
    editor.setUpdateButton($('#btnUpdate'));
    $('#btnReload').on('click', function () {
    	editor.setData(arrayjson);
    });

    $('#btnOutput').on('click', function () {
    	var str = editor.getString();
    	$("#out").text(str);
    });

    $("#btnUpdate").on('click',function(){
    	if ($('#text').val() != '' && $('#href').val() != '') {
    		editor.update();
    	}	
    });

    $('#btnAdd').on('click',function(){
    	if ($('#text').val() != '' && $('#href').val() != '') {
    		editor.add();
    	}
    	
    });

    $('#form-button').on('click',function(){
    	$("#data").val(editor.getString());
    })
    editor.setData(arrayjson);
})(jQuery);	