@extends ("layouts.app")

@section("content")

<div class="container m-2">

    <h4 class="text-center">Laravel RealTime CRUD Using Google Firebase</h4><br>
    <h5># Edit Products</h5>
</div>
<div class="container m-2 d-flex justify-content-between">




    <form class="" id="addFood" class="form" style="flex: 3;" method="POST" action="{{route('update', $id)}}"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group d-flex justify-content-between mb-2">
            <label for="name" style="min-width: 100px;">Name</label>
            <input id="name" class="w-100" type="text" name="name" placeholder="Name" autofocus
                value="{{$product['name']}}">
        </div>
        <div class="form-group d-flex justify-content-between mb-2">
            <label for="catrgories" style="min-width: 100px;">Thể Loại </label>
            <select name="categories" class="form-control w-100" id="">
                @foreach($categories as $key => $category)
                @if($category['id'] == $product['categories'])
                <option selected value="{{$category['id']}}">{{$category['name']}}</option>
                @else
                <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group d-flex justify-content-lg-around mb-2">
            <label style="min-width: 100px;" for="price">Price</label>
            <input id="price" type="number" class="form-control" name="price" placeholder="Price"
                value="{{$product['price']}}">
        </div>
        <div class="form-group d-flex justify-content-lg-around mb-2">
            <label style="min-width: 100px;" for="price">Quantity</label>
            <input id="quantity" type="number" class="form-control" name="quantity" placeholder="Quantity"
                value="{{ $product['quantity'] ?? '' }}">
        </div>
        <div class="form-group d-flex justify-content-lg-around mb-2">
            <label style="min-width: 100px;" for="description">Description</label>
            <textarea id="description" class="form-control" name="description"
                placeholder="Description">{{$product['description']}}</textarea>
        </div>
        <div class="form-group d-flex justify-content-lg-around mb-2">
            <label style="min-width: 100px;" for="status">Status</label>
            <select id="status" class="form-control" name="status">
                @if($product['status'] == "available")
                <option selected value="available">Available</option>
                <option value="unavailable">Unavailable</option>
                @else
                <option value="available">Available</option>
                <option selected value="unavailable">Unavailable</option>
                @endif
            </select>
        </div>
        <div class=" d-flex mt-2 mb-2">
            <div style="min-width: 100px;">Image URL</div>
            <input value="{{$product['image']}}" id="image" type="file" accept="image/png, image/jpeg, image/jpg"
                name="image">
        </div>
        <button id="submitFood" type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>
    <div class="container-image ms-2" style="flex: 2;">
        <img id="imagePreview" src="{{$product['image']}}" class="img-fluid" alt="Ảnh tải lên">
    </div>
</div>


@endsection

@section('scripts')

<script>
var image = document.getElementById('image');
image.onchange = function() {
    var reader = new FileReader();
    reader.onload = function(e) {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = e.target.result;
    }
    reader.readAsDataURL(image.files[0]);
}
</script>

@endsection