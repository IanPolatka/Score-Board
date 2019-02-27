@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Girls Basketball</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h3 class="title">Girls Basketball</h3>

            <div class="row justify-content-center mb-4">

                <div class="col">

                    <div class="form-group mb-0">
                        <label for="exampleFormControlSelect1"><h6 class="mb-0">JUMP TO TEAM</h6></label>
                        <select class="form-control" id="teams" onChange="window.location.href=this.value">
                            <option>Select A Team</option>
                            @foreach($teams as $team)
                                <option value="/girls-basketball/{{ $theCurrentYear[0]->year }}/{{$team->school_name}}">{{$team->school_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @role(['superadministrator','administrator'])
                    <div class="col align-self-end">
                        <a href="{{ route('basketball-girls.create') }}" class="btn btn-primary btn-block">Create Game</a>
                    </div>
                @endrole

            </div><!--  Row  -->


            <hr>


            <h5 class="text-muted">Today's Events</h5>
            <div class="list-group">
                @forelse ($todaysGames as $game)
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
                            <div class="col text-right">
                                @if ($game->game_status < 1)
                                    {{$game->game_time->time}}
                                @elseif ($game->game_status === 1)
                                    Final
                                @else
                                    <?php
                                    $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                    if ($game->game_status == 2) {
                                        echo '<strong><span class="text-danger">1st Quarter</span></strong>';
                                    } elseif ($game->game_status == 3) {
                                        echo '<strong><span class="text-danger">2nd Quarter</span></strong>';
                                    } elseif ($game->game_status == 4) {
                                        echo '<strong><span class="text-danger">Halftime</span></strong>';
                                    } elseif ($game->game_status == 5) {
                                        echo '<strong><span class="text-danger">3rd Quarter</span></strong>';
                                    } elseif ($game->game_status == 6) {
                                        echo '<strong><span class="text-danger">4th Quarter</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">' . $numberFormatter->format($game->game_status - 4) . ' OT</span></strong>';
                                    } ?>
                                    @if($game->game_status != 4)
                                        @if(!empty($game->game_minute) || !empty($game->game_second))
                                            <strong class="border-left pl-2 ml-2">{{$game->game_minute}}:{{$game->game_second}}</strong>
                                        @endif
                                    @endif
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
                                    <span><strong>{{$game->home_team->school_name}} ({{$game->home_team->state}})</strong></span>
                                @else
                                    <span>{{$game->home_team->school_name}} ({{$game->home_team->state}})<br />
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
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted mt-4">Yesterday's Events</h5>
            <div class="list-group">
                @forelse ($yesterdaysGames as $game)
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
                            <div class="col text-right">
                                @if ($game->game_status < 1)
                                    {{$game->game_time->time}}
                                @elseif ($game->game_status === 1)
                                    Final
                                @else
                                    <?php
                                    $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                    if ($game->game_status == 2) {
                                        echo '<strong><span class="text-danger">1st Quarter</span></strong>';
                                    } elseif ($game->game_status == 3) {
                                        echo '<strong><span class="text-danger">2nd Quarter</span></strong>';
                                    } elseif ($game->game_status == 4) {
                                        echo '<strong><span class="text-danger">Halftime</span></strong>';
                                    } elseif ($game->game_status == 5) {
                                        echo '<strong><span class="text-danger">3rd Quarter</span></strong>';
                                    } elseif ($game->game_status == 6) {
                                        echo '<strong><span class="text-danger">4th Quarter</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">' . $numberFormatter->format($game->game_status - 4) . ' OT</span></strong>';
                                    } ?>
                                    @if($game->game_status != 4)
                                        @if(!empty($game->game_minute) || !empty($game->game_second))
                                            <strong class="border-left pl-2 ml-2">{{$game->game_minute}}:{{$game->game_second}}</strong>
                                        @endif
                                    @endif
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
                                    <span><strong>{{$game->home_team->school_name}} ({{$game->home_team->state}})</strong></span>
                                @else
                                    <span>{{$game->home_team->school_name}} ({{$game->home_team->state}})<br />
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
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

            <h5 class="text-muted mt-4">Tomorrow's Events</h5>
            <div class="list-group">
                @forelse ($tomorrowsGames as $game)
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
                            <div class="col text-right">
                                @if ($game->game_status < 1)
                                    {{$game->game_time->time}}
                                @elseif ($game->game_status === 1)
                                    Final
                                @else
                                    <?php
                                    $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                    if ($game->game_status == 2) {
                                        echo '<strong><span class="text-danger">1st Quarter</span></strong>';
                                    } elseif ($game->game_status == 3) {
                                        echo '<strong><span class="text-danger">2nd Quarter</span></strong>';
                                    } elseif ($game->game_status == 4) {
                                        echo '<strong><span class="text-danger">Halftime</span></strong>';
                                    } elseif ($game->game_status == 5) {
                                        echo '<strong><span class="text-danger">3rd Quarter</span></strong>';
                                    } elseif ($game->game_status == 6) {
                                        echo '<strong><span class="text-danger">4th Quarter</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">' . $numberFormatter->format($game->game_status - 4) . ' OT</span></strong>';
                                    } ?>
                                    @if($game->game_status != 4)
                                        @if(!empty($game->game_minute) || !empty($game->game_second))
                                            <strong class="border-left pl-2 ml-2">{{$game->game_minute}}:{{$game->game_second}}</strong>
                                        @endif
                                    @endif
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
                                    <span><strong>{{$game->home_team->school_name}} ({{$game->home_team->state}})</strong></span>
                                @else
                                    <span>{{$game->home_team->school_name}} ({{$game->home_team->state}})<br />
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
                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>

		</div>

	</div>

</div>
@endsection