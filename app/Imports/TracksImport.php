<?php

namespace App\Imports;

use App\Models\TrackList;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TracksImport implements ToModel, SkipsOnError, WithChunkReading
{
    use Importable;

    private $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
     * Handle rows from the imported file.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!empty($row[1])) {
            return new TrackList([
                'track_code' => $row[1],
                'to_china' => $this->date,
                'status' => 'Получено в Китае',
                'reg_china' => 1,
                'created_at' => now(),
            ]);
        }

        return null;
    }

    /**
     * Handle errors during the import process.
     *
     * @param \Throwable $e
     */
    public function onError(\Throwable $e)
    {
        // Log or handle exceptions.
    }

    /**
     * Define the size of the chunks to read.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 30; // Number of rows to process per chunk
    }
}
