<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\InviteUserRequest;
use App\Models\Company;
use App\Models\User;

class InvitationController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        if (auth()->user()->hasRole('Admin')) {
            $invitedUsers = User::with('company', 'roles')
                ->where('company_id', auth()->user()->company_id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
             $invitedUsers = User::with('company', 'roles')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('invitations.index', compact('invitedUsers'));
    }

    public function create()
    {
        $this->authorize('viewAny', User::class);

        $user = auth()->user();
        $companies = $user->hasRole('SuperAdmin') 
            ? Company::orderBy('name')->get()
            : Company::where('id', $user->company_id)->get();

        $roles = $user->hasRole('SuperAdmin') 
            ? ['Admin', 'Member']
            : ['Admin', 'Member'];

        return view('invitations.create', compact('companies', 'roles'));
    }

    public function store(InviteUserRequest $request)
    {
        $this->authorize('invite', [User::class, $request->role, $request->company_id]);

        $user = User::create([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('invitations.index')
            ->with('success', 'User invitation created successfully.');
    }
}
