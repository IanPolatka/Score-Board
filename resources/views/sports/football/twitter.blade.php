<?php 
//  Calculate Team Scores
$away_total_final = $match->away_team_final_score; ?>

<?php $away_total = 0; ?>
@foreach ($scores as $score)
  <?php $away_total += $score->away_team_score; ?>
@endforeach

<?php $home_total_final = $match->home_team_final_score; ?>

<?php $home_total = 0; ?>
@foreach ($scores as $score)
  <?php $home_total += $score->home_team_score; ?>
@endforeach



<!-- Modal -->
<div class="modal fade" id="twitterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="POST" action="{{ route('post.tweet') }}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Game Update</h5>
      </div>
      <div class="modal-body">

        

          {{ csrf_field() }}

          @if(count($errors))
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.
              <br/>
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="form-group">

            <label>Tweet Text:</label>
            <textarea class="form-control" name="tweet" rows="7">
@if ($match->game_status == 1)
🏈 Football Final:
@else
🏈 Football Update:
@endif
@if (!empty($match->away_team_final_score) && !empty($match->home_team_final_score))
{{$match->away_team->school_name}} {{$match->away_team_final_score}}
{{$match->home_team->school_name}} {{$match->home_team_final_score}}
@else
{{$match->away_team->school_name}} {{$match->away_score_sum}}
{{$match->home_team->school_name}} {{$match->home_score_sum}}
@endif
@if ($match->game_status > 1)

<?php
if ($match->game_status == 2) {
echo '1st Quarter';
} elseif ($match->game_status == 3) {
echo '2nd Quarter';
} elseif ($match->game_status == 4) {
echo 'Halftime';
} elseif ($match->game_status == 5) {
echo '3rd Quarter';
} elseif ($match->game_status == 6) {
echo '4th Quarter';
} else {
echo $numberFormatter->format($match->game_status - 4) . ' OT';
} ?>
@endif
@if (!empty($match->game_second))
 - {{$match->game_minute}}:{{$match->game_second}}
@endif

#camelpride
            </textarea>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        <button class="btn btn-primary"><i class="fab fa-twitter mr-2"></i>Tweet</button>
      </div>
    </div>
  </div>
  </form>
</div>



