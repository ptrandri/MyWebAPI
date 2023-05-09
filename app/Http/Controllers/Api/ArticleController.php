<?php
   
namespace App\Http\Controllers\API;
   
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Controllers\API\BaseController as BaseController;
   
class ArticleController extends BaseController
{
    public function index()
    {
        $articles = Article::all();
        return $this->sendResponse(ArticleResource::collection($articles), 'Posts fetched.');
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
        $Article = Article::create($input);
        return $this->sendResponse(new ArticleResource($Article), 'Post created.');
    }
   
    public function show($id)
    {
        $Article = Article::find($id);
        if (is_null($Article)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ArticleResource($Article), 'Post fetched.');
    }
    
    public function update(Request $request, Article $Article)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'body' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $Article->title = $input['title'];
        $Article->body = $input['body'];
        $Article->save();
        
        return $this->sendResponse(new ArticleResource($Article), 'Post updated.');
    }
   
    public function destroy(Article $Article)
    {
        $Article->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}