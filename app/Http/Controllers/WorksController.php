<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WorksController extends Controller
{
    /**
     * Display a listing of the work.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'sometimes|in:image,video,audio,text',
            'tags' => 'sometimes|string',
        ]);
        $works = Work::latest();
        if ($request->input('type')) {
            $works->where('type', $request->input('type'));
        }
        // TODO: search by tags
        return view('works.index', [
            'title' => __('Works'),
            'works' => $works->paginate(),
            'searchTags' => $request->input('tags'),
        ]);
    }

    /**
     * Show the form for uploading a new work.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('works.create', [
            'title' => __('Add work'),
        ]);
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
        return view('works.show', [
            'title' => $work->title,
            'work' => $work,
        ]);
    }

    /**
     * Show the form for editing the specified work.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified work in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified work from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
