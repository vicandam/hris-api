<?php

namespace App;

use Carbon\Carbon;
use Validator;
use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'user_id',
        'recipient_id',
        'message',
        'subject',
        'project_name',
        'email',
        'skype_id',
        'name',
        'status',
        'type',
    ];

    public function validate($input) {

        $section = (! empty($input['section']) ? $input['section'] : null);

        $validate = [];

        if($section == 'contact') {
            $validate = [
                'email' => 'email|required',
                'name' => 'required',
                'message' => 'required',
            ];
        }else if($section == 'post feedback') {
            $validate = [
                'email' => 'email|required',
                'project_name' => 'required',
                'name' => 'required',
                'message' => 'required',
            ];
        }

        $validator = Validator::make($input, $validate);

        $validator->validate();
    }


    public function getCreatedAtAttribute($dateTime)
    {

        return \Carbon\Carbon::createFromTimeStamp(strtotime($dateTime))->diffForHumans();

    }
}
