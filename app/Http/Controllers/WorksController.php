<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WorksController extends Controller
{
    /**
     * Display a listing of works.
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'sometimes|in:image,video,audio,text',
            'tags' => 'sometimes|string',
        ]);
        $works = Work::with('tags:id,name')
            ->latest();
        if ($request->input('type')) {
            $works->where('type', $request->input('type'));
        }
        if ($request->input('tags')) {
            $searchTags = preg_split('/\s/', $request->input('tags'));
            $works->whereHas('tags', function ($query) use ($searchTags) {
                $query->whereIn('name', $searchTags);
            });
        }
        $result = $works->paginate();

        $tagNames = collect($result->items())->pluck('tags')->flatten()->unique()->pluck('name');
        $tags = Tag::whereIn('name', $tagNames)
            ->withCount('works')
            ->orderBy('name', 'asc')
            ->get();

        return view('works.index', [
            'works' => $result,
            'tags' => $tags,
            'searchTags' => $request->input('tags'),
        ]);
    }

    /**
     * Show the form for uploading a new work.
     */
    public function create()
    {
        return view('works.create');
    }

    /**
     * Store a newly uploaded work in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'source_url' => 'nullable|url',
        ]);

        // TODO: check sha1 against existing files before storing anything

        $work = new Work();
        $work->fill($request->only(['title', 'description', 'source_url']));
        $type = explode('/', $request->file('file')->getMimeType())[0];
        if (in_array($type, ['image', 'video', 'audio'])) {
            $work->type = $type;
        } else {
            $work->type = 'text';
        }
        $work->file_size = $request->file('file')->getSize();
        $work->sha1 = sha1_file($request->file('file')->getRealPath());
        $work->file_path = $request->file('file')->store('works/' . $work->type, 'public');

        // Create thumbnail for work
        if ($work->type == 'image') {
            $image = Image::make($request->file('file'));
            $work->width = $image->width();
            $work->height = $image->height();
            $image->resize(240, 240, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::disk('public')->makeDirectory('works/thumbnail');
            $image->save(storage_path("app/public/works/thumbnail/{$work->sha1}.jpg"));
        }

        $work->uploader_ip = $request->ip();
        if ($request->user()) {
            $work->user_id = $request->user()->id;
        }
        $work->save();

        return redirect()->route('works.show', $work);
    }

    /**
     * Display the specified work.
     */
    public function show(Work $work)
    {
        $work->load('tags:id,name');
        $tagNames = $work->tags->pluck('name');
        $tags = Tag::whereIn('name', $tagNames)
            ->withCount('works')
            ->orderBy('name', 'asc')
            ->get();
        return view('works.show', [
            'work' => $work,
            'tags' => $tags,
        ]);
    }

    /**
     * Add a tag to the specified work.
     */
    public function addTag(Request $request, Work $work)
    {
        $request->validate([
            'tag' => 'required|string|max:255',
        ]);
        $tag = Tag::firstOrCreate(
            ['name' => $request->input('tag')],
            ['user_id' => $request->user()->id],
        );
        $work->tags()->attach($tag, [
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('works.show', $work);
    }

    /**
     * Remove a tag from the specified work.
     */
    public function removeTag(Request $request, Work $work, Tag $tag)
    {
        $work->tags()->detach($tag);
        return redirect()->route('works.show', $work);
    }

    /**
     * Update the specified work in storage.
     */
    public function update(Request $request, Work $work)
    {
        //
    }

    /**
     * Remove the specified work from storage.
     */
    public function destroy($id)
    {
        //
    }
}
