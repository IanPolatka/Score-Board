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

            <a href="{{ route('year.create') }}" class="btn btn-primary mb-4">Create Year</a>

            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{$year->year}}</span>
                    <span class="d-flex justify-content-between align-items-center">
                            <a href="/years/{{$year->id}}/edit" class="mr-2"><span class="btn btn-primary btn-sm">Edit</span></a>
                            <form method="POST" action="/years/delete/{{ $year->id }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete Year</button>
                            </form>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
