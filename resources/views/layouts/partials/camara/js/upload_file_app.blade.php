<script type="text/javascript">    

    $("#open_camara_modal").click(function(){
        $('#upload_image_form').trigger("reset");
        $('#fileUploaded').attr('src','');
        $('#factura_section').hide();
    });

    $("#save_image").click(function() {           
        $('#fileUploaded').attr('src','');
        $('#upload_image_form').trigger("submit");
    });

    function saveUploadedFileURL(input) {     
        
        $('#save_image').removeAttr('hidden');  
        $('#fileUploaded').attr('src', "");

        var formdata = false;
        if (window.FormData) {
            formdata = new FormData();
        }

        if (input.files && input.files[0]) {
            var file = input.files[0], reader;

            if (!!file.type.match(/image.*/)) {
                if (window.FileReader) {
                    reader = new FileReader();
                    reader.onloadend = function (e) {
                        $('#fileUploaded').attr('src', e.target.result);
                        $('#fileUploaded').attr('style', 'width:98%;');
                    };
                    reader.readAsDataURL(file);
                }

               if (formdata) {
                   formdata.append("image", file);
               }
            }
        }
    }

</script>