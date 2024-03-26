<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use App\Models\CreditRequest;
use Livewire\Form;

class RequestForm extends Form
{
    #[Validate('required|min:5')]
    public $title = '';
 
    #[Validate('required|min:5')]
    public $content = '';

    public function store() 
    {
        $this->validate();
 
        CreditRequest::create($this->all());

        $this->reset();
    }
}
