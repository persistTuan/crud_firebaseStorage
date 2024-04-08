@extends ("layouts.app")

@section("content")

<div class="container" style="margin-top: 50px;">

    <h4 class="text-center">Laravel RealTime CRUD Using Google Firebase</h4><br>

    <h5># Add Food</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addFood" class="form" method="POST" action="{{route('store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group d-flex justify-content-between mb-2 ">
                    <label style="min-width: 100px;" for="name" >Name</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Name" autofocus>
                </div>
                <div class="form-group d-flex justify-content-between mb-2">
                    <label style="min-width: 100px;" for="catrgories">Thể Loại </label>
                    <select name="categories" class="form-control" id="">
                        @foreach($categories as $key => $category)
                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group d-flex justify-content-between mb-2">
                    <label style="min-width: 100px;" for="price">Price</label>
                    <input id="price" type="number" class="form-control" name="price" placeholder="Price">
                </div>
                <div class="form-group d-flex justify-content-between mb-2">
                    <label style="min-width: 100px;" for="price">Quantity</label>
                    <input id="quantity" type="number" class="form-control" name="quantity" placeholder="Quantity">
                </div>
                <div class="form-group d-flex justify-content-between mb-2">
                    <label style="min-width: 100px;" for="description">Description</label>
                    <textarea id="description" class="form-control" name="description"
                        placeholder="Description"></textarea>
                </div>
                <div class="form-group d-flex justify-content-between mb-2">
                    <label style="min-width: 100px;" for="status">Status</label>
                    <select id="status" class="form-control" name="status">
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                </div>
                <div class="form-group d-flex  mb-2">
                    <label style="min-width: 100px;" for="image">Image URL</label>
                    <input id="image" type="file" accept="image/png, image/jpeg, image/jpg" name="image">
                </div>
                <button id="submitFood" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <br>
    <h5># Foods</h5>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Status</th>
            <th>Image</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">
            @if($products)
            @foreach($products as $key => $product)
            <tr id="tr_{{$key}}">
                <td id="name_{{$key}}">{{$product['name']}}</td>
                <td id="name_{{$key}}">{{$product['categories']}}</td>
                <td id="price_{{$key}}">{{$product['price']}}</td>
                <td id="price_{{$key}}">{{$product['quantity']??0}}</td>
                <td id="description_{{$key}}">{{$product['description']}}</td>
                <td id="status_{{$key}}">{{$product['status']}}</td>
                <td id="image_{{$key}}"><img alt="Ảnh đang bi lõi hoặc hết hạn truy cập" src="{{$product['image']}}"
                        width="50" height="50"></td>
                <td>
                    <a href="{{route('edit', $key)}}" class="btn btn-primary btn-sm">Edit</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#{{$key}}">
                        Delete
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn thực sự muốn xóa
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <form method="post" action="{{route('delete', $key)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="subumit" class="btn btn-primary">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>




            @endforeach
            @endif
        </tbody>
    </table>
</div>

@endsection