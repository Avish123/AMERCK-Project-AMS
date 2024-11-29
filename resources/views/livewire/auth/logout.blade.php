<?php

use Livewire\Volt\Component;

new class extends Component {
    public function mount()
    {
        auth()->logout();
        redirect('/login');
    }
}; ?>

<div>
</div>
