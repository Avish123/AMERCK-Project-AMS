<?php

use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public $users = [];

    public function mount()
    {
        $authUser = auth()->user();
        $role = $authUser->role;
        if ($role == 'Super Admin') {
            $this->users = User::all();
        } else {
            $this->users = $authUser->company->users->filter(function ($user) {
                return $user->role !== 'Super Admin';
            });
        }
    }

    public function edit($user)
    {
        redirect('/users/edit/' . $user['id']);
    }
    public function create()
    {
        redirect('/users/new');
    }
}; ?>

<div>
    <x-header title="Users" separator progress-indicator>
        <x-slot:actions>
            <x-button class="btn-primary" wire:click="create">Create</x-button>
        </x-slot:actions>
    </x-header>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($users as $user)
        <x-card class="shadow border hover:bg-green-50 cursor-pointer" :title="$user->name"
            wire:click="edit({{ $user }})">
            <p>📧 {{ $user->email }}</p>
            <p>📞 {{ $user->phone }}</p>
            <p>👤 {{ $user->role }}</p>
            <p>🏢 {{$user->name}}</p>
            @if ($user->active == 1)
            <x-badge value="Active" class="bg-success text-white" />
            @else
            <x-badge value="Inactive" class="bg-error text-white" />
            @endif
        </x-card>
        @endforeach
    </div>
</div>