<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TaskCard extends Component
{

    /**
     * @var
     */
    public $tasks;

    /**
     * Create a new component instance.
     *
     * @param $tasks
     */
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.task-card');
    }
}
