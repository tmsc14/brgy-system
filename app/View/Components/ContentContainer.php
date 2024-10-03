<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ContentContainer extends Component
{
    public $headerText;
    public $iconResourcePath;
    public $class;

    public function __construct($headerText = '', $iconResourcePath = '', $class = '')
    {
        $this->headerText = $headerText;
        $this->iconResourcePath = $iconResourcePath;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content-container');
    }
}
