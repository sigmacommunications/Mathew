<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ReelsUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ReelsUploadController extends Controller
{
    public function index()
    {
        $reels = ReelsUpload::all();
        return view('admin.reels.index', compact('reels'));
    }

    public function create()
    {
        return view('admin.reels.create');
    }

    public function store(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,avi,mkv',  // Video file validation
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif', // Thumbnail image validation
        ]);

        // Store the video file
        $videoPath = $request->file('video');
        $videoUrl = $videoPath->store('reels', 'public');

        // Store the thumbnail file
        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailUrl = $thumbnail->store('reels/thumbnails', 'public');
        }

        // Optionally, calculate the video duration using FFmpeg (if installed)
        // $duration = $this->getVideoDuration(storage_path('app/' . $videoPath));

        // Store the video details in the database
        $reel = ReelsUpload::create([
            'title' => $request->title,
            'description' => $request->description,
            'path' => $videoUrl,
            'thumbnail' => $thumbnailUrl,
        ]);

        return redirect()->route('reels.index')->with('success', 'Reel uploaded successfully');
    }

    public function edit($id)
    {
        $reel = ReelsUpload::findOrFail($id);
        return view('admin.reels.edit', compact('reel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|file|mimes:mp4,avi,mkv',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $reel = ReelsUpload::findOrFail($id);

        if ($request->hasFile('video')) {
            Storage::disk('public')->delete($reel->path);
            $newVideo = $request->file('video');
            $videoPath = $newVideo->store('reels', 'public');
            $reel->update(['path' => $videoPath]);
        }

        // Handle thumbnail update (if a new thumbnail is uploaded)
        if ($request->hasFile('thumbnail')) {
            // Delete the old thumbnail if it exists
            if ($reel->thumbnail) {
                Storage::disk('public')->delete($reel->thumbnail);
            }

            // Store the new thumbnail
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = $thumbnail->store('reels/thumbnails', 'public');
            $reel->update(['thumbnail' => $thumbnailPath]);
        }


        // Update other fields
        $reel->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('reels.index')->with('success', 'Reel updated successfully');
    }

    public function destroy($id)
    {
        try {
            $reel = ReelsUpload::findOrFail($id);
            $reel->delete();
            return response()->json(['success' => true, 'message' => 'Reel deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Reel.'], 500);
        }
    }
}
