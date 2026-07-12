<?php

namespace App\Http\Controllers;

use App\Models\AgencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => AgencyService::orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.services.form', ['service' => new AgencyService()]);
    }

    public function store(Request $request): RedirectResponse
    {
        AgencyService::create($this->validated($request));

        return redirect()->route('admin.services.index')->with('status', 'Service created.');
    }

    public function edit(AgencyService $service): View
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, AgencyService $service): RedirectResponse
    {
        $service->update($this->validated($request));

        return redirect()->route('admin.services.index')->with('status', 'Service updated.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'summary' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
