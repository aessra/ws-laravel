<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
// use JWTAuth;

class CommentController extends Controller
{
  public function postComment(Request $request)
  {
    // $user = JWTAuth::parseToken()->toUser();

    $comment = new Comment();
    $comment->email = $request->input('email');
    $comment->name = $request->input('name');
    $comment->comment = $request->input('comment');
    $comment->status = $request->input('status');
    $comment->id_parent = $request->input('parent');
    $comment->reply = $request->input('reply');
    $comment->save();

    return response()->json([
      'comment' => $comment,
      // 'user' => $user
    ], 201);
  }

  public function getComments()
  {
    $comments = Comment::all();
    $response = [
      'data' => $comments
    ];

    return response()->json($response, 200);
  }

  public function oneComment($id)
  {
    $comment = Comment::find($id);
    $response = [
      'data' => $comment
    ];

    return response()->json($response, 200);
  }

  public function putComment(Request $request, $id)
  {
    $comment = Comment::find($id);
    if (!$comment)
    {
      return response()->json(['message' => 'Document not found'], 404);
    }

    $comment->content = $request->input('content');
    $comment->save();

    return response()->json(['comment' =>$comment], 200);
  }

  public function deleteComment($id)
  {
    // $comment = Comment::find($id);
    // $comment->delete();
    //
    // return response()->json(['message' => 'comment deleted'], 200);

    $comment = Comment::find($id);
    if (!$comment)
    {
      return response()->json(['message' => 'Comment not found'], 404);
    }

    $comment->status = '0';
    $comment->save();

    return response()->json(['comment' => 'Banned'], 200);
  }
}
