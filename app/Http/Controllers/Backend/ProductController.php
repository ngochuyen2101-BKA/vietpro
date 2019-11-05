<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{AddProductRequest,EditProductRequest};
use App\Models\{Product,Category};
use Illuminate\Support\Str;

class ProductController extends Controller
{
    function getProduct()
    {
        // viết API lấy dữ liệu  đưa ra các sản phẩm
        // return Product::paginate(3);
        // $data['product']=Product::find(1);
        // $data['categories']=Category::all();
        // return response()->json($data,200);
        $data['products'] = Product::paginate(3);
        return view('backend.product.listproduct',$data);
        // json: chuỗi có quy tắc

        // cách sửa version
        // sửa required trong composer.json
        // xóa file vendor -> chạy lại composer install
    }

    function getAddProduct()
    {
        $data['categories'] = Category::all();
        return view('backend.product.addproduct',$data);
    }

    function postAddProduct(AddProductRequest $r)
    {
        $prd = new Product;
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=Str::slug($r->name,'-');
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;

        if($r->hasFile('img'))
        {
            $file=$r->img;
            $fileName=Str::slug($r->name,'-').'.'.$file->getClientOriginalExtension();
            $file->move('backend/img',$fileName);
            $prd->img=$fileName;
        }
        else {
            $prd->img='no-img.jpg';
        }


        $prd->category_id=$r->category;
        $prd->save();

        return redirect('admin/product')->with('thongbao','Đã thêm thành công');
    }

    function getEditProduct($idPrd)
    {
        $data['prd']=Product::find($idPrd);
        $data['categories'] = Category::all();
        return view('backend.product.editproduct',$data);
    }

    function postEditProduct(EditProductRequest $r,$idPrd)
    {
        $prd = Product::find($idPrd);
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=Str::slug($r->name,'-');
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;

        if($r->hasFile('img'))
        {
            if (file_exists($prd->img)) {
                if ($prd->img!='no-img.jpg') {
                    unlink('backend/img',$prd->img);
                }
                
            }
            $file=$r->img;
            $fileName=Str::slug($r->name,'-').'.'.$file->getClientOriginalExtension();
            $file->move('backend/img',$fileName);
            $prd->img=$fileName;
        }


        $prd->category_id=$r->category;
        $prd->save();

        return redirect('admin/product')->with('thongbao','Đã sửa thành công');
    }

    function DelProduct($idPrd)
    {
        Product::destroy($idPrd);
        return redirect('/admin/product')->with('thongbao','Đã xóa thành công');
    }
}
