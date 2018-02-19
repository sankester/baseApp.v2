@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('base.manage.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-xl-4 col-lg-5">

                <!-- Profile Image -->
                <div class="box">
                    <div class="box-body box-profile">
                        <img class="profile-user-img rounded-circle img-fluid mx-auto d-block" src="{{ ! empty($user->userData->foto) ?  asset('images/avatar/thumbnail/'.$user->userData->foto) : asset('themes/base/images/avatar/5.jpg') }}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $user->userData->nama_lengkap }}</h3>

                        <p class="text-muted text-center">@foreach($user->role as $key => $role) {{$role->role_nm}} @if($key+1 != $user->role->count()) - @endif @endforeach </p>

                        <div class="row social-states">
                            <div class="col-6 text-right"><a href="#" class="link"><i class="ion ion-ios-people-outline"></i> 254</a></div>
                            <div class="col-6 text-left"><a href="#" class="link"><i class="ion ion-images"></i> 54</a></div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="profile-user-info">
                                    <p>Email </p>
                                    <h6 class="margin-bottom">{{ $user->email }}</h6>
                                    <p>Phone</p>
                                    <h6 class="margin-bottom">{{ $user->userData->no_telp }}</h6>
                                    <p>Address</p>
                                    <h6 class="margin-bottom">{{  $user->userData->alamat  }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-xl-8 col-lg-7">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">

                        <li><a class="" href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>
                        <li><a href="#activity" data-toggle="tab" class="active" aria-expanded="true">Activity</a></li>
                        <li><a href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane" id="timeline" aria-expanded="false">
                            <!-- The timeline -->
                            <ul class="timeline">
                                <!-- timeline time label -->
                                <li class="time-label">
						  <span class="bg-info">
							15 Jan. 2017
						  </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion ion-email bg-blue"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 11:48</span>

                                        <h3 class="timeline-header"><a href="#">Genelia</a> sent you an email</h3>

                                        <div class="timeline-body">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. ...
                                        </div>
                                        <div class="timeline-footer text-right">
                                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion ion-person bg-green"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 11 mins ago</span>

                                        <h3 class="timeline-header no-border"><a href="#">Ritesh Deshmukh</a> accepted your friend request</h3>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion ion-chatbubble-working bg-purple"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 55 mins ago</span>

                                        <h3 class="timeline-header"><a href="#">Jone Doe</a> commented on your post</h3>

                                        <div class="timeline-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus numquam facilis enim eaque, tenetur nam id qui vel velit similique nihil iure molestias aliquam, voluptatem totam quaerat, magni commodi quisquam.
                                        </div>
                                        <div class="timeline-footer text-right">
                                            <a class="btn bg-purple btn-flat btn-sm">View comment</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <li class="time-label">
						  <span class="bg-info">
							15 Nov. 2016
						  </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion ion-ios-reverse-camera bg-yellow"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 8 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Rakesh Kumar</a> uploaded new photos</h3>

                                        <div class="timeline-body">
                                            <img src="../../../images/150x100.png" alt="..." class="margin">
                                            <img src="../../../images/150x100.png" alt="..." class="margin">
                                            <img src="../../../images/150x100.png" alt="..." class="margin">
                                            <img src="../../../images/150x100.png" alt="..." class="margin">
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion ion-ios-videocam bg-pink"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 18 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Ajay Varma</a> shared a video</h3>

                                        <div class="timeline-body">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe width="854" height="480" src="https://www.youtube.com/embed/k85mRPqvMbE" frameborder="0" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
                                        <div class="timeline-footer text-right">
                                            <a href="#" class="btn btn-sm bg-purple">See comments</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="activity" aria-expanded="true">
                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-bordered-sm rounded-circle" src="../../../images/user1-128x128.jpg" alt="user image">
                                    <span class="username">
                          <a href="#">John Doe</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                    <span class="description">5 minutes ago</span>
                                </div>
                                <!-- /.user-block -->
                                <div class="activitytimeline">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum.
                                    </p>
                                    <ul class="list-inline">
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                        </li>
                                        <li class="pull-right">
                                            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                                (5)</a></li>
                                    </ul>
                                    <form class="form-element">
                                        <input class="form-control input-sm" type="text" placeholder="Type a comment">
                                    </form>
                                </div>
                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-bordered-sm rounded-circle" src="../../../images/user6-128x128.jpg" alt="user image">
                                    <span class="username">
                          <a href="#">John Doe</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                    <span class="description">5 minutes ago</span>
                                </div>
                                <!-- /.user-block -->
                                <div class="activitytimeline">
                                    <div class="row margin-bottom">
                                        <div class="col-sm-6">
                                            <img class="img-fluid" src="../../../images/photo1.png" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <img class="img-fluid" src="../../../images/photo2.png" alt="Photo">
                                                    <br><br>
                                                    <img class="img-fluid" src="../../../images/photo3.jpg" alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-6">
                                                    <img class="img-fluid" src="../../../images/photo4.jpg" alt="Photo">
                                                    <br><br>
                                                    <img class="img-fluid" src="../../../images/photo1.png" alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <ul class="list-inline">
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                        </li>
                                        <li class="pull-right">
                                            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                                (5)</a></li>
                                    </ul>

                                    <form class="form-element">
                                        <input class="form-control input-sm" type="text" placeholder="Type a comment">
                                    </form>
                                </div>
                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post clearfix">
                                <div class="user-block">
                                    <img class="img-bordered-sm rounded-circle" src="../../../images/user7-128x128.jpg" alt="user image">
                                    <span class="username">
                          <a href="#">John Doe</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                    <span class="description">5 minutes ago</span>
                                </div>
                                <!-- /.user-block -->
                                <div class="activitytimeline">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum.
                                    </p>

                                    <form class="form-horizontal form-element">
                                        <div class="form-group row no-gutters">
                                            <div class="col-sm-9">
                                                <input class="form-control input-sm" placeholder="Response">
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.post -->

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="settings">
                            <form class="form-horizontal form-element col-12">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-2 control-label">Phone</label>

                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" id="inputPhone" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="ml-auto col-sm-10">
                                        <div class="checkbox">
                                            <input type="checkbox" id="basic_checkbox_1" checked="">
                                            <label for="basic_checkbox_1"> I agree to the</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Terms and Conditions</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="ml-auto col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
@endsection