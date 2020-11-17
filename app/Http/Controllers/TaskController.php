<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\PaymentSystem;
use App\Project;
use App\Task;
use App\PaymentSystems;
use App\TaskCategory;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use \Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('hasProjects')->only(['pageAdd', 'addTask', 'pageEdit']);
        $this->middleware('hasPermission:create_task')->only(['pageAdd', 'addTask']);
    }

    public function index(Request $request, $taskStatus = 'all')
    {
        $userProjects = Auth::user()->getProjects()->get();
        $paymentSystems = PaymentSystem::get();
        $taskStatus = TaskStatus::class;
        $categories = TaskCategory::get();

        $paginateCount = 15;

        $parameters = [
            'status' => $taskStatus
        ];
        $tasks = Task::getUsersTasks(Auth::id(), $parameters)->paginate($paginateCount);

        return view('tasks.tasks', [
            'tasks' => $tasks,
            'userProjects' => $userProjects,
            'paymentSystems' => $paymentSystems,
            'taskStatus' => $taskStatus,
            'categories' => $categories
        ]);
    }

    public function project(Request $request)
    {
        if (Project::isUserAMember(Auth::user()->id, $request->projectId)) {
            $tasks = Task::where('projectId', $request->projectId)->paginate(15);
            return view('tasks.tasks', [
                'tasks' => $tasks
            ]);
        } else {
            return 'You don\'t have permission to view the page';
        }
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

    public function storeTask(Request $request)
    {
        if (empty( $request->except('_token')))
            return Redirect::back()->withErrors('Request is empty');

        $validator = Task::validateRequest($request);

        if (!empty($ret = $this->proccessValidatePostTask($request, $validator))) {
            return $ret;
        }

        Task::store($request);

        $message = isset($request->id) ? 'The task was successfully updated' : 'The task was successfully created';

        return Redirect::back()->with('success', $message);
    }

    private function proccessValidatePostTask(Request $request, $validator)
    {
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->with('title', $request->title)
                ->with('description', $request->description);
        }

        if (!Auth::user()->hasProject($request->project)) {
            return Redirect::back()
                ->withErrors('You don\'t have access to this project')
                ->with('title', $request->title)
                ->with('description', $request->description);
        }
    }

}
