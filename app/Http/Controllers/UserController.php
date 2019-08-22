<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

use Image;

use Hash;
use DB;

class UserController extends Controller
{
    protected  $status = 200;

    public function profileLoad()
    {
        $auth = auth()->user();

        if(auth()->guest()) {
            $user = User::first();
        } else {
            $user = User::find($auth->id);
        }

        $user->section = '';

        $results = [
            'message' => 'Profile successfully loaded',
            'data' => [
                'user' => $user
            ],
        ];

        return response()->json($results, $this->status, array(), JSON_PRETTY_PRINT);
    }
    public function profileUpdatePhoto(Request $request)
    {
        $auth = auth()->user();

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $user = User::find($auth->id);

        $user->validate($input);

        DB::transaction(function() use ($user, $input, $request) {
            if ($request->hasFile('photo')) {
                $user->photoDelete();

                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $originalName = $file->getClientOriginalName();

                $photo = $request->photo->storeAs($user->id , $originalName,  'profile');
                $photo = 'storage/profile/' . $photo;

                $user->photo = url('/')  . '/' .  $photo;

                image_decrease_in_size($photo, $extension);

                $user->save();
            }
        });

        $results = [
            'message' => 'Profile successfully updated',
            'data' => [
                'user' => $user
            ],
        ];

        return response()->json($results, $this->status, array(), JSON_PRETTY_PRINT);
    }
    public function profileUpdate(Request $request)
    {
        $auth = auth()->user();

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $user = User::find($auth->id);

        $user->validate($input);

        if(!empty($input['name'])) {
            $user->name = $input['name'];
            $user->slug = str_slug($input['name']);
        }
        if(!empty($input['about'])) {
            $user->about = $input['about'];
        }
        if(!empty($input['position'])) {
            $user->position = $input['position'];
        }
        if(!empty($input['history_title'])) {
            $user->history_title = $input['history_title'];
        }
        if(!empty($input['history_description'])) {
            $user->history_description = $input['history_description'];
        }
        if(!empty($input['contact_email'])) {
            $user->contact_email = $input['contact_email'];
        }

        $user->save();

        $results = [
            'message' => 'Profile successfully updated',
            'data' => [
                'profile' => $user
            ],
        ];

        return response()->json($results, $this->status, array(), JSON_PRETTY_PRINT);
    }
}
