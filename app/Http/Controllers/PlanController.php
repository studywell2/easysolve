<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Public pricing page — shows all active plans.
     */
    public function index()
    {
        $plans = Plan::active()->get();

        return view('plans.index', compact('plans'));
    }
}
