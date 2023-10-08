<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    // SHOW FUNCTION

    public function show($slug) {
        $post = Post::where('slug', $slug)->first();

        return view('admin.posts.show', compact('post'));
    }

    // CREATE FUNCTION

    public function create() {
        return view('admin.posts.create');
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

            $alreadyExists = Post::where("slug", $slug)->first();

            $counter++;

        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        $data["slug"] = $slug;

        // $post = new Post();
        // $post->fill($data);
        // $post->save()

        // semplifico il procedimento usando il Post::create invece di newPost(), fill() e save()
        // eseguendoli in un unico comando

        $post = Post::create($data);

        return redirect()->route('admin.posts.show', $post->id);//->with('success', 'Post created succeffully.')
    }

    // EDIT FUNCTION

    public function edit($id)
    {
        $posts = Post::findOrFail($id);

        return view("posts.edit", ["posts" => $posts]);
    }

    // UPDATE FUNCTION

        /**
     * Riceve i dati inviati dal form edit e aggiorna il post che corrisponde
     * all'id indicato come argomento
     * 
     * @return Request $request
     * @param int $id ID del post da modificare
     * @return RedirectResponse 
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // recupera il gioco che corrisponde all'id ricevuto come argomento
        $post = Post::findOrFail($id);

        // legge i dati ricevuti dal form
        $newData = $request->all();

        // $newData["genre"] = explode(",", $newData["genre"]);
        // $newData["platform"] = explode(",", $newData["platform"]);

        // aggiorna i dati del gioco tramite
        // esegue 2 azioni dietro le quinte: fill() e save()
        $post->update($newData);

        // Esegue il redirect alla rotta scelta (in questo caso la pagina prodotto)
        return redirect()->route("posts.show", $post->id);
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
        $post = Post::findOrFail($id);

        // elimina il post
        $post->delete();

        // Esegue il redirect alla rotta scelta (in questo caso la pagina principale)
        return redirect()->route("posts.index");
    }

}

