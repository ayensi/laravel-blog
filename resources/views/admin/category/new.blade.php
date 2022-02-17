@extends('admin.layout.master')
@section('content')
    <form method="post" action="{{route('admin.newCategoryIndex')}}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category name</label>
            <input style="background-color: black;color: white" type="text" class="form-control" id="name" name="name" aria-describedby="text">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
