<?php

namespace App\Http\Controllers;

use App\Models\DemoLead;
use Illuminate\Http\Request;

class WebsiteLeadAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q'));

        $leads = DemoLead::query()
            ->when(in_array($status, ['new', 'contacted', 'closed'], true), fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.website-leads', [
            'leads' => $leads,
            'status' => $status,
            'search' => $search,
            'total' => DemoLead::count(),
            'newCount' => DemoLead::where('status', 'new')->count(),
            'contactedCount' => DemoLead::where('status', 'contacted')->count(),
            'closedCount' => DemoLead::where('status', 'closed')->count(),
        ]);
    }

    public function updateStatus(Request $request, DemoLead $lead)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,closed'],
        ]);

        $lead->update($validated);

        return back()->with('success', 'Lead status updated.');
    }

    public function destroy(DemoLead $lead)
    {
        $lead->delete();

        return back()->with('success', 'Lead deleted.');
    }
}
