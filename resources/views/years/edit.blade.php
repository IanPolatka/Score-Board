@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/years">Years</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$year->year}}</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{route('year.update', $year->id)}}" method="POST">

                {{method_field('PATCH')}}
                {{csrf_field()}}

                <ul class="list-group">
                    <li class="list-group-item">
                        <h5 class="mb-3">Edit Year</h5>
                        <input type="text" class="form-control mb-3" value="{{$year->year}}" name="year" required>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </li>
                </ul>

            </form>
        </div>
    </div>
</div>
@endsection
