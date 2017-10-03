/**
 * 
 */

function onFileSelected(event) {
  var selectedFile = event.target.files[0];
  var reader = new FileReader();

  var imgtag = document.getElementById("myimage");
  $("#imglabel1").text(selectedFile.name);
  imgtag.title = selectedFile.name;

  reader.onload = function(event) {
    imgtag.src = event.target.result;
  };

  reader.readAsDataURL(selectedFile);
}

//imagepicker
(function ( $ ) {
	 
    $.fn.imagePicker = function( options ) {
        // Define plugin options
        var settings = $.extend({
            // Input name attribute
            name: "",
            // Classes for styling the input
            class: "form-control btn btn-default btn-block",
            // Icon which displays in center of input
            icon: "glyphicon glyphicon-plus"
        }, options );
        
        // Create an input inside each matched element
        return this.each(function() {
            $(this).html(create_btn(this, settings));
        });
 
    };
 
    // Private function for creating the input element
    function create_btn(that, settings) {
        // The input icon element
        var picker_btn_icon = $('<i class="'+settings.icon+'"></i>');
        // The actual file input which stays hidden
        var picker_btn_input = $('<input type="file" name="'+that.id+'" id="'+that.id+'" />');
        
        // The actual element displayed
        var picker_btn = $('<div class="'+settings.class+' img-upload-btn"></div>')
            .append(picker_btn_icon)
            .append(picker_btn_input);
            
        // File load listener
        picker_btn_input.change(function() {
            if ($(this).prop('files')[0]) {
                // Use FileReader to get file
                var reader = new FileReader();
                
                // Create a preview once image has loaded
                reader.onload = function(e) {
                    var preview = create_preview(that, e.target.result, settings);
                    $(that).children().hide();
                    $(that).append(preview);
                }
                
                // Load image
                reader.readAsDataURL(picker_btn_input.prop('files')[0]);
            }                
        });

        return picker_btn
    };
    
    // Private function for creating a preview element
    function create_preview(that, src, settings) {
        
            // The preview image
            var picker_preview_image = $('<img src="'+src+'" class="img-responsive img-rounded" />');
            
            // The remove image button
            var picker_preview_remove = $('<button class="btn btn-link"><small>Remove</small></button>');
            
            // The preview element
            var picker_preview = $('<div class="text-center"></div>')
                .append(picker_preview_image)
                .append(picker_preview_remove);

            // Remove image listener
            picker_preview_remove.click(function() {
                var btn = create_btn(that, settings);
                $(that).html(btn);
            });
            
            return picker_preview;
    };
    
}( jQuery ));

jQuery(document).ready(function($){

	    var desktopView = $(document).width();
	    if(desktopView >= "768"){
	        $(".nav a").removeClass("collapser");
	    }
	    else{
	        $(".nav li").removeClass("caterpian");
	    }
		//navbar
		$(".nav a").on("click", function(){
			$(".nav").find(".active").removeClass("active");
			$(this).parent().addClass("active");
			});	
		$(".collapser").on("click", function(){
			$(".navbar-collapse").collapse('hide');
		});
	    $('.img-picker').imagePicker({name: "images"});

	    $('[data-toggle="popover"]').popover(); 
});