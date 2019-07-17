@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/boys-soccer">Boys Soccer</a></li>
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
                                <option value="/boys-soccer/{{ $selectedyear[0] }}/{{$team->school_name}}" @if ($team->school_name == $selectedTeam->school_name) selected @endif>{{$team->school_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @role(['superadministrator','administrator'])
                    <div class="col align-self-end">
                        <a href="{{ route('boyssoccer.create') }}" class="btn btn-primary btn-block">Create Match</a>
                    </div>
                @endrole

            </div>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10 col-sm-12">

            <hr>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10 col-sm-12">

            <div class="row">

                <div class="col-lg-9 col-md-8 col-sm-7 col-7">

                    <h2>{{$selectedTeam->school_name}}</h2>

                </div><!--  Col  -->

                <div class="col-lg-3 col-md-4 col-sm-5 col-5 align-self-center">

                    <select name="home_team_id"class="form-control" onChange="window.location.href=this.value">

                        @foreach($years as $year)

                            <option value="/boys-soccer/{{ $year->year }}/{{ $selectedTeam->school_name }}" @if ($selectedyearid[0] === $year->id) selected @endif>
                                {{ $year->year }}
                            </option>

                        @endforeach

                    </select>

                </div><!--  Col  -->

            </div>

            <h5 class="text-muted">Varsity Summary</h5>

            <div class="card mb-4">

                <div class="card-body">

                    <div class="row">

                        <div class="col">

                            <p class="mb-0 text-muted">Overall Record</p>

                            <h3>{{$wins}} - {{$losses}} @if ($matchTies > 0) - {{$matchTies}} @endif</h3>

                        </div>

                        <div class="col">

                            <p class="mb-0 text-muted">District Record</p>

                            <h3>{{$districtWins}} - {{$districtLosses}}</h3>

                        </div>

                    </div>

                </div>

            </div>

            <h5 class="text-muted">Varsity Schedule</h5>

            <div class="list-group mb-4">
                @forelse ($varsity as $game)
                    <a href="/boys-soccer/{{$game->id}}" class="list-group-item list-group-item-action">

                        <div class="row">
                            <div class="col">
                            <em>{{ Carbon\Carbon::parse($game->date)->format('l') }} {{ Carbon\Carbon::parse($game->date)->format('M j, o') }}</em>
                            </div>
                        </div>

                        <div class="row align-items-center">

                            @if ($game->home_team_id == $id[0])

                                <div class="col">
                                    <span class="badge badge-primary mr-3">VS</span>
                                    <div class="school-logo mr-3">
                                        @if($game->away_team->logo)
                                            <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                        @endif
                                    </div>
                                    {{$game->away_team->school_name}}
                                </div>
                                <div class="col text-right">
                                    @if ($game->winning_team === $selectedTeam->id)
                                        <span class="text-success"><strong>W</strong></span>
                                    @elseif ($game->losing_team === $selectedTeam->id)
                                        <span class="text-danger"><strong>L</strong></span>
                                    @elseif ($game->game_status === 1 && (isset($game->away_team_final_score) === isset($game->home_team_final_score)))
                                        <span class="text-dark"><strong>T</strong></span>
                                    @else
                                        {{$game->game_time->time}}
                                    @endif

                                    @if(isset($game->away_team_final_score) && isset($game->home_team_final_score))

                                        @if ($game->away_team_final_score > $game->home_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->home_team_final_score < $game->away_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @else ($game->away_team_final_score === $game->home_team_final_score)
                                            {{$game->home_team_final_score}} - {{$game->away_team_final_score}}
                                        @endif

                                    @endif

                                </div>

                            @else
                                
                                <div class="col">
                                    <span class="badge badge-light mr-3">AT</span>
                                    <div class="school-logo mr-3">
                                        @if($game->home_team->logo)
                                            <img src="/images/team-logos/{{ $game->home_team->logo }}" />
                                        @endif
                                    </div>
                                    {{$game->home_team->school_name}}
                                </div>
                                <div class="col text-right">
                                    @if ($game->winning_team === $selectedTeam->id)
                                        <span class="text-success"><strong>W</strong></span>
                                    @elseif ($game->losing_team === $selectedTeam->id)
                                        <span class="text-danger"><strong>L</strong></span>
                                    @elseif ($game->game_status === 1 && (isset($game->away_team_final_score) === isset($game->home_team_final_score)))
                                        <span class="text-dark"><strong>T</strong></span>
                                    @else
                                        {{$game->game_time->time}}
                                    @endif

                                    @if(isset($game->away_team_final_score) && isset($game->home_team_final_score))

                                        @if ($game->away_team_final_score > $game->home_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->home_team_final_score < $game->away_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @else ($game->away_team_final_score === $game->home_team_final_score)
                                            {{$game->home_team_final_score}} - {{$game->away_team_final_score}}
                                        @endif

                                    @endif

                                </div>

                            @endif

                        </div><!--  Row  -->

                        @if ($game->tournament_name)

                            <hr>

                            {{$game->tournament_name}}

                        @endif

                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>




            <h5 class="text-muted">Junior Varsity Schedule</h5>

            <div class="list-group mb-4">
                @forelse ($juniorvarsity as $game)
                <a href="/boys-soccer/{{$game->id}}" class="list-group-item list-group-item-action">

                        <div class="row">
                            <div class="col">
                            <em>{{ Carbon\Carbon::parse($game->date)->format('l') }} {{ Carbon\Carbon::parse($game->date)->format('M j, o') }}</em>
                            </div>
                        </div>

                        <div class="row align-items-center">

                            @if ($game->home_team_id == $id[0])

                                <div class="col">
                                    <span class="badge badge-primary mr-3">VS</span>
                                    <div class="school-logo mr-3">
                                        @if($game->away_team->logo)
                                            <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                        @endif
                                    </div>
                                    {{$game->away_team->school_name}}
                                </div>
                                <div class="col text-right">
                                    @if ($game->winning_team === $selectedTeam->id)
                                        <span class="text-success"><strong>W</strong></span>
                                    @elseif ($game->losing_team === $selectedTeam->id)
                                        <span class="text-danger"><strong>L</strong></span>
                                    @elseif ($game->game_status === 1 && (isset($game->away_team_final_score) === isset($game->home_team_final_score)))
                                        <span class="text-dark"><strong>T</strong></span>
                                    @else
                                        {{$game->game_time->time}}
                                    @endif

                                    @if(isset($game->away_team_final_score) && isset($game->home_team_final_score))

                                        @if ($game->away_team_final_score > $game->home_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->home_team_final_score < $game->away_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @else ($game->away_team_final_score === $game->home_team_final_score)
                                            {{$game->home_team_final_score}} - {{$game->away_team_final_score}}
                                        @endif

                                    @endif
                                    
                                </div>

                            @else
                                
                                <div class="col">
                                    <span class="badge badge-light mr-3">AT</span>
                                    <div class="school-logo mr-3">
                                        @if($game->home_team->logo)
                                            <img src="/images/team-logos/{{ $game->home_team->logo }}" />
                                        @endif
                                    </div>
                                    {{$game->home_team->school_name}}
                                </div>
                                <div class="col text-right">
                                    @if ($game->winning_team === $selectedTeam->id)
                                        <span class="text-success"><strong>W</strong></span>
                                    @elseif ($game->losing_team === $selectedTeam->id)
                                        <span class="text-danger"><strong>L</strong></span>
                                    @elseif ($game->game_status === 1 && (isset($game->away_team_final_score) === isset($game->home_team_final_score)))
                                        <span class="text-dark"><strong>T</strong></span>
                                    @else
                                        {{$game->game_time->time}}
                                    @endif
                                    @if ($game->game_status == 1)
                                        @if ($game->away_team_final_score > $game->home_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->home_team_final_score < $game->away_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->away_team_final_score == $game->home_team_final_score)
                                            {{$game->home_team_final_score}} - {{$game->away_team_final_score}}
                                        @else
                                            {{$game->game_time->time}}
                                        @endif
                                    @endif
                                </div>

                            @endif

                        </div><!--  Row  -->

                        @if ($game->tournament_name)

                            <hr>

                            {{$game->tournament_name}}

                        @endif

                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>




            <h5 class="text-muted">Freshman Schedule</h5>

            <div class="list-group mb-4">
                @forelse ($freshman as $game)
                <a href="/boys-soccer/{{$game->id}}" class="list-group-item list-group-item-action">

                        <div class="row">
                            <div class="col">
                            <em>{{ Carbon\Carbon::parse($game->date)->format('l') }} {{ Carbon\Carbon::parse($game->date)->format('M j, o') }}</em>
                            </div>
                        </div>

                        <div class="row align-items-center">

                            @if ($game->home_team_id == $id[0])

                                <div class="col">
                                    <span class="badge badge-primary mr-3">VS</span>
                                    <div class="school-logo mr-3">
                                        @if($game->away_team->logo)
                                            <img src="/images/team-logos/{{ $game->away_team->logo }}" />
                                        @endif
                                    </div>
                                    {{$game->away_team->school_name}}
                                </div>
                                <div class="col text-right">
                                    @if ($game->winning_team === $selectedTeam->id)
                                        <span class="text-success"><strong>W</strong></span>
                                    @elseif ($game->losing_team === $selectedTeam->id)
                                        <span class="text-danger"><strong>L</strong></span>
                                    @elseif ($game->game_status === 1 && (isset($game->away_team_final_score) === isset($game->home_team_final_score)))
                                        <span class="text-dark"><strong>T</strong></span>
                                    @else
                                        {{$game->game_time->time}}
                                    @endif
                                    @if ($game->game_status == 1)
                                        @if ($game->away_team_final_score > $game->home_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->home_team_final_score < $game->away_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->away_team_final_score == $game->home_team_final_score)
                                            {{$game->home_team_final_score}} - {{$game->away_team_final_score}}
                                        @else
                                            {{$game->game_time->time}}
                                        @endif
                                    @endif
                                </div>

                            @else
                                
                                <div class="col">
                                    <span class="badge badge-light mr-3">AT</span>
                                    <div class="school-logo mr-3">
                                        @if($game->home_team->logo)
                                            <img src="/images/team-logos/{{ $game->home_team->logo }}" />
                                        @endif
                                    </div>
                                    {{$game->home_team->school_name}}
                                </div>
                                <div class="col text-right">
                                    @if ($game->winning_team === $selectedTeam->id)
                                        <span class="text-success"><strong>W</strong></span>
                                    @elseif ($game->losing_team === $selectedTeam->id)
                                        <span class="text-danger"><strong>L</strong></span>
                                    @elseif ($game->game_status === 1 && (isset($game->away_team_final_score) === isset($game->home_team_final_score)))
                                        <span class="text-dark"><strong>T</strong></span>
                                    @else
                                        {{$game->game_time->time}}
                                    @endif
                                    @if ($game->game_status == 1)
                                        @if ($game->away_team_final_score > $game->home_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->home_team_final_score < $game->away_team_final_score)
                                            {{$game->away_team_final_score}} - {{$game->home_team_final_score}}
                                        @elseif ($game->away_team_final_score == $game->home_team_final_score)
                                            {{$game->home_team_final_score}} - {{$game->away_team_final_score}}
                                        @else
                                            {{$game->game_time->time}}
                                        @endif
                                    @endif
                                </div>

                            @endif

                        </div><!--  Row  -->

                        @if ($game->tournament_name)

                            <hr>

                            {{$game->tournament_name}}

                        @endif

                    </a>
                @empty
                    <a href="#" class="list-group-item list-group-item-action">No Games Listed</a>
                @endforelse
            </div>



		</div><!--  Col  -->

	</div><!--  Row  -->

</div><!--  Container  -->
@endsection