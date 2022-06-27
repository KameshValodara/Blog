<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;



class HomeController extends Controller
{

    /**
     * @OA\Get(
     *    path="/api/home/index",
     *    summary="Home data",
     *    description="This is practice",
     *    tags={"Home"},
     *    security={{"passport":{}}},
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
    */
    public function index(Request $request){
        $post = Post::all();
        return $post;
    }


    /**
     * @OA\Post(
     *    path="/api/home",
     *    summary="Home data",
     *    description="This is practice",
     *    tags={"Home"},
     *    @OA\Parameter(
     *      name="post",
     *      in="query",
     *      description="Provide your post",
     *      required=true,
     *    ),
     *    @OA\Parameter(
     *      name="description",
     *      in="query",
     *      description="Provide your description",
     *      required=true,
     *    ),
     *    @OA\Parameter(
     *      name="status",
     *      in="query",
     *      description="Provide your status",
     *      required=true,
     *    ),
     *    @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      description="Provide your user",
     *      required=true,
     *    ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function create(Request $request){
        $post = new Post;
        $post->post = $request->post;
        $post->description = $request->description;
        $post->status = $request->status;
        $post->user_id = $request->user_id;
        $result=$post->save();

        if($result){
            return ['message'=>'Post created successfully'];
        }
    }

     /**
     * @OA\Put(
     * path="/api/home/update",
     * summary="Home data",
     * description="This is practice",
     * tags={"Home"},
     *  @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide your id",
     *      required=true,
     *  ),
     *  @OA\Parameter(
     *      name="post",
     *      in="query",
     *      description="Provide your post",
     *      required=true,
     *  ),
     *  @OA\Parameter(
     *      name="description",
     *      in="query",
     *      description="Provide your description",
     *      required=true,
     *  ),
     *  @OA\Parameter(
     *      name="status",
     *      in="query",
     *      description="Provide your status",
     *      required=true,
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *  ),
     * ),
     *
     */

    public function update(Request $request){

        $post = Post::find($request->id);
        $post->post = $request->post;
        $post->description = $request->description;
        $post->status= $request->status;
        $result=$post->save();
        if($result){
            return ['message'=>'Post updated successfully'];
        }
    }

     /**
     * @OA\Delete(
     *    path="/api/home/delete",
     *    summary="Home data",
     *    description="This is practice",
     *    tags={"Home"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide your id",
     *      required=true,
     *    ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function delete(Request $request){
        $id=$request->id;
        $result = Post::find($id)->delete();
        if($result){
            return 'Deleted Successfully!';
        }
    }

    /**
    * @OA\Get(
        *  path="/api/home/search/",
        *  summary="Search Data",
        *  description="This is search data",
        *  tags={"Home"},
        *  @OA\Parameter(
        *      name="post",
        *      in="query",
        *      description="Provide name to search",
        *      required=true,
        *  ),
        *  @OA\Response(
        *      response=200,
        *      description="Ok",
        *      @OA\MediaType(
        *          mediaType="application/json",
        *      )
        *  )
        * ),
        *
    */
    public function search(Request $request){
        return Post::where('post',"like","%".$request->post."%")->get();
    }
}
