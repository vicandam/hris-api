<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use File;
use Validator;
use Storage;
use App\Interaction;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'photo',
        'video',
        'type'
    ];

    protected $table = 'posts';


    public function validate($input)
    {
        $type = $input['type'];
        $page = $input['page'];
        $action = $input['action'];
        $section = $input['section'];

        $validation  = [];

        if($type == 'video') {
            $validation['video'] = 'required';
            $validation['description'] = 'min:10';
            $validation['title'] = 'required';
        } elseif($type == 'photo') {
            if($page != 'update' || $action != 'update') {
                $validation['photo'] = 'required|mimes:jpeg,png,gif';
            }

            $validation['title'] = 'required';
            $validation['description'] = 'required';
        } else if ($action == 'update')  {
            $validation = [
                'title'  => 'required',
                'description' => 'required'
            ];
        } else {
            $validation['description'] = 'required|min:10';
        }

        $validator = Validator::make($input, $validation);

        $validator->validate();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function interaction()
    {
        return $this->hasMany(Interaction::class, 'post_id');
    }

    public function postSaved()
    {
        return $this->hasMany(Interaction::class, 'post_id')->where('action', 'save');
    }
    public function isSavedByAuth()
    {
        $auth = auth()->user();

        return $this->hasMany(Interaction::class, 'post_id')->where('action', 'save')->where('user_id', $auth->id);
    }

    public function postInspired()
    {
        return $this->hasMany(Interaction::class, 'post_id')->where('action', 'inspire');
    }
    public function isInspiredByAuth()
    {
        $auth = auth()->user();

        return $this->hasMany(Interaction::class, 'post_id')->where('action', 'inspire')->where('user_id', $auth->id);
    }

    /**
     * @TODO MOVE TO TRAITS TO VIDEO
     *
     *
     *
     *
     */
    public function hasEmbededYoutube()
    {
        $url = $this->video;

        if(strpos($url, 'youtube') > -1) {
            return true;
        }

        return false;
    }


    public function getDescriptionAttribute($description)
    {
        if($description != null) {
            return $description;
        } else {
            return  ' ';
        }
    }

    public function getYoutubeId($url=null)
    {
        // print " test url = " . $url ;

        if(! $url) {
            $url = $this->video;
        }

        if(strpos($url, 'youtube') > -1 && $this->isYoutube()) {
            // print " youtube 1 ";

            $urlArr = explode('?v=', $url);

            $param = end($urlArr);

            if(strpos($param, '&') > -1) {
                $data = explode('&', $param);

                $param = $data[0];
            }

            return $param;
        } elseif (strpos($url, 'youtu.be') > -1 && $this->isYoutube()) {
            // print " youtube 2 ";

            $data = explode('youtu.be/', $url);

            if(!empty($data[1])) {
                $param = $data[1];
            }

            return $param;
        } elseif($this->isVimeo()) {
            // print " vimeo 1 url " . $url;

            $data = explode('/', $url);

            $param = last($data);
            // $param = (int) substr(parse_url($url, PHP_URL_PATH), 1);

            return $param;
        }

        return null;
    }

    /**
     * Sample input
     *
     * https://www.youtube.com/watch?v=f8TkUMJtK5k&list=RDf8TkUMJtK5k&index=1
     * https://www.youtube.com/watch?v=fiyYoe678yI&list=RDf8TkUMJtK5k&index=2
     * https://www.youtube.com/watch?v=fiyYoe678yI&list=RDf8TkUMJtK5k&index=2
     * https://www.youtube.com/watch?v=0ErkYkx1LP0&t=4742s
     *
     *
     *
     *  Customize embeded youtube player
     *  https://www.classynemesis.com/projects/ytembed/
     *
     * @return bool|string
     */
    public function embededYoutube($youtubeId = null, $url = null)
    {
        if(! $url) {
            $url = $this->video;
        }

        if(! $youtubeId) {
            $youtubeId = $this->getYoutubeId();
        }

        if($youtubeId) {
            if($this->isVimeo($url)) {
                $fullUrl = 'https://player.vimeo.com/video/' . $youtubeId;
            } else {
                $fullUrl = 'https://www.youtube.com/embed/' . $youtubeId . '?modestbranding=1&showinfo=0&rel=0&cc_load_policy=1&iv_load_policy=3&theme=light&color=white';
            }

            return $fullUrl;
        }

        return false;
    }

    public function photoDelete()
    {
        // Delete photo
        $photoMainPath = str_replace( url('/') . '/storage/posts/', '',$this->photo);

        Storage::disk('posts')->delete($photoMainPath);

        if(isset($this->photo)) {
            if(File::exists($this->photo)) {
                File::delete($this->photo);
                File::deleteDirectory(dirname($this->photo));
            }
        }

        // Delete folder
        File::deleteDirectory(storage_path('app/public/posts/' . $this->id));
    }



    public function isVimeo($url = null)
    {
        if(! $url) {
            $url = $this->video;
        }

        if(strpos($url, 'vimeo.com') > -1) {

            return true;
        }

        return false;
    }
    public function isYoutube($url = null)
    {
        if(! $url) {
            $url = $this->video;
        }

        if(strpos($url, 'youtu') > -1) {

            return true;
        }

        return false;
    }
}
