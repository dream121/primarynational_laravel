<div class="modal fade" id="sign_up" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="modal_container border border_radius_10 sign_in_pop">
                    <h3>Login Panel</h3>

                    {{ Form::open(array('url' => 'login', 'class' => 'form-horizontal','id'=>'login_ajax_form', "autocomplete"=>"off", 'role'=>'form')); }}
                        <div class="form-group">
                            <div class="col-sm-12">
                            {{ Form::email('email','',array("class"=>"form-control","required", "placeholder"=>"name@website.com","autocomplete"=>"off","type"=>"email", "name"=>"email", "autofocus")) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" placeholder="*********" required name="password" type="password" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-danger btn-login btn-lg" id="login_submit_btn">Login</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox keep_signin">
                                <label class="color_light">
                                    <input type="checkbox"> Keep me logged in
                                </label>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>

                <div class="not_member">
                    <h4><a href="#"  data-toggle="modal"  data-target="#free_mls_reg" class="free_reg">Need an account? <span class="color-red">Sign up</span></a></h4>
                    <h5><a href="#" data-toggle="modal"  data-target="#forgot_pass" class="forgot_pass">Forgot your password? <span class="color-red">Click Here</span></a></h5>
                </div>
            </div>
            <div class="modal-footer log_in_footer">
                <p class="width_90">By registering with our site you agree to the website
                    <strong><em>terms.</em></strong> We protect you <em>personal privacy</em> and <em>email
                        security.</em> View <strong><em>our privacy policy</em></strong></p>
            </div>
        </div>
    </div>
</div>

<!-- Full Details modal -->
<div class="modal fade full_details_modal" id="view_full_details" tabindex="-1" role="dialog" aria-hidden="true">
</div>

<!-- Request a showing modal -->
<div class="modal fade" id="request_a_showing" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <h2>Request A Showing</h2>
                <h4>About the building no #</h4>
            </div>
            <div class="modal-body">
                <div class="modal_container border border_radius_10 free_mls">
                    <form class="form-horizontal" role="form" name="request_showing" id="request_showing_form">
                        <input type="hidden" name="listing_id" value="" id="req_listing_id">
                        <input type="hidden" name="address" value="" id="req_address">
                        <div class="modal_body_header">
                            <div class="form-group">
                                <label for="date" class="col-sm-2 control-label">Date:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control datepicker" value="{{date('m/d/Y')}}" placeholder="Date" name="date" id="date">
                                </div>
                                <label for="time" class="col-sm-2 control-label">Time:</label>
                                <div class="col-sm-4">
                                    <select name="time" class="form-control">
                                        <option selected="selected" value="Anytime">Anytime</option>
                                        <option value="Morning">Morning</option>
                                        <option value="Afternoon">Afternoon</option>
                                        <option value="Evening">Evening</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="first_name" class="col-sm-2 control-label">Name:</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" required="required" id="first_name" name="first_name" value="{{@Auth::user()->first_name}}" placeholder="Your first name">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" required="required" id="last_name" name="last_name" value="{{@Auth::user()->last_name}}" placeholder="Your last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email:</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" required="required" id="email" name="email" value="{{@Auth::user()->email}}" placeholder="emailaddress@domain.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone:</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"  id="phone" value="{{@Auth::user()->phone}}" placeholder="Ex. (734) 555 1212">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Question:</label>

                            <div class="col-sm-10">
                                <textarea class="form-control" rows="4" required="required" name="question" placeholder="What would you like to know?"></textarea>
                            </div>
                        </div>
                   
                        <div class="text-right">
                            <h5 class="text-muted">A agent will contact to confirm your request</h5>
                            <button type="submit" class="btn btn-danger btn-lg" id="send_request_btn" >Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- forgot password modal -->
<div class="modal fade" id="forgot_pass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="modal_container border border_radius_10 sign_in_pop forgot_pop">
                    <h3>Forgot passward <br/>
                        <a href="#" class="color-red already_signed_in"  data-toggle="modal"  data-target="#sign_up">Back to Login</a>
                    </h3>


                    <form class="form-horizontal" role="form"  name="forgot_password_form"  id="forgot_password_form" action="{{ action('RemindersController@postRemind') }}"  method="POST">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" value="Send Reminder" class="btn btn-danger btn-lg btn-login">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer log_in_footer">
                <p class="width_90">By registering with our site you agree to the website
                    <strong><em>terms.</em></strong> We protect you <em>personal privacy</em> and <em>email
                        security.</em> View <strong><em>our privacy policy</em></strong></p>
            </div>
        </div>
    </div>
</div>

<!-- FREE MLS Account Activation modal -->
<div class="modal fade" id="free_mls_reg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>

                <h2>FREE MLS Account Activation</h2>
                <h4>Free and complete access in 20 seconds.....</h4>
            </div>
            <div class="modal-body">
                <div class="modal_container border border_radius_10 free_mls">
                    <form class="form-horizontal" role="form" name="free_mls_reg_form" id="free_mls_reg_form">
                        <div class="form-group">
                            <label for="first_name" class="col-sm-2 control-label">Name:</label>

                            <div class="col-sm-5">
                                {{ Form::text('first_name','',array('class'=>'form-control','id'=>'first_name','placeholder'=>'First Name')) }}
                                {{ $errors->first('first_name','<p class="text-red">:message</p>'); }}
                            </div>
                            <div class="col-sm-5">
                                {{ Form::text('last_name','',array('class'=>'form-control','id'=>'last_name','placeholder'=>'Last Name')) }}
                                {{ $errors->first('last_name','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                {{ Form::text('email','',array('class'=>'form-control','id'=>'email','placeholder'=>'example@gmail.com')) }}
                                {{ $errors->first('email','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone #:</label>

                            <div class="col-sm-10">
                                <input type="password" name="phone_number" class="form-control" id="phone" placeholder="Phone Number is Used as Password">
                                {{ $errors->first('phone_number','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="checkbox">

                            <h5>
                                <label>
                                    <input type="checkbox" name="local_lender_required" id="local_lender_required">
                                </label>
                                Would you like a trusted, local lender to keep you updated with mark changes and current interest
                                rates?
                            </h5>
                            {{ $errors->first('local_lender_required','<p class="text-red">:message</p>'); }}
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger btn-lg">Create Free Account</button>
                            </div>
                        </div>
                    </form>

                    <h6 class="text-center">
                        <a href="#" class="color-red already_signed_in"  data-toggle="modal"  data-target="#sign_up"><strong>Already Signed In? Log In here</strong></a>
                    </h6>
                </div>
            </div>

            <div class="modal-footer  log_in_footer">
                <p class="width_90">By registering with our site you agree to the website
                    <a href="{{url("page/terms-of-use")}}"><strong><em>terms.</em></strong></a> We protect you <em>personal privacy</em> and <em>email
                        security.</em> View <a href="{{url("page/privacy-policy")}}"><strong><em>our privacy policy</em></strong></a></p>
            </div>
        </div>
    </div>
</div>

<!-- Save search modal -->
    <div class="modal fade" id="save_search" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <h2>Save This search</h2>
                <p>Not what you want? <a href="#" class="color-red">Go back and changes your criteria</a></p>

            </div>
            <div class="modal-body">
                <div class="modal_container border_radius_10 border save_search">
                    <form class="form-horizontal" role="form" name="save_search" id="save_search_form">
                    <div class="row">
                        <div class="col-md-6">
                                <input type="hidden" name="search_type" value="search">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name this search:</label>
                                    <input type="text" class="form-control" id="search_name" name="search_name"
                                           placeholder="Search Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email Address:</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{@Auth::user()->email}}">
                                </div>

                                <div class="form-group">
                                    <label>Get listing Alerts:</label>
                                    <select class="form-control" name="email_interval">
                                        <option>Monthly</option>
                                        <option>Weekly</option>
                                        <option>Daily</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <button type="submit" class="btn btn-danger btn-lg">Save This Search!</button>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-5 col-md-offset-1">
                            <h4>Current Search Filters</h4>

                            <div class="form-group">
                            <input type="hidden" name="search_link" value="" id="search_link">
                                <textarea rows="10" readonly class="form-control" placeholder="My Saved Search" name="search_link1" id="search_link1"></textarea>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ask_an_agent modal -->
<div class="modal fade" id="ask_an_agent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>

                <h2>Ask An Agent</h2>
                <h4>About the building no <span id="listing_id_top"></span></h4>
            </div>
            <div class="modal-body">
                <div class="modal_container border border_radius_10 free_mls">
                    <form class="form-horizontal" role="form" name="ask_an_agent" id="ask_an_agent_form">
                    <input type="hidden" name="listing_id" id="listing_id">
                        <div class="form-group">
                            <label for="First_name" class="col-sm-2 control-label">Name:</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="First_name" name="first_name" placeholder="First name">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="Last_name" name="last_name"  placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email:</label>

                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Orlandofarnandis@gmail.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone #:</label>

                            <div class="col-sm-10">
                                <input type="text" name="phone_number" class="form-control" id="phone" placeholder="+xxx-xxxx-xxxx">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Question:</label>

                            <div class="col-sm-10">
                                <textarea name="comments" class="form-control" rows="4" placeholder="What would you like to know?"></textarea>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-danger btn-lg">Ask The Question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
