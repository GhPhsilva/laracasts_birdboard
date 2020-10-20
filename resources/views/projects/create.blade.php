@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">Start a new project </h1>
        <form action="/projects" method="POST">
            @include('projects._form',['project'=> new App\Models\Project,'buttonText'=>'Create project'])
        </form>
    </div>
@endsection
