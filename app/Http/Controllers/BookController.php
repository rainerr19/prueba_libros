<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libros = Book::paginate(3);
        return view('home',compact('libros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|numeric|unique:books|min:0',
        ]);

        $url = "https://openlibrary.org/api/books?bibkeys=ISBN:". $request->isbn ."&amp;jscmd=data&amp;format=json";
        $response = Http::get($url);
        $datos = $response->json()['ISBN:'.$request->isbn];
        $imagen = NULL;
        if (array_key_exists('cover', $datos)) {
            $imagen = $datos['cover']['large'];
        } 
         
        $book = new Book;
        $book->isbn = $request->isbn;
        $book->titulo = $datos['title'];
        $book->cover = $imagen;
        $book->save();
        $autores = [];
        foreach ( $datos['authors'] as $key => $value) {
            $autores[] = ['nombre' => $value['name']];
        };
        $book->authors()->createMany($autores);
         return redirect()->route('index')->with('success','Guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show( $isbn)
    {
        
            return Book::where('isbn',$isbn)->first();
        
    }

    
    public function destroy($isbn)
    {
        $book = Book::where('isbn',$isbn)->first();
        if ($book->count()) {
            $book->delete();
            return back()->with('success', 'Eliminado');
        } else {
           return response()->json(['error' => 'isbn no encontrado']);
        }
        
        return true;
    }
}
