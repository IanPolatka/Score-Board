@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/boys-golf">Boys Golf</a></li>
                    <li class="breadcrumb-item active">Match ID: {{$match->id}}</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <boys-golf :id="'{!! json_encode($match->id) !!}'" class="mb-4"></boys-golf>

            @role(['superadministrator', 'administrator', 'editor'])

            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <a href="{{ route('boysgolf-edit', $match->id)}}" class="btn btn-primary btn-block">Edit Match</a> 
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">

                    <form method="POST" action="/boys-golf/delete/{{ $match->id }}">

                        {{ method_field('DELETE') }}

                        {{ csrf_field() }}    

                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-block">Delete Game</button>
                            
                    </form>

                </div>

            </div>

            @endrole

		</div><!--  Col  -->

	</div><!--  Row  -->

</div><!--  Container  -->
@endsection