@extends('layouts.app')

@section('content')

<div class="breadcrumb-section">

    <div class="container">

        <div class="row">

            <div class="col">

                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teams</li>
                  </ol>
                </nav>

            </div>

        </div>

    </div>

</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <a href="{{ route('team.create') }}" class="btn btn-primary mb-4">Create Team</a>

            <div class="list-group">
                @forelse ($teams as $team)
                    <a href="/teams/{{$team->id}}/{{$currentYear->the_year->year}}" class="list-group-item list-group-item-action">
                        <img class="mr-3 mb-2" style="height:35px; width:35px" src="/images/team-logos/{{ $team->logo }}" />{{$team->school_name}}
                    </a>
                @empty

                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
