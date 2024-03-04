<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:1'],
            'description' => ['string', 'min:1'],
            'file' => ['required'],
            'section_id' => ['required'],
            'instructor_id' => ['required'],
        ]);

        if ($request->hasFile('file')) {
            // Store the image in the storage
            $fileName = time() . '.' . $request->file->extension();
            $request->file->storeAs('public', $fileName);

            $validatedData['file'] = $fileName;
        }


        Material::create([
            'name' => $request->name,
            'description' => $request->description,
            'file' => $validatedData['file'],
            'section_id' => $request->section_id,
            'instructor_id' => $request->instructor_id,
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully');
    }

    public function update(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'min:1'],
            'description' => ['string', 'min:1'],
            'material_id' => ['required'],
        ]);


        Material::where('id', $request->material_id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back()->with('update-success', 'File updated successfully');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'material_id' => ['required', 'exists:materials,id'],
        ]);

        $material = Material::findOrFail($request->material_id);

        // Delete the file associated with the material
        Storage::delete('public/' . $material->file);

        // Delete the material record from the database
        $material->delete();

        return redirect()->back()->with('update-success', 'File deleted successfully');
    }



    public function download($filename)
    {
        // dd(Storage::disk('public')->path($filename));
        // Check if the file exists in the storage directory
        if (Storage::exists('public/' . $filename)) {
            // Get the file path
            $filePath = storage_path('app/public/' . $filename);

            // Return the file as a downloadable response
            return response()->download($filePath);
        }

        // If the file does not exist, return a 404 error
        return redirect()->back()->with('not-found-error', 'Not found material');
    }
}
