<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\JokesImport;
use App\Models\Joke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;

class JokeController extends Controller
{
    // Show a list of jokes
    public function index()
    {
        $jokes = Joke::OrderBy('id')->get();
        return view('admin.jokes.index', compact('jokes'));
    }

    // Show the form for creating a new joke
    public function create()
    {
        return view('admin.jokes.create');
    }

    // Store a newly created joke in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'joke_name' => 'required',
            'joke_humor' => 'required',
            'joke_detail' => 'required',
        ]);

        Joke::create($validatedData);

        return redirect()->route('jokes.index')->with('success', 'Joke created successfully.');
    }

    // Show the form for editing the specified joke
    public function edit(Joke $joke)
    {
        return view('admin.jokes.edit', compact('joke'));
    }

    // Update the specified joke in the database
    public function update(Request $request, Joke $joke)
    {
        $validatedData = $request->validate([
            'joke_name' => 'required',
            'joke_humor' => 'required',
            'joke_detail' => 'required',
        ]);

        $joke->update($validatedData);

        return redirect()->route('jokes.index')->with('success', 'Joke updated successfully.');
    }

    // Remove the specified joke from the database
    public function destroy(Joke $joke)
    {
        $joke->delete();

        return redirect()->route('jokes.index')->with('success', 'Joke deleted successfully.');
    }

    // Handle CSV file upload
 public function uploadCSV(Request $request)
{
    $file = $request->file('csv_file');
// dd($file);
	//Artisan::call('optimize:clear');
    Excel::import(new JokesImport,$file);

    // $data = Excel::load($file)->get();
    // YourModel::insert($data->toArray());

    return redirect()->back()->with('success', 'Data uploaded and saved successfully.');

}
    // public function uploadCSV(Request $request)
    // {

    //     try {
    //         DB::beginTransaction();

    //         $request->validate([
    //             'csv_file' => 'required|mimes:csv,txt',
    //         ]);

    //         $file = $request->file('csv_file');

    //         $csv = Reader::createFromPath($file->getPathname());

    //         $data = $csv->getRecords();

    //         foreach ($data as $row) {
    //             Joke::create([
    //                 'jokes_id' => $row[0],
    //                 'joke_name' => mb_convert_encoding($row[1], 'UTF-8', 'UTF-8'),
    //                 'joke_humor' => mb_convert_encoding($row[2], 'UTF-8', 'UTF-8'),
    //                 'joke_detail' => mb_convert_encoding($row[3], 'UTF-8', 'UTF-8'),
    //             ]);
    //         }

    //         DB::commit();

    //         return redirect()->route('jokes.index')->with('success', 'Jokes uploaded successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return redirect()->route('jokes.index')->with('error', 'Error uploading jokes: ' . $e->getMessage());
    //     }


    // }


    public function show(Joke $joke)
    {
        return view('admin.jokes.show', compact('joke'));
    }

}
