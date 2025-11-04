<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Track;
use App\Models\ReferralLog;
use App\Models\WithdrawalHistory;
use App\Models\UserSession;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MembersController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');

        $query = $this->getUsersByStatus('active');

        if ($filter === 'online') {
            $query->where('updated_at', '>=', Carbon::now()->subMinutes(env('SESSION_LIFETIME')));
        }

        $users = $query->paginate(15);

        if ($filter === 'online' && $users->isEmpty()) {
            $query = $this->getUsersByStatus('active')
                ->orderBy('updated_at', 'desc');
            $users = $query->paginate(15);
        }

        foreach ($users as $user) {
            $user->statusMessage = $this->formatLastSeen($user->updated_at);
            $user->badgeClass = $this->getBadgeClass($user->updated_at);
        }

        return view('admin.members.index', compact('users'));
    }

    private function getUsersByStatus($status)
    {
        return User::select('uid', 'name', 'email', 'status', 'country_code', 'updated_at')
            ->where('status', $status)
            ->orderBy('created_at', 'desc');
    }

    private function formatLastSeen($updatedAt)
    {
        $now = Carbon::now();
        $diffInMinutes = $now->diffInMinutes($updatedAt);
        $diff = abs((int) $diffInMinutes);

        if ($diff < env('SESSION_LIFETIME')) {
            return "Online";
        } elseif ($diff < 60) {
            return "Last seen {$diff} minute" . ($diff > 1 ? 's' : '') . " ago";
        } elseif ($diff < 1440) {
            $hours = intdiv($diff, 60);
            return "Last seen {$hours} hour" . ($hours > 1 ? 's' : '') . " ago";
        } elseif ($diff < 10080) {
            $days = intdiv($diff, 1440);
            return "Last seen {$days} day" . ($days > 1 ? 's' : '') . " ago";
        } elseif ($diff < 44640) {
            $weeks = intdiv($diff, 10080);
            return "Last seen {$weeks} week" . ($weeks > 1 ? 's' : '') . " ago";
        } elseif ($diff < 525600) {
            $months = intdiv($diff, 43800);
            return "Last seen {$months} month" . ($months > 1 ? 's' : '') . " ago";
        } else {
            $years = intdiv($diff, 525600);
            return "Last seen {$years} year" . ($years > 1 ? 's' : '') . " ago";
        }
    }

    private function getBadgeClass($updatedAt)
    {
        $diffInMinutes = Carbon::now()->diffInMinutes($updatedAt);
        $diff = abs((int) $diffInMinutes);

        if ($diff < env('SESSION_LIFETIME')) {
            return 'bg-green-lt';
        }


        return 'bg-yellow-lt';
    }

    public function banned()
    {
        $query = $this->getUsersByStatus('banned');
        $users = $query->paginate(15);
        return view('admin.members.banned', compact('users'));
    }


    public function info($uid)
    {
        $user = User::with('invitedBy:id,uid')
            ->where('uid', $uid)
            ->firstOrFail();

        $referredBy = $user->invitedBy->uid ?? 'None';
        $invitedCount = User::where('invited_by', $user->id)->count();

        $activities = Track::where('uid', $user->uid)
            ->where('reward', '>', 0)
            ->paginate(15);

        $withdrawals = WithdrawalHistory::where('user_id', $user->id)
            ->with('category')
            ->paginate(15);

        $referrals = ReferralLog::where('referrer_id', $user->id)
            ->with('referredUser:id,uid,name,email,country_code')
            ->paginate(15);

        return view('admin.members.info', compact(
            'user',
            'referredBy',
            'activities',
            'withdrawals',
            'referrals',
            'invitedCount'
        ));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'pass' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'],
            'password' => $request->filled('pass') ? Hash::make($validated['pass']) : $user->password,
        ]);

        return back()->with('success', 'User updated successfully.');
    }

    public function changeStatus(Request $request, $id, $action)
    {
        $user = User::findOrFail($id);

        if ($action === 'ban') {
            $user->status = 'banned';
            $message = 'User has been banned successfully.';
        } elseif ($action === 'unban') {
            $user->status = 'active';
            $message = 'User has been unbanned successfully.';
        } else {
            return back()->with('error', 'Invalid action.');
        }
        $user->save();

        return back()->with('success', $message);
    }

    public function addBalance(Request $request, $id)
    {
        $validatedData = $request->validate([
            'balance' => 'required|numeric',
        ]);

        $user = User::findOrFail($id);
        $user->balance += $validatedData['balance'];
        $user->save();

        return back()->with('success', 'Balance added successfully.');
    }

    public function deductBalance(Request $request, $id)
    {
        $validatedData = $request->validate([
            'balance' => 'required|numeric',
        ]);

        $user = User::findOrFail($id);

        $user->balance -= $validatedData['balance'];

        $user->save();

        return back()->with('success', 'Balance deducted successfully.');
    }








}
