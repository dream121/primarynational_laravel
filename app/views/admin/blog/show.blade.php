@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/blogs') }}"><< Back to Blogs</a></h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading clearfix">
       <p class="pull-left">Blog Details</p>  <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/blogs/edit/'.$blog->id) }}">Edit</a>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{@$blog->title}}</h2>
                <p><strong>Slug :</strong> {{@$blog->slug}}</p>
                <div class="row">
                    @if(!empty($blog->image_link_1))
                        <div class="col-lg-2"><span>Image 1</span><img style="border-radius: 5px;" src='{{$blog->image_link_1}}' height="150" width="150"></div>
                    @endif
                    @if(!empty($blog->image_link_2))
                        <div class="col-lg-2"><span>Image 2</span><img style="border-radius: 5px;" src='{{{$blog->image_link_2}}}' height="150" width="150"></div>
                    @endif
                    @if(!empty($blog->image_link_3))
                        <div class="col-lg-2"><span>Image 3</span><img style="border-radius: 5px;" src='{{{$blog->image_link_3}}}' height="150" width="150"></div>
                    @endif
                    @if(!empty($blog->image_link_4))
                        <div class="col-lg-2"><span>Image 4</span><img style="border-radius: 5px;" src='{{{$blog->image_link_4}}}' height="150" width="150"></div>
                    @endif
                </div>
                <p><strong>Content :</strong></p>
                <p>{{@$blog->content}}</p>
                <div class="clearfix"></div>
                <p><strong>Status :</strong> {{@$blog->status?'Active':'In Active'}}</p>
                <p><strong>Author :</strong> {{@$blog->user->first_name}} {{@$blog->user->last_name}}</p>
                <p><strong>Created :</strong> {{@$blog->created_at}}</p>

            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-12">
            	<div class="panel panel-default">
				    <div class="panel-heading">
				        Comments
				    </div>
				    <!-- /.panel-heading -->
				    <div class="panel-body">
				    
				    
						
				    <table class="table table-striped table-bordered table-hover">
				        <thead>
				            <tr>
				                <th>Author</th>
				                <th>Email</th>
				                <th>comment</th>
				                <th>IP</th>
				                <th>Parent ID</th>
				                <th class="text-center"> Action</th>
				            </tr>
				        </thead>
				        <tbody>
				        
				        @foreach($comments as $comment)
				        <tr>
				           <td>{{ $comment->id,$comment->author_name }}</td>
				           <td>{{ $comment->author_email }}</td>
				           <td>{{ $comment->comment }}</td>
				           <td>{{ $comment->author_ip }}</td>
				           <td>{{ $comment->parent }}</td>
				           <td class="text-center">
			 					<?php 
				 					$approval_toggle=$comment->approved?0:1;
				 					$approval_text=$comment->approved?'Reject':'Approve';
			 					?>
			 					              
				                <a class="btn_approval btn btn-small btn-success" href="{{ URL::to('admin/blogs/approval/' . $comment->id.'/'.$approval_toggle) }}">{{$approval_text}}</a>
				           </td>
				        </tr>
				        @endforeach

				        </tbody>
				    </table>
				    <?php /*echo $blogs->links();*/ ?>
				        </div>
				    </div>
            </div>
        </div>

    </div>
   <!-- /.panel-body -->
</div>
<script type="text/javascript">
	$('.btn_approval').click(function(event)
	{
		event.preventDefault();
		$.get($(this).attr('href'),function(data,status)
		{
			if(data.message='success')
				location.reload();
				
		})
	})
</script>
@stop