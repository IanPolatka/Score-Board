@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">

	<div class="row">

		<div class="col">
	
			<h3 class="title">Manage Users</h3>

			<p><a href="{{route('users.create')}}" class="btn btn-primary">Create User</a></p>

			<table class="table table-bordered table-hover">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">First</th>
			      <th scope="col">Email</th>
			      <th scope="col">Role</th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($users as $user)
			    <tr>
			      <th scope="row">{{$user->id}}</th>
			      <td>{{$user->name}}</td>
			      <td>{{$user->email}}</td>
			      <td>@foreach ($user->roles as $role)
			      	{{$role->name}}
			      @endforeach</td>
			      <td><a class="btn btn-primary" href="{{route('users.edit', $user->id)}}">Edit</a> <a class="btn btn-secondary" href="{{route('users.show', $user->id)}}">Show</a></td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>

		</div>

	</div>

</div>
@endsection