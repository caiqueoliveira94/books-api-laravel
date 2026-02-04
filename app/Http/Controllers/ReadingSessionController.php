<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReadingSession;

class ReadingSessionController extends Controller
{
    public function index()
    {
        $readingSessions = ReadingSession::all();
        return response()->json($readingSessions);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'book_id' => 'required',
            'reading_time_seconds' => 'required|integer',
            'current_page' => 'required|integer',
            'started_at' => 'required|date',
            'finished_at' => 'required|date',
        ]);

        $readingSession = ReadingSession::create($request->all());

        return response()->json($readingSession, 201);
    }

    public function update(Request $request, $id)
    {
        $readingSession = ReadingSession::findOrFail($id);
        $readingSession->update($request->all());
        return response()->json($readingSession);
    }

    public function destroy($id)
    {
        $readingSession = ReadingSession::findOrFail($id);
        $readingSession->delete();
        return response()->json(null, 204);
    }


}
