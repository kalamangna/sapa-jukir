<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $action = $request->input('action');
        $type = $request->input('type');
        $userId = $request->input('user_id');

        $logs = AuditLog::query()
            ->with('user')
            ->when($action, fn ($query) => $query->where('action', $action))
            ->when($type, fn ($query) => $query->where('auditable_type', $type))
            ->when($userId, fn ($query) => $query->where('user_id', $userId))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $users = AuditLog::query()
            ->whereNotNull('user_id')
            ->with('user:id,name')
            ->get()
            ->pluck('user')
            ->filter()
            ->unique('id')
            ->sortBy('name');

        $types = AuditLog::query()
            ->select('auditable_type')
            ->distinct()
            ->orderBy('auditable_type')
            ->pluck('auditable_type');

        return view('admin.audit-logs.index', compact('logs', 'users', 'types', 'action', 'type', 'userId'));
    }
}