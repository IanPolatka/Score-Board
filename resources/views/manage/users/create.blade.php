@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/manage/users">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h1 class="title">Create New User</h1>

			<div class="card">

				<div class="card-body">

					<form action="{{route('users.store')}}" method="POST">
					@csrf

					<div class="form-group">
						<label for="name">Name</label>
					    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" aria-describedby="name" placeholder="Enter Name" value="{{ old('name') }}">

					    @if ($errors->has('name'))
	                        <span class="invalid-feedback">
	                            <strong>{{ $errors->first('name') }}</strong>
	                        </span>
	                    @endif
					</div>
				
					<div class="form-group">
					    <label for="email">Email</label>
					    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" aria-describedby="email" placeholder="Enter Email Address" value="{{ old('email') }}">

					    @if ($errors->has('email'))
	                        <span class="invalid-feedback">
	                            <strong>{{ $errors->first('email') }}</strong>
	                        </span>
	                    @endif
					</div>

					<div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" aria-describedby="password" placeholder="Enter Password" name="password">
					    <small id="emailHelp" class="form-text text-muted">Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.</small>

					    @if ($errors->has('password'))
	                        <span class="invalid-feedback">
	                            <strong>{{ $errors->first('password') }}</strong>
	                        </span>
	                    @endif
					</div>

					<div class="form-group">
					    <label for="password-confirm">Confirm Password</label>
					    <input type="password" class="form-control" id="password-confirm" aria-describedby="password" placeholder="Enter Password" name="password_confirmation">
					</div>
					
					<button type="submit" class="btn btn-primary">Submit</button>

					</form>

				</div>

			</div>

		</div>

	</div>

</div>
@endsection