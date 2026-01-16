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
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
    ];

    public function openModal($component, $parameters = [], $config = [])
    {
        $this->component = $component;
        $this->parameters = $parameters;
        $this->title = $config['title'] ?? '';
        $this->size = $config['size'] ?? 'md';
        $this->closeable = $config['closeable'] ?? true;
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
        $this->dispatch('modalClosed');
        $this->reset(['component', 'parameters', 'title', 'size', 'closeable']);
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
