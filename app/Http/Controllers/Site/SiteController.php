<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Filters\Documents\DocumentFilter;
use App\Http\Filters\Tasks\TaskFilter;
use App\Models\Documents\Document;
use App\Models\Tasks\TaskFile;
use App\Models\Tasks\TaskPriority;
use App\Http\Requests\Roles\StoreRoleFormRequest;
use App\Http\Requests\Roles\UpdateRoleFormRequest;
use App\Http\Requests\Tasks\TaskFilterRequest;
use App\Models\Roles\Role;
use App\Models\Tasks\Task;
use App\Services\Tasks\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DateTime;
use Illuminate\Support\Str;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->taskService = new TaskService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskFilterRequest $request)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'request' => $request->all(),
            ]
        );

        $data = $request->validated();

        if (isset($data['description'])) {
            $data['description'] = no_inject($data['description']);
        }

        $fullname = explode(" ", Auth::user()->name); // Подготовка имени пользователя для приветствия на главной странице
        if (count($fullname) > 1) {
            $name = $fullname[count($fullname) -2 ] . ' ' . $fullname[count($fullname) -1 ]; //Если 2 и более слова
        }
        else{
            $name = $fullname[0]; //Если одно слово
        }
        
        $current_task_ids = $this->taskService->getCurrentTaskIds();
        $current_task_count = count($current_task_ids);

        $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);

        $tasks = Task::filter($filter)
            ->whereIn('id', $current_task_ids)
            ->with(['priority', 'author', 'responsible'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filter = app()->make(DocumentFilter::class, ['queryParams' => array_filter($data)]);

        $new_documents = Document::filter($filter)
            ->select('files.*')
            ->leftjoin('task_files', 'files.id', '=', 'task_files.file_uuid')
            ->orderBy('files.created_at', 'desc')
            ->where('task_files.file_uuid','=',null)
            ->get();

        $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);

        $responsible_outstanding_task_ids = $this->taskService->getOutstandingTaskIds();
        $outstanding_task_count = count($responsible_outstanding_task_ids);


        $outstanding_tasks = Task::filter($filter)
            ->whereIn('id', $responsible_outstanding_task_ids)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($tasks as $key => $value) {
            $utcTime = new DateTime($value['deadline_at']);
            $value['deadline_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('m.d.Y H:i');
        }

        foreach ($outstanding_tasks as $key => $value) {
            $utcTime = new DateTime($value['deadline_at']);
            $value['deadline_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('m.d.Y H:i');
        }

        return view('index', [
            'name' => $name,
            'tasks' => $tasks,
            'current_tasks_count' => $current_task_count,
            'old_filters' => $data,
            'priorities' => TaskPriority::all(),
            'new_documents' => $new_documents,
            'outstanding_tasks' => $outstanding_tasks,
            'outstanding_tasks_count' => $outstanding_task_count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleFormRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleFormRequest $request, Role $role)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
    }
}
