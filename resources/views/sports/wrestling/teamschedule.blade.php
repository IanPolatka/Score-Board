@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/wrestling">Wrestling</a></li>
                    <li class="breadcrumb-item active">{{$selectedTeam->school_name}}</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">

            <div class="row justify-content-center mb-4">

                <div class="col">

                    <div class="form-group mb-0">
                        <label for="exampleFormControlSelect1">Jump To A Team</label>
                        <select class="form-control" id="teams" onChange="window.location.href=this.value">
                            <option>Select A Team</option>
                            @foreach($teams as $team)
                                <option value="/wrestling/2018-2019/{{$team->school_name}}" @if ($team->school_name == $selectedTeam->school_name) selected @endif>{{$team->school_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @role(['superadministrator','administrator'])
                    <div class="col align-self-end">
                        <a href="{{ route('wrestling.create') }}" class="btn btn-primary btn-block">Create Match</a>
                    </div>
                @endrole

            </div>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10 col-sm-12">

            <h2>{{$selectedTeam->school_name}}</h2>

            <h5 class="text-muted">Varsity Schedule</h5>

            <div class="list-group mb-4">
                @forelse ($varsity as $match)
                    <a href="/wrestling/{{$match->id}}" class="list-group-item list-group-item-action">

                        <div class="row">
                            <div class="col">
                            <em>{{ Carbon\Carbon::parse($match->date)->format('l') }} {{ Carbon\Carbon::parse($match->date)->format('M j, o') }}</em>
                            </div>
                        </div>

                        <div class="row align-items-center">

                                <div class="col-lg-1">
                                        <img class="school-logo" src="/images/team-logos/{{ $match->host_team->logo }}" />
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 class="mb-0">{{$match->tournament_name}}</h5>
                                        <p class="text-muted mb-0">(At {{$match->host_team->school_name}})</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <p class="mb-0 text-right"><strong>{{$match->result}}</strong></p>
                                    </div>

                        </div><!--  Row  -->

                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

		</div><!--  Col  -->

	</div><!--  Row  -->

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10 col-sm-12">

            <h5 class="text-muted">Junior Varsity Schedule</h5>

            <div class="list-group mb-4">
                @forelse ($juniorvarsity as $match)
                    <a href="/wrestling/{{$match->id}}" class="list-group-item list-group-item-action">

                        <div class="row">
                            <div class="col">
                            <em>{{ Carbon\Carbon::parse($match->date)->format('l') }} {{ Carbon\Carbon::parse($match->date)->format('M j, o') }}</em>
                            </div>
                        </div>

                        <div class="row align-items-center">

                                <div class="col-lg-1">
                                        <img class="school-logo" src="/images/team-logos/{{ $match->host_team->logo }}" />
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 class="mb-0">{{$match->tournament_name}}</h5>
                                        <p class="text-muted mb-0">(At {{$match->host_team->school_name}})</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <p class="mb-0 text-right"><strong>{{$match->result}}</strong></p>
                                    </div>

                        </div><!--  Row  -->

                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

        </div><!--  Col  -->

    </div><!--  Row  -->

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10 col-sm-12">

            <h5 class="text-muted">Freshman Schedule</h5>

            <div class="list-group mb-4">
                @forelse ($freshman as $match)
                    <a href="/wrestling/{{$match->id}}" class="list-group-item list-group-item-action">

                        <div class="row">
                            <div class="col">
                            <em>{{ Carbon\Carbon::parse($match->date)->format('l') }} {{ Carbon\Carbon::parse($match->date)->format('M j, o') }}</em>
                            </div>
                        </div>

                        <div class="row align-items-center">

                                <div class="col-lg-1">
                                        <img class="school-logo" src="/images/team-logos/{{ $match->host_team->logo }}" />
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 class="mb-0">{{$match->tournament_name}}</h5>
                                        <p class="text-muted mb-0">(At {{$match->host_team->school_name}})</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <p class="mb-0 text-right"><strong>{{$match->result}}</strong></p>
                                    </div>

                        </div><!--  Row  -->

                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

        </div><!--  Col  -->

    </div><!--  Row  -->

</div><!--  Container  -->
@endsection