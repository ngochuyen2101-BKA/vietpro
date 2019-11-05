<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{AddUserRequest,EditUserRequest};
use App\User;
class UserController extends Controller
{
    function getUser()
    {
        $data['users']=User::paginate(1);
        return view('backend.user.listuser',$data);
    }

    function getAddUser()
    {
        return view('backend.user.adduser');
    }

    function postAddUser(AddUserRequest $r)
    {
        $user = new User;
        $user->email=$r->email;
        $user->full=$r->full;
        $user->password=bcrypt($r->password);
        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;

        // có thể thay thế các code trên với User::create($r->all());
        $user->save();

        return redirect('/admin/user')->with('thongbao','Đã thêm thành công');
    }

    function getEditUser($id_user)
    {
        $data['user']=User::find($id_user);
        return view('backend.user.edituser',$data);
    }

    function postEditUser(EditUserRequest $r,$id_user)
    {
        $user = User::find($id_user);
        $user->email=$r->email;
        $user->full=$r->full;
        if($r->password!=''){
            $user->password=bcrypt($r->password);
        }
        
        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;
        $timestamps=false;
        $user->save();
        return redirect()->back()->with('thongbao','Bạn đã sửa thành công');
    }

    function DelUser($id_user)
    {
        User::destroy($id_user);
        return redirect()->back();
    }
}
