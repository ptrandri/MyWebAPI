<?php
   
namespace App\Http\Controllers\API;
   
use App\Models\article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\article as articleResource;
use App\Http\Controllers\API\BaseController as BaseController;
   
class articleController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth.sanctum');
    }
    
    public function index()
    {
        $articles = article::all();
        return $this->sendResponse(articleResource::collection($articles), 'Posts fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'body' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $article = article::create($input);
        return $this->sendResponse(new articleResource($article), 'Post created.');
    }
   
    public function show($id)
    {
        $article = article::find($id);
        if (is_null($article)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new articleResource($article), 'Post fetched.');
    }
    
    public function update(Request $request, article $article)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'body' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $article->title = $input['title'];
        $article->body = $input['body'];
        $article->save();
        
        return $this->sendResponse(new articleResource($article), 'Post updated.');
    }
   
    public function destroy(article $article)
    {
        $article->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}