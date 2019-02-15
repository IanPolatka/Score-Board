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
            <textarea class="form-control tweetText" name="tweet" rows="7" data-limit="280">
@if ($match->inning == 99)
🥎 Final:
@else
🥎 Update:
@endif
@if (!empty($match->away_team_final_score) && !empty($match->home_team_final_score))
{{$match->away_team->school_name}} {{$away_total_final}}
{{$match->home_team->school_name}} {{$home_total_final}}
@else
{{$match->away_team->school_name}} {{$away_total}}
{{$match->home_team->school_name}} {{$home_total}}
@endif
@if ($match->inning > 0 && $match->inning < 99)

<?php echo $numberFormatter->format($match->inning); ?> Inning
@endif

#camelpride</textarea>
            <span id="chars">280</span> characters remaining
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        <button class="btn btn-primary sendTweet"><i class="fab fa-twitter mr-2"></i>Tweet</button>
      </div>
    </div>
  </div>
  </form>
</div>



