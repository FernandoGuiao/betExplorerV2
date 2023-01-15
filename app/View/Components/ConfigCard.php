<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConfigCard extends Component
{
    public $icon;
    public $text;
    public $minName;
    public $maxName;
    public $minPlaceholder;
    public $maxPlaceholder;
    public $inputType;
    public $bgColor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($minName, $maxName, $icon, $text, $minPlaceholder = "min", $maxPlaceholder = "max", $inputType = "number", $bgColor = null)
    {
        $this->icon = $icon;
        $this->text = $text;
        $this->minName = $minName;
        $this->maxName = $maxName;
        $this->minPlaceholder = $minPlaceholder;
        $this->maxPlaceholder = $maxPlaceholder;
        $this->inputType = $inputType;
        $this->bgColor = $bgColor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.config-card', [
            'icon' => $this->icon,
            'text' => $this->text,
            'minName' => $this->minName,
            'maxName' => $this->maxName,
            'minPlaceholder' => $this->minPlaceholder,
            'maxPlaceholder' => $this->maxPlaceholder,
            'inputType' => $this->inputType,
            'bgColor' => $this->bgColor,
        ]);
    }
}
