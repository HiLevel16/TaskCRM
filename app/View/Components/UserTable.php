<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Class UserTable
 * @package App\View\Components
 */
class UserTable extends Component
{

    /**
     * @var
     */
    public $users;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.user-table');
    }
}
