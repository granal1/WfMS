<?php

namespace App\Http\Controllers\ArchiveDocuments;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArchiveDocuments\ArchiveDocumentFilterRequest;
use App\Http\Requests\ArchiveDocuments\UpdateArchiveDocumentFormRequest;

use App\Models\ArchiveDocuments\ArchiveDocument;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use DateTime;

class ArchiveDocumentController extends Controller
{
    public $archive_list = [];

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->archive_list = $this->getArchiveList();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(ArchiveDocumentFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),
            ]);

        $this->authorize('viewAny', ArchiveDocument::class);

        if(empty($this->archive_list))
        {
            return view('archive_documents.index', [
                'archive_documents' => null,
                'old_filters' => null,
                'archive_years' => null,
                'year' => null,
            ]);
        }

        $data = $request->validated();

        if(isset($data['year']))
        {
            Session::put('year', $data['year']);
        } else {
            Session::put('year', $this->getLastArchiveYear());
        }

        $documents = DB::select('select * from archive_files_' . Session::get('year'));
        $documents = $this->paginate($documents);




//        if (isset($data['content'])) {
//            $data['content'] = no_inject($data['content']);
//        }
//        $filter = app()->make(ArchiveDocumentFilter::class, ['queryParams' => array_filter($data)]);
//
//        $documents = null;
//
//        if (!empty($data['content'])) {
//            $documents = ArchiveDocument::filter($filter)
//                ->paginate(config('front.documents.pagination'));
//        } else {
//            $documents = ArchiveDocument::orderBy('created_at', 'desc')
//                ->paginate(config('front.documents.pagination'));
//        }


        return view('archive_documents.index', [
            'archive_documents' => $documents,
            'old_filters' => $data,
            'archive_years' => $this->archive_list,
        ]);
    }


    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($document_id)
    {
        $this->authorize('view', ArchiveDocument::class);

        $document = DB::table('archive_files_' . Session::get('year'))
            ->where('id', 'LIKE', '%' . $document_id . '%')
            ->first();

        $document = json_decode(json_encode($document),true);

        $utcTime = new DateTime($document['created_at']);
        $document['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс

        if (isset($document->tasks[0]->deadline_at)) {
            $utcTime = new DateTime($document->tasks[0]->deadline_at);
            $document->tasks[0]->deadline_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс
        }

        return view('archive_documents.show', [
            'archive_document' => $document,
        ]);
    }

    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($document_id)
    {
        $this->authorize('update', ArchiveDocument::class);

        $document = DB::table('archive_files_' . Session::get('year'))
            ->where('id', 'LIKE', '%' . $document_id . '%')
            ->first();

        $document = json_decode(json_encode($document),true);

        return view('archive_documents.edit', [
            'archive_document' => $document,
            'users' => User::all(),
        ]);
    }

    /**
     * @param UpdateArchiveDocumentFormRequest $request
     * @param ArchiveDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArchiveDocumentFormRequest $request, $document_id)
    {
        $this->authorize('update', ArchiveDocument::class);

        if ($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                DB::table('archive_files_' . Session::get('year'))
                    ->where('id', $document_id)
                    ->update(array(
                        'incoming_at' => $data['incoming_at'],
                        'incoming_number'=>$data['incoming_number'],
                        'short_description' => $data['short_description'],
                        'incoming_author' => $data['incoming_author'],
                        'number' => $data['number'],
                        'date' => $data['date'],
                        'document_and_application_sheets' => $data['document_and_application_sheets'],
                        'file_mark' => $data['file_mark'],
                ));

                DB::commit();

                return redirect()->route('archive_documents.edit', $document_id)->with('success', 'Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('archive_documents.edit', $document_id)->with('error', 'Изменения не сохранились, ошибка.');
    }

    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($document_id)
    {
        $this->authorize('delete', ArchiveDocument::class);

        try {

            $document = DB::table('archive_files_' . Session::get('year'))
                ->where('id', 'LIKE', '%' . $document_id . '%')
                ->first();

            $document = json_decode(json_encode($document),true);

            if (Storage::exists('/public/' . $document['path'])) {

                //Storage::delete('/public/' . $document['path']);


            }

            DB::table('archive_files_' . Session::get('year'))->delete($document_id);

        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('archive_documents.index');
    }

    private function getArchiveList(): array
    {
        $result = [];

        foreach (DB::select('SHOW TABLES LIKE "archive_files_%"') as $item) {
            foreach ($item as $key => $value) {
                $result[substr($value, -4)] = $value;
            }
        }
        arsort($result);
        return $result;
    }

    private function getLastArchiveYear(): string
    {
        $years = $this->getArchiveList();
        return substr(array_pop($years), -4);
    }

    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return $paginator->setPath(Paginator::resolveCurrentPath());
    }
}
