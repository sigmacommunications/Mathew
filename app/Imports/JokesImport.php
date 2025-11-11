<?php

namespace App\Imports;

use App\Models\Joke;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JokesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
		if(!array_filter($row)) {
     return null;
  } 
        return new Joke([
            'jokes_id'    => $row['jokes_id'],
            'joke_name'     => $row['joke_name'],
            'joke_humor'    => $row['joke_humor'],
            'joke_detail'    => $row['joke_detail'],
        ]);
    }
}
