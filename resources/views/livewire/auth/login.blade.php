<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $email, $password;
    protected $rules = [
        'email' => 'email|required',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();
        try {
            $existing = User::where('email', $this->email)->first();
            if ($existing) {
                if (Hash::check($this->password, $existing['password'])) {
                    if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
                        $role = $existing->role;
                        if ($role === 'Super Admin') {
                            return redirect('/companies');
                        } else {
                            return redirect('/users');
                        }
                    }
                } else {
                    throw new Exception('Incorrect password!');
                }
            } else {
                throw new Exception('Email not found!');
            }
        } catch (Exception $error) {
            $this->error($error->getMessage());
        }
    }

    public function rendering($view)
    {
        $view->layout('components/layouts/guest');
        $view->title('Login');
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-500">
    <x-card class="shadow border w-96">
        <x-form wire:submit="login">
            <h1 class="text-2xl font-bold">Login</h1>
            <x-input type="email" placeholder="Required!" label="Email" wire:model="email" />
            <x-input type="password" placeholder="Required!" wire:model="password" label="Password" />
            <x-button type="submit" class="btn-primary" spinner="login">Login</x-button>
        </x-form>
    </x-card>
</div>
