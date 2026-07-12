<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContentController extends Controller
{
    public function index(): View
    {
        return view('admin.content.index', ['contents' => SiteContent::orderBy('key')->get()]);
    }

    public function edit(SiteContent $content): View
    {
        return view('admin.content.form', compact('content'));
    }

    public function update(Request $request, SiteContent $content): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
        ]);

        $content->update($data);

        return redirect()->route('admin.content.index')->with('status', 'Content updated.');
    }
}
