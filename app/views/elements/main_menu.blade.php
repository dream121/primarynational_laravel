<?php
$menus = array(
    array('link' => '/', 'label' => 'Home'),
    array('link' => '/search', 'label' => 'Search'),
    //array('link' => '/search/map', 'label' => 'Map'),
    array('link' => '/buy', 'label' => 'Buy'),
    array('link' => '/sell', 'label' => 'Sell'),
    array('link' => '/finance', 'label' => 'Finance'),
    array('link' => '/agents', 'label' => 'Agents'),
    array('link' => '/search?OfficeMLS=BB9805', 'label' => 'Our Listings'),
    array('link' => '/contact-us', 'label' => 'Contact Us'),
    array('link' => '/community-guides', 'label' => 'Community Guides'),
//    array('link' => '/resource', 'label' => 'Resources'),
//    array('link' => '/press', 'label' => 'Press'),
    array('link' => '/blog', 'label' => 'Blog')
);
?>

<nav class="navbar max_width navbar-default menu" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle pull-left" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-8">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-8">
            <ul class="nav navbar-nav">
                @foreach($menus as $menu)
                <li
                {{ $menu['link']=='/'.$selected_menu ? 'class="active"':''}}>{{link_to($menu['link'],$menu['label'])}}
                </li>
                @endforeach
            </ul>
        </div>
        <!-- /.navbar-collapse -->
        <ul class="nav navbar-nav navbar-right">
            <li><a id="menu-save_search" href="{{@Auth::check()?'/notification':"#"}}">Saved Search</a></li>
            <li><a id="menu-fav-count" href="{{@$favorites_count?url('search?favs=1'):'#'}}">Favorites({{@$favorites_count?$favorites_count:0}})</a></li>
            <li class="login-logout-sec">
                @if (Auth::check())
                    {{link_to('account',Auth::user()->first_name)}}<span>(</span>{{link_to('logout','Logout',array('class'=>'no-padding'))}}<span>)</span>
                @else
                    <a href="#" id="signinlink" rel="nofollow" data-toggle="modal" data-target="#sign_up" title="Sign In">
                        <span class="user-menu-text">Sign In</span>
                    </a>
                @endif
            </li>
        </ul>
    </div>
</nav>