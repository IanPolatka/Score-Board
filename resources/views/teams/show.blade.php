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
                    <li class="breadcrumb-item active" aria-current="page">{{$team->school_name}}</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <ul class="list-group mb-4">
                <li class="list-group-item disabled">
                    <img class="mr-3 mb-2" style="height:35px; width:35px" src="/images/team-logos/{{ $team->logo }}" />{{$team->school_name}}
                </li>
            </ul>

            <a href="{{ route('team.edit', $team->id)}}" class="btn btn-primary mb-2">Edit Team</a>

            <div class="form-group">
                <label for="year_id">Select A Year</label>
                <select class="form-control" name="year_id" onChange="window.location.href=this.value">
                    <option value="">Please Select A Year</option>
                    @foreach($years as $year)
                        <option value="/teams/{{$team->id}}/{{$year->year}}" @if($selectedyearid == $year->id) selected @endif>{{$year->year}}</option>
                    @endforeach
                </select>
            </div>

            <ul class="list-group mb-4">
                <li class="list-group-item disabled">
                    City: {{$team->city}}
                </li>
                <li class="list-group-item disabled">
                    State: {{$team->state}}
                </li>
                <li class="list-group-item disabled">
                    Mascot: {{$team->mascot}}
                </li>
                <li class="list-group-item disabled">
                    Abbreviated Name: {{$team->abbreviated_name}}
                </li>
            </ul>

            @if (count($teamMeta) < 1)

            <form action="/teams/{{$team->id}}/{{$selectedyearid}}/create-meta" method="POST">
                @csrf

                <button type="submit" class="btn btn-primary">Create District Records</button>

            </form>

            @else

                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col"><small>Baseball Region</small><br />
                                @if($teamMeta[0]->baseball_region)
                                    <h4>{{$teamMeta[0]->baseball_region}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                            <div class="col"><small>Baseball District</small><br />
                                @if($teamMeta[0]->baseball_district)
                                    <h4>{{$teamMeta[0]->baseball_district}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col"><small>Basketball Region</small><br />
                                @if($teamMeta[0]->basketball_region)
                                    <h4>{{$teamMeta[0]->basketball_region}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                            <div class="col"><small>Basketball District</small><br />
                                @if($teamMeta[0]->basketball_district)
                                    <h4>{{$teamMeta[0]->basketball_district}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col"><small>Football Class</small><br />
                                @if($teamMeta[0]->football_class)
                                    <h4>{{$teamMeta[0]->football_class}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                            <div class="col"><small>Football District</small><br />
                                @if($teamMeta[0]->football_district)
                                    <h4>{{$teamMeta[0]->football_district}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col"><small>Soccer Region</small><br />
                                @if($teamMeta[0]->soccer_region)
                                    <h4>{{$teamMeta[0]->soccer_region}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                            <div class="col"><small>Soccer District</small><br />
                                @if($teamMeta[0]->soccer_district)
                                    <h4>{{$teamMeta[0]->soccer_district}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col"><small>Softball Region</small><br />
                                @if($teamMeta[0]->softball_region)
                                    <h4>{{$teamMeta[0]->softball_region}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                            <div class="col"><small>Softball District</small><br />
                                @if($teamMeta[0]->softball_district)
                                    <h4>{{$teamMeta[0]->softball_district}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col"><small>Volleyball Region</small><br />
                                @if($teamMeta[0]->volleyball_region)
                                    <h4>{{$teamMeta[0]->volleyball_region}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                            <div class="col"><small>Volleyball District</small><br />
                                @if($teamMeta[0]->volleyball_district)
                                    <h4>{{$teamMeta[0]->volleyball_district}}</h4>
                                @else
                                    <h4>-</h4>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>

                <a href="" class="btn btn-primary">Edit Standings Info</a>

            @endif

            <!-- <input type="text" class="form-control" value="{{$currentYear->the_year->year}}"> -->

        </div>
    </div>
</div>
@endsection
