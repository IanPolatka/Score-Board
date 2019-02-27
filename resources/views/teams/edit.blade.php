@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/teams">Teams</a></li>
                    <li class="breadcrumb-item"><a href="/teams/{{$team->id}}/{{$currentYear->the_year->year}}">{{$team->school_name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-4">

              <div class="card-body">

                <h4>Team Logo</h4>

                <form action="/teams/{{ $team->id }}/image-upload" enctype="multipart/form-data" method="POST">

                  <div class="team-profile mb-4">
      
                    {{ csrf_field() }}

                    @if ($team->logo)



                      <img src="/images/team-logos/{{ $team->logo }}" style="max-width: 100px;">
                        @endif

               

                    <input type="file" name="image" />

                  </div><!--  Team Profile  -->

                  <button type="submit" class="btn btn-primary">Upload</button>

                </form>

              </div><!--  Card Body  -->

            </div>


            <div class="card">

                <div class="card-body">

                    <h4>Team Information</h4>

                    <form action="{{route('team.update', $team->id)}}" method="POST">
                        {{method_field('PATCH')}}
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="school_name">School Name</label>
                            <input type="text" class="form-control{{ $errors->has('school_name') ? ' is-invalid' : '' }}" name="school_name" id="school_name" aria-describedby="School Name" placeholder="School Name" value="{{$team->school_name}}">

                            @if ($errors->has('school_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('school_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="abbreviated_name">Abbreviated Name</label>
                            <input type="text" class="form-control{{ $errors->has('abbreviated_name') ? ' is-invalid' : '' }}" name="abbreviated_name" id="abbreviated_name" aria-describedby="Abbreviated Name" placeholder="Abbreviated Name" value="{{$team->abbreviated_name}}">

                            @if ($errors->has('abbreviated_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('abbreviated_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" id="city" aria-describedby="City" placeholder="City" value="{{$team->city}}">

                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="form-control" id="state" name="state" @if ($errors->has('state')) style="border-color: #dc3545;" @endif>
                              <option value="" @if ($team->state === '') selected @endif>Select A State</option>
                              <option value="AL" @if ($team->state === 'AL') selected @endif>Alabama</option>
                              <option value="AK" @if ($team->state === 'AK') selected @endif>Alaska</option>
                              <option value="AZ" @if ($team->state === 'AZ') selected @endif>Arizona</option>
                              <option value="AR" @if ($team->state === 'AR') selected @endif>Arkansas</option>
                              <option value="CA" @if ($team->state === 'CA') selected @endif>California</option>
                              <option value="CO" @if ($team->state === 'CO') selected @endif>Colorado</option>
                              <option value="CT" @if ($team->state === 'CT') selected @endif>Connecticut</option>
                              <option value="DE" @if ($team->state === 'DE') selected @endif>Delaware</option>
                              <option value="DC" @if ($team->state === 'DC') selected @endif>District Of Columbia</option>
                              <option value="FL" @if ($team->state === 'FL') selected @endif>Florida</option>
                              <option value="GA" @if ($team->state === 'GA') selected @endif>Georgia</option>
                              <option value="HI" @if ($team->state === 'HI') selected @endif>Hawaii</option>
                              <option value="ID" @if ($team->state === 'ID') selected @endif>Idaho</option>
                              <option value="IL" @if ($team->state === 'IL') selected @endif>Illinois</option>
                              <option value="IN" @if ($team->state === 'IN') selected @endif>Indiana</option>
                              <option value="IA" @if ($team->state === 'IA') selected @endif>Iowa</option>
                              <option value="KS" @if ($team->state === 'KS') selected @endif>Kansas</option>
                              <option value="KY" @if ($team->state === 'KY') selected @endif>Kentucky</option>
                              <option value="LA" @if ($team->state === 'LA') selected @endif>Louisiana</option>
                              <option value="ME" @if ($team->state === 'ME') selected @endif>Maine</option>
                              <option value="MD" @if ($team->state === 'MD') selected @endif>Maryland</option>
                              <option value="MA" @if ($team->state === 'MA') selected @endif>Massachusetts</option>
                              <option value="MI" @if ($team->state === 'MI') selected @endif>Michigan</option>
                              <option value="MN" @if ($team->state === 'MN') selected @endif>Minnesota</option>
                              <option value="MS" @if ($team->state === 'MS') selected @endif>Mississippi</option>
                              <option value="MO" @if ($team->state === 'MO') selected @endif>Missouri</option>
                              <option value="MT" @if ($team->state === 'MT') selected @endif>Montana</option>
                              <option value="NE" @if ($team->state === 'NE') selected @endif>Nebraska</option>
                              <option value="NV" @if ($team->state === 'NV') selected @endif>Nevada</option>
                              <option value="NH" @if ($team->state === 'NH') selected @endif>New Hampshire</option>
                              <option value="NJ" @if ($team->state === 'NJ') selected @endif>New Jersey</option>
                              <option value="NM" @if ($team->state === 'NM') selected @endif>New Mexico</option>
                              <option value="NY" @if ($team->state === 'NY') selected @endif>New York</option>
                              <option value="NC" @if ($team->state === 'NC') selected @endif>North Carolina</option>
                              <option value="ND" @if ($team->state === 'ND') selected @endif>North Dakota</option>
                              <option value="OH" @if ($team->state === 'OH') selected @endif>Ohio</option>
                              <option value="OK" @if ($team->state === 'OK') selected @endif>Oklahoma</option>
                              <option value="OR" @if ($team->state === 'OR') selected @endif>Oregon</option>
                              <option value="PA" @if ($team->state === 'PA') selected @endif>Pennsylvania</option>
                              <option value="RI" @if ($team->state === 'RI') selected @endif>Rhode Island</option>
                              <option value="SC" @if ($team->state === 'SC') selected @endif>South Carolina</option>
                              <option value="SD" @if ($team->state === 'SD') selected @endif>South Dakota</option>
                              <option value="TN" @if ($team->state === 'TN') selected @endif>Tennessee</option>
                              <option value="TX" @if ($team->state === 'TX') selected @endif>Texas</option>
                              <option value="UT" @if ($team->state === 'UT') selected @endif>Utah</option>
                              <option value="VT" @if ($team->state === 'VT') selected @endif>Vermont</option>
                              <option value="VA" @if ($team->state === 'VA') selected @endif>Virginia</option>
                              <option value="WA" @if ($team->state === 'WA') selected @endif>Washington</option>
                              <option value="WV" @if ($team->state === 'WV') selected @endif>West Virginia</option>
                              <option value="WI" @if ($team->state === 'WI') selected @endif>Wisconsin</option>
                              <option value="WY" @if ($team->state === 'WY') selected @endif>Wyoming</option>>
                            </select>

                            @if ($errors->has('state'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="mascot">Mascot</label>
                            <input type="text" class="form-control{{ $errors->has('mascot') ? ' is-invalid' : '' }}" name="mascot" id="mascot" aria-describedby="Mascot" placeholder="Mascot" value="{{$team->mascot}}">

                            @if ($errors->has('mascot'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mascot') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
