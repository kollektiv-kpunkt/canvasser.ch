<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectInput extends Component
{
    public $options;
    public $multiple;
    public $selected;
    /**
     * Create a new component instance.
     */
    public function __construct(array $options = [], $multiple = false, array $selected = [])
    {
        $this->options = $options;
        $this->multiple = $multiple;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-input');
    }
}
