<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document' => 'required|mimes:pdf,csv,xls,xlsx,doc,docx|max:2048',
            'mentor' => 'required|exists:users,id',
            'mentee' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $user = Auth::user();
        
        // Authorization: User must be either the mentor or mentee
        if ($user->id != $request->mentor && $user->id != $request->mentee) {
            abort(403, 'You can only upload documents for conversations you are part of');
        }

        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        // Store file in storage/app/documents (private storage)
        // Create documents directory if it doesn't exist
        if (!Storage::exists('documents')) {
            Storage::makeDirectory('documents');
        }
        
        $file->storeAs('documents', $fileName);

        $document = Document::create([
            'title' => $request->title,
            'description' => $request->description ?? '',
            'document' => $fileName,
            'ext' => $file->extension(),
            'filename' => $file->getClientOriginalName(),
            'mentor' => $request->mentor,
            'mentee' => $request->mentee,
            'project_id' => $request->project_id,
        ]);

        return (new HomeController)->afterandreturn($request);
    }

    /**
     * Download a document (with authorization check)
     */
    public function download(Document $document)
    {
        $user = Auth::user();
        
        // Authorization: User must be either the mentor or mentee
        if ($user->id != $document->mentor && $user->id != $document->mentee) {
            abort(403, 'You can only download documents from conversations you are part of');
        }

        $filePath = 'documents/' . $document->document;
        
        if (!Storage::exists($filePath)) {
            abort(404, 'Document not found');
        }

        return Storage::download($filePath, $document->filename);
    }
}
