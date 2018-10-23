@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Boys Basketball</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h3 class="title">Create Game</h3>

            <div class="card">

                <div class="card-body">

                    <form action="{{route('basketball-boys-create-game')}}" method="POST">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="year_id">School Year</label>
                            <select class="form-control" id="year_id" name="year_id" @if ($errors->has('year_id')) style="border-color: #dc3545;" @endif>
                                <option value="">Select A Year</option>
                                @foreach($years as $year)
                                    <option value="{{$year->id}}" @if (old('year_id') == $year->id) selected @endif>{{$year->year}}</option>
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
                                <option value="">Select A Team Level</option>
                                <option value="1" @if (old('team_level') == '1') selected @endif>Varsity</option>
                                <option value="2" @if (old('team_level') == '2') selected @endif>Junior Varsity</option>
                                <option value="3" @if (old('team_level') == '3') selected @endif>Freshman</option>
                            </select>

                            @if ($errors->has('team_level'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('team_level') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="datepicker" aria-describedby="Date" placeholder="Date" value="{{ old('date') }}">

                            @if ($errors->has('date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="scrimmage">Is this game a scrimmage?</label>
                            <select class="form-control" id="" name="scrimmage">
                                <option value="0" @if (old('scrimmage') == '0') selected @endif>No</option>
                                <option value="1" @if (old('scrimmage') == '1') selected @endif>Yes</option>
                            </select>

                            @if ($errors->has('scrimmage'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('scrimmage') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="tournament_name">Is this game part of a tournament?  If so, what is the tournament name?</label>
                            <input type="text" class="form-control" id="tournament_name" name="tournament_name" value="{{ old('tournament_name') }}">

                            @if ($errors->has('tournament_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tournament_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <hr>

                        <label>Is this game at a neutral location</label>

                        <div class="form-group form-inline">

                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                              <label class="btn btn-small btn-outline-primary active">
                                <input type="radio" name="location-place" id="no" value="no" autocomplete="off" checked> No
                              </label>
                              <label class="btn btn-small btn-outline-primary">
                                <input type="radio" name="location-place" id="yes" value="yes" autocomplete="off"> Yes
                              </label>
                            </div>

                        </div>

                        <div class="form-group location">

                            <label for="away_team_id">Game Location</label>
                            <input type="text" class="form-control" name="location" value="{{ old('location') }}">

                            @if ($errors->has('location'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                            @endif

                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="away_team_id">Away Team</label>
                            <select class="form-control" id="" name="away_team_id" @if ($errors->has('away_team_id')) style="border-color: #dc3545;" @endif>
                                <option value="">Select A Team</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if (old('away_team_id') == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
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
                                <option value="">Select A Team</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if (old('home_team_id') == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
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
                                <option value="" @if (old('time_id') === '') selected @endif>Please Select A Time</option>
                                @foreach($times as $time)
                                    <option value="{{$time->id}}" @if (old('time_id') == $time->id) selected @endif>{{$time->time}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district_game">District Game</label>
                            <select class="form-control" id="" name="district_game">
                                <option value="0" @if (old('district_game') == '0') selected @endif>No</option>
                                <option value="1" @if (old('district_game') == '1') selected @endif>Yes</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>

                    </form>

                </div>

            </div>

        </div>

		</div>

	</div>

</div>
@endsection

@section('javascript')
<script>

    $('.location').hide();

    // $( "#neutral" ).on( "click", function() {
    //     var selectedValue = $(this).val();
    //     if(selectedValue == 'No') {
    //         console.log(selectedValue);
    //     } else {
    //         console.log(selectedValue);
    //     }
    // });

$(document).ready(function(){

    $('input:radio[name=location-place]').change(function() {
        if (this.value == 'no') {
            $('.location').slideToggle();
        }
        else if (this.value == 'yes') {
            $('.location').slideToggle();
        }
    });

});

</script>
@stop