@extends('layouts.default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu">
    <div class="width_90">
        <div class="agents_content clearfix">
            <div class="header_container">
                <h3><strong>CONTACT NICK RATLIFE REALITY TEAM</strong></h3>
                <h4><em>PROMPT AND PROFESSIONAL SERVICE IS OUR GUARANTEE.</em></h4>
            </div>


            <p>Our goal is to be <span><strong>informative and helpfull.</strong></span> Through our service we hope to earn your business with our exemplary level of service and extensive local knowledge of the Lxington area.</p>
            <br>


            <div class="col-md-6">
                <div class="contact_content text-center">
                    <h3><em>{{$contact_us->title}}</em></h3>

                    <div>
                        {{$contact_us->content}}
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-md-offset-1">
                <div class="contact_box">
                    <div class="box_header text-center">
                        <h3>How can we help you?</h3>
                    </div>

                    {{ Form::open(array('url' => 'contact-us', 'id'=>'contact_request_form','role'=>'form')); }}
                        <div class="form-group">
                            {{ Form::text('first_name','',array("class"=>"form-control", "placeholder"=>"First Name", "required", "name"=>"first_name", "type"=>"text", "autofocus")) }}
                            {{ $errors->first('first_name','<p class="text-red">:message</p>'); }}
                        </div>
                        <div class="form-group">
                            {{ Form::text('last_name','',array("class"=>"form-control", "placeholder"=>"Last Name", "required", "name"=>"last_name", "type"=>"text", "autofocus")) }}
                            {{ $errors->first('last_name','<p class="text-red">:message</p>'); }}
                        </div>
                        <div class="form-group">
                            {{ Form::text('email','',array("class"=>"form-control", "placeholder"=>"Email Address", "required", "name"=>"email", "type"=>"email", "autofocus")) }}
                            {{ $errors->first('email','<p class="text-red">:message</p>'); }}
                        </div>
                        <div class="form-group">
                            <input name="phone_number" type="text" class="form-control" placeholder="Phone Number">
                        </div>
                        <div class="form-group">

                            <select class="form-control" name="interested_in">
                                <option>I'm Interested In</option>
                                <option>General Comments or Inquiry</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                Comments
                            </label>
                            <textarea name="comments" class="form-control" name="" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger  btn-block" id="contact_submit_btn">SUBMIT</button>
                        </div>


                    {{ Form::close() }}

                </div>
            </div>



        </div>
    </div>
</div>
@stop