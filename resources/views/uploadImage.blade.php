@extends("layouts.app")

@section("content")

<form method="post" action="{{route("upload")}}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image">
    <button type="submit" class="btn btn-sm btn-primary">submit</button>

</form>

@endsection