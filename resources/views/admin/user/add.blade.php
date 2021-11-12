@extends('layouts.admin.layout')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Management</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/admin">Home</a></li>
               <li class="breadcrumb-item active">User</li>
               <li class="breadcrumb-item active">User Add/Edit</li>
            </ol>
         </div><!-- /.col -->
      </div><!-- /.row -->
   </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
       @if((isset($data)) && $data->user_id)
			<form id="adminUserForm" action="{{ route('user.update', $data) }}" method="POST" enctype="multipart/form-data">
			  {{ method_field('PUT') }}
		  @else
         <form id="adminUserForm" method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
      @endif
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <input type="hidden" id="user_id" name="user_id" value="{{ isset($data) ? $data->user_id : '' }}">

         <!-- FIRST INFORMATION  - START -->
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- general form elements -->
               <div class="card card-parimary">
                  <div class="card-header">
                     <h3 class="card-title">@if((isset($data)) && $data->user_id) Edit @else Add @endif User</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm-4">
                           <div class="form-group">
                              <label >First Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('first_name') ? 'is-invalid' : ''}}" id="first_name" placeholder="Enter First Name" name="first_name"  value="{{isset($data->first_name) ? $data->first_name : old('first_name')}}" autocomplete="off">
                              @if ($errors->has('first_name'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('first_name') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="form-group">
                              <label >Last Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('last_name') ? 'is-invalid' : ''}}" id="last_name" placeholder="Enter First Name" name="last_name"  value="{{isset($data->last_name) ? $data->last_name : old('last_name')}}" autocomplete="off">
                              @if ($errors->has('last_name'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('last_name') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        {{-- <div class="col-sm-6">
                           <div class="form-group">
                              <label >Email <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" placeholder="Enter email" name="email"  value="{{isset($data->email) ? $data->email : old('email')}}" autocomplete="off">
                              @if ($errors->has('email'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}
                              </div>
                              @endif
                           </div>
                        </div> --}}
                        <div class="col-sm-4">
                           <div class="form-group">
                              <label >Email <span class="text-danger">*</span></label>
                              <div class="input-group">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                 </div>
                                 <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" placeholder="Enter email as username" name="email"  value="{{isset($data->email) ? $data->email : old('email')}}" autocomplete="off" >
                                 @if ($errors->has('email'))
                                 <div class="invalid-feedback">
                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="form-group">
                              <label >Password 
                                 @if((isset($data)) && $data->user_id)
                                 @else
                                 <span class="text-danger">*</span>
                                 @endif
                              </label>
                              <input type="password" class="form-control  {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" placeholder="Enter Password" name="password" autocomplete="off">
                              @if ($errors->has('password'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('password') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="form-group">
                              <label >Confirm Password 
                                 @if((isset($data)) && $data->user_id)
                                 @else
                                 <span class="text-danger">*</span>
                                 @endif
                              </label>
                              <input type="password" class="form-control  {{$errors->has('confirm_password') ? 'is-invalid' : ''}}" id="confirm_password" placeholder="Enter confirm password" name="confirm_password" autocomplete="off">
                              @if ($errors->has('confirm_password'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('confirm_password') }}
                              </div>
                              @endif
                           </div>
                        </div>

                        <div class="col-sm-4">
                           <div class="form-group">
                              <label > User Type <span class="text-danger">*</span></label>
                              <select class="form-control {{$errors->has('user_type') ? 'is-invalid' : ''}}" name="user_type" id="user_type">
                                 <option value="">---Select User Type---</option>
                                 @if(isset($userTypeList) && isset($userTypeList))
                                 @foreach($userTypeList as $key => $value)
                                   <option value="{{$key}}" {{( isset($data->user_type) && $data->user_type === $key || old('user_type') == $key) ? 'selected' : '' }}> {{$value}} </option>
                                 @endforeach
                                 @endif
                               </select>
                               @if ($errors->has('user_type'))
                                 <div class="invalid-feedback">
                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('user_type') }}
                                 </div>
                                 @endif
                           </div>
                        </div>
                     </div>
                     <div class="row">

                        <div class="col-4">
                           <div class="form-group">
                              <label for="image">Profile Picture</label>
                              <div class="custom-file">
                                 <input type="file" class="custom-file-input {{$errors->has('profile_picture') ? 'is-invalid' : ''}}" id="profile_picture" name="profile_picture">
                                 <label class="custom-file-label" for="profile_picture">Choose file</label>
                                 @if($errors->has('profile_picture'))
                                 <div class="invalid-feedback">
                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('profile_picture') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="col-2">
                           <div class="company-logo">
                             @if(isset($data) && ($data->profile_picture) != "")
                              <input type="hidden" value="0" name="imgdel" id="imgdel">
                              <div class="del-img" id="delimg">
                                 <img class="img-thumbnail thums-img" width="100" id="imageview" src="{{ $data->profile_picture!='' ? route('adminimage.displayUserImage',['foldername'=> 'user_images','filename' => $data->profile_picture]) : '/admin-panel/img/avatar5.png'}}">
                                 <a href="javascript:void(0);" onclick="return theImgDelete();" class="remove-icon">
                                    <i class="fas fa-times-circle"></i>
                                 </a>
                              </div>
                             @else
                              <img id="imageview">
                              @endif
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
               <!-- /.card -->
            </div>
         </div>

         <!-- /.row -->
         <!-- FIRST INFORMATION  - END -->
         <div class="row">
            <div class="col-md-12 mb-3">
               <button type="submit" class="btn btn-primary">Submit</button>&nbsp;
               <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
            </div>
         </div>
      </form>
   </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
   $( document ).ready(function() {
      $('#menu_permission').select2({placeholder: " Select Menus"});

      $("#profile_picture").change(function(){
         imagesPreview(this);
         $('#delimg').show();
      });
      $("#adminUserForm").validate({
			rules: {
				name: {
					required: true,
            },
				email: {
					required: true,
				},
				password: {
					required: isPasswordPresent,
				},
            user_type: {
					required: true,
				},
				confirm_password: {
					required: isPasswordPresent,
					equalTo : "#password"
				}
			},
			messages: {
				name: {
					required: 'Full name field is required',
				},
				email: {
					required: 'Email field is required',
				},
            user_type: {
					required: 'User Type field is required',
				},
				password: {
					required: 'The password field is required.',
					minlength: 'The password must be at least 5 characters.'
				},
				confirm_password: {
					required: 'The confirm password field is required.',
					minlength: 'The confirm password must be at least 5 characters.',
					equalTo: 'Your password and confirmation password do not match.',
				}
			},
		});
   });
   function isPasswordPresent() {
      return $('#password').val().length > 0;
   }
   function theImgDelete(){
      $('#delimg').hide();
      $('#imgdel').val('1');
   }
   function imagesPreview(input) {
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
            $('#imageview').attr('src', e.target.result);
            $('#imageview').addClass("img-thumbnail thums-img");
         }
         reader.readAsDataURL(input.files[0]);
      }
   }
</script>
@stop
