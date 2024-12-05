<?php

use App\Models\Company;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $company;
    public $name, $address, $email, $phone, $description;
    public $active = true;

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'description' => 'required',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->company = Company::findOrFail($id);
            $this->fill($this->company);
            $this->active = $this->company->active == 1;
        }
    }

    public function save()
    {
        $this->validate();
        if ($this->company) {
            $this->company->update($this->all());
            $this->success('Company updated!');
        } else {
            $this->company = Company::create($this->all());
            $this->success('Company created!');
            redirect('/companies/edit/' . $this->company->id);
        }
    }

    public function delete()
    {
        $this->company->delete();
        $this->success('Company deleted!');
        redirect('/companies');
    }

    public function with()
    {
        return [
            'title' => $this->company ? 'Edit Company' : 'Create Company',
        ];
    }
}; ?>

<div>
    <x-header :title="$title" separator progress-indicator />
    <x-form class="w-96" wire:submit="save">
        <x-input type="text" label="Name" wire:model="name" />
        <x-input type="email" label="Email" wire:model="email" />
        <x-input type="tel" label="Phone" wire:model="phone" />
        <x-input type="text" label="Address" wire:model="address" />
        <x-input type="text" label="Description" wire:model="description" />
        <x-toggle label="Active" wire:model="active" class="my-3" />
        <x-button class="btn-primary" type="submit" spinner="save">Save</x-button>
        @if ($company)
            <x-button class="btn-link text-error flex-1" spinner="delete" wire:confirm wire:click="delete">Delete
            </x-button>
        @endif
    </x-form>
</div>
