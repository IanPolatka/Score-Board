@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Boys Golf</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h3 class="title">Boys Golf</h3>

            <div class="row justify-content-center mb-4">

                <div class="col">

                    <div class="form-group mb-0">
                        <label for="exampleFormControlSelect1">Jump To A Team</label>
                        <select class="form-control" id="teams" onChange="window.location.href=this.value">
                            <option>Select A Team</option>
                            @foreach($teams as $team)
                                <option value="/boys-golf/{{ $theCurrentYear[0]->year }}/{{$team->school_name}}">{{$team->school_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @role(['superadministrator','administrator', 'editor'])
                    <div class="col align-self-end">
                        <a href="{{ route('boysgolf.create') }}" class="btn btn-primary btn-block">Create Match</a>
                    </div>
                @endrole

            </div><!--  Row  -->

            <h5 class="text-muted">Today's Matches</h5>
            <div class="list-group">
                @forelse ($todaysMatches as $match)
                    <a href="/boys-golf/{{$match->id}}" class="list-group-item list-group-item-action">
                        <img class="school-logo mr-3 mb-2" src="/images/team-logos/{{ $match->away_team->logo }}" />{{$match->away_team->school_name}}<br />
                        <img class="school-logo mr-3" src="/images/team-logos/{{ $match->home_team->logo }}" />{{$match->home_team->school_name}}
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Matches Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted mt-4">Yesterday's Matches</h5>
            <div class="list-group">
                @forelse ($yesterdaysMatches as $match)
                  <a href="/boys-golf/{{$match->id}}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center mb-3">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($match->away_team->logo)
                                        <img src="/images/team-logos/{{ $match->away_team->logo }}" />
                                    @endif
                                </div>
                                @if($match->away_team_final_score && ($match->away_team_final_score > $match->home_team_final_score))
                                <strong>{{$match->away_team->school_name}}</strong>
                                @else
                                    {{$match->away_team->school_name}}
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($match->away_team_final_score))
                                    @if($match->away_team_final_score && ($match->away_team_final_score > $match->home_team_final_score))
                                        <strong>{{$match->away_team_final_score}}</strong>
                                    @else
                                        {{$match->away_team_final_score}}
                                    @endif
                                @else
                                    {{$match->game_time->time}}
                                @endif 
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($match->home_team->logo)
                                        <img src="/images/team-logos/{{ $match->home_team->logo }}" />
                                    @endif
                                </div>
                                @if($match->home_team_final_score && ($match->home_team_final_score > $match->away_team_final_score))
                                    <span><strong>{{$match->home_team->school_name}} ({{$match->home_team->state}})</strong></span>
                                @else
                                    <span>{{$match->home_team->school_name}} ({{$match->home_team->state}})<br />
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($match->home_team_final_score))
                                    @if($match->home_team_final_score && ($match->home_team_final_score > $match->away_team_final_score))
                                        <strong>{{$match->home_team_final_score}}</strong>
                                    @else
                                        {{$match->home_team_final_score}}
                                    @endif
                                @endif 
                            </div>
                        </div>
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Matches Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted mt-4">Tomorrow's Matches</h5>
            <div class="list-group">
                @forelse ($tomorrowsMatches as $match)
                    <a href="/boys-golf/{{$match->id}}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center mb-3">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($match->away_team->logo)
                                        <img src="/images/team-logos/{{ $match->away_team->logo }}" />
                                    @endif
                                </div>
                                @if($match->away_team_final_score && ($match->away_team_final_score > $match->home_team_final_score))
                                <strong>{{$match->away_team->school_name}}</strong>
                                @else
                                    {{$match->away_team->school_name}}
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($match->away_team_final_score))
                                    @if($match->away_team_final_score && ($match->away_team_final_score > $match->home_team_final_score))
                                        <strong>{{$match->away_team_final_score}}</strong>
                                    @else
                                        {{$match->away_team_final_score}}
                                    @endif
                                @else
                                    {{$match->game_time->time}}
                                @endif 
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-9">
                                <div class="school-logo mr-3">
                                    @if($match->home_team->logo)
                                        <img src="/images/team-logos/{{ $match->home_team->logo }}" />
                                    @endif
                                </div>
                                @if($match->home_team_final_score && ($match->home_team_final_score > $match->away_team_final_score))
                                    <span><strong>{{$match->home_team->school_name}} ({{$match->home_team->state}})</strong></span>
                                @else
                                    <span>{{$match->home_team->school_name}} ({{$match->home_team->state}})<br />
                                @endif
                            </div>
                            <div class="col-3 text-right">
                                @if(isset($match->home_team_final_score))
                                    @if($match->home_team_final_score && ($match->home_team_final_score > $match->away_team_final_score))
                                        <strong>{{$match->home_team_final_score}}</strong>
                                    @else
                                        {{$match->home_team_final_score}}
                                    @endif
                                @endif 
                            </div>
                        </div>
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Matches Listed</a>
                @endforelse
            </div>

		</div>

	</div>

</div>
@endsection