    $(document).ready(function(){
        
        $(".droppable").sortable({
            update: function( event, ui ) {
                Dropped();
            }
        });
        $( ".droppable" ).disableSelection();

        $('.response_message').hide();
        $(".delete_page").on('click',function(e){
            e.preventDefault();
            if(confirm('Are you sure?')){
                $(this).parent('form').submit();
            }
        })
        $(".delete_banner").on('click',function(e){
            if(confirm('Are you sure want to delete this image?')){
                e.preventDefault();
                $('.banner_image').val('');
                $('.banner_image_preview').attr('src','');
                $('.banner_image_section').hide();
            }
        })
        $(".delete_user_image").on('click',function(e){
            if(confirm('Are you sure want to delete this image?')){
                e.preventDefault();
                $('.user_image').val('');
                $('.user_image_preview').attr('src','');
                $('.user_image_section').hide();
            }
        })
        $(".listing_image_delete").on('click',function(e){
            if(confirm('Are you sure?')){
                var path = $(this).attr('hrefpath');
                window.location.href = path;
            }
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".save_chart_data").click(function(e){
            e.preventDefault();
            $('.tr_values').each(function(row, tr){
                if( $(this).find('.title').val() == '' && $(this).find('.value').val() == '' ) {
                    $('.response_message').show();
                    $('.response_message').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>The title field is required.<br>The value field is required.<br></div>');
                    return false;
                }else if( $(this).find('.title').val() == '' ){
                    $('.response_message').show();
                    $('.response_message').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>The title field is required.</div>');
                    return false;
                }else if( $(this).find('.value').val() == '' ){
                    $('.response_message').show();
                    $('.response_message').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>The value field is required.<br></div>');
                    return false;
                }
            });
            var TableData = new Array();
            $('.tr_values').each(function(row, tr){
                TableData[row]={
                    "title" : $(this).find('.title').val(),
                    "legend" : $(this).find('.legend').val(),
                    "value" : $(this).find('.value').val(),
                    "colour" : $(this).find('.colour').val(),
                }
            });
            TableData = JSON.stringify(TableData);
            var url = $('.url').val();
            $.ajax({
               type:'POST',
               url:url,
               data:TableData,
               contentType: 'application/json; charset=utf-8',
               dataType: "json",
               success:function(data){
                   $('.response_message').show();
                   $('.response_message').html('<div class="alert alert-success response_message">'+data.success+'</div>');
                   console.log(data.success);
               }
            });
        });

        // Remove Partner Images
        $(".partner_image.remove").click(function(){
            if(confirm('Are you sure?')){
                $(this).parent(".pip").remove();

                var url = $(this).parent().find('.url').val();
                var id = $(this).parent().find('.stored_image_id').val();
                var count = $('#partner_total_count').val();
                if( id && id != null ){
                    $.ajax({
                        type:'POST',
                        url:url,
                        data:id,
                        contentType: 'application/json; charset=utf-8',
                        success:function(data){

                            count = count-1;
                            $('#partner_total_count').val(count);
                            var i=1;
                            $('.pip.draggable.item.ui-sortable-handle span').each( function(){
                                $(this).parent().find('.stored_image_id').attr("name",'');
                                $(this).parent().find('.stored_image_id').attr("name",'stored_image_id_'+i);
                                i++;
                            });
                        }
                    });
                }
            }
        });

        // Remove Programme Images
        $(".programme_image.remove").click(function(){
            if(confirm('Are you sure?')){
                $(this).parent(".pip").remove();

                var url = $(this).parent().find('.url').val();
                var id = $(this).parent().find('.stored_image_id').val();
                var count = $('#programme_total_count').val();
                if( id && id != null ){
                    $.ajax({
                        type:'POST',
                        url:url,
                        data:id,
                        contentType: 'application/json; charset=utf-8',
                        success:function(data){

                            count = count-1;
                            $('#programme_total_count').val(count);
                            var i=1;
                            $('.pip.draggable.item.ui-sortable-handle span').each( function(){
                                $(this).parent().find('.stored_image_id').attr("name",'');
                                $(this).parent().find('.stored_image_id').attr("name",'stored_image_id_'+i);
                                i++;
                            });
                        }
                    });
                }
            }
        });
        // Partner Image Upload Preview
        if (window.File && window.FileList && window.FileReader) {
            $("#partner_files").on("change", function(e) {
                var files = e.target.files,
                filesLength = files.length;
                var count = $("#partner_total_count").val();
                for (var i = 0; i < filesLength; i++) {
                    count++;
                    setupReader(files[i],count);
                }
                $('#partner_total_count').val(count);

            });
            $("#programme_files").on("change", function(e) {
                var files = e.target.files,
                filesLength = files.length;
                var count = $("#programme_total_count").val();
                for (var i = 0; i < filesLength; i++) {
                    count++;
                    setupReader(files[i],count);
                }
                $('#programme_total_count').val(count);

            });
        } else {
            alert("Your browser doesn't support to File API")
        }

        $("#tags").on('keyup',function(){
            var path = SITEURL+"/autocomplete";
            $.ajax({
                type:'POST',
                url:path,
                contentType: 'application/json; charset=utf-8',
                dataType: "json",
                success:function(data){
                    get_specified_users_data(data);
                }
            });
        })

        var tmp_array = [];
        $('.add_specified_user').on('click',function(){
            var user_name = $('#tags').val();
            var user_id = $('.tags_id').val();
            if($('.specified_users input').size() > 0 ){
                $.each($("input[name='specified_users[]']"), function(){
                    if($(this).val() != '' && $(this).val() != "NaN" && $(this).val() != user_id && $.inArray(user_id, tmp_array) == -1){
                        console.log('before if---->'+tmp_array);
                        tmp_array.push(user_id);
                        $('.specified_users').append('<input checked="checked" type="checkbox" name="specified_users[]" value="'+user_id+'">'+user_name);
                        console.log('after if---->'+tmp_array);
                    }
                    $('#tags').val('');
                });
            }else{
                console.log('before else---->'+tmp_array);
                if(user_id != '' && user_id != "NaN"){
                    tmp_array.push(user_id);
                    $('.specified_users').append('<input checked="checked" type="checkbox" name="specified_users[]" value="'+user_id+'">'+user_name);
                        $('#tags').val('');
                    console.log('after else---->'+tmp_array);
                }
            }
        });

        $("input[name='radio']").on('click',function(){
            if($(this).val() == 'all_users'){
                $('.specified_user').hide();
                $('.all_user').show();
            }else{
                $('.all_user').hide();
                $('.specified_user').show();
            }
        });


    });

function add_pie() {
    var pie_count = $('tr.tr_values').length;
    var count = Number(pie_count)+Number(1);
    var pie_tr = $("#graph_datasets #pie"+pie_count);

    var new_tr = '<tr class="tr_values" id="pie'+count+'"><td><a class="text-danger pointer" onclick="remove_pie($(this));" ><i class="fa fa-close"></i> Remove</a></td><td><input type="text" name="title_'+count+'" class="form-control title" id="title_'+count+'" placeholder="Title"></td><td><input type="text" name="legend_'+count+'" class="form-control legend" id="legend_'+count+'" placeholder="Legend"></td><td><input type="text" name="value_'+count+'" id="value_'+count+'" class="form-control value" placeholder="Value"></td><td><input type="color" class="form-control colour" id="color_'+count+'" name="color_'+count+'" placeholder="Select Color" /></td></tr>';

    //console.log(new_tr);
    $('#pie'+pie_count).after(new_tr);
    $("#graph_datasets #pie_count").val(count);
}
function remove_pie(elmnt) {
    if(confirm("Are you sure ?"))
    {
        var pie_count = $('tr.tr_values').length;
        if (pie_count > 1) {
            var row_id = elmnt.parents('tr').attr('id').replace(/[^0-9]/g,'');
            elmnt.parents('tr#pie'+row_id).remove();
            var count = Number(pie_count)-Number(1);
        }
    }
}
function Dropped(event, ui){
    var i = 1;
    $('.droppable span.pip').each( function(){
        // alert('foram');
        console.log($(this));
        $(this).find('.stored_image_id').attr("name",'');
        console.log('stored_image_id_'+i);
        console.log('---------------------');
        $(this).find('.stored_image_id').attr("name",'stored_image_id_'+i);
        i++;
    });
}

function setupReader(file,count){
    var reader = new FileReader();  
    console.log(count);
    reader.onload = function(e) {  
        $('.field.droppable').append("<span class=\"pip item draggable\">" +
        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
        "<input type=\"hidden\" name='stored_image_id_"+count+"' value=\"" + file.name + "\" class=\"stored_image_id\">"+
        "<br/><span class=\"remove notify-badge\">X</span>" +
        "</span>");
    }
    // reader.readAsText(file, "UTF-8");
    reader.readAsDataURL(file);
}

function get_specified_users_data(data)
{
    var source  = [ ];
    var mapping = { };
    for(var i = 0; i < data.length; ++i) {
        source.push(data[i].name);
        mapping[data[i].name] = data[i].id;
    }
    $('#tags').autocomplete({
        minLength: 1,
        source: source,
        select: function(event, ui) {
            $('.tags_id').val(mapping[(ui.item.value)]);
        }
    });

}