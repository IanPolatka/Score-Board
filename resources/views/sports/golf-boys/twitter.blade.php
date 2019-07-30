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
Boys Golf Final:
{{$match->away_team->school_name}} {{$match->away_team_final_score}}
{{$match->home_team->school_name}} {{$match->home_team_final_score}}

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



