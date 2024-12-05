<?php

use App\Models\Unit;
use App\Models\Company;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $unit;
    public $name, $address, $phone, $company_id;
    public $active = true;
    public $companies = [];

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'company_id' => 'required|exists:companies,id',
    ];

    public function mount($id = null)
    {
        // Fetch all companies for the dropdown
        $this->companies = Company::all()->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
            ];
        })->toArray();

        if ($id) {
            $this->unit = Unit::findOrFail($id);
            $this->fill($this->unit);
            $this->active = $this->unit->active == 1;
        }
    }

    public function updatedCompanyId()
    {
        $this->validateOnly('company_id');
    }

    public function save()
    {
        $this->validate();

        if ($this->unit) {
          
            $this->unit->update([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'company_id' => $this->company_id,
                'active' => $this->active,
            ]);
            $this->success('Unit updated!');
        } else {
            
            $this->unit = Unit::create([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'company_id' => $this->company_id,
                'active' => $this->active,
            ]);
            $this->success('Unit created!');
            redirect('/units/edit/' . $this->unit->id);
        }
    }

    public function delete()
    {
        $this->unit->delete();
        $this->success('Unit deleted!');
        redirect('/units');
    }

    public function with()
    {
        return [
            'title' => $this->unit ? 'Edit Unit' : 'Create Unit',
            'companies' => $this->companies, 
        ];
    }
};
?>

<div>
   
    <x-header :title="$title" separator progress-indicator />

    <x-form class="w-96" wire:submit="save">
        <x-input type="text" label="Name" wire:model="name" />

        <x-select 
            wire:model="company_id" 
            label="Company" 
            :options="$companies" 
            option-label="name" 
            option-value="id" 
            placeholder="Select company" 
        />

        @error('company_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <x-input type="tel" label="Phone" wire:model="phone" />
        <x-input type="text" label="Address" wire:model="address" />
        <x-toggle label="Active" wire:model="active" class="my-3" />

        <x-button class="btn-primary" type="submit" spinner="save">Save</x-button>

        @if ($unit)
            <x-button 
                class="btn-link text-error flex-1" 
                spinner="delete" 
                wire:confirm 
                wire:click="delete">
                Delete
            </x-button>
        @endif
    </x-form>
</div>
