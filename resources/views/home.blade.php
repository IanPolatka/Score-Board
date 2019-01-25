@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12 col-sm-12">

            <h3>Todays Event's</h3>

            @if (count($basketball_boys) > 0)

                <h5 class="text-muted mt-3">Boys Basketball</h5>

                <div class="row">

                    @foreach ($basketball_boys as $game)

                        <div class="col-lg-6 col-md-12 mb-3">

                            <a href="/boys-basketball/{{$game->id}}" class="list-group-item list-group-item-action">
                    
                                <div class="row team-level-identifier">
                                    <div class="col">
                                        @if ($game->team_level === 1)
                                            Varsity Level Event
                                        @elseif ($game->team_level === 2)
                                            Junior Varsity Level Event
                                        @else
                                            Freshman Level Event
                                        @endif
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-9">
                                        <div class="school-logo mr-3">
                                            @if($game->away_team->logo)
                                                <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                            @endif
                                        </div>
                                        @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                            <strong>{{$game->away_team->school_name}} ({{$game->away_team->state}})</strong>
                                        @else
                                            {{$game->away_team->school_name}} ({{$game->away_team->state}})
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

                        </div><!--  Col  -->

                    @endforeach

                </div>

            @endif




            @if (count($basketball_girls) > 0)

                <h5 class="text-muted mt-3">Girls Basketball</h5>

                <div class="row">

                    @foreach ($basketball_girls as $game)

                        <div class="col-lg-6 col-md-12 mb-3">

                            <a href="/girls-basketball/{{$game->id}}" class="list-group-item list-group-item-action">
                    
                                <div class="row team-level-identifier">
                                    <div class="col">
                                        @if ($game->team_level === 1)
                                            Varsity Level Event
                                        @elseif ($game->team_level === 2)
                                            Junior Varsity Level Event
                                        @else
                                            Freshman Level Event
                                        @endif
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-9">
                                        <div class="school-logo mr-3">
                                            @if($game->away_team->logo)
                                                <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                            @endif
                                        </div>
                                        @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                            <strong>{{$game->away_team->school_name}} ({{$game->away_team->state}})</strong>
                                        @else
                                            {{$game->away_team->school_name}} ({{$game->away_team->state}})
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

                        </div><!--  Col  -->

                    @endforeach

                </div>

            @endif


            @if (count($bowling_boys) > 0)

                <h5 class="text-muted mt-4">Boys Bowling</h5>
                @foreach ($bowling_boys as $game)
                    <a href="/boys-bowling/{{$game->id}}" class="list-group-item list-group-item-action">
                        <div class="row team-level-identifier">
                            <div class="col">
                                @if ($game->team_level === 1)
                                    Varsity Level Event
                                @elseif ($game->team_level === 2)
                                    Junior Varsity Level Event
                                @else
                                    Freshman Level Event
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


            @if (count($bowling_girls) > 0)

                <h5 class="text-muted mt-4">Girls Bowling</h5>
                @foreach ($bowling_girls as $game)
                    <a href="/girls-bowling/{{$game->id}}" class="list-group-item list-group-item-action">
                        <div class="row team-level-identifier">
                            <div class="col">
                                @if ($game->team_level === 1)
                                    Varsity Level Event
                                @elseif ($game->team_level === 2)
                                    Junior Varsity Level Event
                                @else
                                    Freshman Level Event
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


            @if (count($soccer_boys) > 0)

                <h5 class="text-muted mt-4">Today's Soccer Games</h5>
                @foreach ($soccer_boys as $game)
                    <a href="/boys-soccer/{{$game->id}}" class="list-group-item list-group-item-action">
                        <div class="row team-level-identifier">
                            <div class="col">
                                @if ($game->team_level === 1)
                                    Varsity Level Event
                                @elseif ($game->team_level === 2)
                                    Junior Varsity Level Event
                                @else
                                    Freshman Level Event
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
