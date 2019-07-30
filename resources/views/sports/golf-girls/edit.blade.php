@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/girls-golf">Girls Golf</a></li>
                    <li class="breadcrumb-item"><a href="/girls-golf/{{$match->id}}">Match ID: {{$match->id}}</a></li>
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

                    <form action="{{route('girlsgolf-edit-match', $match->id)}}" method="POST">
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
                            <label for="tournament_id">Is this game part of a tournament?  If so, what is the tournament name?</label>
                            <input type="text" name="tournament_name" class="form-control" id="tournament_name" value="{{$match->tournament_name}}">
                        </div>

                        <div class="form-group">
                            <label for="location">Is this match at a nuetral location?  If so, what is the name of the location?</label>
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
                            <label for="time_id">Match Time</label>
                            <select class="form-control" id="" name="time_id">
                                <option value="" @if ($match->time_id == '') selected @endif>Please Select A Time</option>
                                @foreach($times as $time)
                                    <option value="{{$time->id}}" @if ($match->time_id == $time->id) selected @endif>{{$time->time}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="background: #f8f8f8; display: block; margin: 0 -20px 20px -20px; padding: 20px;">

                            <h5>Match Summary</h5>

                            <div class="form-group">
                                <label for="winning_team">Who Won?</label>
                                <select class="form-control" id="winning_team" name="winning_team">
                                    <option value="">Select An Option</option>
                                    <option value="{{$match->away_team_id}}" @if($match->winning_team == $match->away_team_id) selected @endif>{{$match->away_team->school_name}}</option>
                                    <option value="{{$match->home_team_id}}" @if($match->winning_team == $match->home_team_id) selected @endif>{{$match->home_team->school_name}}</option>
                                </select>

                                <input type="hidden" id="losing_team" name="losing_team" value="">
                            </div>

                            <div class="row">

                                <div class="col-6">

                                    <div class="form-group">
                                        <label for="away_team_final_score">{{$match->away_team->school_name}} Final Score</label>
                                        <input type="text" class="form-control" value="{{$match->away_team_final_score}}" name="away_team_final_score">
                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="form-group">
                                        <label for="game_status">{{$match->home_team->school_name}} Final Score</label>
                                        <input type="text" class="form-control" value="{{$match->home_team_final_score}}" name="home_team_final_score">
                                    </div>

                                </div>

                            </div><!--  Row  -->

                        </div>

                        <div class="row">

                            <div class="col-6">

                                <button type="submit" class="btn btn-primary btn-block">Update</button>

                            </div>

                            @if ($match->winning_team)

                                <div class="col-6">

                                    <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#twitterModal">
                                        <i class="fab fa-twitter mr-1"></i> Tweet Score
                                    </button>

                                </div>

                            @endif

                        </div>

                    </form>

                </div>

            </div>

        </div>

		</div>

	</div>

</div>
@endsection

@section('javascript')

<?php // Twitter Form Modal ?>
@include('sports.golf-girls.twitter')
<script>

var losingTeam = "<?php echo $match->losing_team; ?>";

$('#losing_team').val(losingTeam);

$(document).ready(function(){
    var home_team_id = <?php echo $match->home_team_id; ?>;
    var away_team_id = <?php echo $match->away_team_id; ?>;
    $("#winning_team").change(function(){
        if($(this).val() == home_team_id) {
            $('#losing_team').val(away_team_id);
        } else if ($(this).val() == away_team_id) {
            $('#losing_team').val(home_team_id);
        } else {
            $('#losing_team').val("");
            $('#winning_team').val("");
        }
    });
});
    

</script>
@stop