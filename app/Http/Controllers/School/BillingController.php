<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Show the school's subscription/billing status.
     */
    public function index()
    {
        $school = auth()->user()->school;
        $plans = Plan::active()->get();

        return view('school.billing.index', compact('school', 'plans'));
    }
}
