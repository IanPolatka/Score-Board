@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Swimming</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	
			<h3 class="title">Create Match</h3>

            <div class="card">

                <div class="card-body">

                    <form action="{{route('swimming.create.match')}}" method="POST">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="team_id">What team is this event for?</label>
                            <select class="form-control" id="" name="team_id" @if ($errors->has('team_id')) style="border-color: #dc3545;" @endif>
                                <option value="">Select A Team</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if (old('team_id') == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
                                @endforeach
                            </select>

                            @if ($errors->has('away_team_id'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('away_team_id') }}</strong>
                                </span>
                            @endif
                        </div>

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
                            <label for="scrimmage">Is this match a scrimmage?</label>
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
                            <label for="tournament_name">Tournament Name</label>
                            <input type="text" class="form-control" id="tournament_name" name="tournament_name" value="{{ old('tournament_name') }}">

                            @if ($errors->has('tournament_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tournament_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="host_id">Who Is Hosting This Event?</label>
                            <select class="form-control" id="" name="host_id" @if ($errors->has('host_id')) style="border-color: #dc3545;" @endif>
                                <option value="">Select A Team</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if (old('host_id') == $team->id) selected @endif>{{$team->school_name}} ({{$team->state}})</option>
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
                            <input type="text" class="form-control" name="location" value="{{ old('location') }}" placeholder="ex. Riverside High School">

                            @if ($errors->has('location'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="time_id">Match Time</label>
                            <select class="form-control" id="" name="time_id">
                                <option value="" @if (old('time_id') === '') selected @endif>Please Select A Time</option>
                                @foreach($times as $time)
                                    <option value="{{$time->id}}" @if (old('time_id') == $time->id) selected @endif>{{$time->time}}</option>
                                @endforeach
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