<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IconLongButton extends Component
{
    public $text;
    public $iconName;
    public $alt;

    public function __construct($text = 'Click Me', $iconName, $alt = '')
    {
        $this->text = $text;
        $this->iconName = $iconName;
        $this->alt = $alt;
    }

    public function render()
    {
        return view('components.icon-long-button');
    }
}