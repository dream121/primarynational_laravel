<div class="subscribe_bg_opacity">
    <h2>SUBSCRIBE FOR OUR BLOG UPDATES</h2>
    <p>We will not rent, share or spam your account, ever. Please read and review our privacy policy.</p>


    <form role="form" action="blog/subscribe" method="POST" name="subscription_form" id="subscription_form">
        <div class="col-md-8">
            <input type="email" required="" id="email" name="email" class="form-control" placeholder="Enter a valid email address and click subscribe">

        </div>
        <div class="col-md-4">
            <button id="subscribe" type="submit" class="btn btn-danger btn-block">SUBSCRIBE</button>
        </div>
    <div class="clearfix"></div>
    </form>
    <p>You can also stay updated by following us below</p>
    <ul class="list-inline">
        @foreach($social_media as $item)
        <li>
            <a href="{{$item->link}}"><img src="{{asset('assets/img/'.strtolower($item->title).'-subscribe.jpg')}}" alt="{{$item->title}}"/></a>
        </li>
        @endforeach

    </ul>
</div>