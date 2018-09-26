@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

@if (Session::has('failure'))
    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h5 class="text-muted">Profile Edit</h5>

            <div class="card mb-4">

                <form method="POST" action="{{ route('profile.update') }}">

                    {{ method_field('PATCH') }}
                    @csrf

                    <div class="card-body">

                        <div class="form-group">

                            <h6 class="text-muted">Name</h6>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$user->name}}" name="name">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group">

                            <h6 class="text-muted">Email Address</h6>
                            <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{$user->email}}" name="email">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                        </div>

                    </div><!--  Card Body  -->

                    <div class="card-footer">

			             <button type="submit" class="btn btn-primary">Submit</button>

                    </div>

                </div>

            </form>


            <h5 class="text-muted">Profile Edit</h5>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">

                <form method="POST" action="{{ route('profile.edit.password') }}">
                {{ csrf_field() }}

                <div class="card-body">


                        <div class="form-group">

                            <h6 class="text-muted"><label for="current-password" class="control-label{{ $errors->has('current-password') ? ' is-invalid' : '' }}">Current Password</label></h6>
                            <input type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password">

                            @if ($errors->has('current-password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('current-password') }}</strong>
                                </span>
                            @endif

                        </div>
 
                        <div class="form-group">
                            <h6 class="text-muted"><label for="new-password" class="control-label{{ $errors->has('new-password') ? ' is-invalid' : '' }}">New Password</label></h6>
                            <input id="new-password" type="password" class="form-control" name="new-password" required>
                            <small id="emailHelp" class="form-text text-muted">Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.</small>
 
                            @if ($errors->has('new-password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('new-password') }}</strong>
                                </span>
                            @endif
                        </div>
 
                        <div class="form-group">
                            <h6 class="text-muted"><label for="new-password-confirm" class="control-label">Confirm New Password</label></h6>
                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                        </div>
 
                    </div><!--  Card Body  -->

                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">
                            Change Password
                        </button>
                    </div><!--  Card Footer  -->

                </form>

            </div><!--  Card  -->
  
		</div>

	</div>
</div>



@endsection