<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\PaymentSystem;
use App\Project;
use App\Task;
use App\PaymentSystems;
use App\TaskCategory;
use \Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private $paginateCount;

    public function __construct()
    {
        $this->middleware('hasProjects')->only(['pageAdd', 'addTask', 'pageEdit']);
        $this->middleware('hasPermission:create_task')->only(['pageAdd', 'addTask']);
        $this->paginateCount = 15;
    }

    public function index(Request $request)
    {
        $taskFilters = Auth::user()->generateTaskFilterArray($request->all());
        $currentFilters = Task::getCurrentFilters($request);
        $tasks = Task::getUsersTasks(Auth::id(), $request->all())->paginate($this->paginateCount);

        return view('tasks.tasks', [
            'tasks' => $tasks,
            'taskFilters' => $taskFilters,
            'currentFilters' => $currentFilters
        ]);
    }

    public function pageAdd()
    {
        $userProjects = Auth::user()->getProjects()->get();
        $paymentSystems = PaymentSystem::get();
        $taskStatus = TaskStatus::class;
        $categories = TaskCategory::get();

        return view('tasks.add_task', [
            'userProjects' => $userProjects,
            'paymentSystems' => $paymentSystems,
            'taskStatus' => $taskStatus,
            'categories' => $categories
        ]);
    }

    public function pageEdit(Request $request)
    {
        $userProjects = Auth::user()->getProjects()->get();
        $paymentSystems = PaymentSystem::get();
        $task = Task::find($request->id);
        $currentProject = Project::find($task->projectId);
        $status = taskStatus::fromKey($task->status);
        $categories = TaskCategory::get();

        return view('tasks.edit_task', [
            'userProjects' => $userProjects,
            'currentProject' => $currentProject,
            'task' => $task,
            'taskStatus' => $status,
            'paymentSystems' => $paymentSystems,
            'categories' => $categories
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $task = Task::find($request->id);

        if ($task->deleteTask())
            return back()->with('success', __('task.deleted'));
    }

    public function storeTask(Request $request)
    {
        if (empty( $request->except('_token')))
            return back()->withErrors(__('overall.empty_request'));

        $validator = Task::validateRequest($request);

        if (!empty($ret = $this->proccessValidatePostTask($request, $validator))) {
            return $ret;
        }

        Task::store($request);

        $message = isset($request->id) ? __('task.updated') : __('task.created');

        return back()->with('success', $message);
    }

    private function proccessValidatePostTask(Request $request, $validator)
    {
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('title', $request->title)
                ->with('description', $request->description);
        }

        if (!Auth::user()->hasProject($request->project)) {
            return back()
                ->withErrors('You don\'t have access to this project')
                ->with('title', $request->title)
                ->with('description', $request->description);
        }
    }

}
