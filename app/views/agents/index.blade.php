@extends('layouts/default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">
    <div class="width_90">
        <div class="agents_content clearfix">
            <div class="header_container">
                <h3><strong>NICK RATLIFE REALITY TEAM'S REAL ESTATE AGENTS</strong></h3>
                <h4><em>Selling your home can be easy. Let our experienced staff help you make it happen.</em></h4>
            </div>
            <p>Nick Ratliff Realty Team is comprised of a team of local real estate professionals committed to selling some of the most desired homes in Lexington. Selling these "right addresses" is the mission of Nick Ratliff Realty Team. Let us know what you're looking for. Please take advantage of the helpful tools on this website, including our exclusive Lexington Real Estate search, but also feel free to contact us personally.</p>
            <br>
            <div class="col-md-7">
                <div class="row">
                <div class="col-md-12 text-center">
                 @if(!$agents->isEmpty())
                 @foreach($agents as $agent)
                 <div style="float:left; margin-right:20px">
                     <div class="img_frame">
                        <div class="shadow_left"></div>
                        <div class="shadow_right"></div>
                        <div class="img_holder">
                            <a href="{{url('agents/'.$agent->id.'/'.Str::slug($agent->first_name.' '.$agent->last_name))}}">
                            <div class="agents_img">
                                @if(@$agent->profile->photo)
                                <img src="<?=Croppa::url($agent->profile->photo, 225, 230, array('resize'))?>" alt="{{@$agent->first_name}} {{@$agent->last_name}}"/>
                                @endif
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="someclass">
                        <h4><strong> <p>{{ link_to('agents/'.$agent->id.'/'.Str::slug($agent->first_name.' '.$agent->last_name), $agent->first_name .' '.$agent->last_name ) }} </p></strong></h4>
                        <p>{{ @$agent->profile->designation }}</p>    
                    </div>
                 </div>
                @endforeach
                @endif
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="contact_box">
                <div class="box_header text-center">
                    <h3>NEED HELP FINDING THE RIGHT AGENT</h3>
                    <p>Tell us what you're looking for and we'll have an agent with experience in your area get in touch ASAP</p>
                </div>

                <form role="form">
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Phone No:</label>
                        <input type="text" class="form-control" placeholder="(_ _ _) _ _ _ - _ _ _">
                    </div>
                    <div class="form-group">
                        <label>
                            Where are you buying or selling? <br>
                            <span>Optional- this enables a more personal experiance</span>
                        </label>

                        <input type="text" class="form-control" placeholder="City States or ZIP">
                    </div>

                    <div class="form-group">
                        <label>
                            Comments/questions
                        </label>
                        <textarea class="form-control" cols="30" rows="5"></textarea>
                    </div>

                    <button class="btn btn-danger btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@stop