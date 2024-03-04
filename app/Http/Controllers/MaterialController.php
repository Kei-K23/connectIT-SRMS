<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:1'],
            'description' => ['string', 'min:1'],
            'file' => ['required'],
            'section_id' => ['required'],
            'instructor_id' => ['required'],
        ]);

        $file = $request->file('file');

        // Store the file in the storage/app/public directory
        $path = $file->store('public');

        Material::create([
            'name' => $request->name,
            'description' => $request->description,
            'file' => $path,
            'section_id' => $request->section_id,
            'instructor_id' => $request->instructor_id,
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully');
    }
}
