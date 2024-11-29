<?php

use Livewire\Volt\Volt;

Volt::route('/', 'users.index')->middleware(['auth']);
Volt::route('/login', 'auth.login')->name('login');
Volt::route('/logout', 'auth.logout')->name('logout');
Volt::route('/companies', 'companies.index')->middleware(['auth']);
Volt::route('/companies/edit/{id}', 'companies.edit')->middleware(['auth']);
Volt::route('/companies/new', 'companies.edit')->middleware(['auth']);
Volt::route('/users', 'users.index')->middleware(['auth']);
Volt::route('/users/edit/{id}', 'users.edit')->middleware(['auth']);
Volt::route('/users/new', 'users.edit')->middleware(['auth']);
Volt::route('/units', 'units.index')->middleware(['auth'])->name('units.index');
Volt::route('/units/edit/{id}', 'units.edit')->middleware(['auth']);
Volt::route('/units/new', 'units.edit')->middleware(['auth'])->name('units.new');
