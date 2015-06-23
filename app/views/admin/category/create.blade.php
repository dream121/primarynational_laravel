<!--<script type="text/javascript">
    $(document).ready(function(){
    var slug = function(str) {
        var $slug = '';
        var trimmed = $.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            replace(/-+/g, '-').
            replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }

    $( document ).on( "keyup", ".category-name", function() {
        //$( ".category-name" ).keyup(function() {
        var name = $('.category-name').val();
        //alert("Name:" + name);
        var slug = slug(name);
        $('.category-slug').text(slug);
    });
    });

</script>-->
<div class="row">
        <div class="col-lg-12"><p id="validation-message"></p></div>
        <div class="col-lg-12">
            {{ Form::open(array('role'=>"form",'files'=>true,'class'=>"category-form")) }}
            <form action="#" name="category-form">

                <div class="form-group" id="name-group" >
                    {{ Form::label('Name : ') }}
                    {{ Form::text('name','',array('class'=>'form-control category-name')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug','',array('class'=>'form-control category-slug')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('Is Active?')}}
                    {{ Form::checkbox('status', 1, true,array('class' => 'status' )) }}
                </div>

                <div class="form-group">
                    <a href="{{url('/admin/category/create')}}" class="btn btn-primary save-category">Save Category</a>
                    <button type="button" class="btn btn-default categoryModalClose" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
