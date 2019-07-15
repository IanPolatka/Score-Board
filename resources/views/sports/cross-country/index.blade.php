@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Cross Country</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h3 class="title">Cross Country</h3>

            <div class="row justify-content-center mb-4">

                <div class="col">

                    <div class="form-group mb-0">
                        <label for="exampleFormControlSelect1">Jump To A Team</label>
                        <select class="form-control" id="teams" onChange="window.location.href=this.value">
                            <option>Select A Team</option>
                            @foreach($teams as $team)
                                <option value="/cross-country/{{ $theCurrentYear[0]->year}}/{{$team->school_name}}">{{$team->school_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @role(['superadministrator','administrator'])
                    <div class="col align-self-end">
                        <a href="{{ route('cross-country.create') }}" class="btn btn-primary btn-block">Create Event</a>
                    </div>
                @endrole

            </div><!--  Row  -->

            <h5 class="text-muted">Today's Events</h5>
            <div class="list-group mb-4">
                @forelse ($todaysMatches as $match)
                    <a href="/cross-country/{{$match->id}}" class="list-group-item list-group-item-action">
                        <div class="row">
                        <div class="col-lg-1">
                            <img class="school-logo" src="/images/team-logos/{{ $match->the_team->logo }}" />
                        </div>
                        <div class="col-lg-11">
                            <h5 class="mb-0">{{$match->the_team->school_name}}</h5>
                            <p class="text-muted mb-0">{{$match->tournament_name}} (At {{$match->host_team->school_name}})</p>
                        </div>
                    </div>
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Events Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted">Tomorrow's Events</h5>
            <div class="list-group mb-4">
                @forelse ($tomorrowsMatches as $match)
                    <a href="/cross-country/{{$match->id}}" class="list-group-item list-group-item-action">
                        <div class="row">
                        <div class="col-lg-1">
                            <img class="school-logo" src="/images/team-logos/{{ $match->the_team->logo }}" />
                        </div>
                        <div class="col-lg-11">
                            <h5 class="mb-0">{{$match->the_team->school_name}}</h5>
                            <p class="text-muted mb-0">{{$match->tournament_name}} (At {{$match->host_team->school_name}})</p>
                        </div>
                    </div>
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Events Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted">Yesterday's Events</h5>
            <div class="list-group">
                @forelse ($yesterdaysMatches as $match)
                    <a href="/cross-country/{{$match->id}}" class="list-group-item list-group-item-action">
                        <div class="row">
                        <div class="col-lg-1">
                            <img class="school-logo" src="/images/team-logos/{{ $match->the_team->logo }}" />
                        </div>
                        <div class="col-lg-11">
                            <h5 class="mb-0">{{$match->the_team->school_name}}</h5>
                            <p class="text-muted mb-0">{{$match->tournament_name}} (At {{$match->host_team->school_name}})</p>
                        </div>
                    </div>
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Events Listed</a>
                @endforelse
            </div>

		</div>

	</div>

</div>
@endsection