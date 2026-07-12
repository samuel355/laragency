<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('team.index', [
            'members' => TeamMember::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function show(TeamMember $member): View
    {
        abort_unless($member->is_active, 404);

        return view('team.show', compact('member'));
    }
}
