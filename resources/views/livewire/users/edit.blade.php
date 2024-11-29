<?php

use App\Models\User;
use App\Models\Company;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    use Toast;

    public $user;

    public $name, $email, $phone, $role, $company_id;
    public $active = true;

    public $companies = [];

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'company_id' => 'required',
        'role' => 'required',
    ];

    public function mount($id = null)
    {
        $userRole = auth()->user()->role;
        if ($userRole !== 'Super Admin') {
            $this->companies = [auth()->user()->company];
        } else {
            $this->companies = Company::all();
        }
        if ($id) {
            $this->user = User::findOrFail($id);
            $this->fill($this->user);
            $this->active = $this->user->active == 1;
        }
    }

    public function with()
    {
        $userRole = auth()->user()->role;
        return [
            'title' => $this->user ? 'Edit User' : 'Create User',
            'roles' => collect(['Super Admin', 'Admin', 'Operator', 'Gatekeeper'])->map(function ($role) use ($userRole) {
                $canCreateSuperAdmin = $userRole === 'Super Admin';
                $disabled = false;
                if ($role === 'Super Admin' && !$canCreateSuperAdmin) {
                    $disabled = true;
                }
                return [
                    'id' => $role,
                    'name' => $role,
                    'disabled' => $disabled,
                ];
            }),
            'companies' => collect($this->companies)->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                ];
            }),
        ];
    }

    public function save()
    {
        $this->validate();
        if ($this->user) {
            $this->user->update($this->all());
            $this->success('User updated successfully!');
        } else {
            $this->user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'active' => $this->active,
                'company_id' => $this->company_id,
                'password' => Hash::make($this->email),
            ]);
            $this->success('User created successfully!');
        }
    }
}; ?>

<div>
    <x-header :title="$title" separator progress-indicator />
    <x-form class="w-96" wire:submit="save">
        <x-input placeholder="Required" type="text" wire:model="name" label="Name" />
        <x-input type="email" wire:model="email" label="Email" :readonly="$user != null" placeholder="Required" />
        <x-input type="phone" wire:model="phone" label="Phone" placeholder="Required" />
        <x-select wire:model="role" label="Role" :options="$roles" placeholder="Select role" />
        <x-select wire:model="company_id" label="Company" :options="$companies" placeholder="Select company" />
        <x-toggle wire:model="active" class="my-3" label="Active" />
        <x-button type="submit" spinner="save" class="btn-primary">Save</x-button>
    </x-form>
</div>
