<?php

namespace App\Livewire;

use App\Livewire\Forms\RequestForm;
use Livewire\Component;
use App\Models\CreditRequest;

class CreateRequest extends Component
{
    public RequestForm $form; 
 
    public function save()
    {
        $this->form->store(); 
 
        return $this->redirect('/requests');
    }
 
    public function render()
    {
        return view('livewire.create-request');
    }
}
