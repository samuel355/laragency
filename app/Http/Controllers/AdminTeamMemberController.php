<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminTeamMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.team.index', [
            'members' => TeamMember::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.team.form', ['member' => new TeamMember()]);
    }

    public function store(Request $request): RedirectResponse
    {
        TeamMember::create($this->validated($request));

        return redirect()->route('admin.team.index')->with('status', 'Team member created.');
    }

    public function edit(TeamMember $team): View
    {
        return view('admin.team.form', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $team->update($this->validated($request));

        return redirect()->route('admin.team.index')->with('status', 'Team member updated.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'role' => ['required', 'string', 'max:180'],
            'bio' => ['required', 'string'],
            'email' => ['nullable', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:80'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'social_links' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['social_links'] = array_values(array_filter(array_map('trim', explode("\n", $data['social_links'] ?? ''))));
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
