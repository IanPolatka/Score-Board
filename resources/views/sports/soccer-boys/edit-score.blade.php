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
                    <li class="breadcrumb-item"><a href="/boys-soccer/{{$match->id}}">Game ID: {{$match->id}}</a></li>
                    <li class="breadcrumb-item active">Edit Score</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>






<div class="score-summary fixed-top">

    <div class="container">

    <div class="row">

        <div class="col">

            <div class="score-summary-summary">

                <div class="away-team">

                    @if($match->away_team->logo)
                            
                    <div class="the-logo">
                        <a href="/boys-soccer/{{$match->the_year->year}}/{{ $match->away_team->school_name }}"><img class="school-logo" src="/images/team-logos/{{ $match->away_team->logo }}" /></a>
                    </div>

                    @endif

                    <div class="school-name">
                        <h5 class="inline-text text-uppercase">
                            <a href="/boys-soccer/{{$match->the_year->year}}/{{$match->away_team->school_name}}">
                                <span class="mobile-view">{{ $match->away_team->abbreviated_name }}</span>
                                <span class="non-mobile-view">{{ $match->away_team->school_name }}</span>
                            </a>
                            <p class="mb-0"><small class="text-muted">({{$away_wins}}-{{$away_losses}}@if($away_team_ties > 0)-{{$away_team_ties}}@endif)</small></p>
                        </h5></a>
                    </div>

                </div><!--  Away Team  -->

                <div class="score-information">

                    <?php if ($match->game_status == 0 || $match->game_status == NULL) : ?>
                        <strong>{{$match->game_time->time}}</strong>
                    <?php elseif ($match->game_status == 1) :?>
                        <strong>Final</strong>
                    <?php else : ?>
                            <?php
                                $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                if ($match->game_status == 2):
                                    if ($match->game_minute) {
                                        echo '<strong><span class="text-danger">1st Half - ' . $match->game_minute . '\'</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">1st Half</span></strong>';
                                    }
                                elseif ($match->game_status == 3):
                                    echo '<strong><span class="text-danger">Halftime</span></strong>';
                                elseif ($match->game_status == 4):
                                    if ($match->game_minute) {
                                        echo '<strong><span class="text-danger">2nd Half -  ' . $match->game_minute . '\'</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">2nd Half</span></strong>';
                                    }
                                elseif ($match->game_status == 5):
                                    if ($match->game_minute) {
                                        echo '<strong><span class="text-danger">OT -  ' . $match->game_minute . '\'</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">OT</span></strong>';
                                    }
                                else:
                                    if ($match->game_minute) {
                                        echo '<strong><span class="text-danger">' . $numberFormatter->format($match->game_status - 4) . ' OT -  ' . $match->game_minute . '\'</span></strong>';
                                    } else {
                                        echo '<strong><span class="text-danger">' . $numberFormatter->format($match->game_status - 4) . ' OT</span></strong>';
                                    }
                                endif;?>
                    <?php endif; ?>

                    @if ($match->game_status > 0)
                        <h2>
                            <span class="away-total">
                            @if(isset($match->away_team_final_score))
                                {{ $match->away_team_final_score }}
                            @else
                                {{ $match->away_score_sum }}
                            @endif
                            </span> - <span class="home-total">
                            @if(isset($match->home_team_final_score))
                                {{ $match->home_team_final_score }}
                            @else
                                {{ $match->home_score_sum }}
                            @endif
                            </span>
                        </h2>
                    @endif

                </div><!--  Score Information  -->

                <div class="home-team">

                    @if($match->home_team->logo)

                    <div class="the-logo">
                        <a href="/boys-soccer/{{$match->the_year->year}}/{{ $match->home_team->school_name }}"><img class="school-logo" src="/images/team-logos/{{ $match->home_team->logo }}" /></a>
                    </div>

                    @endif

                    <div class="school-name">
                        <h5 class="inline-text text-uppercase">
                            <a href="/boys-soccer/{{$match->the_year->year}}/{{$match->home_team->school_name}}">
                                <span class="mobile-view">{{ $match->home_team->abbreviated_name }}</span>
                                <span class="non-mobile-view">{{ $match->home_team->school_name }}</span>
                            </a>
                            <p class="mb-0"><small class="text-muted">({{$home_wins}}-{{$home_losses}}@if($home_team_ties > 0)-{{$home_team_ties}}@endif)</small></p>
                        </h5>
                    </div>

                </div><!--  Home Team  -->

            </div>
        
        </div>

    </div>

</div>

</div>







<div class="container main-with-score-summary">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="game-final">

            <h5 class="text-muted">SCORING</h5>

            <div class="card mb-4">

                @if(!$scores->isEmpty())

                <div class="card-body">
                    <?php $half = 1; ?>
                    @foreach ($scores as $score)

                    <div class="row">

                        <div class="col-lg-12 mb-2">
                            <div style="padding: 5px 20px; background-color: rgba(0, 0, 0, 0.03); @if($half === 1)margin-top: -20px;@endif @if($half != 1) border-top: 1px solid rgba(0, 0, 0, 0.125); @endif border-bottom: 1px solid rgba(0, 0, 0, 0.125); margin-left: -20px; margin-right: -20px;">
                                @if ($half > 2)
                                    <strong>{{$half - 2}} OT</strong>
                                @elseif ($half == 3)
                                    <strong>OT</strong>
                                @else
                                    <strong>{{$half}} HALF</strong>
                                @endif
                            </div>
                        </div>

                    </div>
                    
                    <form method="POST" action="/boys-soccer-half-update/{{ $score->id }}">
                        <div class="row mb-4">
                        {{ method_field('PATCH') }}
                        @csrf
                            <div class="col">
                                {{$match->away_team->school_name}}<br />

                                <div class="qrt-form">

                                    <button class="subtractingAway btn btn-primary mr-2"><strong>&nbsp;-&nbsp;</strong></button>
                                        <input type="text" class="form-control mr-2" value="{{$score->away_team_score}}" name="away_team_score" />
                                    <button class="addingAway btn btn-primary"><strong>&nbsp;+&nbsp;</strong></button>

                                </div>

                            </div>
                            <div class="col">
                                {{$match->home_team->school_name}}<br />
                                <div class="qrt-form">

                                    <button class="subtractingHome btn btn btn-primary mr-2">&nbsp;-&nbsp;</button>
                                        <input type="text" class="form-control mr-2" value="{{$score->home_team_score}}" name="home_team_score" />
                                    <button class="addingHome btn btn btn-primary" id="testButton">&nbsp;+&nbsp;</button>

                                </div>
                            </div>
                            <div class="col"><BR/>
                                <button type="submit" class="btn btn-outline-primary btn-block">Update Half</button>
                            </div>
                        
                        <?php $half++; ?>
                        </div>
                    </form>
                    @if ($loop->last)<?php $score_id = $score->id; ?>@endif
                    @endforeach

                </div><!--  Card Body  -->

                @endif

                <div class="card-footer text-muted" @if($scores->isEmpty()) style="border-top: none;" @endif>

                    <div class="row">

                        <div class="col">

                            <form method="POST" action="/boys-soccer-score-create/{{$match->id}}">

                                @csrf 

                                <button type="submit" class="btn btn-primary btn-block"><strong>+ Add Half</strong></button>

                            </form>

                        </div><!--  Col  -->

                        @if(!$scores->isEmpty())

                        <div class="col">

                            <form method="POST" action="/boys-soccer-score-delete/{{$score->id}}">

                                {{ method_field('DELETE') }}

                                {{ csrf_field() }} 

                                <button type="submit"  onclick="return confirm('Are you sure?')" class="btn btn-primary btn-block btn-danger">
                                    <?php $half = $half - 1; ?>
                                    <strong>
                                        Delete 
                                        @if ($half > 2)
                                            {{$half - 2}} OT
                                        @elseif ($half == 3)
                                            OT
                                        @else
                                            {{$half}} HALF
                                        @endif
                                    </strong>
                                </button>

                            </form>

                        </div><!--  Col  -->

                        @endif

                    </div><!--  Row  -->

                </div><!--  Card Footer  -->

            </div><!--  Card  -->

            </div><!--  Is Game Final  -->

            <div class="game-details">

            <h5 class="text-muted">GAME DETAILS</h5>

            <form method="POST" action="/boys-soccer/{{$match->id}}/match-update">

                {{ method_field('PATCH') }}
                @csrf

            <div class="card mb-4">

                <div class="card-body">

                    <div class="row">

                        <div class="col">

                            <div class="form-group">
                                <label for="game_status">Game Status</label>
                                <select class="form-control" id="game_status" name="game_status">
                                    <option value="0">Game Has Not Started</option>
                                    <option value="1" @if($match->game_status == 1) selected @endif>Final</option>
                                    <option value="2" @if($match->game_status == 2) selected @endif>1st Half</option>
                                    <option value="3" @if($match->game_status == 3) selected @endif>Halftime</option>
                                    <option value="4" @if($match->game_status == 4) selected @endif>2nd Half</option>
                                    @if(count($match['scores']) > 0)
                                        <?php $num =  count($match['scores']) - 2; ?>
                                        @for ($i = 0; $i < $num; $i++)
                                            <?php $j = $i + 5; ?>
                                            <option value="{{$j}}" @if($match->game_status == $j) selected @endif>
                                                <?php
                                                $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                                if ($i == 0):
                                                    echo 'Overtime';
                                                else:
                                                    echo $numberFormatter->format($i + 1) . ' Overtime';
                                                endif;
                                                ?>
                                            </option>
                                        @endfor
                                    @endif
                                </select>
                            </div>

                        </div>

                        <div class="col">

                            <label for="game_status">Game Minute</label>
                            <select class="form-control" id="game_minute" name="game_minute">
                                <option value="">Select A Game Minute</option>
                                @for ($i = 1; $i < 151; $i++)
                                    <option value="{{$i}}" @if($match->game_minute == $i) selected @endif>{{$i}}</option>
                                @endfor
                            </select>

                        </div>

                    </div><!--  Row  -->

                    <div class="game-summary-details">

                    <div class="row">

                        <div class="col-6">

                            <div class="form-group">
                                <label for="away_team_final_score">{{$match->away_team->school_name}} Final Score</label>
                                <input id="away_team_final_score" type="text" class="form-control" value="{{$match->away_team_final_score}}" name="away_team_final_score">
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group">
                                <label for="game_status">{{$match->home_team->school_name}} Final Score</label>
                                <input id="home_team_final_score" type="text" class="form-control" value="{{$match->home_team_final_score}}" name="home_team_final_score">
                            </div>

                        </div>

                    </div><!--  Row  -->

                    <div class="row">

                        <div class="col-lg-6">

                            <label for="winning_team">Who Won?</label>
                            <select class="form-control" id="winning_team" name="winning_team">
                                <option value="">Select An Option</option>
                                <option value="{{$match->away_team_id}}" @if($match->winning_team == $match->away_team_id) selected @endif>{{$match->away_team->school_name}}</option>
                                <option value="{{$match->home_team_id}}" @if($match->winning_team == $match->home_team_id) selected @endif>{{$match->home_team->school_name}}</option>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">If the match ended in a tie, don't select a team here.</small>

                            <input type="hidden" id="losing_team" name="losing_team" value="">

                        </div>

                        <div class="col-lg-6">

                            <label for="winning_team">Did the match end in Penalty Kicks?</label>
                            <select class="form-control" id="end_in_pks" name="end_in_pks">
                                <option value="0" @if($match->end_in_pks == 0) selected @endif>No</option>
                                <option value="1" @if($match->end_in_pks == 1) selected @endif>Yes</option>
                            </select>

                        </div>

                    </div>

                    </div><!--  Game Summary Details  -->

                    <div class="row">

                        <div class="col-lg-6 mt-2">

                            <button type="submit" class="btn btn-primary btn-block"><strong>Update</strong></button>

                        </div>

                        <div class="col-lg-6">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary btn-block mt-2" data-toggle="modal" data-target="#twitterModal">
                            <i class="fab fa-twitter mr-1"></i> Tweet Score
                            </button>

                        </div>

                    </div><!--  Row  -->

                </div><!--  Card Body  -->

            </div><!--  Card  -->

            </form>

            </div><!--  Game Details  -->
                    
        </div>
    </div>
</div>
@endsection

@section('javascript')

<?php // Twitter Form Modal ?>
@include('sports.soccer-boys.twitter')
<script>

    var qrt = "<?php echo $match->game_status; ?>";

    var losingTeam = "<?php echo $match->losing_team; ?>";

    $('#losing_team').val(losingTeam);

    if (qrt != 1) {
        $('.game-summary-details').hide();
    } else {
        $('.game-summary-details').show();
        $('.game-final').hide();
    }

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


    $("#game_status").change(function(){
        var selectedValue = $(this).val();
        if(selectedValue == 1) {
            console.log(selectedValue);
            $('.game-summary-details').slideDown();
            $('.game-final').slideUp();
            $('#game_minute').val('');
        } else if (selectedValue == 3) {
            $('#game_minute').val('');
            $('#away_team_final_score').val('');
            $('#home_team_final_score').val('');
        } else if (selectedValue == 0) {
            $('#game_minute').val('');
        } else {
            $('.game-summary-details').slideUp();
            $('.game-final').slideDown();
            $('#away_team_final_score').val('');
            $('#home_team_final_score').val('');
        }
    });
});
    

</script>
@stop