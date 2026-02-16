<script type="text/javascript">
    $('table[data-form="deleteForm"]').on('click', '.delete-button', function(e){
        e.preventDefault();

        var row = $(this).closest('tr');
        var id = $(this).attr('id').replace("item_","");

        var nombre = "";
        nombre = row.find('td.nombre').text();
        nombre = nombre + ' (' + id + ')';

        $("#modal-delete-title").text(nombre);
        $("#confirm_deletion_link").trigger('click');

        $('#confirm_deletion').modal({ backdrop: 'static', keyboard: false })
            .on('click', '#modal-delete-btn', function(){                
                var old_url = $('#confirm_modal_deletion_buttons_form').attr('action');
                var new_url = old_url.replace('confirm_deletion_item_id',id);
                $('#confirm_modal_deletion_buttons_form').attr('action', new_url).submit();
            });
    });
</script>

            