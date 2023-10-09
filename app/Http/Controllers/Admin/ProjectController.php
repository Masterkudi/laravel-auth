<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|max:255',
        ]);

        // contatore da usare per avere un numero incrementale

        $counter = 0;

        do {
            // creo uno slug e se il counter è maggiore di 0, concateno il counter

            $slug = Str::slug($data["title"]) . ($counter > 0 ? "-" . $counter : "");

            // cerco se esiste già un elemento con questo slug

            $alreadyExists = Project::where("slug", $slug)->first();

            $counter++;

        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        $data["slug"] = $slug;

        // $project = new Project();
        // $project->fill($data);
        // $project->save()

        // semplifico il procedimento usando il Project::create invece di newProject(), fill() e save()
        // eseguendoli in un unico comando

        $project = Project::create($data);

        return redirect()->route('admin.projects.show', $project->id);//->with('success', 'Project created succeffully.')
    }

    // EDIT FUNCTION

    public function edit($id)
    {
        $projects = Project::findOrFail($id);

        return view("projects.edit", ["projects" => $projects]);
    }

    // UPDATE FUNCTION

        /**
     * Riceve i dati inviati dal form edit e aggiorna il progetto che corrisponde
     * all'id indicato come argomento
     * 
     * @return Request $request
     * @param int $id ID del post da modificare
     * @return RedirectResponse 
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // recupera il gioco che corrisponde all'id ricevuto come argomento
        $project = Project::findOrFail($id);

        // legge i dati ricevuti dal form
        $newData = $request->all();

        // $newData["genre"] = explode(",", $newData["genre"]);
        // $newData["platform"] = explode(",", $newData["platform"]);

        // aggiorna i dati del progetto tramite
        // esegue 2 azioni dietro le quinte: fill() e save()
        $project->update($newData);

        // Esegue il redirect alla rotta scelta (in questo caso la pagina prodotto)
        return redirect()->route("projects.show", $project->id);
    }

    // DELETE FUNCTION


    /**
     * Rimuove il post che corrisponde ricevuto come argomento
     * 
     * @param int $id ID del post da eliminare
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse {
        // recupera il post che corrisponde all'id ricevuto come argomento
        $project = Project::findOrFail($id);

        // elimina il post
        $project->delete();

        // Esegue il redirect alla rotta scelta (in questo caso la pagina principale)
        return redirect()->route("projects.index");
    }

}



