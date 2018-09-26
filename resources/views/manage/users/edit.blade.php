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
                    <li class="breadcrumb-item"><a href="/manage/users/{{$user->id}}">{{$user->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h1 class="title">Edit User</h1>

			<div class="card">

				<div class="card-body">

			<form action="{{route('users.update', $user->id)}}" method="POST">
				{{method_field('PUT')}}
				{{csrf_field()}}

				<div class="form-group">
					<label for="name">Name</label>
				    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" aria-describedby="name" placeholder="Enter Name" value="{{$user->name}}">
				</div>
				
				<div class="form-group">
				    <label for="email">Name</label>
				    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" aria-describedby="email" placeholder="Enter Email Address" value="{{$user->email}}">
				</div>

				<div class="form-group">
                    <label for="role">User Role</label>
                    <select class="form-control text-capitalize" name="role">
                        <option value="">Select A Role</option>
                            @foreach ($roles as $role)
                            @if ($user->roles->count() > 0)
                                <option value="{{$role->id}}" @if ($user->roles[0]->name === $role->name) selected @endif>{{$role->name}}</option>
                            @else
                            	<option value="{{$role->id}}">{{$role->name}}</option>
                            @endif
                         	@endforeach
                    </select>
                        </div>
					
				<button type="submit" class="btn btn-primary">Submit</button>

			</form>

		</div>

	</div>

		</div>

	</div>

</div>
@endsection