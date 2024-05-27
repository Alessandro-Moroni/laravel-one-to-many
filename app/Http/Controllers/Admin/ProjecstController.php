<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Functions\Helper as Help;


class ProjecstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(isset($_GET['toSearch'])){
            $projects = Project::where('title', 'like', '%'. $_GET['toSearch'] . '%')->get();
        }else{
            $projects = Project::all();
        }

        $direction = 'desc';

        return view('admin.projects.index', compact('projects', 'direction'));
    }

    public function orderby($direction, $column){
        $direction = $direction === 'desc' ? 'asc' : 'desc';

        $projects = Project::orderBy($column, $direction)->get();
        return view('admin.projects.index', compact('projects', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exists = $request->validate([
            'title' => 'required|min:3|max:30'
        ],
        [
            'title.required' => 'Title is obbligatory',
            'title.min' => 'Title must have at least 3 letters',
            'title.max' => 'Title must have a maximum of 30 letters',
        ]);

        $exists = Project::where('title', $request->title)->first();
        if($exists){
            return redirect()->route('admin.projects.index')->with('error', 'Project exist');

        }else{
            $new = new Project();
            $new->title = $request->title;
            $new->slug = Help::generateSlug($new->title, Project::class);
            $new->save();

            return redirect()->route('admin.projects.index')->with('success', 'Project added');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|min:3|max:30'
        ],
        [
            'title.required' => 'Title is obbligatory',
            'title.min' => 'Title must have at least 3 letters',
            'title.max' => 'Title must have a maximum of 30 letters',
        ]);

        $exists = Project::where('title', $request->title)->first();
        if($exists){
            return redirect()->route('admin.projects.index')->with('error', 'Project exist');

        }else{
            $data['slug'] = Help::generateSlug($request->title, Project::class);
            $project->update($data);

            return redirect()->route('admin.projects.index')->with('success', 'Project modificated');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted');
    }
}
