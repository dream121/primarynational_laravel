@extends('layouts/default')
@section('assets-js')
@parent
{{ HTML::script('assets/js/jquery.bootstrap.wizard.js'); }}
<script type="text/javascript">
    $(document).ready(function() {
        $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            $('#rootwizard').find('.bar').css({width:$percent+'%'});

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#rootwizard').find('.pager .next').hide();
                $('#rootwizard').find('.pager .finish').show();
                $('#rootwizard').find('.pager .finish').removeClass('disabled');
            } else {
                $('#rootwizard').find('.pager .next').show();
                $('#rootwizard').find('.pager .finish').hide();
            }

        }});
        $('#rootwizard .finish').click(function() {
//            alert('Finished!, Starting over!');
//            $('#rootwizard').find("a[href*='tab1']").trigger('click');
        });
    });
</script>
@stop
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">
    <div class="width_90">
        <div class="inner_header">
            <h3><b>Finance your dream home in Lexington</b>
                <button class="btn btn-danger pull-right contact_btn">CONTACT US</button>
            </h3>
            <h4><em>Imagine buying your dream home. Let our experienced staff help you make it happen.</em></h4>

            <div class="row">
                <div class="col-md-3">
                    <div class="img_frame">
                        <div class="shadow_left"></div>
                        <div class="shadow_right"></div>
                        <div class="img_holder">
                            <div class="agents_img">
                                <img class="img-responsive" src="<?=Croppa::url($agent->profile->photo, 225, 230, array('resize'))?>" alt="{{@$agent->first_name}} {{@$agent->last_name}}"/>
                            </div>
                        </div>
                    </div>

                    <h4 class="text-center">{{$agent->first_name}} {{$agent->last_name}}</h4>
                </div>

                <div class="col-md-9 sell_text">
                    {{$content}}
                </div>
            </div>

        </div>

    {{ Form::open(array('url' => 'finance', 'class' => 'form-horizontal','id'=>'finance_request_form','role'=>'form')); }}
        <input type="hidden" name="user_id" value="{{$agent->id}}">
        <div id="rootwizard" class="form_wizard">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container-fluid">

                        <ul class="nav nav-pills tab-3">
                            <li class="active">
                                <div class="wizard_line line_50_right"></div>
                                <a href="#tab1" data-toggle="tab">HOW CAN WE REACH YOU?</a></li>
                            </li>
                            <li>
                                <div class="wizard_line"></div>
                                <a href="#tab2" data-toggle="tab">WHAT WOULD YOU LIKE TO DO?</a>

                            </li>
                            <li>
                                <div class="wizard_line line_50_left"></div>
                                <a href="#tab3" data-toggle="tab">BASIC INFO</a>


                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">How can we contact you?</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="way_of_contact" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">What is the best time to reach you?</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="time_to_reach" class="form-control" placeholder="">
                            </div>
                        </div>
                </div>
                <div class="tab-pane" id="tab2">
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">Get pre-approved</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-4">
                                <input type="text" name="get_pre_approved" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">Get re-financed</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="get_refinanced" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Apply for a Home loan</label>

                            <div class="col-sm-2 col-sm-offset-3">
                                <select class="form-control" name="apply_home_loan">
                                    <option value="">Yes</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Attend First Time Homebuyer Seminar</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="attend_homebuyer_seminar" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Comments</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <textarea name="comments" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                </div>

                <div class="tab-pane" id="tab3">
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">Your name</label>

                            <div class="col-sm-2 col-sm-offset-3 col-xs-4">
                                {{ Form::text('first_name','',array("class"=>"form-control", "placeholder"=>"First Name", "required", "name"=>"first_name", "type"=>"text", "autofocus")) }}
                                {{ $errors->first('first_name','<p class="text-red">:message</p>'); }}
                            </div>
                            <div class="col-sm-2 col-xs-4">
                                {{ Form::text('last_name','',array("class"=>"form-control", "placeholder"=>"Last Name", "required", "name"=>"last_name", "type"=>"text", "autofocus")) }}
                                {{ $errors->first('last_name','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">Email Address</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                {{ Form::text('email','',array("class"=>"form-control", "placeholder"=>"E-mail", "required", "name"=>"email", "type"=>"email", "autofocus")) }}
                                {{ $errors->first('email','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Phone Number</label>

                            <div class="col-sm-4 col-sm-offset-3">
                                <input type="text" name="phone_number" class="form-control" placeholder="* (_ _ _) _ _ _ - _ _ _">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Reason for purchasing?</label>

                            <div class="col-sm-4 col-sm-offset-3">
                                <select class="form-control" name="purchase_reason">
                                    <option value="">Just Browsing</option>
                                </select>
                            </div>
                        </div>
                </div>

                <ul class="pager wizard">
                    <li class="next"><a href="javascript:;">Next</a></li>
                    <li class="next finish" style="display: none;"><button type="submit" class="btn btn-danger  pull-right" id="login_submit_btn">Finish</button></li>
                </ul>
            </div>
        </div>
    {{ Form::close() }}
    </div>
</div>
@stop