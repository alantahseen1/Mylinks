<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    /**
     * Display a user's public profile page with active links.
     */
    public function show(Request $request, User $user): View
    {
        if (! $request->user()?->is($user)) {
            $user->increment('profile_views');
        }

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
