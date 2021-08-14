<?php

namespace App\Http\Middleware;

use App\Services\RoleAndPriviledgeService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $roleAndPriviledgeService = App::make(RoleAndPriviledgeService::class);
        if (!$roleAndPriviledgeService->user(auth()->user())->hasPermission($permission)) {
            return response()->json(["message", "Unauthorized: User must have permission $permission"], 403);
        }
        return $next($request);
    }
}
