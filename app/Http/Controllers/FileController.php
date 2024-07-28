<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use function Sodium\add;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("index", [
            'files' => File::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:6144',
            'name' => 'required|string|min:3|max:255'
        ]);

        if ($request->hasfile('files')) {
            $files = [];
            foreach ($request->file('files') as $file) {
                // Jika ingin menyimpan dengan nama unik
                 $filename = time() . '_' . $file->getClientOriginalName();
                 $filePath = $file->storeAs('uploads', $filename, 'public');
                 array_push($files, $filePath);
            }
            $uploadFile = File::create([
                'name' => $request->name,
                'files' => $files,
            ]);
            if (!$uploadFile) {
                back()->with('failed', 'Files fail uploaded successfully.');
            }
            return back()->with('success', 'Files have been uploaded successfully.');
        }

        return back()->withErrors(['files' => 'Please upload at least one file.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        if (!is_null(\request()->download)) {
            if (in_array(request()->download, $file->files)) {
                return Storage::disk('public')->download(request()->download);
            }
            return back()->with("failed", "File not found in this path.");
        }

        return view('show', [
            'file' => $file
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        if ($request->add_files == 'add') {
            $request->validate([
                'files.*' => 'required|file|max:6144'
            ]);

            $fileRecord = File::findOrFail($file->id);
            $existingFiles = $fileRecord->files;

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $existingFiles[] = $file->storeAs('uploads', $filename, 'public');
                }
            }

            $addFiles = $fileRecord->update([
                'files' => $existingFiles,
            ]);
            if (!$addFiles) {
                return back()->with('failed', 'Files fail uploaded successfully.');
            }

            return back()->with('success', 'Files added successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        // delete one file on one path
        if (!is_null(request()->delete_file)) {
            $filePath = request()->delete_file;
            $fileArray = $file->files;
            $fileRecord = File::findOrFail($file->id);
            if (in_array($filePath, $fileArray)) {
                try {
                    Storage::disk('public')->delete($filePath);
                } catch (Exception $err) {
                    dd($err->getMessage());
                }
                $fileKey = array_search($filePath, $fileArray);

                unset($fileArray[$fileKey]);
                $updateFile = $fileRecord->update([
                    'files' => $fileArray
                ]);
                if (!$updateFile) {
                    return back()->with("failed", "Error while saving file data.");
                }
                return back()->with("success", "File deleted successfully.");
            }
            return back()->with("failed", "File not found in this path.");
        }

        // detele all on one path
        if (!is_null(request()->delete)) {
            foreach ($file->files as $data) {
                Storage::disk('public')->delete($data);
                Log::info("delete file from " . $file->name);
            }

            $file->delete();
            return back()->with('success', "Path successfuly deleted.");
        }

        return back()->with("failed", "Something went wrong :(");
    }
}
