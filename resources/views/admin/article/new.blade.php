@extends('admin.layout.master')
@section('content')
    <form method="post" enctype="multipart/form-data" action="{{route('admin.newArticleIndex')}}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Article name</label>
            <input style="background-color: black;color: white" type="text" class="form-control" id="name" name="name" aria-describedby="text">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category name</label>
            <select name="category" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"> {{ $category->category_name }} </option>
                @endforeach
            </select>
        </div>
      <div class="mb-3">
          <label for="name" class="form-label">Article</label>
           <textarea name="articlecontent"></textarea>
     </div>
        <div class="mb-3">
            <input type="file" name="image" placeholder="Choose image" id="image">
            @error('image')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
