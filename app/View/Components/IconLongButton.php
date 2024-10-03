<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IconLongButton extends Component
{
    public $text;
    public $iconResourcePath;
    public $onClick;
    public $alt;

    public function __construct($text = 'Click Me', $iconResourcePath, $onClick, $alt = '')
    {
        $this->text = $text;
        $this->iconResourcePath = $iconResourcePath;
        $this->onClick = $onClick;
        $this->alt = $alt;
    }

    public function render()
    {
        return view('components.icon-long-button');
    }
}