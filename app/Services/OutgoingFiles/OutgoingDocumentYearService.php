<?php

namespace App\Services\OutgoingFiles;

use App\Models\OutgoingFiles\OutgoingFile;
use Illuminate\Support\Facades\DB;

class OutgoingDocumentYearService
{
    public function getYearsList()
    {    
                // $years = OutgoingFile::
        //     selectRaw('DISTINCT YEAR(`outgoing_at`)')
        //     ->get()
        //     ->sortDesc()
        //     ->pluck('YEAR(`outgoing_at`)');
        // return $years;          //TODO работало на MySQL

        $years = DB::table('outgoing_files')
            ->select(DB::raw('EXTRACT (YEAR FROM outgoing_at) as outgoing_at'))
            ->distinct()
            ->orderBy('outgoing_at', 'desc')
            ->get();
        return $years;
    }
}
