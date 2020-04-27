<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->input();

        $users = $this->user->index($input);

        $result = [
            'data' => [
                'users' => $users
            ]
        ];

        return response()->json($result, $this->user->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(array $data)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $input = $request->input();

        $data = $this->user->store($input);

        $result = [
            'data' => [
                'user' => $data['user'],
                'token' => $data['access_token']
            ]
        ];

        return response()->json($result, $this->user->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();

        $user = $this->user->update($input, $id);

        $result = [
            'data' => [
                'user' => $user
            ]
        ];

        return response()->json($result, $this->user->status, [], JSON_PRETTY_PRINT);
    }

    public function sendSms(Request $request)
    {
        $input = $request->input();

        $number  = $input['number'];
        $message = $input['message'];
        $apiCode = 'TR-ZERAU010994_9X138';
        $passwd  = '$sdz(}jsfa';

        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('1' => $number, '2' => $message, '3' => $apiCode, 'passwd' => $passwd);
        $param = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($itexmo),
            ),
        );
        $context  = stream_context_create($param);
        $response =  file_get_contents($url, false, $context);

        $result = [
            'data' => [
                'message' => 'message sent!',
                'response' => $response
            ]
        ];

        return response()->json($result, 200, [], JSON_PRETTY_PRINT);
    }
    public function updatePassword(UserUpdatePasswordRequest $request)
    {
        $input = $request->input();

        $user = $this->user->updatePassword($input);

        $result = [
            'data' => [
                'message' => 'Password updated successfully',
                'user'    => $user
            ]
        ];

        return response()->json($result, $this->user->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
