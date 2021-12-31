<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkTagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Work $work)
    {
        return $work->tags->sortBy('name');
    }

    public function store(Work $work, Request $request)
    {
        $this->authorize('update', $work);

        $request->validate([
            'tag' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_ ]*$/i'],
        ]);
        $tag = Tag::firstOrCreate(['name' => $request->input('tag')]);
        $work->tags()->attach($tag, [
            'user_id' => $request->user()->id,
        ]);

        return $tag;
    }

    public function destroy(Work $work, Tag $tag)
    {
        $this->authorize('update', $work);

        $work->tags()->detach($tag);
        return redirect()->route('works.show', $work);
    }
}
