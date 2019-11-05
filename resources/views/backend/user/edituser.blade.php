@extends('backend.master.master')
@section('title','Sửa người dùng')
@section('content')
    <!--main-->
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sửa Thành viên</h1>
            </div>
        </div>
        <!--/.row-->
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fas fa-user"></i> Sửa thành viên - {{ $user->email }}</div>
                    @if (session('thongbao'))
                        <div class="alert alert-success" role="alert">
                            <strong>{{ session('thongbao') }}</strong>
                        </div>
                    @endif
                    <div class="panel-body">
                        <div class="row justify-content-center" style="margin-bottom:40px">
                            <form method="post">
                                @csrf
                            <div class="col-md-8 col-lg-8 col-lg-offset-2">
                             
                                 
                             
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                    {{ ShowError($errors,'email') }}
                                </div>
                                <div class="form-group">
                                    <label>password</label>
                                    <input type="text" name="password" class="form-control" value="{{ $user->password }}">
                                    {{ ShowError($errors,'password') }}
                                </div>
                                <div class="form-group">
                                    <label>Full name</label>
                                    <input type="full" name="full" class="form-control" value="{{ $user->full }}">
                                    {{ ShowError($errors,'full') }}
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="address" name="address" class="form-control" value="{{ $user->address }}">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                                    {{ ShowError($errors,'phone') }}
                                </div>
                              
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level" class="form-control" value="">
                                        <option @if ('level'==1) selected @endif value="1">admin</option>
                                        <option @if ('level'==2) selected @endif value="2">user</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-lg-8 col-lg-offset-2 text-right">
                                  
                                    <button class="btn btn-success"  type="submit">Sửa thành viên</button>
                                    <button class="btn btn-danger" type="reset">Huỷ bỏ</button>
                                </div>
                            </div>
                        </form>

                        </div>
                    
                        <div class="clearfix"></div>
                    </div>
                </div>

        </div>
    </div>

        <!--/.row-->
    </div>

    @stop