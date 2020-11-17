<?php

namespace App;

use App\Enums\TaskStatus;
use App\Traits\ProjectAndPaymentSystem;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use \Validator;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use ProjectAndPaymentSystem;
    /**
     * @var mixed
     */

    /**
     * @var string[]
     */
    protected $casts = [
        'amount' => 'array'
    ];

    private $paginateCount = 15;

    public static function getUsersTasks($userId, $parameters = [])
    {
        $status = '';
        if (isset($parameters['status']) && $parameters['status'] !== 'all') {
            $status = TaskStatus::fromKey($parameters['status']);
        } elseif ($parameters['status'] == 'all') {
            $status = $parameters['status'];
        } else {
            $status = TaskStatus::Pending();
        }
        $order = isset($parameters['order']) ? $parameters['order'] : ['key' => 'created_at', 'order' => 'asc'];
        $user = User::find($userId);

        $task = new Task();

        $task = ($status == 'all') ? $task : $task->where('status', $status);
        $task = $user->hasPermission('view_all_task') ? $task : $task->where('userId', $userId);
        $task = $task->orderBy($order['key'], $order['order']);

        return $task;
    }

    public static function getAllTasks()
    {
        return static::orderBy('created_at', 'asc')->get();
    }

    public static function validateRequest(\Illuminate\Http\Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required|max:255',
            'amount' => 'required|integer',
            'currency' => 'required|in:usd,btc,eur,rub,uah',
            'status' => 'required|max:255',
            'project' => 'required|integer',
            'category' => 'required|integer'
        ]);
    }

    public static function store($request)
    {
        $task = null;

        if (isset($request->id)) {
            $task = Task::find($request->id);
        } else {
            $task = new Task;
        }

        $taskStatus = TaskStatus::fromKey($request->status);

        $currencies = get_five_currencies($request->currency, $request->amount);
        $task->projectId = $request->project;
        $task->fromId = Auth::user()->id;
        $task->paymentSystemId = $request->payment_type;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->amount = $currencies;
        $task->status = $taskStatus->key;
        $task->category = $request->category;
        return $task->save();

    }
}
