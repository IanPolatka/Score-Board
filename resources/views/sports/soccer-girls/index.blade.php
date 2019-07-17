@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Girls Soccer</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h3 class="title">Girls Soccer</h3>

            <div class="row justify-content-center mb-4">

                <div class="col">

                    <div class="form-group mb-0">
                        <label for="exampleFormControlSelect1"><h6 class="mb-0">Jump To A Team</h6></label>
                        <select class="form-control" id="teams" onChange="window.location.href=this.value">
                            <option>Select A Team</option>
                            @foreach($teams as $team)
                                <option value="/girls-soccer/2018-2019/{{$team->school_name}}">{{$team->school_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @role(['superadministrator','administrator', 'editor'])
                    <div class="col align-self-end">
                        <a href="{{ route('girlssoccer.create') }}" class="btn btn-primary btn-block">Create Match</a>
                    </div>
                @endrole

            </div><!--  Row  -->

            <hr>

            <h5 class="text-muted">Today's Events</h5>
            <div class="list-group">
                @forelse ($todaysGames as $game)
                    <a href="/girls-soccer/{{$game->id}}" class="list-group-item list-group-item-action">
                        <img class="school-logo mr-3 mb-2" src="/images/team-logos/{{ $game->away_team->logo }}" />{{$game->away_team->school_name}}<br />
                        <img class="school-logo mr-3" src="/images/team-logos/{{ $game->home_team->logo }}" />{{$game->home_team->school_name}}
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted mt-4">Yesterday's Events</h5>
            <div class="list-group">
                @forelse ($yesterdaysGames as $game)
                  <a href="/girls-soccer/{{$game->id}}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center mb-3">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($game->away_team->logo)
                                        <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                    @endif
                                </div>
                                @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                <strong>{{$game->away_team->school_name}}</strong>
                                @else
                                    {{$game->away_team->school_name}}
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($game->away_team_final_score))
                                    @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                        <strong>{{$game->away_team_final_score}}</strong>
                                    @else
                                        {{$game->away_team_final_score}}
                                    @endif
                                @else
                                    {{$game->game_time->time}}
                                @endif 
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($game->home_team->logo)
                                        <img src="/images/team-logos/{{ $game->home_team->logo }}" />
                                    @endif
                                </div>
                                @if($game->home_team_final_score && ($game->home_team_final_score > $game->away_team_final_score))
                                    <span><strong>{{$game->home_team->school_name}} ({{$game->home_team->state}})</strong></span>
                                @else
                                    <span>{{$game->home_team->school_name}} ({{$game->home_team->state}})<br />
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($game->home_team_final_score))
                                    @if($game->home_team_final_score && ($game->home_team_final_score > $game->away_team_final_score))
                                        <strong>{{$game->home_team_final_score}}</strong>
                                    @else
                                        {{$game->home_team_final_score}}
                                    @endif
                                @endif 
                            </div>
                        </div>
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted mt-4">Tomorrow's Events</h5>
            <div class="list-group">
                @forelse ($tomorrowsGames as $game)
                    <a href="/girls-soccer/{{$game->id}}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center mb-3">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($game->away_team->logo)
                                        <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                    @endif
                                </div>
                                @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                <strong>{{$game->away_team->school_name}}</strong>
                                @else
                                    {{$game->away_team->school_name}}
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($game->away_team_final_score))
                                    @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                        <strong>{{$game->away_team_final_score}}</strong>
                                    @else
                                        {{$game->away_team_final_score}}
                                    @endif
                                @else
                                    {{$game->game_time->time}}
                                @endif 
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($game->home_team->logo)
                                        <img src="/images/team-logos/{{ $game->home_team->logo }}" />
                                    @endif
                                </div>
                                @if($game->home_team_final_score && ($game->home_team_final_score > $game->away_team_final_score))
                                    <span><strong>{{$game->home_team->school_name}} ({{$game->home_team->state}})</strong></span>
                                @else
                                    <span>{{$game->home_team->school_name}} ({{$game->home_team->state}})<br />
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($game->home_team_final_score))
                                    @if($game->home_team_final_score && ($game->home_team_final_score > $game->away_team_final_score))
                                        <strong>{{$game->home_team_final_score}}</strong>
                                    @else
                                        {{$game->home_team_final_score}}
                                    @endif
                                @endif 
                            </div>
                        </div>
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

		</div>

	</div>

</div>
@endsection