<?php

namespace App\Services\ArchiveOutgoingDocuments;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ArchiveOutgoingDocumentService
{
    public function getYearsList(): array
    {
        $result = [];

        //$archiveTabs = DB::select('SHOW TABLES LIKE "archive_files_%"'); //для MySQL
        $archiveTabs = DB::select("SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public'
            AND table_name LIKE 'archive_files_%'");                       //для Postgresql

        foreach ($archiveTabs as $item) {
            foreach ($item as $key => $value) {
                $result[] = substr($value, -4);
            }
        }

        if(!empty($result)){
            arsort($result);
            return $result;
        }

        return [];
    }

    public function getLastArchiveYear(): string
    {
        //$archiveTabs = DB::select('SHOW TABLES LIKE "archive_files_%"'); //для MySQL
        $archiveTabs = DB::select("SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public'
            AND table_name LIKE 'archive_files_%'");                       //для Postgresql

        foreach ($archiveTabs as $item) {
            foreach ($item as $key => $value) {
                $result[] = substr($value, -4);
            }
        }
        if (!empty($result)) {
            arsort($result);

            $years = array_reverse($result);
            return array_pop($years);
        }

        return '';
    }
}
