@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/boys-basketball">Boys Basketball</a></li>
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

                <div class="card-header">

                    <div class="row">
                        <div class="col-lg-6">
                            <strong>
                                @if ($game->team_level === 1)
                                    VARSITY LEVEL EVENT
                                @elseif ($game->team_level === 2)
                                    JUNIOR VARSITY LEVEL EVENT
                                @else
                                    FRESHMAN LEVEL EVENT
                                @endif
                            </strong>
                        </div>
                        <div class="col-lg-6 text-right">
                            <strong>
                                @if ($game->game_status < 1)
                                    {{$game->game_time->time}}
                                @elseif ($game->game_status === 1)
                                    FINAL
                                @else
                                    <?php
                                    $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                    if ($game->game_status == 2) {
                                        echo '<strong><span class="text-danger">1ST QUARTER</span></strong>';
                                    } elseif ($game->game_status == 3) {
                                        echo '<strong><span class="text-danger">2ND QUARTER</span></strong>';
                                    } elseif ($game->game_status == 4) {
                                        echo '<strong><span class="text-danger">HALFTIME</span></strong>';
                                    } elseif ($game->game_status == 5) {
                                        echo '<strong><span class="text-danger">3RD QUARTER</span></strong>';
                                    } elseif ($game->game_status == 6) {
                                        echo '<strong><span class="text-danger">4TH QUARTER</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">' . $numberFormatter->format($game->game_status - 4) . ' OT</span></strong>';
                                    } ?>
                                    @if($game->game_status != 4)
                                        @if(!empty($game->game_minute) || !empty($game->game_second))
                                            <strong class="border-left pl-2 ml-2">{{$game->game_minute}}:{{$game->game_second}}</strong>
                                        @endif
                                    @endif
                                @endif
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    

                    <div class="row align-items-center mb-3">
                        <div class="col-9">
                            <div class="school-logo mr-3">
                                @if($game->away_team->logo)
                                    <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                @endif
                            </div>
                            @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                <strong><a href="/boys-basketball/{{$game->the_year->year}}/{{$game->away_team->school_name}}">{{$game->away_team->school_name}} ({{$game->away_team->state}})</a></strong>
                            @else
                                <a href="/boys-basketball/{{$game->the_year->year}}/{{$game->away_team->school_name}}">{{$game->away_team->school_name}}</a>
                            @endif
                        </div>
                        <div class="col-3 text-right">
                            @if($game->game_status > 0)
                                @if(isset($game->away_team_final_score))
                                    @if($game->away_team_final_score && ($game->away_team_final_score > $game->home_team_final_score))
                                        <strong>{{$game->away_team_final_score}}</strong>
                                    @else
                                        {{$game->away_team_final_score}}
                                    @endif
                                @else
                                    <?php $away_total = 0; ?>
                                    @foreach ($game->scores as $score)
                                        <?php $away_total += $score->away_team_score; ?>
                                    @endforeach
                                    {{$away_total}}
                                @endif
                            @else
                                -
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
                                <span><strong><a href="/boys-basketball/{{$game->the_year->year}}/{{$game->home_team->school_name}}">{{$game->home_team->school_name}} ({{$game->home_team->state}})</a></strong></span>
                            @else
                                <span><a href="/boys-basketball/{{$game->the_year->year}}/{{$game->home_team->school_name}}">{{$game->home_team->school_name}} ({{$game->home_team->state}})</a><br />
                            @endif
                        </div>
                        <div class="col-3 text-right">
                            @if($game->game_status > 0)
                                @if(isset($game->home_team_final_score))
                                    @if($game->home_team_final_score && ($game->home_team_final_score > $game->away_team_final_score))
                                        <strong>{{$game->home_team_final_score}}</strong>
                                    @else
                                        {{$game->home_team_final_score}}
                                    @endif
                                @else
                                    <?php $home_total = 0; ?>
                                    @foreach ($game->scores as $score)
                                        <?php $home_total += $score->home_team_score; ?>
                                    @endforeach
                                    {{$home_total}}
                                @endif
                            @else
                                -
                            @endif 
                        </div>
                    </div>
                </div>

            </div><!--  Card  -->

            @role(['superadministrator', 'administrator', 'editor'])

            <div class="row">

                <div class="col-lg-4 col-mg-4 col-sm-4 mb-3">
                    <a href="{{ route('basketball-boys-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Game</a> 
                </div>
                <div class="col-lg-4 col-mg-4 col-sm-4 mb-3">
                    <a href="{{ route('basketball-boys-score-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Game Play</a> 
                </div>
                <div class="col-lg-4 col-mg-4 col-sm-4 mb-3">

                    <form method="POST" action="/boys-basketball/delete/{{ $game->id }}">

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