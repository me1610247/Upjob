<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // First check if the user is authenticated
        if (!Auth::check()) {
            // If not logged in, redirect to the login page
            return redirect()->route('account.login')->with('error', 'You need to log in.');
        }

        // Now check if the authenticated user is an admin
        if ($request->user()->role != 'admin') {
            session()->flash('error', 'You are not authorized to access this page.');
            return redirect()->back();
        }

        // If the user is an admin, allow them to proceed
        return $next($request);
    }
}
