<?php

use App\Models\Unit;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    //
    use Toast;

    public $unit;
    public $name, $address, $phone;
    public $active = true;

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->unit = Unit::findOrFail($id);
            $this->fill($this->unit);
            $this->active = $this->unit->active == 1;
        }
    }

    public function save()
    {
        $this->validate();
        if ($this->unit) {
            $this->unit->update($this->all());
            $this->success('Company updated!');
        } else {
            $this->unit = Unit::create($this->all());
            $this->success('unit created!');
            redirect('/units/edit/' . $this->unit->id);
        }
    }

    public function delete()
    {
        $this->unit->delete();
        $this->success('Unit deleted!');
        redirect('/unit');
    }

    public function with()
    {
        return [
            'title' => $this->unit ? 'Edit Unit' : 'Create Unit',
        ];
    }
}; ?>

<div>
    {{-- TODO: Build a form to add a unit. --}}
    {{-- Units are assigned to each company. --}}
    {{-- Each unit will have name, address, number, active/inactive state, company_id, image --}}
    <x-header :title="$title" separator progress-indicator />
    <x-form class="w-96" wire:submit="save">
        <x-input type="text" label="Name" wire:model="name" />
        <x-input type="tel" label="Phone" wire:model="phone" />
        <x-input type="text" label="Address" wire:model="address" />
        <x-toggle label="Active" wire:model="active" class="my-3" />
        <x-button class="btn-primary" type="submit" spinner="save">Save</x-button>
        @if ($unit)
            <x-button class="btn-link text-error flex-1" spinner="delete" wire:confirm wire:click="delete">Delete
            </x-button>
        @endif
    </x-form>
</div>
