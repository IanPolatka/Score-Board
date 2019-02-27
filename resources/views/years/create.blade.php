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

            <form action="{{route('year.create')}}" method="POST">

                {{csrf_field()}}

                <ul class="list-group">
                    <li class="list-group-item">
                        <h5 class="mb-3">Create Year</h5>
                        <input type="text" class="form-control" name="year" required placeholder="Example: 1999-2000"></li>
                    <li class="list-group-item"><button type="submit" class="btn btn-primary">Create Year</button></li>
                </ul>

            </form>
        </div>
    </div>
</div>
@endsection
