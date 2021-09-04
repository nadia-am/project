<?php

namespace App\Http\Controllers\admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query();
        if ($key = \request('search')){
            $comments = $comments->where('comment','like',"%{$key}%")
                            ->orWhereHas('user', function ($query) use ($key){
                                $query->where('name', 'like',"%{$key}%");
                            });
        }
        $comments = $comments->latest()->paginate(20);
        return view('admin.comments.all',compact('comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update(['approved'=>1]);
        alert()->success('دیدگاه تایید شد', 'عملیات موفق');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('دیدگاه حذف شد', 'عملیات موفق');
        return back();
    }
}
