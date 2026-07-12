<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminParcelController extends Controller
{
    public function index(): View
    {
        return view('admin.parcels.index', [
            'parcels' => Parcel::query()->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.parcels.form', ['parcel' => new Parcel()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Parcel::create($this->validated($request));

        return redirect()->route('admin.parcels.index')->with('status', 'Parcel created.');
    }

    public function edit(Parcel $parcel): View
    {
        return view('admin.parcels.form', compact('parcel'));
    }

    public function update(Request $request, Parcel $parcel): RedirectResponse
    {
        $parcel->update($this->validated($request));

        return redirect()->route('admin.parcels.index')->with('status', 'Parcel updated.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'plot_number' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:160'],
            'location_name' => ['required', 'string', 'max:160'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'area_sqm' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,reserved,sold,on_hold'],
            'geometry' => ['required', 'json'],
            'attributes' => ['nullable', 'json'],
        ]);

        $data['geometry'] = json_decode($data['geometry'], true);
        $data['attributes'] = filled($data['attributes'] ?? null)
            ? json_decode($data['attributes'], true)
            : null;

        return $data;
    }
}
