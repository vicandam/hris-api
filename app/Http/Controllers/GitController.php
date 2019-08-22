<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp;

class GitController extends Controller
{
    private $status = 200;

    public function getRepositories(Request $request) {
        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        // @todo this will become a dynamic data so that any user can enter their stack overflow id



        $client_id = (!empty($input['client_id'])) ? $input['client_id'] : 'Iv1.89ce5c2d0247d74d';

        $client_secret = (!empty($input['client_secret'])) ? $input['client_secret'] : '0bb698b88fa3cc690f95d6b714be0f033e5b0240';

        // this is for the limit and total results
        $limit = $input['limit'];
        $offset = $input['offset'];

        // the result will be subtracted with 2 results, ex: 5 - 2 = 3 response
        $limitNow = $limit;

        $client = new GuzzleHttp\Client();

        $apiUrl = "https://api.github.com/users/jesus143/repos?order=desc&page=$offset&per_page=$limitNow&client_id=$client_id&client_secret=$client_secret";

        $res = $client->get($apiUrl);

        $content = $res->getBody();

        $repositories = json_decode($content, true);

        $result = [
            'limit' => $limit,
            'offset' => $offset + 1, // + 1 because we need to make it per page
            'data' => [
                'repositories' => $repositories
            ],
            'params' => $input,
            'message' => 'Successfully retrieved repositories from github'
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }
    public function getActivities() {}
    public function getInformation() {}
}
