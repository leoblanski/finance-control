<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SetTeamSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $team = $request->user()?->team;

        if (!$team) {
            return $next($request);
        }

        if ($team?->primary_color) {
            FilamentColor::register([
                'primary' => $team?->primary_color,
            ]);
        }

        if ($team?->secondary_color) {
            FilamentColor::register([
                'secondary' => $team?->secondary_color,
            ]);
        }

        try {
            $logoUrl = $team?->logo ? Storage::url($team?->logo) : null;
        } catch (\InvalidArgumentException $e) {
            $logoUrl = null;
            report($e);
        }

        $panel = filament()->getPanel('user');
        // ->brandName($team?->name)
        // ->teamLogo($logoUrl);

        return $next($request);
    }
}
