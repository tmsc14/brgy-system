<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IconHeader extends Component
{
    public $text;
    public $iconResourcePath;
    public $iconAlt;
    public $isBrown;

    public function __construct($text, $iconResourcePath, $iconAlt = '', $isBrown = false)
    {
        $this->text = $text;
        $this->iconResourcePath = $iconResourcePath;
        $this->iconAlt = $iconAlt;
        $this->isBrown = $isBrown;
    }

    public function render()
    {
        return view('components.icon-header');
    }
}