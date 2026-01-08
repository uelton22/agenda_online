<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ApiTokenController extends Controller
{
    /**
     * Display a listing of tokens.
     */
    public function index()
    {
        $tokens = auth()->user()->tokens()->orderBy('created_at', 'desc')->get();
        
        return view('admin.api.tokens', compact('tokens'));
    }

    /**
     * Store a newly created token.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'expires_at' => ['nullable', 'in:7,30,60,90,365,never'],
        ], [
            'name.required' => 'O nome do token é obrigatório.',
        ]);

        // Calculate expiration
        $expiresAt = null;
        if ($request->expires_at && $request->expires_at !== 'never') {
            $expiresAt = now()->addDays((int) $request->expires_at);
        }

        // Create token
        $token = auth()->user()->createToken(
            $request->name,
            ['*'],
            $expiresAt
        );

        return redirect()
            ->route('admin.api.tokens')
            ->with('success', 'Token criado com sucesso!')
            ->with('newToken', $token->plainTextToken)
            ->with('tokenName', $request->name);
    }

    /**
     * Remove the specified token.
     */
    public function destroy($tokenId)
    {
        $token = auth()->user()->tokens()->where('id', $tokenId)->first();

        if (!$token) {
            return back()->with('error', 'Token não encontrado.');
        }

        $token->delete();

        return back()->with('success', 'Token revogado com sucesso!');
    }

    /**
     * Display API documentation.
     */
    public function documentation()
    {
        return view('admin.api.documentation');
    }
}

