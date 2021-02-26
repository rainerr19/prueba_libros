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
        // return view('home',compact('libros'));
        return $libros;
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
    public function store($isbn)
    {
        // $validated = $request->validate([
        //     'isbn' => 'required|numeric|unique:books|min:0',
        // ]);
        // $response = ['response' => '', 'success'=>false];
        
        // if ($$validated->fails()) {
        //     return response()->json(['status' => 'Error ISBN no valido']);
        // }        

        $url = "https://openlibrary.org/api/books?bibkeys=ISBN:". $isbn ."&amp;jscmd=data&amp;format=json";
        $response = Http::get($url);
        $datos = $response->json();
        if (empty($datos)) {
            return response()->json(['status' => 'ISBN no encontrado']);
        }
        $datos = $datos['ISBN:'.$isbn];
        $imagen = NULL;
        if (array_key_exists('cover', $datos)) {
            $imagen = $datos['cover']['large'];
        } 
         
        $book = new Book;
        $book->isbn = $isbn;
        $book->titulo = $datos['title'];
        $book->cover = $imagen;
        $book->save();
        $autores = [];
        foreach ( $datos['authors'] as $key => $value) {
            $autores[] = ['nombre' => $value['name']];
        };
        $book->authors()->createMany($autores);
        // return redirect()->route('index')->with('success','Guardado');
        return response()->json(['status' => 'Exito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show( $isbn)
    {
        $book = Book::where('isbn',$isbn)->first();
        if (empty($book)) {
            return response()->json(['status' => 'ISBN no encontrado']);
        }
            return $book;
        
    }

    
    public function destroy($isbn)
    {
        $book = Book::where('isbn',$isbn)->first();
        if ($book->count()) {
            $book->delete();
            return response()->json(['status' => 'Exito']);
        } else {
           return response()->json(['error' => 'isbn no encontrado']);
        }
        
    }
}
