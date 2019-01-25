@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/baseball">Baseball</a></li>
                    <li class="breadcrumb-item"><a href="/baseball/{{$match->id}}">Game ID: {{$match->id}}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h3 class="title">Edit Game</h3>

            <div class="card">

                <div class="card-body">

                    <form action="{{route('baseball-edit-match', $match->id)}}" method="POST">
                        {{method_field('PUT')}}
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="year_id">School Year</label>
                            <select class="form-control" id="year_id" name="year_id" @if ($errors->has('year_id')) style="border-color: #dc3545;" @endif>
                                @foreach($years as $year)
                                    <option value="{{$year->id}}" @if ($match->year_id === $year->id) selected @endif>{{$year->year}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('year_id'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('year_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="team_level">Team Level</label>
                            <select class="form-control" id="team_level" name="team_level" @if ($errors->has('team_level')) style="border-color: #dc3545;" @endif>
                                <option value="" @if ($match->team_level == '') selected @endif>Select A Team Level</option>
                                <option value="1" @if ($match->team_level == '1') selected @endif>Varsity</option>
                                <option value="2" @if ($match->team_level == '2') selected @endif>Junior Varsity</option>
                                <option value="3" @if ($match->team_level == '3') selected @endif>Freshman</option>
                            </select>

                            @if ($errors->has('team_level'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('team_level') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="datepicker" aria-describedby="Date" placeholder="Date" value="{{ $match->date }}">

                            @if ($errors->has('date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="scrimmage">Is this game a scrimmage?</label>
                            <select class="form-control" id="" name="scrimmage">
                                <option value="0" @if ($match->scrimmage == '0') selected @endif>No</option>
                                <option value="1" @if ($match->scrimmage == '1') selected @endif>Yes</option>
                            </select>

                            @if ($errors->has('scrimmage'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('scrimmage') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="tournament_id">Is this game part of a tournament?  If so, what is the tournament name?</label>
                            <input type="text" name="tournament_name" class="form-control" id="tournament_name" value="{{$match->tournament_name}}">
                        </div>

                        <div class="form-group">
                            <label for="location">Is this game at a nuetral location?  If so, what is the name of the location?</label>
                            <input type="text" name="location" class="form-control" id="location" value="{{$match->location}}">
                        </div>

                        <div class="form-group">
                            <label for="away_team_id">Away Team</label>
                            <select class="form-control" id="" name="away_team_id" @if ($errors->has('away_team_id')) style="border-color: #dc3545;" @endif>
                                <option value="" @if ($match->away_team_id == '') selected @endif>Select A Team</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if ($match->away_team_id == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
                                @endforeach
                            </select>

                            @if ($errors->has('away_team_id'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('away_team_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="home_team_id">Home Team</label>
                            <select class="form-control" id="" name="home_team_id" @if ($errors->has('home_team_id')) style="border-color: #dc3545;" @endif>
                                <option value="" @if ($match->away_team_id == '') selected @endif>Select A Team</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if ($match->home_team_id == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
                                @endforeach
                            </select>

                            @if ($errors->has('home_team_id'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('home_team_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="time_id">Game Time</label>
                            <select class="form-control" id="" name="time_id">
                                <option value="" @if ($match->time_id == '') selected @endif>Please Select A Time</option>
                                @foreach($times as $time)
                                    <option value="{{$time->id}}" @if ($match->time_id == $time->id) selected @endif>{{$time->time}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district_game">District Game</label>
                            <select class="form-control" id="" name="district_game">
                                <option value="0" @if ($match->district_game == '0') selected @endif>No</option>
                                <option value="1" @if ($match->district_game == '1') selected @endif>Yes</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>

                    </form>

                </div>

            </div>

        </div>

		</div>

	</div>

</div>
@endsection