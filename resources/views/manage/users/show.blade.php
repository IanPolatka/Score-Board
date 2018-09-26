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
                    <li class="breadcrumb-item active">{{$user->name}}</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">

	<div class="row">

		<div class="col">
	
			<h1 class="title">Manage Users</h1>

			<table class="table table-bordered table-hover">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">First</th>
			      <th scope="col">Last</th>
			      <th scope="col">Role</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">{{$user->id}}</th>
			      <td>{{$user->name}}k</td>
			      <td>{{$user->email}}</td>
			      <td>@foreach ($user->roles as $role)
			      			{{$role->display_name}}
			      		@endforeach
			      </td>
			      <td><a class="btn btn-primary" href="{{route('users.edit', $user->id)}}">Edit</a></td>
			    </tr>
			  </tbody>
			</table>

		</div>

	</div>

</div>
@endsection