<?php

namespace App\Repositories;

use App\Employee;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    public $status = 200;

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function index($input)
    {
        $paginate = isset($input['paginate']) ? $input['paginate'] : null;

        $users = new User();

        if ($paginate) {
            $users = $users->paginate($paginate);
        } else {
            $users = $users->get();
        }

        $data['users'] = $users;

        return $data;
    }
    public function store($input)
    {
        $user = new User();

        $user->name     = $input['name'];
        $user->email    = $input['email'];
        $user->password = bcrypt($input['password']);

        $accessToken = $user->createToken('authToken')->accessToken;

        $user->save();

        $data['access_token'] = $accessToken;
        $data['user']         = $user;

        return $data;
    }

    public function update($input, $id)
    {
        $user = User::find($id);

        $user->name     = $input['name'];
        $user->email    = $input['email'];
        $user->password = bcrypt($input['password']);

        $user->save();

        return $user;
    }

    public function updatePassword($input)
    {
        $user = auth()->user();

        $user->password = Hash::make($input['new_password']);
        $user->save();

        return $user;
    }
}
