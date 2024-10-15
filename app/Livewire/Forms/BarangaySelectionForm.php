<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class BarangaySelectionForm extends Form
{
    public $selectedRegionCode = '';
    public $selectedProvinceCode = '';
    public $selectedCityCode = '';
    public $selectedBarangayCode = '';
}
