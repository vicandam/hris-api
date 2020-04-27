<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Post;
use File;
use Illuminate\Support\Facades\Input;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Storage;
use Validator;
use App\Interaction;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    public $request_user_id = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'about', 'photo', 'position', 'history_title', 'contact_email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function validate($input)
    {
        $section = $input['section'];

        $validate = [];

        if($section == 'basic information') {
            $validate = [
                'position'  =>  'required|max:100',
                'about' =>'required',
                'name' =>'required|max:200',
            ];
        } else if ($section == 'profile photo') {
            $validate['photo'] = 'mimes:jpeg,png,gif';
        } else if ($section == 'history') {
            $validate = [
                'history_title'  =>  'required|max:100',
                'history_description' =>'required',
            ];
        } else if($section == 'contact us') {
            $validate['contact_email'] = 'required|email';
        }

//         if(!empty($input['history_title'])) {
//
//            $validate['history_title'] =  'required|max:100';
//
////            $user->about = $input['history_title'];
//        }
//        if(!empty($input['history_description'])) {
//            $validate['history_description'] =  'required|max:2000';
//
////            $user->about = $input['history_description'];
//        }
//
//        if(!empty($input['contact_email'])) {
//            $validate['contact_email'] =  'required|email|max:100';
////            $user->about = $input['contact_email'];
//        }
//
        Validator::make($input,  $validate)->validate();
    }

    public function getPhotoAttribute($photo) {
        if($photo != null) {
            return $photo;
        } else {
            return  url('/') . '/img/default.png';
        }
    }

    public function photoDelete()
    {
        $photoMainPath = str_replace( url('/') . '/storage/profile/', '',$this->photo);

        Storage::disk('profile')->delete($photoMainPath);

        if(isset($this->photo)) {
            if(File::exists($this->photo)) {
                File::delete($this->photo);
                File::deleteDirectory(dirname($this->photo));
            }
        }
    }

    public function employee()
    {
        return $this->hasMany('App\Employee');
    }
//
//    public function getAboutAttribute($about)
//    {
//        if($about != null) {
//            return $about;
//        } else {
//            return  ' ';
//        }
//    }

//    public function postSaved()
//    {
//        $auth = auth()->user();
//
//        if($this->request_user_id) {
//           $user_id = $this->request_user_id;
//        } else {
//            $user_id =  $auth->id;
//        }
//
//        return $this->hasMany(Interaction::class, 'user_id')
//            ->where('action', 'save')
//            ->where('user_id',$user_id);
//    }
//
//    public function postInspired()
//    {
//        $auth = auth()->user();
//
//        if($this->request_user_id) {
//           $user_id = $this->request_user_id;
//        } else {
//            $user_id =  $auth->id;
//        }
//
//        return $this->hasMany(Interaction::class, 'user_id')
//            ->where('action', 'inspire')
//            ->where('user_id',$user_id);
//    }
}
