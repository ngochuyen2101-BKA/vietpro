<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//---LÝ THUYẾT
//Tạo cấu trúc cơ sở dữ liệu
Route::group(['prefix' => 'schema'], function () {
    Route::get('create-order-and-product-order', function (){

        // Tạo bảng order bằng schema
        Schema::create('order', function ($table) {
            $table->bigIncrements('id');
            $table->string('full'); // mặc định chiều dài là 255 nấu không khai báo, không ghi gì thì bắt buộc not null
            $table->string('address')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->decimal('total',18);// đơn vị tiền tệ 
            $table->tinyInteger('state')->unsigned();
            $table->timestamps();
        });

        // tạo bảng product_order
        Schema::create('product_order', function ($table) {
            $table->bigIncrements('id');
            $table->string('code', 45);
            $table->string('name');
            $table->double('price', 18);
            $table->tinyInteger('qty');
            $table->string('img');

            //tạo khóa ngoại
            $table->bigInteger('order_id')->unsigned();
        });
    });
    Route::get('del_table', function () {
        //xóa bảng
        // Schema::drop('table'); // nếu không có bảng sẽ lỗi chương trình
        Schema::dropIfExists('orders'); 
        Schema::dropIfExists('product_order');// nếu không có bảng vẫn chạy bình thường
    });

    Route::get('rename_table', function () {
        Schema::rename('order','orders');
    });

     // Xóa cột trong bảng
     Route::get('del-col', function () {
         Schema::table('orders', function($table){
            $table->dropColumn('updated_at');
         });
     });

     // Thay đổi thuộc tính của cột
     Route::get('change_col', function () {
         Schema::table('orders',function($table){
             // thay đổi thuộc tính
             $table->string('email', 50)->change();
             $table->integer('total')->change();

             // Bổ sung cột mới
             $table->string('zzzzzz');
         });
     });

});

// Query Builder
Route::group(['prefix' => 'query'], function () {
    
    Route::get('insert', function () {
    //     DB::table('users')->insert([
    //                                 'email'=>'huyen@gmail.com',
    //                                 'full'=>'Nguyễn Thị Huyền', // -> lấy thuộc tính trong đối trượng, => chỉ dùng trong arrray
    //                                 'password'=>'123456',
    //                                 'address'=>'Hà Nội',
    //                                 'phone'=>'123456123',
    //                                 'level'=>1
    //                                 ]);
    // });
    
    // Tạo nhiều bảng cùng lúc
    DB::table('users')->insert([
        ['email'=>'admin@gmail.com','password'=>bcrypt('123456'),'full'=>'vietpro','address'=>'Thường tín','phone'=>'0356653301','level'=>1],
        ['email'=>'zimpro@gmail.com','password'=>bcrypt('123456'),'full'=>'Nguyễn thế vũ','address'=>'Bắc giang','phone'=>'0356654487','level'=>2],
        ['email'=>'phucnguyenthe0809@gmail.com','password'=>bcrypt('123456'),'full'=>'Nguyễn thế phúc','address'=>'Huế','phone'=>'0352264487','level'=>1],
        ['email'=>'zimpro9x@gmail.com','password'=>bcrypt('123456'),'full'=>'Nguyễn Văn Công','address'=>'Nghệ An','phone'=>'0357846659','level'=>2]
    ]);
});

// Sửa dữ liệu trong bảng
Route::get('update', function () {
    DB::table('users')->where('id',5)->update([
                                        'email'=>'huyen@gmail.com',
                                        'full'=>'Nguyễn Thị Huyền', // -> lấy thuộc tính trong đối trượng, => chỉ dùng trong arrray
                                        'password'=>'123456',
                                        'address'=>'Hà Nội',
                                        'phone'=>'123456123',
                                        'level'=>1
                                        ]);
});

// Xóa bản tất cả bản ghi
Route::get('del', function () {
    DB::table('users')->where('id',1)->delete();
    //Xóa tấ cả các bản ghi
    //DB::table('users')->delete();
});
//nâng cao
//lấy dữ liệ kết thúc bằng get(),first()

// chú ý Phương thức get() dùng để lấy danh sách nhiều bản ghi, first() lấy ra bản ghi đầu tiên
Route::get('get-al-data', function () {
    $user=DB::table('users')->get();
    // dd($user-> số); --> sai, không trỏ sang số
    dd($user[0]->email);
});

Route::get('get-first-data', function () {
    $user=DB::table('users')->first();
    dd($user);
});

Route::get('select', function () {
    $user=DB::table('users')->select('id','full')->get();
    dd($user);
});

Route::get('where', function () {
    // $user=DB::table('users')->where('id',33)->get();
    // //dd($user);
    // dd($user[0]->email);

    $user=DB::table('users')->where('id',33)->first();
    //dd($user);
    dd($user->email);
});

Route::get('where-cond', function () {
    $user=DB::table('users')->where('id','>',34)->where('id','<',36)->get();
    dd($user);
});

Route::get('where-in', function () {
    // lấy bản ghi có tên trường trong khoảng x đến y
    $user=DB::table('users')->whereBetween('id',[34,36])->get();
    dd($user);
});

Route::get('or-where', function () {
    // thỏa mãn 1 trong số các điều kiện
    $user=DB::table('users')->where('id','<',34)->orwhere('id','>',35)->get();
    dd($user);
});

Route::get('orderby', function () {
    // DB không có relationship-> phải sử dụng join, ít dược sử dụng nhưng nhanh hơn model
    // sắp xếp chuỗ theo bảng chữ cái
    $user=DB::table('users')->where('id','>',33)->where('id','<',36)->orderBy('id','desc')->get();
    dd($user);
});

// giới hạn của kết quả tìm kiếm
Route::get('limit', function () {
    // đứng từ bản ghi thứ 2 lấy 3 phần tử
    // nếu không có skip() -> đứng từ 0
    $user=DB::table('users')->skip(2)->take(3)->get();
    dd($user);
});

// lấy giá trị trung bình
Route::get('avg', function () {
    $user=DB::table('users')->where('id','>',33)->avg('id');
    dd($user);
});

// increment,decrement
Route::get('increment', function () {
    $user=DB::table('users')->where('id','>',33)->decrement('level',1);
    dd($user);

});
});

Route::group(['prefix' => 'lien-ket'], function () {
    // chú ý
    // bảng chính là bảng chứa khóa chính
    // bảng phụ là bảng chứa khóa ngoại

    // liên kết 1-1 theo chiều thuận( liên kết từ bảng chính đến bảng phụ)
    Route::get('lk1-1-t', function () {
        $data['info']=App\User::find(39);
        return view('lien-ket', $data);
    });
    
    // liên kết 1-1 theo chiều nghịch( liên kết từ bảng phụ đến bảng chính)
    Route::get('lk1-1-n', function () {
        $user=App\Models\Info::find(2)->user()->first()->toArray();
        dd($user);
        return view('lien-ket',$user);
    });
    
    // liên kết 1-n
    Route::get('lk1-n', function () {
        $cate=App\Models\Category::find(6);
        $product=$cate->product()->get();
        dd($product);
        return view('lien-ket',$product);
    });
    //liên kết n-n
});


// frontend
Route::get('', 'Frontend\HomeController@getIndex');
Route::get('about', 'Frontend\HomeController@getAbout');
Route::get('contact', 'Frontend\HomeController@getContact');

Route::group(['prefix' => 'cart'], function () {

    Route::get('', 'Frontend\CartController@getCart');
});



Route::group(['prefix' => 'checkout'], function () {

    Route::get('', 'Frontend\CheckoutController@getCheckout');
    Route::post('', 'Frontend\CheckoutController@postCheckout');
    Route::get('complete', 'Frontend\CheckoutController@getComplete');
});



Route::group(['prefix' => 'product'], function () {

    Route::get('shop', 'Frontend\ProductController@getShop');
    Route::get('detail/{slug}', 'Frontend\ProductController@getDetail');
    Route::get('shop/{id_cate}', 'Frontend\ProductController@getCatePrd');

});

//backend

Route::get('login', 'Backend\LoginController@getLogin')->middleware('checkLogout');
Route::post('login', 'Backend\LoginController@postLogin');

Route::group(['prefix' => 'admin','middleware'=>'checkLogin'], function () {

    Route::get('', 'Backend\IndexController@getIndex');
    Route::get('logout', 'Backend\IndexController@Logout');

    Route::group(['prefix' => 'category'], function () {
        
        Route::get('', 'Backend\CategoryController@getCategory');
        Route::post('', 'Backend\CategoryController@postCategory');

        Route::get('edit/{idCate}', 'Backend\CategoryController@getEditCategory');
        Route::post('edit/{idCate}', 'Backend\CategoryController@postEditCategory');

        Route::get('del/{idCate}', 'Backend\CategoryController@delCategory');

    });

    Route::group(['prefix' => 'order'], function () {

        Route::get('', 'Backend\OrderController@getOrder');
        Route::get('detail/{id}', 'Backend\OrderController@getDetailOrder');
        Route::get('processed', 'Backend\OrderController@getProcessedOrder');
        Route::get('xu-ly/{id}', 'Backend\OrderController@xuly');
        
    });

    Route::group(['prefix' => 'product'], function () {
        
        Route::get('', 'Backend\ProductController@getProduct');

        Route::get('add', 'Backend\ProductController@getAddProduct');
        Route::post('add', 'Backend\ProductController@postAddProduct');

        Route::get('edit/{idPrd}', 'Backend\ProductController@getEditProduct');
        Route::post('edit/{idPrd}', 'Backend\ProductController@postEditProduct');

        Route::get('del/{idPrd}', 'Backend\ProductController@DelProduct');

    });

    Route::group(['prefix' => 'user'], function () {
        
        Route::get('', 'Backend\UserController@getUser');

        Route::get('add', 'Backend\UserController@getAddUser');
        Route::post('add', 'Backend\UserController@postAddUser');

        Route::get('edit/{id_user}', 'Backend\UserController@getEditUser');
        Route::post('edit/{id_user}', 'Backend\UserController@postEditUser');

        Route::get('del/{id_user}', 'Backend\UserController@DelUser');

    });
    
});




