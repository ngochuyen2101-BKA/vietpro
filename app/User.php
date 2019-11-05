<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // mặc định liên kết với bảng users 
    // protected $table="thanh_vien"; 

    // mặc định khóa chính là id
    // protected $primaryKey=Tên khóa chính trong bảng'

    // mặc định $timestamps=true
    public $timestamps=false;

    // mặc định khóa chính tự tăng
    // public $incrementing = false(không tự tăng)

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function info()
    {
        return $this->hasOne('App\Models\info', 'id_user', 'id');
    }

    public function lop()
    {
        // không thể dùng các câu lệnh query builder trừ first() hoặc get()
        return $this->belongsToMany('App\Models\Lop', 'tên bảng trung gian', 'user_id', 'lop_id')->orderBy('id','desc');
    }
}
