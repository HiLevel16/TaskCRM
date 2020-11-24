<?php

namespace App;

use App\Enums\TaskStatus;
use App\Traits\ProjectAndPaymentSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $statuses = [];
        //dd($parameters['statuses']);
        if (isset($parameters['statuses'])) {
            if (is_array($parameters['statuses'])) {
                foreach ($parameters['statuses'] as $status) {
                    $statuses[] = $status;
                }
            } else {
                $statuses[] = $parameters['statuses'];
            }
        } else {
            $statuses[] = TaskStatus::Pending()->value;
        }

        $user = User::find($userId);

        $task = new Task();

        $task = $statuses ? $task->whereIn('status', $statuses) : $task;
        $task = isset($parameters['projects'])  ? $task->whereIn('projectId', (array)$parameters['projects']) : $task;
        $task = isset($parameters['categories']) ? $task->whereIn('category', (array)$parameters['categories']) : $task;
        $task = isset($parameters['payments'])  ? $task->whereIn('paymentSystemId', (array)$parameters['payments']) : $task;
        $task = isset($parameters['date-from']) ? $task->whereDate('created_at', '>', $parameters['date-from']) : $task;
        $task = isset($parameters['date-to']) ? $task->whereDate('created_at', '<', $parameters['date-to']) : $task;

        if ($user->hasPermission('view_all_task') && isset($parameters['user'])) {
            $task = $task->whereIn('fromId', (array)$parameters['users']);
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
        $result['users'] = !empty($request->input('users')) ? (array)$request->input('users') : [];
        $result['projects'] = !empty($request->input('projects')) ? (array)$request->input('projects') : [];
        $result['payments'] = !empty($request->input('payments')) ? (array)$request->input('payments') : [];
        $result['categories'] = !empty($request->input('categories')) ? (array)$request->input('categories') : [];
        $result['statuses'] = !empty($request->input('statuses')) ? (array)$request->input('statuses') : [];
        $result['date-from'] = !empty($request->input('date-from')) ? $request->input('date-from') : null;
        $result['date-to'] = !empty($request->input('date-to')) ? $request->input('date-to') : null;

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

    public function deleteTask()
    {
        if ($this->id) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return true;
        }
        return true;
    }

}
