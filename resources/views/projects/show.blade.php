@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-gray text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normla no-underline">My projects</a>  / {{$project->title}}
            </p>
            <a href="/projects/create" class="text-grey no-underline button">New project</a>
        </div>
    </header>
    <main>
        <div class="lg:flex -mx-3 mb-6">
            <div class="lg:w-3/4 px-3">
                <div class="mb-8">
                    <h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>
                    
                    <div class="card mb-2">Lorem Ipsum</div>

                    <div class="card mb-2">Lorem Ipsum</div>

                    <div class="card mb-2">Lorem Ipsum</div>

                    <div class="card">Lorem Ipsum</div>
                </div>
                
                <div>
                    <h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>

                    <textarea class="card w-full" style="min-height: 200px">Lorem Ipsum</textarea>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">    
                @include('projects.card')
            </div>
        </div>
    </main>
    
@endsection