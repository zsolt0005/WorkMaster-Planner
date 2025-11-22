<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

abstract class AController
{
    protected function flashSuccess(string $message): void
    {
        $this->flash('success', $message);
    }

    protected function flashError(string $message): void
    {
        $this->flash('danger', $message);
    }

    protected function flashWarning(string $message): void
    {
        $this->flash('warning', $message);
    }

    protected function flashInfo(string $message): void
    {
        $this->flash('info', $message);
    }

    protected function flash(string $type, string $message): void
    {
        $flashes = Session::get('flash', []);
        $flashes[] = ['type' => $type, 'message' => $message];

        Session::flash('flash', $flashes);
    }

    protected function getAuthUser(): User
    {
        /** @var User|null $user */
        $user = auth()->user();
        if($user === null) {
            Redirect::route('login');
        }

        return $user;
    }
}
