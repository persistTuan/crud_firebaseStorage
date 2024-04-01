@extends ("layouts.app")

@section("content")


<div class="container m-2">
    <h4 class="text-center">Laravel RealTime CRUD Using Google Firebase</h4><br>
    <h5># Edit Products</h5>




    <form class="" id="addFood" class="form" method="POST" action="{{route('update', $id)}}"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group d-flex justify-content-between mb-2">
            <label for="name" style="min-width: 100px;">Name</label>
            <input id="name" class="w-100" type="text" name="name" placeholder="Name" autofocus
                value="{{$product['name']}}">
        </div>
        <div class="form-group d-flex justify-content-lg-around mb-2">
            <label style="min-width: 100px;" for="price">Price</label>
            <input id="price" type="number" class="form-control" name="price" placeholder="Price"
                value="{{$product['price']}}">
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
            <input id="image" type="file" accept="image/png, image/jpeg, image/jpg" name="image">
        </div>
        <img id="imagePreview" src="" class="img-fluid" alt="Ảnh tải lên">
        <button id="submitFood" type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


@endsection

@section('scripts')

<script>
    var image = document.getElementById('image');
    image.onchange = function(){
        var reader = new FileReader();
        reader.onload = function(e){
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result;
        }
        reader.readAsDataURL(image.files[0]);
    }
</script>

@endsection