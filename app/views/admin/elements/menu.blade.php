<div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
        <li class="sidebar-search">

            {{ Form::open(array('url'=>'admin/users/search','method'=>'get'))}}
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" value="{{@$q}}" name="q" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
            </div>
            {{ Form::close()}}
        </li>
        <li class="active">
            <a href="{{ url('/admin/dashboard') }}"><span class="glyphicon glyphicon-dashboard"></span> Dashboard </a>
        </li>
        <li>
            <a href="{{ url('/admin/page') }}"><span class="glyphicon glyphicon-file"></span> Manage Pages </a>
        </li>
        <li>
            <a href="{{ url('/admin/user') }}"><span class="glyphicon glyphicon-user"></span></span> Manage Users </a>
        </li>
        <li>
            <a href="{{ url('/admin/agent') }}"><span class="glyphicon glyphicon-user"></span></span> Manage Agents </a>
        </li>
        <li>
            <a href="{{ url('/admin/financial-agent') }}"><span class="glyphicon glyphicon-user"></span></span> Manage Mortgage Lenders </a>
        </li>
        <li class="active">
            <a href="{{ url('/admin/blogs') }}"><span class="glyphicon glyphicon-th-list"></span> Manage Blog </a>
        </li>
        <li class="active">
            <a href="{{ url('/admin/comment') }}"><span class="glyphicon glyphicon-th-list"></span> Manage Comment </a>
        </li>
        <li class="active">
            <a href="#"><i class="fa fa-wrench fa-fw"></i> Home page setup<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li>
                    <a href="{{ url('/admin/banner') }}"><span class="glyphicon glyphicon-ok"></span> Manage Banner </a>
                </li>
                <li>
                    <a href="{{ url('/admin/buy') }}"><span class="glyphicon glyphicon-ok"></span> Manage
                        Buy Page </a>
                </li>
                <li>
                    <a href="{{ url('/admin/sell') }}"><span class="glyphicon glyphicon-ok"></span> Manage
                        Sell Page </a>
                </li>
                <li>
                    <a href="{{ url('/admin/finance') }}"><span class="glyphicon glyphicon-ok"></span> Manage
                        Finance </a>
                </li>
                <li>
                    <a href="{{ url('/admin/welcome_note') }}"><span class="glyphicon glyphicon-ok"></span> Manage
                        Welcome Note </a>
                </li>
                <li>
                    <a href="{{ url('/admin/manage/edit-about-us') }}"><span class="glyphicon glyphicon-ok"></span> Edit
                        About us </a>
                </li>
                <li>
                    <a href="{{ url('/admin/manage/edit-contact-us') }}"><span class="glyphicon glyphicon-ok"></span> Edit
                        Contact us </a>
                </li>
                <li>
                    <a href="{{ url('/admin/social_media') }}"><span class="glyphicon glyphicon-ok"></span> Manage
                        Social Media </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="{{ url('/admin/guide') }}"><span class="glyphicon glyphicon-th-list"></span> Manage Guide </a>
        </li>
        <li class="">
            <a href="#"><i class="fa fa-wrench fa-fw"></i> Feedback<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li>
                    <a href="{{ url('/admin/feedback/category/buy') }}"><span class="glyphicon glyphicon-ok"></span> Buy Requests </a>
                </li>
                <li>
                    <a href="{{ url('/admin/feedback/category/sell') }}"><span class="glyphicon glyphicon-ok"></span> Sell Requests</a>
                </li>
                <li>
                    <a href="{{ url('/admin/feedback/category/finance') }}"><span class="glyphicon glyphicon-ok"></span> Financial Requests </a>
                </li>
                <li>
                    <a href="{{ url('/admin/feedback/category/ask') }}"><span class="glyphicon glyphicon-ok"></span> Ask An Agent </a>
                </li>
                <li>
                    <a href="{{ url('/admin/feedback/category/contact') }}"><span class="glyphicon glyphicon-ok"></span> Contact Requests </a>
                </li>
                <li>
                    <a href="{{ url('/admin/feedback/category/showing') }}"><span class="glyphicon glyphicon-ok"></span> Request A Showing </a>
                </li>
            </ul>
        </li>

    </ul>
</div>