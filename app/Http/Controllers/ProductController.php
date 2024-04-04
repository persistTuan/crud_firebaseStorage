<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Storage;
use Kreait\Firebase\Storage\Bucket;
use Google\Cloud\Core\Timestamp;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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
        $categories = $this->database->getReference('categories')->getSnapshot()->getValue();
        $products = collect($products);
        $categories = collect($categories); 
        $innerJoin = $products->map(function($product) use ($categories){
            $category = $categories->where('id', $product['categories'])->first();
            $result = collect([
                'name' => $product['name'],
                'price' => $product['price'],
                'description' => $product['description'],
                'status' => $product['status'],
                'image' => $product['image'],
                'categories' => $category['name'],
                'category_id' => $category['id'],
            ]);
            return $result;
        });
        $innerJoin = $innerJoin->toArray();
        $products = $innerJoin;
        // return view("products.index")->with("products", $products);
        // print_r($products);
        return view("products.index", compact('products', 'categories'));
        // or
        // return view("products.index", ['products' => $products, 'categories' => $categories]);
    }

    public function edit(string $id){
        $product = $this->database->getReference("products/{$id}")->getValue();
        $categories = $this->database->getReference("categories")->getValue();
        return view("products.edit", compact("product", "id", "categories"));
    }

    public function update(Request $request, string $id){
        $product = $this->database->getReference("products/{$id}")->getValue();
        if(isset($product['object'])){
            $obj = $this->storage->getBucket()->object($this->folderImage . $product['object']);
            $obj->delete();
        }

        $image = $request->file('image');  
        $myBucket = $this->storage->getBucket();
        if($image != null)
        {
            $hashName = $image->hashName();
            $obj = $myBucket->upload(
                $image->get(),
                [
                    'name' => $this->folderImage . $hashName,
                ]
                );
            $data = [
                'name' => $request->name,
                'categories' => $request->categories,
                'price' => $request->price,
                'description' => $request->description,
                'status' => $request->status,
                'object' => $hashName,
                'image' => $obj->signedUrl(Carbon::now()->addYears(100)),
            ];
        }
        else{
            // set trường hợp ảnh được thêm trực tiếp vào firebase bằng url nhưng chưa có trong storage
            if (!isset($product['object']) || $myBucket->object($this->folderImage . $product['object'])->exists()) {
                $imageContent = file_get_contents($product['image']);
                $imageName = basename($product['image']);
                $obj = $myBucket->upload(
                    $imageContent,
                    [
                        'name' => $this->folderImage . $imageName,
                    ]
                );
            }
            
            $data = [
                'name' => $request->name,
                'categories' => $request->categories,
                'price' => $request->price,
                'description' => $request->description,
                'status' => $request->status,
                'object' => $imageName,
                'image' => $obj->signedUrl(Carbon::now()->addYears(100)),
            ];
        }
          
        
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
        // $this->storage->getBucket()->object($this->folderImage . $product->getValue()['object'])->delete();
        $obj = $this->storage->getBucket()->object($this->folderImage . $product->getValue()['object']);
        if($obj->exists())
        {
            $obj->delete();
        }
        $product->remove();
        return redirect()->back();
    }
}