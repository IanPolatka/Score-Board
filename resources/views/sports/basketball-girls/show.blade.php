@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/girls-basketball">Girls Basketball</a></li>
                    <li class="breadcrumb-item active">Game ID: {{$game->id}}</li>
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
                            <div class="school-logo mr-3">
                                @if($game->away_team->logo)
                                    <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                @endif
                            </div>
                            @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                <strong><a href="/girls-basketball/2018-2019/{{$game->away_team->school_name}}">{{$game->away_team->school_name}} ({{$game->away_team->state}})</a></strong>
                            @else
                                <a href="/girls-basketball/2018-2019/{{$game->away_team->school_name}}">{{$game->away_team->school_name}}</a>
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
                                <span><strong><a href="/girls-basketball/2018-2019/{{$game->home_team->school_name}}">{{$game->home_team->school_name}} ({{$game->home_team->state}})</a></strong></span>
                            @else
                                <span><a href="/girls-basketball/2018-2019/{{$game->home_team->school_name}}">{{$game->home_team->school_name}} ({{$game->home_team->state}})</a><br />
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
                </div>

            </div><!--  Card  -->

            @role(['superadministrator', 'administrator', 'editor'])

            <div class="row">

                <div class="col">
                    <a href="{{ route('basketball-girls-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Game</a> 
                </div>
                <div class="col">
                    <a href="{{ route('basketball-girls-score-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Game Play</a> 
                </div>
                <div class="col">

                    <form method="POST" action="/girls-basketball/delete/{{ $game->id }}">

                        {{ method_field('DELETE') }}

                        {{ csrf_field() }}    

                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-block">Delete Game</button>
                            
                    </form>

                </div>

            </div>

            @endrole

		</div><!--  Col  -->

	</div><!--  Row  -->

</div><!--  Container  -->
@endsection