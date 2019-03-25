@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/track">Track & Field</a></li>
                    <li class="breadcrumb-item active">Event ID: {{$match->id}}</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-body">

                    <div class="row align-items-center mb-3">
                        <div class="col-9">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <img class="school-logo" src="/images/team-logos/{{ $match->the_team->logo }}" />
                                    </div>
                                    <div class="col-lg-10">
                                        <h5 class="mb-0">{{$match->the_team->school_name}}</h5>
                                        <p class="text-muted mb-0">{{$match->tournament_name}} (At {{$match->host_team->school_name}})</p>
                                    </div>
                                </div>

                        </div>

                    </div>

                </div>

            </div><!--  Card  -->

            @role(['superadministrator', 'administrator', 'editor'])

            <div class="row">

                <div class="col">
                    <a href="{{ route('track.edit', $match->id)}}" class="btn btn-primary btn-block">Edit Match</a> 
                </div>
                <div class="col">

                    <form method="POST" action="/track/delete/{{ $match->id }}">

                        {{ method_field('DELETE') }}

                        {{ csrf_field() }}    

                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-block">Delete Match</button>
                            
                    </form>

                </div>

            </div>

            @endrole

		</div><!--  Col  -->

	</div><!--  Row  -->

</div><!--  Container  -->
@endsection