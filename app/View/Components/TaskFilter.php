<?php

namespace App\View\Components;

use App\Enums\TaskStatus;
use App\PaymentSystem;
use App\Project;
use App\TaskCategory;
use App\User;
use Illuminate\View\Component;

class TaskFilter extends Component
{
    public $filters;

    public $current;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($filters, $current)
    {
        $this->filters = $filters;
        $this->current = $current;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.task-filter');
    }
}
