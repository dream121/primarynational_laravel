<div class="row">
    <div class="col-lg-12"><p id="validation-message"></p></div>
    <div class="col-lg-12">
        {{ Form::open(array('role'=>"form",'files'=>true,'class'=>"update-category-form")) }}
        <form action="#" name="category-form" id="category-form">
            <input type="hidden" name="id" id="id" value="{{ $category->id }}">
            <div class="form-group">
                {{ Form::label('Name : ') }}
                {{ Form::text('name',$category->name,array('class'=>'form-control category-name')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Slug : ') }}
                {{ Form::text('slug',$category->slug,array('class'=>'form-control category-slug')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Is Active?')}}
                {{ Form::checkbox('status', $category->status, $category->status) }}
            </div>

            <div class="form-group">
                <a href="{{url('/admin/category/edit/')}}" class="btn btn-primary update-category">Update Category</a>
                <button type="button" class="btn btn-default categoryModalClose" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
