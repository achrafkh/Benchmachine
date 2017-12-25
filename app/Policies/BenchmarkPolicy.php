<?php

namespace App\Policies;

use App\Benchmark;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BenchmarkPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function view(User $user, Benchmark $benchmark)
    {
        return $user->id === $benchmark->user_id;
    }

    public function delete(User $user, Benchmark $benchmark)
    {
        return $user->id === $benchmark->user_id;
    }
}
