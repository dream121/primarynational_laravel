<ul class="nav nav-pills nav-stacked">
	<li class="profile_my_account">
		<a href="#"><span class="glyphicon glyphicon-cog pull-left"></span>my account</a>
	</li>
	<li class="profile_nav_profile {{$selected_menu == 'account'? 'active':''}}">
		<a href="{{url('account')}}"><span class="glyphicon glyphicon-user pull-left"></span>Profile</a>
	</li>
	<li class="profile_saved_search_n_listing {{$selected_menu == 'notification'? 'active':''}}">
		<a href="{{url('notification')}}"><span class="glyphicon glyphicon-th-list pull-left"></span>saved search &amp; listing alerts</a>
	</li>
</ul>