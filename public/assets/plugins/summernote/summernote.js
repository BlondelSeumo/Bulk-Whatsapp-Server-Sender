(function($) {
    "use strict";

    /*------------------------	
        Payment Form Submit
      ----------------------------*/
    $('.summernote').summernote({
        tabsize: 2,
        height: 500,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['Insert', ['link', 'picture', 'hr', 'video', 'table']],
            ['para', ['ul', 'ol', 'paragraph', 'height', 'style']],
            ['Misc', ['undo', 'redo']]

        ]
    });

    $('.summernote2').summernote({
        tabsize: 2,
        height: 350,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['Insert', ['link', 'picture', 'hr', 'video', 'table']],
            ['para', ['ul', 'ol', 'paragraph', 'height', 'style']],
            ['Misc', ['undo', 'redo']]

        ]
    });

})(jQuery);