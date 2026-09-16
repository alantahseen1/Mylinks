<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LinkController extends Controller
{
    /**
     * Display the authenticated user's links.
     */
    public function index(Request $request): View
    {
        $links = $request->user()
            ->links()
            ->orderBy('position')
            ->get();

        return view('links.index', ['links' => $links]);
    }

    /**
     * Show the form for creating a new link.
     */
    public function create(): View
    {
        return view('links.create');
    }

    /**
     * Store a newly created link.
     */
    public function store(StoreLinkRequest $request): RedirectResponse
    {
        $maxPosition = $request->user()->links()->max('position') ?? -1;

        $request->user()->links()->create([
            ...$request->validated(),
            'position' => $maxPosition + 1,
        ]);

        return redirect()->route('links.index')->with('status', 'link-created');
    }

    /**
     * Show the form for editing a link.
     */
    public function edit(Link $link): View
    {
        Gate::authorize('update', $link);

        return view('links.edit', ['link' => $link]);
    }

    /**
     * Update the specified link.
     */
    public function update(UpdateLinkRequest $request, Link $link): RedirectResponse
    {
        Gate::authorize('update', $link);

        $link->update($request->validated());

        return redirect()->route('links.index')->with('status', 'link-updated');
    }

    /**
     * Remove the specified link.
     */
    public function destroy(Link $link): RedirectResponse
    {
        Gate::authorize('delete', $link);

        $link->delete();

        return redirect()->route('links.index')->with('status', 'link-deleted');
    }

    /**
     * Toggle a link's active/inactive state.
     */
    public function toggleActive(Link $link): RedirectResponse
    {
        Gate::authorize('toggle', $link);

        $link->update(['is_active' => ! $link->is_active]);

        return redirect()->route('links.index')->with('status', 'link-toggled');
    }

    /**
     * Reorder links by updating their position values.
     *
     * Expects request body: { "ids": [3, 1, 5, 2, ...] }
     */
    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'integer'],
        ]);

        $user = $request->user();
        $linkIds = $user->links()->pluck('id');

        foreach ($request->input('ids') as $position => $id) {
            if (! $linkIds->contains($id)) {
                abort(403);
            }

            Link::where('id', $id)->update(['position' => $position]);
        }

        return redirect()->route('links.index')->with('status', 'links-reordered');
    }
}
