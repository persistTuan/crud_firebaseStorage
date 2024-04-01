<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Storage;
use Kreait\Firebase\Storage\Bucket;
use Google\Cloud\Core\Timestamp;
use Carbon\Carbon;
class ProductController extends Controller
{
    //
    public $folderImage = "image_products/";
    protected $database;
    protected $storage;
    public function __construct(Database $database, Storage $storage)
    {
        $this->database = $database;
        $this->storage = $storage;
    }
    public function index(){
        $products = $this->database->getReference('products')->getSnapshot()->getValue();
        // print_r($products);
        return view("products.index", compact('products'));
    }

    public function edit(string $id){
        $product = $this->database->getReference("products/{$id}")->getValue();
        return view("products.edit", compact("product", "id"));
    }

    public function update(Request $request, string $id){
        $product = $this->database->getReference("products/{$id}")->getValue();
        $obj = $this->storage->getBucket()->object($this->folderImage . $product['object']);
        $image = $request->file('image');
        $obj->delete();

        $myBucket = $this->storage->getBucket();
        $hashName = $image->hashName();
        $obj = $myBucket->upload(
            $image->get(),
            [
                'name' => $this->folderImage . $hashName,
            ]
            );
          
        
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'object' => $hashName,
            'image' => $obj->signedUrl(Carbon::now()->addYears(100)),
        ];
        $this->database->getReference("products/{$id}")->update($data);
        return redirect()->route('product');
        
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'required',
        ]);
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $status = $request->status;
        $image = $request->file('image');

        $myBucket = $this->storage->getBucket();
        $hashName = $image->hashName();
        $object = $myBucket->upload(
            $image->get(),
            [
                'name' => "image_products/" . $hashName,
            ]
            );
        $url = $object->signedUrl(Carbon::now()->addYears(100));
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'status' => $status,
            'image' => $url,
            'object'=> $hashName,
        ];


        $this->database->getReference('products')->push($data);
        return redirect()->route('product');
    }
 

    public function delete(string $id){
        $product = $this->database->getReference("products/{$id}");
        $folderImage = $this->folderImage;
        $this->storage->getBucket()->object($this->folderImage . $product->getValue()['object'])->delete();
        $product->remove();
        return redirect()->back();
    }
}