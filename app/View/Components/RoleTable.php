<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RoleTable extends Component
{

    public $roles;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.role-table');
    }
}
