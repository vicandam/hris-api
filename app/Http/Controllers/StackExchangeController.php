<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;


class StackExchangeController extends Controller
{
    protected $status = 200;

    public function stackoveflowQuestionAndAnswer(Request $request)
    {
        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        // @todo this will become a dynamic data so that any user can enter their stack overflow id

        $stack_overflow_user_id = (!empty($input['stack_overflow_user_id'])) ? $input['stack_overflow_user_id'] : 6638764 ;

        $stack_overflow_api_key = (!empty($input['stack_overflow_api_key'])) ? $input['stack_overflow_api_key'] : '57lzag))oeUJa8zO11n9Ew((' ;

        // this is for the limit and total results
        $limit = $input['limit'];
        $offset = $input['offset'];

        // the result will be subtracted with 2 results, ex: 5 - 2 = 3 response
        $limitNow = $limit;
        // $limitNow = $limit - 2;

        $data = [];

        $client = new GuzzleHttp\Client();

        $apiUrl = "https://api.stackexchange.com/2.2/users/$stack_overflow_user_id/answers?page=$offset&pagesize=$limitNow&order=desc&sort=activity&site=stackoverflow&key=$stack_overflow_api_key";

        // Get all the users top answers
        $res = $client->get($apiUrl);

        $content = $res->getBody();

        $topAnswers = json_decode($content, true)['items'];

        // Get the specific quertion and answer
        foreach($topAnswers as $index => $item) {
            $question_id = $item['question_id'];
            $answer_id = $item['answer_id'];

            // get the main entry
            $data[$index]['entry'] =  $item;

            // get thequestion
            $questionUrl = "https://api.stackexchange.com/2.2/questions/$question_id?&site=stackoverflow&filter=withbody&key=$stack_overflow_api_key";

            $res = $client->get($questionUrl);

            $content = $res->getBody();

            $questions = json_decode($content, true);

            $question = array_first($questions['items']);

            $data[$index]['question'] = $question;

            // get the answer
            $answerUrl = "https://api.stackexchange.com/2.2/answers/$answer_id?&site=stackoverflow&filter=withbody&key=$stack_overflow_api_key";

            $res = $client->get($answerUrl);

            $content = $res->getBody();

            $answers = json_decode($content, true);

            $answer = array_first($answers['items']);

            $data[$index]['answer'] = $answer;
        }

        $result = [
            'limit' => $limit,
            'offset' => $offset + 1, // + 1 because we need to make it per page
            'data' => [
                'question_and_answer' => $data
            ],
            'params' => $input,
            'message' => 'Successfully retrieved the questions and answer from stackoverflow'
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);

    }
}
