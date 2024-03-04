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

    // public function download($filename)
    // {
    //     // Check if the file exists in the storage directory
    //     if (Storage::disk('public')->exists($filename)) {
    //         // Get the file path
    //         $filePath = Storage::disk('public')->path($filename);

    //         // Return the file as a downloadable response
    //         return response()->download($filePath);
    //     }

    //     // If the file does not exist, return a 404 error
    //     return redirect()->back()->with('error', 'Material not found');
    // }
    public function download($filename)
    {
        // Check if the file exists in the storage directory
        if (Storage::exists('public' . $filename)) {
            // Get the file path
            $filePath = storage_path('public' . $filename);

            // Return the file as a downloadable response
            return response()->download($filePath);
        }

        // If the file does not exist, return a 404 error
        return redirect()->back()->with('error', 'Not found material');
    }
}
