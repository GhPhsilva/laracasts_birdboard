@extends('layouts.app')
@section('content')
    <form action="/projects" method="POST">
        @csrf
        <div class="form-group">
            <label for="">Title</label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{url('projects')}}">Back</a>
    </form>
@endsection