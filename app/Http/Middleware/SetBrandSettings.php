<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SetBrandSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $brand = $request->user()?->brand;

        if (!$brand) {
            return $next($request);
        }

        if ($brand?->primary_color) {
            FilamentColor::register([
                'primary' => $brand?->primary_color,
            ]);
        }

        if ($brand?->secondary_color) {
            FilamentColor::register([
                'secondary' => $brand?->secondary_color,
            ]);
        }

        try {
            $logoUrl = $brand?->logo ? Storage::url($brand?->logo) : null;
        } catch (\InvalidArgumentException $e) {
            $logoUrl = null;
            report($e);
        }

        $panel = filament()->getPanel('user')
            ->brandName($brand?->name)
            ->brandLogo($logoUrl);

        return $next($request);
    }
}
