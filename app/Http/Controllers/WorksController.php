<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WorksController extends Controller
{
    public function __construct()
    {
        if (!config('auth.allow_guests')) {
            $this->middleware('auth');
        }
        $this->authorizeResource(Work::class, 'work');
    }

    /**
     * Display a listing of works.
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'sometimes|in:image,video,audio,text',
            'tags' => 'sometimes|nullable|string',
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
        $result = $works->paginate()->withQueryString();

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
    public function create(Request $request)
    {
        $request->validate([
            'type' => 'sometimes|string|in:image,text',
        ]);
        $type = $request->input('type', 'image');
        return view('works.create', [
            'type' => $type,
        ]);
    }

    /**
     * Store a newly uploaded work in storage.
     */
    public function store(Request $request)
    {
        // TODO: handle text uploads with content editor as description, and no file
        // TODO: also support uploading a text-type file, no UI for that yet
        $request->validate([
            'file' => 'required|file',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'source_url' => 'nullable|url',
            'tags' => ['sometimes', 'nullable', 'string', 'regex:/^[a-z0-9_ ]*$/i'],
        ]);

        // Check if the file already exists
        $sha1 = sha1_file($request->file('file')->getRealPath());
        if ($existingWork = Work::where('sha1', $sha1)->first()) {
            return redirect()->route('works.show', $existingWork)
                ->with('error', __('This file has already been uploaded.'));
        }

        // Store the uploaded file
        $work = new Work();
        $work->fill($request->only(['title', 'description', 'source_url']));
        $type = explode('/', $request->file('file')->getMimeType())[0];
        if (in_array($type, ['image', 'video', 'audio'])) {
            $work->type = $type;
        } else {
            $work->type = 'text';
        }
        $work->file_size = $request->file('file')->getSize();
        $work->sha1 = $sha1;
        $work->file_path = $request->file('file')->store('works/' . $work->type, 'public');

        // Create thumbnail for work
        if ($work->type == 'image') {
            $orig = Image::make($request->file('file'))->orientate();
            $work->width = $orig->width();
            $work->height = $orig->height();
            $thumb = Image::canvas($orig->width(), $orig->height(), '#fff');
            $thumb->insert($orig);
            $thumb->resize(240, 240, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::disk('public')->makeDirectory('works/thumbnail');
            $thumb->save(storage_path("app/public/works/thumbnail/{$work->sha1}.jpg"));
        }

        $work->save();

        if ($request->input('tags')) {
            $tags = preg_split('/\s/', $request->input('tags'));
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $work->tags()->attach($tag, [
                    'user_id' => $request->user()->id,
                ]);
            }
        }

        return redirect()->route('works.show', $work)
            ->with('success', __('The file has been uploaded.'));
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
     * Update the specified work in storage.
     */
    public function update(Request $request, Work $work)
    {
        //
    }

    /**
     * Remove the specified work from storage.
     */
    public function destroy(Work $work)
    {
        //
    }
}
