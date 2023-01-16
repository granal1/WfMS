<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Filters\Documents\DocumentFilter;
use App\Http\Filters\Roles\RoleFilter;
use App\Http\Filters\Tasks\TaskFilter;
use App\Http\Filters\Tasks\TaskHistoryFilter;
use App\Models\Documents\Document;
use App\Models\Tasks\TaskFile;
use App\Models\Tasks\TaskPriority;
use App\Http\Requests\Roles\RoleFilterRequest;
use App\Http\Requests\Roles\StoreRoleFormRequest;
use App\Http\Requests\Roles\UpdateRoleFormRequest;
use App\Http\Requests\Tasks\TaskFilterRequest;
use App\Models\Roles\Role;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskHistory;
use App\Services\Tasks\TaskHistoryService;
use App\Services\Tasks\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        $data = $request->validated();


        $current_task_ids = $this->taskService->getCurrentTaskIds();
        $current_task_count = count($current_task_ids);

        $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);

        $tasks = Task::filter($filter)
            ->whereIn('id', $current_task_ids)
            ->orderBy('created_at', 'desc')
            ->paginate(config('front.tasks.pagination'));


        $filter = app()->make(DocumentFilter::class, ['queryParams' => array_filter($data)]);

        $file_ids = TaskFile::all()->pluck('file_uuid')->all();

        $new_documents = Document::filter($filter)
            ->with(['tasks'])
            ->whereNot(function ($query) use ($file_ids) {
                $query->whereIn('id', $file_ids);
            })
            ->orderBy('created_at', 'desc')
            ->latest()
            ->get();

        $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);

        $responsible_outstanding_task_ids = $this->taskService->getOutstandingTaskIds();
        $outstanding_task_count = count($responsible_outstanding_task_ids);


        $outstanding_tasks = Task::filter($filter)
            ->whereIn('id', $responsible_outstanding_task_ids)
            ->orderBy('created_at', 'desc')
            ->paginate(config('front.tasks.pagination'));

        return view('index',[
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleFormRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleFormRequest $request, Role $role)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
    }
}
