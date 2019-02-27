@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Years</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>


<div class="container">
    <div class="row">
        <div class="col-md-8 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="mb-0">All Years</h5>

                        <a href="{{ route('year.create') }}" class="btn btn-primary text-left">Create Year</a>

                    </div>

                    <div class="list-group">
                        @forelse ($years as $year)
                            <a href="/years/{{$year->id}}" class="list-group-item list-group-item-action">
                                {{$year->year}}
                            </a>
                        @empty

                        @endforelse
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card p-4">

                <h5 class="mb-2">Current School Year</h5>

                <form action="/years/current-year" method="POST">

                    {{method_field('PATCH')}}
                    {{csrf_field()}}

                    <div class="form-group">
                        <select class="form-control" id="exampleFormControlSelect1" name="year_id">
                            <option value="">Select A Year</option>
                            @foreach ($years as $year)
                                <option value="{{$year->id}}" @if($currentYear->year_id == $year->id) selected @endif>{{$year->year}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>

                </form>

            </div>

        </div>

    </div>
</div>
@endsection
