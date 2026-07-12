<?php

namespace App\Support;

use App\Models\Parcel;
use Illuminate\Support\Str;
use RuntimeException;

class SampleParcelImport
{
    public function import(string $path): int
    {
        if (! is_file($path)) {
            return 0;
        }

        $collection = $this->readFeatureCollection($path);
        $count = 0;

        foreach ($collection['features'] ?? [] as $feature) {
            $properties = $feature['properties'] ?? [];
            $projectArea = 'Demarcated Parcel Area';
            $objectId = (string) ($properties['OBJECTID'] ?? '');
            $plotNo = (string) ($properties['Plot_No'] ?? $objectId);
            $street = trim((string) ($properties['Street_Nam'] ?? 'Unnamed Street'));
            $status = $this->normalizeStatus((string) ($properties['Status'] ?? 'available'));
            $title = trim("Plot {$plotNo} - ".Str::title($street));

            Parcel::updateOrCreate(
                ['plot_number' => $this->plotNumber($street, $plotNo, $objectId)],
                [
                    'title' => $title,
                    'location_name' => $projectArea,
                    'price' => 0,
                    'currency' => 'GHS',
                    'area_sqm' => (float) ($properties['Area'] ?? 0),
                    'status' => $status,
                    'geometry' => $feature['geometry'],
                    'attributes' => [
                        ...$properties,
                        'project_area' => $projectArea,
                        'source_status' => $properties['Status'] ?? null,
                        'status_label' => $this->statusLabel($status),
                        'status_color' => $this->statusColor($status),
                    ],
                ]
            );

            $count++;
        }

        return $count;
    }

    private function readFeatureCollection(string $path): array
    {
        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException("Unable to read {$path}");
        }

        $contents = preg_replace('/^\s*export\s+const\s+parcels\s*=\s*/', '', $contents) ?? $contents;
        $contents = preg_replace('/;\s*$/', '', trim($contents)) ?? $contents;
        $contents = preg_replace('/([{\[,]\s*)([A-Za-z_][A-Za-z0-9_]*):/', '$1"$2":', $contents) ?? $contents;
        $contents = preg_replace('/,\s*([}\]])/', '$1', $contents) ?? $contents;

        $decoded = json_decode($contents, true);

        if (! is_array($decoded)) {
            throw new RuntimeException('sample-parcel.js could not be converted to JSON: '.json_last_error_msg());
        }

        return $decoded;
    }

    private function plotNumber(string $street, string $plotNo, string $objectId): string
    {
        $prefix = Str::upper(Str::slug($street ?: 'plot'));

        return "{$prefix}-{$plotNo}-{$objectId}";
    }

    private function normalizeStatus(string $status): string
    {
        return match (Str::lower(trim($status))) {
            's', 'sold' => 'sold',
            'r', 'reserved' => 'reserved',
            'h', 'hold', 'on hold', 'on_hold', 'c' => 'on_hold',
            default => 'available',
        };
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'sold' => 'Sold',
            'reserved' => 'Reserved',
            'on_hold' => 'On hold',
            default => 'Available',
        };
    }

    private function statusColor(string $status): string
    {
        return match ($status) {
            'sold' => '#e3342f',
            'reserved' => '#071f49',
            'on_hold' => '#808080',
            default => '#16a34a',
        };
    }
}
