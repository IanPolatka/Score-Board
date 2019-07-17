@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/boys-soccer">Boys Soccer</a></li>
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

            <boys-soccer :id="'{!! json_encode($game->id) !!}'" class="mb-4"></boys-soccer>

            @role(['superadministrator', 'administrator', 'editor'])

            <div class="row">

                <div class="col">
                    <a href="{{ route('boys-soccer-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Match</a> 
                </div>
                <div class="col">
                    <a href="{{ route('boys-soccer-score-edit', $game->id)}}" class="btn btn-primary btn-block">Edit Match Play</a> 
                </div>
                <div class="col">

                    <form method="POST" action="/boys-soccer/delete/{{ $game->id }}">

                        {{ method_field('DELETE') }}

                        {{ csrf_field() }}    

                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-block">Delete Match</button>
                            
                    </form>

                </div>

            </div>

            @endrole

		</div><!--  Col  -->

	</div><!--  Row  -->

</div><!--  Container  -->
@endsection