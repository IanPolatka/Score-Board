@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/football">Football</a></li>
                    <li class="breadcrumb-item"><a href="/football/{{$match->id}}">Game ID: {{$match->id}}</a></li>
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
                        <a href="/football/{{$match->the_year->year}}/{{ $match->away_team->school_name }}"><img class="school-logo" src="/images/team-logos/{{ $match->away_team->logo }}" /></a>
                    </div>

                    @endif

                    <div class="school-name">
                        <h5 class="inline-text text-uppercase">
                            <a href="/football/{{$match->the_year->year}}/{{$match->away_team->school_name}}">
                                <span class="mobile-view">{{ $match->away_team->abbreviated_name }}</span>
                                <span class="non-mobile-view">{{ $match->away_team->school_name }}</span>
                            </a>
                            <p class="mb-0"><small class="text-muted">({{$away_wins}}-{{$away_losses}})</small></p>
                        </h5></a>
                    </div>

                </div><!--  Away Team  -->

                <?php if ($match->possession === $match->away_team_id): ?>
                    <span class="ml-2 mr-2"><i class="fas fa-football-ball"></i></span>
                <?php else: ?>
                    <span class="ml-2 mr-2"><i class="fas fa-football-ball text-white"></i></span>
                <?php endif; ?>

                <div class="score-information">

                    <?php if ($match->game_status == 0 || $match->game_status == NULL) : ?>
                        <strong>{{$match->game_time->time}}</strong>
                    <?php elseif ($match->game_status == 1) :?>
                        <strong>Final</strong>
                    <?php else : ?>
                            <?php
                                $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                if ($match->game_status == 2) {
                                    echo '<strong><span class="text-danger">1st Quarter</span></strong>';
                                } elseif ($match->game_status == 3) {
                                    echo '<strong><span class="text-danger">2nd Quarter</span></strong>';
                                } elseif ($match->game_status == 4) {
                                    echo '<strong><span class="text-danger">Halftime</span></strong>';
                                } elseif ($match->game_status == 5) {
                                    echo '<strong><span class="text-danger">3rd Quarter</span></strong>';
                                } elseif ($match->game_status == 6) {
                                    echo '<strong><span class="text-danger">4th Quarter</span></strong>';
                                } else {
                                    echo '<strong><span class="text-danger">' . $numberFormatter->format($match->game_status - 4) . ' OT</span></strong>';
                                } ?>
                                <?php if ($match->game_second != null || $match->game_second != ''): ?>
                                &nbsp;&nbsp;|&nbsp;&nbsp; {{$match->game_minute}}:{{$match->game_second}}
                            <?php endif;
                    endif; ?>

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

                <?php if ($match->possession === $match->home_team_id): ?>
                    <span class="ml-2 mr-2"><i class="fas fa-football-ball"></i></span>
                <?php else: ?>
                    <span class="ml-2 mr-2"><i class="fas fa-football-ball text-white"></i></span>
                <?php endif; ?>

                <div class="home-team">

                    @if($match->home_team->logo)

                    <div class="the-logo">
                        <a href="/football/{{$match->the_year->year}}/{{ $match->home_team->school_name }}"><img class="school-logo" src="/images/team-logos/{{ $match->home_team->logo }}" /></a>
                    </div>

                    @endif

                    <div class="school-name">
                        <h5 class="inline-text text-uppercase">
                            <a href="/football/{{$match->the_year->year}}/{{$match->home_team->school_name}}">
                                <span class="mobile-view">{{ $match->home_team->abbreviated_name }}</span>
                                <span class="non-mobile-view">{{ $match->home_team->school_name }}</span>
                            </a>
                            <p class="mb-0"><small class="text-muted">({{$home_wins}}-{{$home_losses}})</small></p>
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
                                    <strong><?php echo $numberFormatter->format($qrt-4); ?> Overtime</strong>
                                @elseif ($qrt == 5)
                                    <strong>Overtime</strong>
                                @else
                                    <strong><?php echo $numberFormatter->format($qrt); ?> Quarter</strong>
                                @endif
                            </div>
                        </div>

                    </div>
                    
                    <form method="POST" action="/football-half-update/{{ $score->id }}">
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
                                <button type="submit" class="btn btn-outline-primary btn-block">Update Quarter</button>
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

                            <form method="POST" action="/football-score-create/{{$match->id}}">

                                @csrf 

                                <button type="submit" class="btn btn-primary btn-block"><strong>+ Add Quarter</strong></button>

                            </form>

                        </div><!--  Col  -->

                        @if(!$scores->isEmpty())

                        <div class="col">

                            <form method="POST" action="/football-score-delete/{{$score->id}}">

                                {{ method_field('DELETE') }}

                                {{ csrf_field() }} 

                                <button type="submit"  onclick="return confirm('Are you sure?')" class="btn btn-primary btn-block btn-danger">
                                    <?php $qrt = $qrt - 1; ?>
                                    <strong>
                                        Delete 
                                        @if ($qrt > 5)
                                            {{$qrt - 3}} OT
                                        @elseif ($qrt == 5)
                                            OT
                                        @else
                                            {{$qrt}} QUARTER
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

            <form method="POST" action="/football/{{$match->id}}/match-update">

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
                                    <option value="2" @if($match->game_status == 2) selected @endif>1st Quarter</option>
                                    <option value="3" @if($match->game_status == 3) selected @endif>2nd Quarter</option>
                                    <option value="4" @if($match->game_status == 4) selected @endif>Halftime</option>
                                    <option value="5" @if($match->game_status == 5) selected @endif>3rd Quarter</option>
                                    <option value="6" @if($match->game_status == 6) selected @endif>4th Quarter</option>
                                    @if(count($scores) > 4)
                                        <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL); ?>
                                        @for ($i = 4; $i < count($scores); $i++)
                                            <option value={{$i+3}} @if($match->game_status == $i+3) selected @endif><?php echo $numberFormatter->format($i-3); ?> Overtime</option>
                                        @endfor
                                        
                                    @endif
                                </select>
                            </div>

                        </div>

                    </div><!--  Row  -->

                    <div class="game-time">

                        <div class="row mb-3">

                            <div class="col">

                                <label for="game_status">Game Minute</label>
                                <select class="form-control" id="game_minute" name="game_minute">
                                    <option value="">Select A Game Minute</option>
                                    @for ($i = 1; $i < 151; $i++)
                                        <option value="{{$i}}" @if($match->game_minute == $i) selected @endif>{{$i}}</option>
                                    @endfor
                                </select>

                            </div>

                            <div class="col">

                                <label for="game_status">Game Second</label>
                                <select class="form-control" id="game_second" name="game_second">
                                    <option value="">Select A Game Second</option>
                                    <option value="00" @if($match->game_second == "00") selected @endif>00</option>
                                    <option value="01" @if($match->game_second == "01") selected @endif>01</option>
                                    <option value="02" @if($match->game_second == "02") selected @endif>02</option>
                                    <option value="03" @if($match->game_second == "03") selected @endif>03</option>
                                    <option value="04" @if($match->game_second == "04") selected @endif>04</option>
                                    <option value="05" @if($match->game_second == "05") selected @endif>05</option>
                                    <option value="06" @if($match->game_second == "06") selected @endif>06</option>
                                    <option value="07" @if($match->game_second == "07") selected @endif>07</option>
                                    <option value="08" @if($match->game_second == "08") selected @endif>08</option>
                                    <option value="09" @if($match->game_second == "09") selected @endif>09</option>
                                    @for ($i = 10; $i < 59; $i++)
                                        <option value="{{$i}}" @if($match->game_second == $i) selected @endif>{{$i}}</option>
                                    @endfor
                                </select>

                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-6">

                                <label for="possession">Who Has Possession?</label>
                                <select class="form-control" id="possession" name="possession">
                                    <option value="">Select Team</option>
                                    <option value="{{$match->away_team_id}}" @if($match->possession == $match->away_team_id) selected @endif>{{$match->away_team->school_name}}</option>
                                    <option value="{{$match->home_team_id}}" @if($match->possession == $match->home_team_id) selected @endif>{{$match->home_team->school_name}}</option>
                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="game-summary-details">

                        <div class="row">

                            <div class="col-6">

                                <div class="form-group">
                                    <label for="away_team_final_score">{{$match->away_team->school_name}} Final Score</label>
                                    <input type="text" id="away_team_final_score" class="form-control" value="{{$match->away_team_final_score}}" name="away_team_final_score">
                                </div>

                            </div>

                            <div class="col-6">

                                <div class="form-group">
                                    <label for="game_status">{{$match->home_team->school_name}} Final Score</label>
                                    <input type="text" id="home_team_final_score" class="form-control" value="{{$match->home_team_final_score}}" name="home_team_final_score">
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

<?php // Twitter Form Modal ?>
@include('sports.football.twitter')
<script>

    var qrt = "<?php echo $match->game_status; ?>";

    var losingTeam = "<?php echo $match->losing_team; ?>";

    $('#losing_team').val(losingTeam);

    if (qrt === 1) {
        $('.game-summary-details').show();
        $('.game-time').hide();
    } else if (qrt < 1) {
        $('.game-summary-details').hide();
        $('.game-time').hide();
    } else {
        $('.game-time').show();
        $('.game-summary-details').hide();
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
                $('.game-final').slideUp();
                $('.game-time').slideUp();
                $("#game_minute").val('');
                $("#game_second").val('');
                $("#possession").val('');
                $(".game-summary-details").slideDown();
            } else if (selectedValue > 1) {
                console.log(selectedValue);
                $('.game-summary-details').slideUp();
                $('.game-time').slideDown();
                $('.game-final').slideDown();
                $("#winning_team").val('');
                $("#away_team_final_score").val('');
                $("#home_team_final_score").val('');
            } else {
                console.log(selectedValue);
                $('.game-time').slideUp();
                $(".game-summary-details").slideUp();
                $("#game_minute").val('');
                $("#game_second").val('');
                $("#winning_team").val('');
                $("#away_team_final_score").val('');
                $("#home_team_final_score").val('');
                $("#possession").val('');
            }
        });
    });
    
</script>
@stop