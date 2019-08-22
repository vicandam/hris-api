<?php

namespace App\Http\Controllers;

use App\Mail\ContactedEmail;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class MessageController extends Controller
{

    protected $status = 200;

    public function search(Request $request) {
        $result = [];

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $auth = auth()->user();

        // insert new contact information
        $messages = new Message();

        $keyword =  (!empty($input['keyword']) ? $input['keyword'] : "");


        $type = (!empty($input['type']) ? $input['type'] : '');

        // new query pagination
        $count = null !== $messages ? $messages->count() : 0;


        // if added a parameter type then only query the specific type
        if($type) {
            $messages = $messages->where('type', $type);
        }

        if (null !== @$input['offset']) {
            $messages = $messages->offset($input['offset']);
        }

        if (null !== @$input['limit']) {
            $limit = $input['limit'];
            $messages = $messages->limit($input['limit']);
        } else {
            $limit = 10;
            $messages = $messages->limit($limit);
        }

        $offset = (null !== @$input['offset'] ?  $input['offset']  : 0) + $limit;

        $messages = $messages->orderBy('updated_at', 'desc');

        $messages = $messages->get();

        if($type == 'feedback') {
            $messages = $messages->map(function($message){
                $message->avatar = get_gravatar($message->email, 30);

                return $message;
            });
        }

        $result = [
            'data' => [
                'feedbacks' => $messages
            ],
            'offset' => $offset,
            'limit' => $limit,
            'params' => $input
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }


    public function store(Request $request) {
        $result = [];

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $auth = auth()->user();

        $section = (!empty($input['section']) ? $input['section'] : '');

//        return response()->json($input, $this->status, array(), JSON_PRETTY_PRINT);

        // insert new contact information
        $message = new Message();

        $message->validate($input);


        if(auth()->check()) {
            $message->user_id = $auth->id;
        }


        if(!empty($input['name'])) {
            $message->name = $input['name'];
        }

//        if(!empty($input['section'])) {
//            $message->section = $input['section'];
//        }

        if(!empty($input['email'])) {
            $message->email = $input['email'];
        }

        if(!empty($input['message'])) {
            $message->message = $input['message'];
        }

        if(!empty($input['skype_id'])) {
            $message->skype_id = $input['skype_id'];
        }


        if(!empty($input['project_name'])) {
            $message->project_name = $input['project_name'];
        }

        if(!empty($input['recipient_id'])) {
            $message->recipient_id = $input['recipient_id'];
        }

        if(!empty($input['subject'])) {
            $message->subject = $input['subject'];
        }

        if(!empty($input['subject'])) {
            $message->subject = $input['subject'];
        }

        if(!empty($input['type'])) {
            $message->type = $input['type'];
        }

        if(!empty($input['others'])) {
            $message->others = json_encode($input['others']);
        }

        // return response()->json($message, $this->status, array(), JSON_PRETTY_PRINT);
        // return response()->json($message, $this->status, array(), JSON_PRETTY_PRINT);

        $message->save();

        // send email information
        if($section == 'contact') {
            $contact = $message;

            Mail::to(env('MAIL_ADMIN'))->send(new ContactedEmail($contact));
        }

        $result = [
            'data' => [
                'contact' => $message,
                'feedback' => $message
            ],
            'params' => $input,
            'message' => 'Successfully stored message'
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }


    public function delete(Request $request, $id)
    {
        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $message = Message::find($id);

        $deleted = DB::transaction(function() use ($message, $id) {
            $deleted = $message->delete();

            return $deleted;
        });

        $result = [
            'data' => [
              'deleted' => $deleted,
              'message' => $message,
              'feedback' => $message,
            ],
            'params' => $input
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }
}
