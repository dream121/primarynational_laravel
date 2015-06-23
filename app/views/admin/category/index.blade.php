<div id="validation-message" style="display: block;"></div>
<div class="row category-list">
<table class="table table-striped table-bordered table-hover" id="category-list-table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Slug</th>
        <th>Type</th>
        <th>Status</th>
        <th class="text-center"> Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
    <tr id={{ $category->id }}>
        <td class="lbl-category-name">{{ $category->name }}</td>
        <td class="lbl-category-slug">{{ $category->slug }}</td>
        <td class="lbl-category-type">{{ $category->type }}</td>
        <td class="lbl-category-status">{{Util::getStatus($category->status )}}</td>
        <td class="text-center">
            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
            <a class="btn btn-small btn-info load-edit-category-form" id="{{ $category->id }}" href="{{url('/admin/category/edit/'.$category->id)}}">Edit</a>
            <a href="{{url('/admin/category/delete/'.$category->id)}}" title="Delete this Item" class="delete-category" delete_id="{{ $category->id }}"><i class="glyphicon glyphicon-trash"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>