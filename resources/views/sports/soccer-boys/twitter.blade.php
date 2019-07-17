<!-- Modal -->
<div class="modal fade" id="twitterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="POST" action="{{ route('post.tweet') }}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Match Update</h5>
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
⚽ Boys Soccer Final:
@else
⚽ Boys Soccer Update:
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
echo '1st Half';
} elseif ($match->game_status == 3) {
echo 'Halftime';
} elseif ($match->game_status == 4) {
echo '2nd Half';
} else {
echo $numberFormatter->format($match->game_status - 4) . ' OT';
} ?>
@endif
@if (!empty($match->game_minute))
&nbsp;&nbsp;|&nbsp;&nbsp;{{$match->game_minute}}'
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



