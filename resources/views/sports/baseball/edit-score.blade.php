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
                        <a href="/baseball/2018-2019/{{ $match->away_team->school_name }}"><img class="school-logo" src="/images/team-logos/{{ $match->away_team->logo }}" /></a>
                    </div>

                    @endif

                    <div class="school-name">
                        <h5 class="inline-text text-uppercase">
                            <a href="/baseball/2018-2019/{{$match->away_team->school_name}}">
                                <span class="mobile-view">{{ $match->away_team->abbreviated_name }}</span>
                                <span class="non-mobile-view">{{ $match->away_team->school_name }}</span>
                            </a>
                            
                        </h5></a>
                    </div>

                </div><!--  Away Team  -->

                <div class="score-information">

                    <?php if ($match->inning == 0 || $match->inning == NULL) : ?>
                        <strong>{{$match->game_time->time}}</strong>
                    <?php elseif ($match->inning == 99) :?>
                        <strong>Final</strong>
                    <?php else : ?>
                    <?php
                        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                        echo '<strong><span class="text-danger">' . $numberFormatter->format($match->inning) . ' Inning</span></strong>';
                    endif; ?>

                        <?php $away_total_final = $match->away_team_final_score; ?>

                        <?php $away_total = 0; ?>
                        @foreach ($scores as $score)
                            <?php $away_total += $score->away_team_score; ?>
                        @endforeach


                        <?php $home_total_final = $match->home_team_final_score; ?>

                        <?php $home_total = 0; ?>
                        @foreach ($scores as $score)
                            <?php $home_total += $score->home_team_score; ?>
                        @endforeach

                    @if ($match->inning > 0)
                        <h2>
                            <span class="away-total">
                            @if($match->inning == 99)
                                @if(isset($match->away_team_final_score))
                                    {{ $away_total_final }}
                                @endif
                            @else
                                {{$away_total}}
                            @endif
                            </span> - <span class="home-total">
                            @if($match->inning == 99)
                                @if(isset($match->home_team_final_score))
                                    {{ $home_total_final }}
                                @endif
                            @else
                                {{$home_total}}
                            @endif
                            </span>
                        </h2>
                    @endif

                </div><!--  Score Information  -->

                <div class="home-team">

                    @if($match->home_team->logo)

                    <div class="the-logo">
                        <a href="/baseball/2018-2019/{{ $match->home_team->school_name }}"><img class="school-logo" src="/images/team-logos/{{ $match->home_team->logo }}" /></a>
                    </div>

                    @endif

                    <div class="school-name">
                        <h5 class="inline-text text-uppercase">
                            <a href="/baseball/2018-2019/{{$match->home_team->school_name}}">
                                <span class="mobile-view">{{ $match->home_team->abbreviated_name }}</span>
                                <span class="non-mobile-view">{{ $match->home_team->school_name }}</span>
                            </a>
                            
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
                    <?php $qrt = 1; ?>
                    @foreach ($scores as $score)

                    <div class="row">

                        <div class="col-lg-12 mb-2">
                            <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL); ?>
                            <div style="padding: 5px 20px; background-color: rgba(0, 0, 0, 0.03); @if($qrt === 1)margin-top: -20px;@endif @if($qrt != 1) border-top: 1px solid rgba(0, 0, 0, 0.125); @endif border-bottom: 1px solid rgba(0, 0, 0, 0.125); margin-left: -20px; margin-right: -20px;">
                                @if ($qrt > 5)
                                    <strong><?php echo $numberFormatter->format($qrt-4); ?> Inning</strong>
                                @elseif ($qrt == 5)
                                    <strong>Overtime</strong>
                                @else
                                    <strong><?php echo $numberFormatter->format($qrt); ?> Inning</strong>
                                @endif
                            </div>
                        </div>

                    </div>
                    
                    <form method="POST" action="/baseball-inning-update/{{ $score->id }}">
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
                                <button type="submit" class="btn btn-outline-primary btn-block">Update Inning</button>
                            </div>
                        
                        <?php $qrt++; ?>
                        </div>
                    </form>
                    @if ($loop->last)<?php $score_id = $score->id; ?>@endif
                    @endforeach

                </div><!--  Card Body  -->

                @endif

                <div class="card-footer text-muted" @if($scores->isEmpty()) style="border-top: none;" @endif>

                    <div class="row">

                        <div class="col">

                            <form method="POST" action="/baseball-score-create/{{$match->id}}">

                                @csrf 

                                <button type="submit" class="btn btn-primary btn-block"><strong>+ Add Inning</strong></button>

                            </form>

                        </div><!--  Col  -->

                        @if(!$scores->isEmpty())

                        <div class="col">

                            <form method="POST" action="/baseball-score-delete/{{$score->id}}">

                                {{ method_field('DELETE') }}

                                {{ csrf_field() }} 

                                <button type="submit"  onclick="return confirm('Are you sure?')" class="btn btn-primary btn-block btn-danger">
                                    <?php $qrt = $qrt - 1; ?>
                                    <strong>
                                        <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL); ?>
                                        Delete <?php echo $numberFormatter->format(count($scores)); ?> Inning
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

            <form method="POST" action="/baseball/{{$match->id}}/match-update">

                {{ method_field('PATCH') }}
                @csrf

            <div class="card mb-4">

                <div class="card-body">

                    <div class="row">

                        <div class="col">

                            <div class="form-group">
                                <label for="inning">Game Status</label>
                                <select class="form-control" id="game_status" name="inning">
                                    <option value="0">Game Has Not Started</option>
                                    <option value="99" @if($match->inning == 99) selected @endif>Final</option>
                                    @foreach ($scores as $score)
                                        <?php $number = $loop->iteration; ?>
                                        <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL); ?>
                                        <option value="{{ $loop->iteration }}" @if($match->inning == $loop->iteration) selected @endif><?php echo $numberFormatter->format($loop->iteration); ?> Inning</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div><!--  Row  -->

                    <div class="game-summary-details">

                    <div class="row">

                        <div class="col-6">

                            <div class="form-group">
                                <label for="away_team_final_score">{{$match->away_team->abbreviated_name}} Final Score</label>
                                <input type="text" class="form-control" value="{{$match->away_team_final_score}}" name="away_team_final_score">
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group">
                                <label for="home_team_final_score">{{$match->home_team->abbreviated_name}} Final Score</label>
                                <input type="text" class="form-control" value="{{$match->home_team_final_score}}" name="home_team_final_score">
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

                    </div>

                    </div><!--  Game Summary Details  -->

                    <div class="row mt-4">

                        <div class="col-lg-6">

                            <button type="submit" class="btn btn-primary btn-block mb-3"><strong>Update</strong></button>

                        </div>

                        <div class="col-lg-6">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#twitterModal">
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
<script>

    $('.game-summary-details').show();

    var inning = "<?php echo $match->inning; ?>";

    var losingTeam = "<?php echo $match->losing_team; ?>";

    $('#losing_team').val(losingTeam);

    if (inning != 99) {
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
        if(selectedValue == 99) {
            console.log(selectedValue);
            $('.game-summary-details').slideDown();
            $('.game-final').slideUp();
            $('.game-time').slideUp();
        } else {
            $('.game-summary-details').slideUp();
            $('.game-final').slideDown();
            $('.game-time').slideDown();
        }
    });

});
    

</script>
@stop

<?php // Twitter Form Modal ?>
@include('sports.baseball.twitter')