<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{AddCategoryRequest,EditCategoryRequest};
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function getCategory()
    {
        $data['categories']=Category::all()->toArray();   
        return view('backend.category.category',$data);
    }

    function postCategory(EditCategoryRequest $r)
    {
        $cate = new Category;
        $cate->name=$r->name;
        $cate->slug = Str::slug($r->name, '-');
        $cate->parent=$r->parent;
        $cate->save();

        return redirect()->back()->with('thongbao','Thêm thành công');
    }

    function getEditCategory($idCate)
    {
        $data['cate']=Category::findOrFail($idCate); // không có bản ghi đẩy sang lỗi 404 tương tự không có route
        $data['categories']=Category::all()->toArray();
        return view('backend.category.editcategory',$data);
    }

    function postEditCategory(EditCategoryRequest $r,$idCate)
    {
        $cate=Category::find($idCate);
        $cate->name=$r->name;
        $cate->slug = Str::slug($r->name, '-');
        $cate->parent=$r->parent;
        $cate->save();
        return redirect()->back()->with('thongbao','Sửa thành công');
    }

    function delCategory($idCate)
    {
        $cate=Category::find($idCate);
        $parent=$cate->parent;

        Category::where('parent',$cate->id)->update(['parent'=>$parent]);

        Category::destroy($idCate);

        return redirect()->back()->with('thongbao','Xóa thành công danh mục ');
    }
}
