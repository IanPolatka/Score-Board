@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/track">Track & Field</a></li>
                    <li class="breadcrumb-item"><a href="/track/{{$match->id}}">Event ID: {{$match->id}}</a></li>
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
	
			<h3 class="title">Edit Match</h3>

            <div class="card">

                <div class="card-body">

                    <form action="{{route('track.edit.match', $match->id)}}" method="POST">
                        {{method_field('PUT')}}
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="team_id">What team is this event for?</label>
                            <select class="form-control" id="team_id" name="team_id" @if ($errors->has('team_id')) style="border-color: #dc3545;" @endif>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if ($match->team_id == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
                                @endforeach
                            </select>

                            @if ($errors->has('team_id'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('team_id') }}</strong>
                                </span>
                            @endif
                        </div>

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
                            <label for="scrimmage">Is this match a scrimmage?</label>
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
                            <label for="tournament_name">Tournament Name</label>
                            <input type="text" name="tournament_name" class="form-control" id="tournament_name" value="{{$match->tournament_name}}">
                        </div>

                        <div class="form-group">
                            <label for="host_id">Who Is Hosting This Event?</label>
                            <select class="form-control" id="" name="host_id" @if ($errors->has('host_id')) style="border-color: #dc3545;" @endif>
                                <option value="">Select A Team</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if ($match->host_id == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
                                @endforeach
                            </select>

                            @if ($errors->has('host_id'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('host_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">

                            <label for="location">Where Is This Tournament Taking Place?</label>
                            <input type="text" class="form-control" name="location" value="{{ $match->location }}" placeholder="ex. Riverside High School">

                            @if ($errors->has('location'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="time_id">Event Time</label>
                            <select class="form-control" id="" name="time_id">
                                <option value="" @if ($match->time_id == '') selected @endif>Please Select A Time</option>
                                @foreach($times as $time)
                                    <option value="{{$time->id}}" @if ($match->time_id == $time->id) selected @endif>{{$time->time}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="background: #f8f8f8; display: block; margin: 0 -20px 20px -20px; padding: 20px;">

                            <h5>Match Summary</h5>

                            <div class="row">

                                <div class="col">

                                    <div class="form-group">

                                        <label for="boys_result">Boys Result</label>
                                        <input type="text" class="form-control" name="boys_result" value="{{ $match->boys_result }}" placeholder="1st Place">

                                        @if ($errors->has('boys_result'))
                                            <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                                <strong>{{ $errors->first('boys_result') }}</strong>
                                            </span>
                                        @endif

                                    </div>

                                </div>

                                <div class="col">

                                    <div class="form-group">

                                        <label for="girls_result">Girls Result</label>
                                        <input type="text" class="form-control" name="girls_result" value="{{ $match->girls_result }}" placeholder="1st Place">

                                        @if ($errors->has('girls_result'))
                                            <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                                <strong>{{ $errors->first('girls_result') }}</strong>
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>

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