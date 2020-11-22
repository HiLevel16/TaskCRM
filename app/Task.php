<?php

namespace App;

use App\Enums\TaskStatus;
use App\Traits\ProjectAndPaymentSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Validator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
    use ProjectAndPaymentSystem;

    /**
     * @var string[]
     */
    protected $casts = [
        'amount' => 'array'
    ];

    /**
     * How many items should be displayed in one page
     *
     * @var int
     */
    private $paginateCount = 15;

    /**
     * Get actual user's tasks
     *
     * @param $userId
     * @param array $parameters
     * @return mixed
     * @throws \BenSampo\Enum\Exceptions\InvalidEnumKeyException
     */
    public static function getUsersTasks($userId, $parameters = [])
    {
        $status = '';
        if (isset($parameters['status'])) {
            $status = TaskStatus::fromKey($parameters['status']);
        } else {
            $status = TaskStatus::Pending();
        }
        $user = User::find($userId);

        $task = new Task();

        $task = $status ? $task->where('status', $status) : $task;
        $task = isset($parameters['project'])  ? $task->where('projectId', $parameters['project']) : $task;
        $task = isset($parameters['category']) ? $task->where('category', $parameters['category']) : $task;
        $task = isset($parameters['payment'])  ? $task->where('paymentSystemId', $parameters['payment']) : $task;

        if ($user->hasPermission('view_all_task') && isset($parameters['user'])) {
            $task = $task->where('fromId', $parameters['user']);
        } else {
            $task = $task->where('fromId', $userId);
        }

        $task = $task->latest();

        return $task;
    }

    /**
     * Gets filter values from the request
     *
     * @param Request $request
     * @return mixed
     */
    public static function getCurrentFilters(Request $request)
    {
        $result['user'] = !empty($request->input('user')) ? User::find($request->user) : null;
        $result['project'] = !empty($request->input('project')) ? Project::find($request->project) : null;
        $result['payment'] = !empty($request->input('payment')) ? PaymentSystem::find($request->payment) : null;
        $result['category'] = !empty($request->input('category')) ? TaskCategory::find($request->category) : null;
        $result['status'] = !empty($request->input('status')) ? TaskCategory::find($request->status) : null;

        return $result;
    }

    /**
     * @return mixed
     */
    public static function getAllTasks()
    {
        return static::latest();
    }

    /**
     * Validates request
     *
     * @param Request $request
     * @return mixed
     */
    public static function validateRequest(Request $request)
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

    /**
     * Saves Task
     *
     * @param $request
     * @return bool
     * @throws \BenSampo\Enum\Exceptions\InvalidEnumKeyException
     */
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
