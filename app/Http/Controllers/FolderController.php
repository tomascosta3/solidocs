<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /** 
     * 
     */
    public function new_folder(Request $request) {
        
        $request->validate([
            'parent_folder_id' => 'required|exists:folders,id',
            'folder-name' => 'required|max:255'
        ]);

        $parent_folder_id = $request->input('parent_folder_id');
        $folder_name = $request->input('folder-name');

        $subfolder = Folder::create([
            'parent_id' => $parent_folder_id,
            'name' => $folder_name,
        ]);

        $parent_folder = Folder::find($request->input('parent_folder_id'));
        $users_with_permissions = $parent_folder->users()->get();

        foreach ($users_with_permissions as $user) {
            $can_read = $user->pivot->can_read;  // Acceder al valor 'can_read' de la tabla pivote para el usuario actual
            $can_write = $user->pivot->can_write; // Acceder al valor 'can_write' de la tabla pivote para el usuario actual
            
            $user->folders()->attach($subfolder->id, [
                'can_read' => $can_read,
                'can_write' => $can_write
            ]);
        }

        return to_route('documents');
    }
}
