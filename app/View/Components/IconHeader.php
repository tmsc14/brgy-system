<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IconHeader extends Component
{
    public $text;
    public $iconResourcePath;
    public $iconAlt;

    public function __construct($text, $iconResourcePath, $iconAlt = '')
    {
        $this->text = $text;
        $this->iconResourcePath = $iconResourcePath;
        $this->iconAlt = $iconAlt;
    }

    public function render()
    {
        return view('components.icon-header');
    }
}