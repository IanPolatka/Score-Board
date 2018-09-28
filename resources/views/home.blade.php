@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            @if (count($soccer_boys) > 0)

                <h5 class="text-muted">Today's Soccer Games</h5>
                @foreach ($soccer_boys as $game)
                    <a href="/boys-soccer/{{$game->id}}" class="list-group-item list-group-item-action">
                        <div class="row team-level-identifier">
                            <div class="col">
                                @if ($game->team_level === 1)
                                    Varsity
                                @elseif ($game->team_level === 2)
                                    Junior Varsity
                                @else
                                    Freshman
                                @endif
                            </div>
                        </div>
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
                                @if($game->home_team_final_score)
                                    @if($game->home_team_final_score && ($game->home_team_final_score > $game->away_team_final_score))
                                        <strong>{{$game->home_team_final_score}}</strong>
                                    @else
                                        {{$game->home_team_final_score}}
                                    @endif
                                @endif 
                            </div>
                        </div>
                    </a>
                @endforeach

            @endif

        </div>
    </div>
</div>
@endsection
