<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    /**
     * Display a user's public profile page with active links.
     */
    public function show(User $user): View
    {
        $links = $user->links()
            ->where('is_active', true)
            ->orderBy('position')
            ->get();

        return view('public.profile', [
            'user' => $user,
            'links' => $links,
        ]);
    }
}
