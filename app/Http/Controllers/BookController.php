<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return response()->json($books);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'google_books_id' => 'required|string|unique:books,google_books_id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'total_pages' => 'nullable|integer',
            'publication_year' => 'nullable|integer',
            'category' => 'nullable|string|max:255',
            'cover_image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $this->validate($request, [
            'google_books_id' => 'required|string|unique:books,google_books_id,' . $book->id,
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'total_pages' => 'nullable|integer',
            'publication_year' => 'nullable|integer',
            'category' => 'nullable|string|max:255',
            'cover_image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $book->update($request->all());

        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
