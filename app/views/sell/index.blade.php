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
//            $('#rootwizard').find("a[href*='tab1']").trigger('click');
        });
    });
</script>
@stop
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">
<div class="width_90">
<div class="inner_header">
    <h3><b>Sell Your Home in Lexington!</b>
        <button class="btn btn-danger pull-right contact_btn">CONTACT US</button>
    </h3>
    <h4><em>SELLING YOUR HOME CAN BE EASY. LET OUR EXPERIENCED STAFF HELP YOU MAKE IT HAPPEN.</em></h4>

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
            <h4 class="text-center">{{@$agent->first_name}} {{@$agent->last_name}}</h4>
        </div>

        <div class="col-md-9 sell_text">
            {{$content}}
        </div>
    </div>
</div>

{{ Form::open(array('url' => 'sell', 'class' => 'form-horizontal','id'=>'sell_request_form','role'=>'form')); }}
<input type="hidden" name="user_id" value="{{$agent->id}}">
<div id="rootwizard" class="form_wizard">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container-fluid">

                        <ul class="nav nav-pills tab-3">
                            <li class="active">
                                <div class="wizard_line line_50_right"></div>
                                <a href="#tab1" data-toggle="tab">BASIC INFO</a>
                            </li>
                            <li>
                                <div class="wizard_line"></div>
                                <a href="#tab2" data-toggle="tab">List or DESCRIBE important feature</a>
                            </li>
                            <li>
                                <div class="wizard_line line_50_left"></div>
                                <a href="#tab3" data-toggle="tab">More about yourself</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                        <div class="form-group">
                            <label  class="col-sm-5 col-xs-4 control-label">Which city/town is your property located?</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="location" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">Desired Sale Price</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="price" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Number of Bedrooms</label>

                            <div class="col-sm-2 col-sm-offset-3">
                                <input type="number" name="bedrooms" class="form-control" placeholder="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Number of Bathrooms</label>

                            <div class="col-sm-2 col-sm-offset-3">
                                <input type="number" name="bathrooms" class="form-control" placeholder="1">
                            </div>
                        </div>
                </div>
                <div class="tab-pane" id="tab2">
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">Sq. Ft.</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-4">
                                <input type="text" name="size" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 col-xs-4 control-label">Style of Property</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="style" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Any recent improvements?</label>

                            <div class="col-sm-2 col-sm-offset-3">
                                <select class="form-control" name="recent_improvements">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Other Needs (Pool, Fence, Deck, Garage)</label>

                            <div class="col-sm-4 col-sm-offset-3 col-xs-8">
                                <input type="text" name="others" class="form-control" placeholder="">
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
                            <label class="col-sm-5 control-label">When do you want to sell?</label>

                            <div class="col-sm-4 col-sm-offset-3">
                                <input type="text" class="form-control datepicker" value="" placeholder="Date" name="date_of_sell" id="date_of_sell">
                                {{--<select class="form-control">--}}
                                    {{--<option value="">Just Browsing</option>--}}
                                {{--</select>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Will you need help relocating?</label>

                            <div class="col-sm-4 col-sm-offset-3">
                                <select class="form-control" name="relocating">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
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