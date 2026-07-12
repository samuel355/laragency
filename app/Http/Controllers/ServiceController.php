<?php

namespace App\Http\Controllers;

use App\Models\AgencyService;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function show(AgencyService $service): View
    {
        abort_unless($service->is_active, 404);

        return view('services.show', [
            'service' => $service,
            'otherServices' => AgencyService::where('is_active', true)->where('id', '!=', $service->id)->orderBy('sort_order')->get(),
        ]);
    }
}
