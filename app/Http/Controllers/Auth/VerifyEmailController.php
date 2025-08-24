<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

final class VerifyEmailController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {

        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1((string) $user->getEmailForVerification()))) {
            return redirect(config('app.frontend_url').'/verify?status=invalid');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect(config('app.frontend_url').'/verify?status=already_verified');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect(config('app.frontend_url').'/verify?status=success');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Already verified'], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent']);
    }
}
