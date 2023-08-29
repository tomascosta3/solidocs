<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    /**
     * Download document from id.
     */
    public function download_document($id) : RedirectResponse {

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

        $path = public_path($document->path);
        
        return response()->download($path, $document->name);
    }
}
