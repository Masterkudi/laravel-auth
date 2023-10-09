<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUpsertRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


    class ProjectController extends Controller {
    public function index() {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    // SHOW FUNCTION

    public function show($slug) {
        $project = Project::where('slug', $slug)->first();

        return view('admin.projects.show', compact('project'));
    }

    // CREATE FUNCTION

    public function create() {
        return view('admin.projects.create');
    }

// STORE FUNCTION CON FUNZIONE SLUG

    public function store(ProjectUpsertRequest $request) {
        $data = $request->validated(); // questa funzione ritorna i dati già validati da Laravel

        // qui invoco la funzione generateSlug tramite il $this e gli passo il titolo dell'articolo per ppoter generare lo slug        
        $data["slug"] = $this->generateSlug($data['title']);

        // $project = new Project();
        // $project->fill($data);
        // $project->save()

        // semplifico il procedimento usando il Project::create invece di newProject(), fill() e save() eseguendoli in un unico comando

        $project = Project::create($data);

        return redirect()->route('admin.projects.show', $project->slug);//->with('success', 'Project created succeffully.')
    }

// EDIT FUNCTION

    public function edit($slug) { // la funzione edit recupera il progetto corrente, richiesto con lo slug e lo passa con la variabile 'project' alla view .edit
        $project = Project::where('slug', $slug)->firstOrFail();

        return view('admin.projects.edit', compact('project'));
    }

// UPDATE FUNCTION

    public function update(ProjectUpsertRequest $request, $slug) {
        $data = $request->validated();
        $project = Project::where("slug", $slug)->firstOrFail();

        // se il titolo è cambiato, rigenero lo slug
        if ($data['title'] !== $project->title) {
            $data["slug"] = $this->generateSlug($data['title']);
        } 

        // $project->update($data); // la funzione update aggiorna i dati e modifica il db

        // se spunto la checkbox, il server riceve il valore true
        // se non la spunto, il server riceve il valore false
        if (isset($data["is_published"])) {
            $project->is_published = true;
            $project->published_at = now();
        } else {
            $project->is_published = false;
            $project->published_at = null;
        }
        
        $project->update($data);

        return redirect()->route('admin.projects.show', $project->slug);
    }

// DELETE FUNCTION

    public function destroy($slug) {
        $project = Project::where("slug", $slug)->firstOrFail();

        $project->delete();

        return redirect()->route("admin.projects.index");
    } 
    
// GENERATE SLUG FUNCTION    

    protected function generateSlug($title) {
        // contatore da usare per avere un numero incrementale
        $counter = 0;

        do {
            // creo uno slug e se il counter è maggiore di 0, concateno il counter
            $slug = Str::slug($title) . ($counter > 0 ? "-" . $counter : "");

            // cerco se esiste già un elemento con questo slug
            $alreadyExists = Project::where("slug", $slug)->first();

            $counter++;
        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        return $slug;
    }

}



