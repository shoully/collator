<?php

namespace App\Http\Controllers;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DocumentController extends Controller
{
    public function store(Request $request)
    {        
        $request->validate([
            'document' => 'required|mimes:pdf,csv,xls,xlsx,doc,docx|max:2048',
        ]);
        $document = new Document;
        $document->title       = $request->title;
        $document->description = $request->description;
        $document->mentor = empty($request->mentor) ? '0' : $request->mentor;
        $document->mentee = empty($request->mentee) ? '0' : $request->mentee;
        $file = $request->file('document');
        $document->ext = $file->extension();;
        $document->filename = $file->getClientOriginalName();
        $fileName = time().$request->file('document')->getClientOriginalName();
        $request->document->move(public_path('storage/images'), $fileName);
        $document->document    = $fileName;
        $document->save();

        return App::call('App\Http\Controllers\HomeController@afterandreturn' , ['request' => $request]);
    }
}
