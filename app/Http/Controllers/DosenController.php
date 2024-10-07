<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::all();
        return view('index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|unique:dosen|max:10',
            'nama_dosen' => 'required|max:50',
            'tgl_mulai_tugas' => 'required|date',
            'jenjang_pendidikan' => 'required|max:10',
            'bidang_keilmuan' => 'required|max:50',
            'foto_dosen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure the file is an image
        ]);


        if ($request->hasFile('foto_dosen')) {
            $fileName = time() . '_' . $request->file('foto_dosen')->getClientOriginalName();
            $filePath = $request->file('foto_dosen')->storeAs('uploads/dosen', $fileName, 'public');
            $validated['foto_dosen'] = $filePath;
        }

        Dosen::create($validated);

        return redirect()->route('dosen.index')->with('success', 'Dosen created successfully.');
    }


    public function show($nidn)
    {
        $dosen = Dosen::findOrFail($nidn);
        return view('dosen.show', compact('dosen'));
    }

    public function edit($nidn)
    {
        $dosen = Dosen::findOrFail($nidn);
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, $nidn)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|max:50',
            'tgl_mulai_tugas' => 'required|date',
            'jenjang_pendidikan' => 'required|max:10',
            'bidang_keilmuan' => 'required|max:50',
            'foto_dosen' => 'nullable|max:50',
        ]);

        $dosen = Dosen::findOrFail($nidn);
        $dosen->update($validated);

        return redirect()->route('dosen.index')->with('success', 'Dosen updated successfully.');
    }

    public function destroy($nidn)
    {
        $dosen = Dosen::findOrFail($nidn);
        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Dosen deleted successfully.');
    }
}
