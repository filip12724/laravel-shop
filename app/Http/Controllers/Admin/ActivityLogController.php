<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($action = $request->get('action')) {
            $query->where('action', $action);
        }

        $logs    = $query->orderByDesc('created_at')->paginate(25)->withQueryString();
        $actions = ActivityLog::distinct()->pluck('action')->sort()->values();

        return view('admin.logs.index', compact('logs', 'actions'));
    }
}
