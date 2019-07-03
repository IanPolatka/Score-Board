@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/baseball">Baseball</a></li>
                    <li class="breadcrumb-item active">Game ID: {{$game->id}}</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <baseball :id="'{!! json_encode($game->id) !!}'" class="mb-4"></baseball>

            @role(['superadministrator', 'administrator', 'editor'])

            <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <a href="{{ route('baseball-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Game</a> 
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <a href="{{ route('baseball-score-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Game Play</a> 
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">

                    <form method="POST" action="/baseball/delete/{{ $game->id }}">

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