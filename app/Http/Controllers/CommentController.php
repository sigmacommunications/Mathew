<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blogs;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::whereNull('parent_id')->get();
        return view('admin.comments.index', compact('comments'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'author' => 'required|string',
            'email' => 'required|email',
            'comment' => 'required|string',
            'website' => 'nullable|url',
            'blog_id' => 'nullable|exists:blogs,id', // Validate existence of post_id in posts table
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // If post_id is provided, ensure it corresponds to an existing post
        if (isset($validatedData['blog_id'])) {
            if (!Blogs::where('id', $validatedData['blog_id'])->exists()) {
                return back()->withErrors(['blog_id' => 'Invalid post ID.']);
            }
        }

        Comment::create($validatedData);

        return back()->with('success', 'Comment submitted for moderation.');
    }

    public function reply(Request $request)
    {

        $id = $request->comment_id;

        // Check if the original comment is approved
        $originalComment = Comment::findOrFail($id);
        if ($originalComment->approved != 1) {
            return redirect()->back()->with('error', 'Sorry, replies to unapproved comments are not allowed.');
        }

        // Comment 
        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->blog_id = $request->blog_id; // or however you're getting the current blog id
        $comment->author = $request->author; // or however you're getting the current user's name
        $comment->email = $request->email; // or however you're getting the current user's email
        $comment->website = $request->website;
        $comment->parent_id = $id; // set the parent_id to the ID of the original comment
        $comment->approved = 1; // Assuming you want to approve replies automatically
        $comment->save();

        return redirect()->back()->with('success', 'Your reply has been posted successfully.');
    }

    public function approveComment($id)
    {

        $comment = Comment::find($id);
        $comment->approved = 1; // Assuming you have a column named 'approved'
        $comment->save();
        return response()->json(['message' => 'Comment approved successfully']);
    }

    public function cancelComment($id)
    {

        $comment = Comment::find($id);
        $comment->approved = 2; // Assuming you have a column named 'approved'
        $comment->save();
        return response()->json(['message' => 'Comment canceled successfully']);
    }

    public function destroy($id)
    {
        try {
            $Comdelete = Comment::find($id);

            if (!$Comdelete) {
                return response()->json(['success' => false, 'message' => 'Comment not found.'], 404);
            }

            $Comdelete->delete();

            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Comment.'], 500);
        }
    }
}
