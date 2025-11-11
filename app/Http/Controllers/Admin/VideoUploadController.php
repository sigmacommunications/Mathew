<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\VideoUpload;
use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
	public function index()
	{
		$videos = VideoUpload::all();
		return view('admin.videos.index', compact('videos'));
	}

	public function create()
	{
		return view('admin.videos.create');
	}

	public function store(Request $request)
	{

		$request->validate([
			'title' => 'required',
			'video' => 'required|mimes:mp4,mov,avi|max:204800', // 200 MB limit
			'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2 MB limit
		]);

		$video = $request->file('video');
		$path = $video->store('videos', 'public');

		$thumbnailPath = null;
		if ($request->hasFile('thumbnail')) {
			$thumbnail = $request->file('thumbnail');
			$thumbnailPath = $thumbnail->store('thumbnails', 'public');
		}
		VideoUpload::create([
			'title' => $request->input('title'),
			'path' => $path,
			'thumbnail' => $thumbnailPath,
		]);

		return redirect()->route('videos.index')->with('success', 'Video uploaded successfully');
	}

	public function show(VideoUpload $video)
	{
		return view('videos.show', compact('video'));
	}

	public function edit(VideoUpload $video)
	{
		return view('admin.videos.edit', compact('video'));
	}

	public function update(Request $request, VideoUpload $video)
	{
		$request->validate([
			'title' => 'required',
			'video' => 'nullable|mimes:mp4,mov,avi|max:204800', // 200 MB limit
			'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2 MB limit for the thumbnail
		]);

		// Update video if a new one is uploaded
		if ($request->hasFile('video')) {
			Storage::disk('public')->delete($video->path);
			$newVideo = $request->file('video');
			$videoPath = $newVideo->store('videos', 'public');
			$video->update(['path' => $videoPath]);
		}

		// Handle thumbnail update (if a new thumbnail is uploaded)
		if ($request->hasFile('thumbnail')) {
			// Delete the old thumbnail if it exists
			if ($video->thumbnail) {
				Storage::disk('public')->delete($video->thumbnail);
			}

			// Store the new thumbnail
			$thumbnail = $request->file('thumbnail');
			$thumbnailPath = $thumbnail->store('thumbnails', 'public');
			$video->update(['thumbnail' => $thumbnailPath]);
		}

		// Update the video title
		$video->update([
			'title' => $request->input('title'),
		]);

		return redirect()->route('videos.index')->with('success', 'Video updated successfully');
	}

	public function destroy(VideoUpload $video)
	{
		try {

			Storage::disk('public')->delete($video->path);
			$video->delete();
			return response()->json(['success' => true, 'message' => 'Video deleted successfully.']);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'Failed to delete Video.'], 500);
		}
	}
}
