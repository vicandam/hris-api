<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

use Image;
use DB;
use App\Interaction;

class PostController extends Controller
{
    protected $status = 200;

    /**
     * Search the header of the nav
     */
    public function search(Request $request, $id = 0)
    {
        $result = [];

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $auth = auth()->user();

        $keyword =  (!empty($input['keyword']) ? $input['keyword'] : "");

        $posts = new Post();

        if(!empty($input['type'])) {
            $posts = $posts->where('type', $input['type']);
        }

        // new query pagination
        $count = null !== $posts ? $posts->count() : 0;

        if (null !== @$input['offset']) {
            $posts = $posts->offset($input['offset']);
        }

        if (null !== @$input['limit']) {
            $limit = $input['limit'];
            $posts = $posts->limit($input['limit']);
        } else {
            $limit = 10;
            $posts = $posts->limit($limit);
        }

        $offset = (null !== @$input['offset'] ?  $input['offset']  : 0) + $limit;

        $posts = $posts->orderBy('created_at', 'desc');

        $posts = $posts->get();


        $posts = $posts->map(function($post){
            $post->editing = false;
            $post->error = [];
            $post->loader = false;
            $post->deleting = false;

            return $post;
        });


        // set embeded url
        $posts = $posts ->map(function($post){

            if($post->type == 'video') {
                $post->embededUrl = $post->embededYoutube();
            }

            return $post;
        });


        $result = [
            'offset' => $offset,
            'count' => $posts->count(),
            'limit' => $limit,
            // 'params' => $input,
            // 'auth' => $auth,
            'message' => 'Posts successfully retrieved',
            'data' => [
                'posts' => $posts,
            ],
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {
        $result = [];

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $input['page'] = 'update';


        $auth= auth()->user();

        $post = Post::find($id);

        $post->validate($input);

        if(!empty($input['description'])) {
            $post->description = trim(ucfirst($input['description']));
        }

        if(!empty($input['title'])) {
            $post->title = trim(ucfirst($input['title']));
        }

        if(!empty($input['url'])) {
            $post->url = $input['url'];
        }

        $post->save();


        $post->editing = false;
        $post->error = [];
        $post->loader = false;
        $post->deleting = false;

        $result = [
            'message' => 'Post successfully updated',
            'data' => [
                'post' => $post,
            ],
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }

    public function delete(Request $request, $id)
    {
        $result = [];

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $auth= auth()->user();

        $post = Post::find($id);

        $deleted = DB::transaction(function() use ($post) {
            if($post->type == 'photo') {
                $post->photoDelete();
            }

            $post->interaction()->delete();

            return $post->delete();
        });

        $result = [
            // 'params' => $input,
            // 'auth' => $auth,
            'message' => 'Post successfully deleted',
            'data' => [
                'deleted' => $deleted,
                'post' => $post,
            ],
        ];

        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $result = [];

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        $input['page'] = 'store';

        $auth= auth()->user();

        $post = new Post;

        $post->validate($input);

        DB::transaction(function() use ($auth, $post, $input, $request) {
            $type = $input['type'];
            $video = $input['video'];
            $title = $input['title'];
            $url = $input['url'];

            $description = ucfirst($input['description']);

            $post->user_id = $auth->id;

            if(!empty($description)) {
                $post->description = $description;
            }

            if(!empty($type)) {
                $post->type = $type;
            }

            if(!empty($title)) {
                $post->title = $title;
            }

            if(!empty($url)) {
                $post->url = $url;
            }

            $post->save();

            if ($type == 'video') {
                if(! $post->isYoutube()) {
                    $photo = 'https://img.youtube.com/vi/' . $post->getYoutubeId($video) . '/hqdefault.jpg';

                    $post->video = $video;
                    $post->photo = $photo;

                    $post->save();
                }

               $post->embededUrl = $post->embededYoutube();
            } else if ($type == 'photo') {
                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $extension = $file->getClientOriginalExtension();
                    $originalName = $file->getClientOriginalName();

                    $photo = $request->photo->storeAs($post->id , $originalName, 'posts');
                    $photo = 'storage/posts/' . $photo;

                    $post->photo = url('/') . '/' . $photo; //$input['photo'];

                    image_decrease_in_size($photo, $extension);

                    $post->save();
                }
            }
        });

        $post->slug = to_slug($post->description, $post->type);

        $post->editing = false;

        $post->loader = false;
        $post->deleting = false;
        $post->error = [
            'description' => [],
            'title' => [],
            'url' => []
        ];


        $post->isProcessingUpdate = false;
//        $post->owner->more = false;
//        $post->total_view = 1;
//        $post->post_saved_count = 0;
//        $post->is_saved_by_auth_count = 0;
//        $post->post_inspired_count = 0;
//        $post->is_inspired_by_auth_count = 0;


        $result = [
            // 'params' => $input,
            // 'auth' => $auth,
            'message' => 'Successfully posted',
            'data' => [
                'post' => $post,
            ],
        ];


        return response()->json($result, $this->status, array(), JSON_PRETTY_PRINT);
    }
}