<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;
    public $component = '';
    public $parameters = [];
    public $title = '';
    public $size = 'md';
    public $closeable = true;

    protected $listeners = [
        'openModal',
        'closeModal',
    ];

    public function openModal($payload)
    {
        $this->component  = $payload['component'] ?? '';
        $this->parameters = $payload['parameters'] ?? [];
        $this->title      = $payload['config']['title'] ?? '';
        $this->size       = $payload['config']['size'] ?? 'md';
        $this->closeable  = $payload['config']['closeable'] ?? true;

        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;

        $this->reset([
            'component',
            'parameters',
            'title',
            'size',
            'closeable',
        ]);
    }

    public function render()
    {
        return view('livewire.modal');
    }
}

