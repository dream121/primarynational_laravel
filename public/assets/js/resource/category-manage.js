/**
 * Created with JetBrains PhpStorm.
 * User: siddik
 * Date: 6/15/14
 * Time: 3:13 AM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){

    var slug = function(str) {
        var $slug = '';
        var trimmed = $.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            replace(/-+/g, '-').
            replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }

    $( document ).on( "keyup", ".resource_title", function() {
        var value = $( this ).val();
        var sluggedValue = slug(value);
        $('.slug').val(sluggedValue);
    });

    $( document ).on( "keyup", ".category-name", function() {
        var value = $( this ).val();
        var sluggedValue = slug(value);
        $('.category-slug').val(sluggedValue);
    });

    function clear_form_elements(ele) {

        $(ele).find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });

    }

    $('.manage-category').click(function(event){
        event.preventDefault();
        var type=$("#content_type").val();
        clear_form_elements('.category-form');
        clear_form_elements('.update-category-form');
        $("#validation-message").empty();
        getAjaxFormLoad($(this).attr('href')+'/create');
        getAjaxContent($(this).attr('href')+'/index/'+type);
    });

    function getAjaxContent(url){
        //console.log(location);
        $.ajax({
            type: "get",
            cache: false,
            url : url,
            success: function(data)
            {
                $('#categoryModal .category-list ').html(data);
                $('#categoryModal').modal('show');
            }
        })
    }

    function getAjaxFormLoad(url){
        $.ajax({
            type: "get",
            cache: false,
            url : url,
            success: function(data)
            {
               $('#categoryModal .category-create').html(data);
            }
        })
    }

    $( document ).on( "click", ".save-category", function(e) {
        e.preventDefault();
        var type=$("#content_type").val();
        var form_data = $('.category-form').serialize()+"&type="+type;
        //form_data.type=$(".content_type").val();
        //console.log(form_data);
        var categoryName = $('.category-name').val();
        var category_slug = $('.category-slug').val();
        var status = $('.status').attr('checked') ? "Active" : "Inactive";
        var url = $(this).attr('href');

        $.ajax({
            type: "post",
            cache: false,
            url : url,
            data: form_data,
            success: function(data)
            {
                var id = data.id;
                var successMessage = "New category saved successfully";

                if(data.success==true)
                {
                    $('<option value="'+id+'">'+categoryName+'</option>').appendTo(".ddlCategory");
                    $('#category-list-table > tbody:last').append('<tr id='+id+'><td>'+categoryName+'</td><td>'+category_slug+'</td><td>'+type+'</td><td>'+status+'</td><td class="text-center"><a class="btn btn-small btn-info edit-category" id='+id+' href="#">Edit</a><a href="#" title="Delete this Item" class="delete-category" delete_id='+id+'><i class="glyphicon glyphicon-trash"></i></a></td></tr>');
                    $("#validation-message").append('<div class="alert alert-success"><strong>'+ successMessage +'</strong><div>');
                }else{
                    var arr = data.errors;
                    $.each(arr, function(index, value)
                    {
                        if (value.length != 0)
                        {
                            $("#validation-message").append('<div class="alert alert-danger"><strong>'+ value +'</strong><div>');
                        }
                    });
                }
                $("#validation-message").show();
            }
        })

    });

    $( document ).on( "click", ".load-edit-category-form", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var url = $(this).attr('href');
        $.ajax({
            type: "get",
            cache: false,
            url : url,
            success: function(data)
            {

                $('#categoryModal .category-create').hide();
                $('#categoryModal .category-edit').html(data);
            }
        })

    });

    $( document ).on( "click", ".update-category", function(e) {
        e.preventDefault();
        var type =$("#content_type").val();
        var form_data = $('.update-category-form').serialize()+'&type='+type;
        var new_category = $('.category-name').val();
        var category_slug = $('.category-slug').val();
        var status = $('.status').attr('checked') ? "Active" : "Inactive";
        var successMessage = "New category updated successfully";

        var id = $('#id').val();
        var url = $(this).attr('href')+"/"+id;
        $.ajax({
            type: "post",
            cache: false,
            url : url,
            data: form_data,
            success: function(data)
            {
                if(data.success==true)
                {
                    $("table#category-list-table tr[id=" + id + "]").find(".lbl-category-name").html(new_category);
                    $("table#category-list-table tr[id=" + id + "]").find(".lbl-category-slug").html(category_slug);
                    $("table#category-list-table tr[id=" + id + "]").find(".lbl-category-type").html(type);
                    $("table#category-list-table tr[id=" + id + "]").find(".lbl-category-status").html(status);
                    $("#validation-message").append('<div class="alert alert-success"><strong>'+ successMessage +'</strong><div>');
                    $('.ddlCategory option[value="'+id+'"]').text(new_category);
                }else{

                    var arr = data.errors;
                    $.each(arr, function(index, value)
                    {
                        if (value.length != 0)
                        {
                            $("#validation-message").append('<div class="alert alert-danger"><strong>'+ value +'</strong><div>');
                        }
                    });

                }
                $("#validation-message").show();
            }
        })

    });

    $( document ).on( "click", ".delete-category", function(e) {
        e.preventDefault();
        var id = $(this).attr('delete_id');
        var url = $(this).attr('href');
        if(!confirm("Are you want to delete this item?"))
            return false;

        $.ajax({
            type: "get",
            cache: false,
            url : url,
            dataType 	: 'json', // what type of data do we expect back from the server
            encode          : true,
            success: function(data)
            {
                if(data.success==true)
                {
                    $("#validation-message").append('<div class="alert alert-success"><strong>'+ data.message +'</strong><div>');
                    $("table#category-list-table tr#"+id).remove();
                    $('.ddlCategory option[value="'+id+'"]').remove();
                }else{
                    $("#validation-message").append('<div class="alert alert-danger"><strong>'+ data.message +'</strong><div>');
                }
            }
        })
    });
});
