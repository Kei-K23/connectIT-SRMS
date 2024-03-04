<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
}
