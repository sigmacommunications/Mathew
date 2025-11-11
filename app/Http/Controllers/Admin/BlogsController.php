<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    public function index()
    {
        $blogs = Blogs::all();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
        ]);

        $blog = new Blogs();
        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];
        $blog->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $coverImage = $request->file('image');
            $coverImageName = Str::uuid() . '.' . $coverImage->getClientOriginalExtension();
            $imagePath = $request->file('image')->store('public/blog_images');
            $coverImagePath = $coverImage->storeAs('uploads', $coverImageName, 'public');
            $blog->image = $coverImagePath;
        }

        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully');
    }

    public function edit(Blogs $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blogs $blog)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
        ]);

        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];
        $blog->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $coverImage = $request->file('image');
            $coverImageName = Str::uuid() . '.' . $coverImage->getClientOriginalExtension();
            $imagePath = $request->file('image')->store('public/blog_images');
            $coverImagePath = $coverImage->storeAs('uploads', $coverImageName, 'public');
            $blog->image = $coverImagePath;
        }

        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }

    public function destroy(Blogs $blog)
    {
        try {
            if ($blog->image) {
                Storage::delete($blog->image);
            }
            $blog->delete();
            return response()->json(['success' => true, 'message' => 'Blog deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete role.'], 500);
        }
    }
}
