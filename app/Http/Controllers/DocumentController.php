<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Returns document list view.
     */
    public function index(Request $request) : View {

        $user_access_level = Auth::user()->access_level_in_organization(session('organization_id'));

        $search = $request->input('search');

        if($search) {
            $documents = Document::where('name', 'like', '%' . $search . '%')
                ->where('active', true)
                ->where('required_access_level', '<=', $user_access_level)
                ->get();
        } else {
            $documents = Document::where('active', true)
                ->where('required_access_level', '<=', $user_access_level)
                ->get();
        }
        
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
        $validated = $request->validateWithBag('create', [
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
    public function view($id) {

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

        return view('documents.view')
            ->with(['document' => $document]);
    }


    /**
     * Change the document status to inactive so that it is not visible.
     */
    public function delete($id) : RedirectResponse {

        $document = Document::find($id);
        
        // If the document doesn't exists, it returns an error.
        if(!$document || $document->active == false) {

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

        // Set active field to false.
        $document->active = false;
        $document->save();

        session()->flash('success', 'Documento eliminado.');

        return to_route('documents');
    }


    /**
     * Edits the document fields with the changes made by the user.
     */
    public function edit(Request $request, $id) : RedirectResponse {

        $document = Document::find($id);

        // If the document doesn't exists, it returns an error.
        if(!$document || $document->active == false) {

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

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('register', [
            'name' => ['required'],
            'required_access_level' => ['required'],
            'comment' => ['nullable'],
        ]);

        /**
         * Check if any changes were made, if there were changes save them.
         */
        $edited = false;

        if($document->name !== $request->input('name')) {
            $document->name = $request->input('name');
            $edited = true;
        }

        if($document->required_access_level !== $request->input('required_access_level')) {
            $document->required_access_level = $request->input('required_access_level');
            $edited = true;
        }

        if($document->comment !== $request->input('comment')) {
            $document->comment = $request->input('comment');
            $edited = true;
        }

        if($edited) {
            $document->save();
            session()->flash('success', 'Documento modificado correctamente');
        } else {
            session()->flash('problem', 'Ningún cambio realizado');
        }

        return to_route('documents.view', ['id' => $id]);
    }
}
