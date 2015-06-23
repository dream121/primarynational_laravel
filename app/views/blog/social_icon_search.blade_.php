<div class="text-right">
@foreach($social_media as $item)
    <a href="{{$item->link}}"><img src="{{asset('assets/img/'.strtolower($item->title).'.png')}}" alt="{{$item->title}}"/></a>
@endforeach
</div>
<div class="search_sub">
    <div class="input-group">
        <div class="input-group-addon ">
            <span class="glyphicon glyphicon-search"></span>
        </div>

        <input type="text" name="search" class="form-control" placeholder="SEARCH THE SITE">
    </div>
</div>