<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Returns document list view.
     */
    public function index() : View {

        $documents = Document::where('active', true)
            ->get();
        
        return view('documents.index')
            ->with(['documents' => $documents]);
    }


    /**
     * Returns document creation view.
     */
    public function create() : View {

        return view('documents.create');
    }

    
    /**
     * Store document in database.
     */
    public function store(Request $request) : RedirectResponse {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('register', [
            'name' => ['required'],
            'required_access_level' => ['required'],
            'comment' => ['nullable'],
            'file' => ['required', 'mimes:pdf,png,jpg,doc,docx', 'max:10240'],
        ]);

        // Move file to server and hash its name.
        $file = $request->file('file');
        $hashed_name = $file->hashName();
        $folder_name = 'storage/documents';
        $file->move(public_path($folder_name), $hashed_name);       
        
        // Create document.
        $document = Document::create([
            'name' => $request->input('name'),
            'required_access_level' => $request->input('required_access_level'),
            'comment' => $request->input('comment'),
            'path' => $folder_name . '/' . $hashed_name,
            'created_by' => Auth::user()->id,
        ]);

        // Check if the document was created successfully and set flash session variable.
        if($document->id) {
            session()->flash('success', 'El documento fue creado correctamente');
        } else {
            session()->flash('problem', 'Error al crear el documento');
        }

        return to_route('documents.create');
    }


    /**
     * Return view
     */
    public function view($id){

        $document = Document::find($id);

        // If the document doesn't exists, it returns an error.
        if(!$document) {

            session()->flash('problem', 'No se encuentra el documento');
            return to_route('documents');
        }

        /**
         * If the user doesn't have the permissions to access the document,
         * it returns an error.
         */
        if(Auth::user()->access_level_in_organization(session('organization_id')) < 
        $document->required_access_level) {

            session()->flash('problem', 'No cuentas con los permisos suficientes para acceder al archivo');
            return to_route('documents');
        }

        // Get all active documents.
        $documents = Document::where('active', true)
            ->get();

        return view('documents.view')
            ->with(['documents' => $documents])
            ->with(['document' => $document]);
    }
}
