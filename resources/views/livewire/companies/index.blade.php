<?php

use App\Models\Company;
use Livewire\Volt\Component;

new class extends Component {
    public $companies = [];

    public function mount(): void
    {
        $this->companies = Company::all();
    }

    public function edit($company)
    {
        $id = $company['id'];
        redirect('companies/edit/' . $id);
    }

    public function create()
    {
        redirect('companies/new');
    }
}; ?>

<div>
    <x-header title="Companies" separator progress-indicator>
        <x-slot:actions>
            <x-button class="btn-primary" wire:click="create">Create</x-button>
        </x-slot:actions>
    </x-header>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($companies as $company)
            <x-card :title="$company->name" class="border shadow-sm cursor-pointer hover:bg-primary/10"
                wire:click="edit({{ $company }})">
                <p>📍 {{ $company->address }}</p>
                <p>📧 {{ $company->email }}</p>
                <p>📞 {{ $company->phone }}</p>
                <p>📝{{$company->description}}</p>
                @if ($company->active == 1)
                    <x-badge value="Active" class="bg-success text-white" />
                @else
                    <x-badge value="Inactive" class="bg-error text-white" />
                @endif
            </x-card>
        @endforeach
    </div>
</div>
