<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = auth()->user();

        $product = $request->route('product');

        if ($product) {
            $hasUserAccess = $user->products()->where('products.id', $product->id)->exists();

            $teamIds = $user->teams->pluck('id');

            $hasTeamAccess = $product->teams()->whereIn('teams.id', $teamIds)->exists();
        } else {
            $hasUserAccess = false;
            $hasTeamAccess = false;
        }

        if ($permission) {
            $hasPermission = $user->roles->contains(function ($role) use ($permission) {
                return $role->hasPermissionTo($permission);
            });
        } else {
            $hasPermission = false;
        }
        if ($hasUserAccess || $hasTeamAccess || $hasPermission) {
            return $next($request);
        }

        return response()->json(['message' => 'Access Denied'], 403);
    }
}
