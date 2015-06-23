<div class="container-fluid footer_bg">
    <div class="footer width_90">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <h4>GUIDES</h4>
                <ul>
                    @foreach($guide_lists as $guide)
                    <li>{{link_to('community-guides/'.$guide->slug,$guide->title)}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <h4>COMPANY</h4>
                <ul>
                    <li>{{link_to('/agents', 'Meet our agents')}}</li>
                    <li>{{link_to('/blog', 'Our blog')}}</li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <h4>RESOURCES</h4>
                <ul>
                    <li>{{link_to('/buy', 'Buy home')}}</li>
                    <li>{{link_to('/sell', 'Sell your home')}}</li>
                    <li>{{link_to('/finance', 'Finance')}}</li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <h4>{{$about_us->title}}</h4>
                <p>
                    {{$about_us->details}}
                </p>
            </div>
        </div>

        <div class="border_btm"></div>
        <?php
        $menus = array(
            array('link'=>'/','label'=>'Home'),
            array('link'=>'search/map','label'=>'Map'),
            array('link'=>'/agents','label'=>'Agents'),
            array('link'=>'search?OfficeMLS=BB9805','label'=>'Our Listings'),
            array('link'=>'/community-guides','label'=>'Community Guides'),
            array('link'=>'/contact-us','label'=>'Contact Us')
        );
        ?>
        <div class="navi">
            <ul class="list-inline">
                @foreach($menus as $menu)
                <li>{{link_to($menu['link'], $menu['label'])}}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="bg_red row">
        <div class="footer width_90">
            <div class="copyright">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p>Copyright &copy; {{date('Y')}}. Primarynational.com. All right Reserved</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3">
                    <p> {{link_to('/page/privacy-policy', 'Privacy policy')}} | {{link_to('/page/terms-of-use', 'Terms of use')}}</p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 text-right">
                    <p class="social_icon">
                        @foreach($social_icons as $sicon)
                        <a href="{{$sicon->link}}">{{HTML::image($sicon->image_link_1,$sicon->title)}}</a>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer data width_90">
        <p>The data relating to real estate for sale on this web site comes in part from the Internet Data Exchange
            Program of the MLS Property Information Network, Inc. and the Rhode Island State-Wide MLS. Real estate
            listings held by IDX Brokerage firms other than Primary National Residential Brokerage, Inc. are marked with
            the IDX logo and detailed information about them includes the name of the listing IDX Brokers. Information
            is deemed reliable but is not guaranteed accurate by the MLS or listing broker.
        </p>
    </div>
</div>