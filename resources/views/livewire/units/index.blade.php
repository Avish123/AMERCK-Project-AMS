<?php
use App\Models\Unit;
use Livewire\Volt\Component;

new class extends Component {
    public $units = [];
    public function mount()
    {
        $this-> units = Unit::all();
    }
    public function onAdd()
    {
        redirect(route('units.new'));
    }
   
        public function edit($unit)
        {
            $id = $unit['id'];
            redirect('units/edit/' . $id);
        }
    
        public function create()
        {
            redirect('units/new');
        }
    
}; ?>

<div>
    <x-header title="Units" seperator progress-indicator>
        <x-slot:actions>
            <x-button class="btn-primary" wire:click="onAdd">Add Unit</x-button>
        </x-slot:actions>
    </x-header>
    {{-- Add a list of units here --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($units as $unit)
            <x-card :title="$unit->name" class="border shadow-sm cursor-pointer hover:bg-primary/10"
                wire:click="edit({{ $unit }})">
                <p> {{ $unit->name }}</p>
                <p>📞 {{ $unit->phone }}</p>
                <p>📍 {{ $unit->address }}</p>
                 @if ($unit->active == 1)
                    <x-badge value="Active" class="bg-success text-white" />
                @else
                    <x-badge value="Inactive" class="bg-error text-white" />
                @endif
            </x-card>
        @endforeach
    </div>
</div>

