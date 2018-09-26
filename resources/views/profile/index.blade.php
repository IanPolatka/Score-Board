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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        	<ul class="list-group mb-4">
			  	<li class="list-group-item"><h6 class="text-muted">Name</h6><h3>{{$user->name}}</h3></li>
			  	<li class="list-group-item"><h6 class="text-muted">Email Address</h6><h3>{{$user->email}}</h3></li>
			</ul>

			<a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>

		</div>

	</div>
</div>



@endsection