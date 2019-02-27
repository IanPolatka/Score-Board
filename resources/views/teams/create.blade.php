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
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

          <h3 class="title">Create New Team</h3>

            <div class="card">

                <div class="card-body">

                    <form action="{{route('team.store')}}" method="POST">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="school_name">School Name</label>
                            <input type="text" class="form-control{{ $errors->has('school_name') ? ' is-invalid' : '' }}" name="school_name" id="school_name" aria-describedby="School Name" placeholder="School Name" value="{{ old('school_name') }}">

                            @if ($errors->has('school_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('school_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="abbreviated_name">Abbreviated Name</label>
                            <input type="text" class="form-control{{ $errors->has('abbreviated_name') ? ' is-invalid' : '' }}" name="abbreviated_name" id="abbreviated_name" aria-describedby="Abbreviated Name" placeholder="Abbreviated Name" value="{{ old('abbreviated_name') }}">

                            @if ($errors->has('abbreviated_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('abbreviated_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" id="city" aria-describedby="City" placeholder="City" value="{{ old('city') }}">

                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="form-control" id="state" name="state" @if ($errors->has('state')) style="border-color: #dc3545;" @endif>
                              <option value="" @if (old('state') === '') selected @endif>Select A State</option>
                              <option value="AL" @if (old('state') === 'AL') selected @endif>Alabama</option>
                              <option value="AK" @if (old('state') === 'AK') selected @endif>Alaska</option>
                              <option value="AZ" @if (old('state') === 'AZ') selected @endif>Arizona</option>
                              <option value="AR" @if (old('state') === 'AR') selected @endif>Arkansas</option>
                              <option value="CA" @if (old('state') === 'CA') selected @endif>California</option>
                              <option value="CO" @if (old('state') === 'CO') selected @endif>Colorado</option>
                              <option value="CT" @if (old('state') === 'CT') selected @endif>Connecticut</option>
                              <option value="DE" @if (old('state') === 'DE') selected @endif>Delaware</option>
                              <option value="DC" @if (old('state') === 'DC') selected @endif>District Of Columbia</option>
                              <option value="FL" @if (old('state') === 'FL') selected @endif>Florida</option>
                              <option value="GA" @if (old('state') === 'GA') selected @endif>Georgia</option>
                              <option value="HI" @if (old('state') === 'HI') selected @endif>Hawaii</option>
                              <option value="ID" @if (old('state') === 'ID') selected @endif>Idaho</option>
                              <option value="IL" @if (old('state') === 'IL') selected @endif>Illinois</option>
                              <option value="IN" @if (old('state') === 'IN') selected @endif>Indiana</option>
                              <option value="IA" @if (old('state') === 'IA') selected @endif>Iowa</option>
                              <option value="KS" @if (old('state') === 'KS') selected @endif>Kansas</option>
                              <option value="KY" @if (old('state') === 'KY') selected @endif>Kentucky</option>
                              <option value="LA" @if (old('state') === 'LA') selected @endif>Louisiana</option>
                              <option value="ME" @if (old('state') === 'ME') selected @endif>Maine</option>
                              <option value="MD" @if (old('state') === 'MD') selected @endif>Maryland</option>
                              <option value="MA" @if (old('state') === 'MA') selected @endif>Massachusetts</option>
                              <option value="MI" @if (old('state') === 'MI') selected @endif>Michigan</option>
                              <option value="MN" @if (old('state') === 'MN') selected @endif>Minnesota</option>
                              <option value="MS" @if (old('state') === 'MS') selected @endif>Mississippi</option>
                              <option value="MO" @if (old('state') === 'MO') selected @endif>Missouri</option>
                              <option value="MT" @if (old('state') === 'MT') selected @endif>Montana</option>
                              <option value="NE" @if (old('state') === 'NE') selected @endif>Nebraska</option>
                              <option value="NV" @if (old('state') === 'NV') selected @endif>Nevada</option>
                              <option value="NH" @if (old('state') === 'NH') selected @endif>New Hampshire</option>
                              <option value="NJ" @if (old('state') === 'NJ') selected @endif>New Jersey</option>
                              <option value="NM" @if (old('state') === 'NM') selected @endif>New Mexico</option>
                              <option value="NY" @if (old('state') === 'NY') selected @endif>New York</option>
                              <option value="NC" @if (old('state') === 'NC') selected @endif>North Carolina</option>
                              <option value="ND" @if (old('state') === 'ND') selected @endif>North Dakota</option>
                              <option value="OH" @if (old('state') === 'OH') selected @endif>Ohio</option>
                              <option value="OK" @if (old('state') === 'OK') selected @endif>Oklahoma</option>
                              <option value="OR" @if (old('state') === 'OR') selected @endif>Oregon</option>
                              <option value="PA" @if (old('state') === 'PA') selected @endif>Pennsylvania</option>
                              <option value="RI" @if (old('state') === 'RI') selected @endif>Rhode Island</option>
                              <option value="SC" @if (old('state') === 'SC') selected @endif>South Carolina</option>
                              <option value="SD" @if (old('state') === 'SD') selected @endif>South Dakota</option>
                              <option value="TN" @if (old('state') === 'TN') selected @endif>Tennessee</option>
                              <option value="TX" @if (old('state') === 'TX') selected @endif>Texas</option>
                              <option value="UT" @if (old('state') === 'UT') selected @endif>Utah</option>
                              <option value="VT" @if (old('state') === 'VT') selected @endif>Vermont</option>
                              <option value="VA" @if (old('state') === 'VA') selected @endif>Virginia</option>
                              <option value="WA" @if (old('state') === 'WA') selected @endif>Washington</option>
                              <option value="WV" @if (old('state') === 'WV') selected @endif>West Virginia</option>
                              <option value="WI" @if (old('state') === 'WI') selected @endif>Wisconsin</option>
                              <option value="WY" @if (old('state') === 'WY') selected @endif>Wyoming</option>>
                            </select>

                            @if ($errors->has('state'))
                                <span style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="mascot">Mascot</label>
                            <input type="text" class="form-control{{ $errors->has('mascot') ? ' is-invalid' : '' }}" name="mascot" id="mascot" aria-describedby="Mascot" placeholder="Mascot" value="{{ old('mascot') }}">

                            @if ($errors->has('mascot'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mascot') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
