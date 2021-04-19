<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get ALL
        $books = Book::all();
        if (!$books) {
            return response()->json([
                'success' => false,
                'message' => 'Books not found'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $books->toArray()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Instanciem la classe Book
        $book = new Book;
        //Declarem el nom amb el request
        $book->ISBN = $request->ISBN;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->editorial = $request->editorial;
        $book->gender = $request->gender;
        $book->synopsis = $request->synopsis;
        $book->idiom = $request->idiom;
        $book->miniature = $request->miniature;
        //el usuario que ha creado el libro
        $book->user_id = auth()->user()->id;
        //Desem els canvis
        $book->save();
        return response()->json([
            'success' => true,
            'message' => 'Book created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //PREGUNTAR AL TONI COMO SE PONE UN PARAMETRO OPCIONAL EN LARAVEL (RUTAS)
    public function show($id)
    {
        //FIND BY ID
        $books = Book::find($id);
        if (!$books) {
            return response()->json([
                'success' => false,
                'message' => 'Book with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $books->toArray()
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book with id ' . $id . ' not found'
            ], 400);
        }

        //solo puede editar el usuario que vende el libro
        if (auth()->user()->id != $book->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'This is not your book'
            ], 400);
        }

        $book->update([
            'ISBN' => $request->ISBN,
            'title' => $request->title,
            'author' => $request->author,
            'editorial' => $request->editorial,
            'gender' => $request->gender,
            'synopsis' => $request->synopsis,
            'idiom' => $request->idiom,
            'miniature' => $request->miniature
            //¿'user_id'?
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Book ' . $id . ' updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        //solo puede eliminar el usuario que vende el libro
        if (auth()->user()->id != $book->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'This is not your book'
            ], 400);
        }
        Book::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Book ' . $id . ' destroyed'
        ], 200);
    }
}
