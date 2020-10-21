@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-gray text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normla no-underline">My projects</a> /
                {{ $project->title }}
            </p>
            <a href="{{ $project->path() . '/edit' }}" class="text-grey no-underline button">Edit project</a>
        </div>
    </header>
    <main>

        <div class="lg:flex -mx-3 mb-6">
            <div class="lg:w-3/4 px-3">
                <div class="mb-8">
                    <h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex">
                                    <input type="text" name="body" value="{{ $task->body }}"
                                        class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                    <input name="completed" type="checkbox" onchange="this.form.submit()"
                                        {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input name="body" type="text" placeholder="Add a new task.." class="w-full">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>
                    <form action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" placeholder="Anything special that you want to make note of ?"
                            class="card w-full" style="min-height: 200px">
                        {{ $project->notes }}
                        </textarea>
                        <button class="button" type="submit">Save</button>
                    </form>
                </div>
                @if ($errors->any())
                    <div class="field mt-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>

@endsection
