<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::where('user_id', $user->id)->latest()->get();
        return view('profile.index', compact('user', 'invoices'));
    }
}