<?php

namespace App\View\Components\BaseComponents\layout;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->items = config('sidebar_items');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.BaseComponents.layout.sidebar');
    }
}
