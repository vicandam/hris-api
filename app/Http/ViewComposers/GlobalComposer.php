<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Auth;
use App\User;


class GlobalComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $data =  [
            'url' => url('/'),
            'environmentParentFolderAssetJsCompiledPages' => (env('APP_ENV') == 'production' || env('APP_ENV') == 'prod') ? 'js/pages/prod' : 'js/pages/dev',

        ];


        $user = User::first();

        if($user) {
            $data['meta'] =  [
                'title' => $user->position,
                'description' => $user->about,
                'author' => $user->name,
                'keyword' => to_keyword($user->position),
                'page' => request('page')
            ];
        }

        $view->with($data);
    }
}