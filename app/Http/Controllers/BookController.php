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
            'google_books_id' => 'required|string',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'total_pages' => 'nullable|integer',
            'publication_year' => 'nullable|integer',
            'category' => 'nullable|string|max:255',
            'cover_image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $googleBooksId = $request->google_books_id;
    
        $book = Book::withTrashed()
            ->where('google_books_id', $googleBooksId)
            ->first();
        
        if ($book) {
            if ($book->trashed()) {
                $book->restore();
                $book->update($request->all());
                return response()->json($book, 200);
            } else {
                return response()->json(['message' => 'Book already exists'], 409);
            }
        }

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::withTrashed()->find($id);

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
            'google_books_id' => 'string',
            'title' => 'string|max:255',
            'author' => 'string|max:255',
            'total_pages' => 'integer',
            'publication_year' => 'integer',
            'category' => 'string|max:255',
            'cover_image' => 'string|max:255',
            'description' => 'string',
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
