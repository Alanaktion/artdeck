<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    /**
     * Display a listing of the tags.
     */
    public function index()
    {
        $tags = Tag::orderBy('name', 'asc')
            ->withCount('works')
            ->paginate(60);
        return view('tags.index', compact('tags'));
    }
}
