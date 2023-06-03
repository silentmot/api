<?php

namespace Tests;

use Afaqy\Role\Models\Role;
use Afaqy\User\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $users;

    public function generateUsers($count = 2, $data = [])
    {
        $this->users = factory(User::class, $count)->create($data);

        return $this;
    }

    public function generateUser($data = [])
    {
        $this->users = $this->generateUsers(1, $data)->apply()->first();

        return $this;
    }

    public function createUsers($count = 2, $role = 'administrator', $data = [])
    {
        $users = $this->generateUsers($count, $data)->apply();

        $this->storeRole($role);

        $users->each(function ($user) use ($role) {
            $user->attachRole($role);
        });

        $this->users = ($count == 1) ? $users->first() : $users;

        return $this->apply();
    }

    public function createUser($role = 'administrator', $data = [])
    {
        return $this->createUsers(1, $role, $data);
    }

    public function createOwner($data = [])
    {
        return $this->createUser('owner', $data);
    }

    public function createAdmin($data = [])
    {
        return $this->createUser('administrator', $data);
    }

    public function storeRole($role)
    {
        return factory(Role::class)->create([
            'name'         => Str::slug($role, '-'),
            'display_name' => $role,
            'description'  => 'The site ' . $role
        ]);
    }

    public function apply()
    {
        return $this->users;
    }

    public function dd($response)
    {
        dd(json_decode($response->getContent(), true));
    }
}
