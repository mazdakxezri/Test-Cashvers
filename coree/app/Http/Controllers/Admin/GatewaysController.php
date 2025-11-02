<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalCategory;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\WithdrawalSubCategory;
use App\Models\WithdrawalHistory;
use App\Lib\FileManagement;
use App\Jobs\SendGenericEmail;
use App\Models\EmailTemplate;

class GatewaysController extends Controller
{
    private $fileManager;

    public function __construct(FileManagement $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function index()
    {
        $withdrawalsCategories = WithdrawalCategory::all();
        return view('admin.gateways', ['withdrawalsCategories' => $withdrawalsCategories]);
    }


    public function store(Request $request)
    {

        $validatedData = $this->validateStoreRequest($request);
        if ($this->categoryExists($validatedData['name'])) {
            return redirect()->back()->with('error', 'Withdrawal category already exists.');
        }

        $coverPath = $this->storeCover($request);
        $rewardImage = $this->storeRewardImage($request);

        $category = WithdrawalCategory::create([
            'name' => $validatedData['name'],
            'withdrawal_type' => $validatedData['withdrawal_type'],
            'cover' => $coverPath,
            'minimum' => $validatedData['minimum'],
            'reward_img' => $rewardImage,
            'bg_color' => $validatedData['bg_color'],
        ]);



        return redirect()->back()->with('success', 'Withdrawal category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateUpdateRequest($request);

        $category = WithdrawalCategory::findOrFail($id);

        if ($this->categoryNameChanged($category, $validatedData['name'])) {
            if ($this->categoryExists($validatedData['name'])) {
                return redirect()->back()->with('error', 'Withdrawal category name already exists.');
            }
            $category->name = $validatedData['name'];
        }

        if ($request->hasFile('cover')) {
            $this->updateCover($category, $request);
        }

        if ($request->hasFile('reward_img')) {
            $this->updateRewardImage($category, $request);
        }


        $category->minimum = $validatedData['minimum'];
        $category->bg_color = $validatedData['bg_color'] ?? $category->bg_color;
        $category->save();

        return redirect()->back()->with('success', 'Withdrawal category updated successfully.');
    }

    public function destroy($id)
    {
        $category = WithdrawalCategory::findOrFail($id);

        $this->deleteCover($category);
        $this->deleteRewardImage($category);

        $category->delete();

        return redirect()->back()->with('success', 'Withdrawal category deleted successfully.');
    }

    // Private Methods

    private function validateStoreRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'withdrawal_type' => 'required|in:cash,gift_card,skins,crypto',
            'cover' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
            'minimum' => 'nullable|numeric|min:0.01',
            'reward_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'bg_color' => 'nullable|string|max:255',
        ]);
    }

    private function validateUpdateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'withdrawal_type' => 'required|in:cash,gift_card,skins,crypto',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
            'minimum' => 'nullable|numeric|min:0.01',
            'reward_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'bg_color' => 'nullable|string|max:255',
        ]);
    }

    private function categoryExists($name)
    {
        return WithdrawalCategory::where('name', $name)->exists();
    }

    private function storeCover(Request $request)
    {
        return $request->hasFile('cover')
            ? $this->fileManager->uploadImage($request->file('cover'), 'gateways')
            : null; // Return null if no file was uploaded
    }


    private function updateCover($category, Request $request)
    {
        if ($category->cover) {
            $this->fileManager->delete($category->cover);
        }

        $category->cover = $this->fileManager->uploadImage($request->file('cover'), 'gateways');
    }



    private function deleteCover($category)
    {
        if ($category->cover) {
            $this->fileManager->delete($category->cover);
        }
    }


    private function storeRewardImage(Request $request)
    {
        return $request->hasFile('reward_img')
            ? $this->fileManager->uploadImage($request->file('reward_img'), 'reward')
            : null;
    }


    private function updateRewardImage($category, Request $request)
    {
        if ($category->reward_img) {
            $this->fileManager->delete($category->reward_img);
        }

        $category->reward_img = $this->fileManager->uploadImage($request->file('reward_img'), 'reward');
    }

    private function deleteRewardImage($category)
    {
        if ($category->reward_img) {
            $this->fileManager->delete($category->reward_img);
        }
    }

    private function categoryNameChanged($category, $name)
    {
        return $category->name !== $name;
    }

    //items Controllers
    public function addItems($categoryId)
    {
        $withdrawalsCategory = WithdrawalCategory::findOrFail($categoryId);

        $withdrawalsSubCategories = WithdrawalSubCategory::where('withdrawal_categories_id', $categoryId)
            ->get();

        return view('admin.gateways-items', [
            'withdrawalsCategory' => $withdrawalsCategory,
            'withdrawalsSubCategories' => $withdrawalsSubCategories,
        ]);
    }



    public function storeItems($categoryId, Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|between:0.01,999999.99',
            'description' => 'required|string|max:100',
        ]);

        $existingItem = WithdrawalSubCategory::where('withdrawal_categories_id', $categoryId)
            ->where('amount', $request->amount)
            ->exists();

        if ($existingItem) {
            return redirect()->back()->with('error', 'This amount already exists for this category.');
        }

        WithdrawalSubCategory::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'withdrawal_categories_id' => $categoryId,
        ]);

        return redirect()->back();
    }

    public function deleteItem($id)
    {
        $item = WithdrawalSubCategory::findOrFail($id);
        $item->delete();

        return redirect()->back();
    }

    protected function getWithdrawalsByStatus(Request $request, string $status)
    {
        $search = str_replace(' ', '', $request->input('search') ?? '');
        $perPage = $request->input('perPage', 15);

        $withdrawalsQuery = WithdrawalHistory::with('category', 'user')
            ->where('status', $status);

        if (!empty($search)) {
            $withdrawalsQuery->where(function ($query) use ($search) {
                $query->where('redeem_wallet', $search)
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('uid', $search);
                    });
            });

            $userPagination = $withdrawalsQuery->count();
            $withdrawals = $withdrawalsQuery->paginate($userPagination);
        } else {
            $withdrawals = $withdrawalsQuery->paginate($perPage);
            $userPagination = $perPage;
        }

        $totals = WithdrawalHistory::selectRaw('COUNT(*) as totalWithdrawals, SUM(amount) as totalUSDAmount')
            ->where('status', $status)
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('redeem_wallet', $search)
                        ->orWhereHas('user', function ($subQuery) use ($search) {
                            $subQuery->where('uid', $search);
                        });
                });
            })
            ->first();

        $userTotal = !empty($search)
            ? WithdrawalHistory::where('redeem_wallet', $search)
                ->where('status', $status)
                ->sum('amount')
            : 0;

        return [
            'withdrawals' => $withdrawals,
            'totalWithdrawals' => $totals->totalWithdrawals ?? 0,
            'totalUSDAmount' => $totals->totalUSDAmount / AdminRate() ?? 0,
            'userTotal' => $userTotal,
        ];
    }


    public function withdraw(Request $request)
    {
        $data = $this->getWithdrawalsByStatus($request, 'pending');

        return view('admin.withdraws.index', [
            'withdrawals' => $data['withdrawals'],
            'totalPendingWithdrawals' => $data['totalWithdrawals'],
            'totalUSDAmount' => $data['totalUSDAmount'],
            'userTotal' => $data['userTotal'],
        ]);
    }

    public function withdrawHold(Request $request)
    {
        $data = $this->getWithdrawalsByStatus($request, 'hold');

        return view('admin.withdraws.hold', [
            'withdrawals' => $data['withdrawals'],
            'totalHoldWithdrawals' => $data['totalWithdrawals'],
            'totalUSDAmount' => $data['totalUSDAmount'],
            'userTotal' => $data['userTotal'],
        ]);
    }

    public function markCompleted(Request $request)
    {
        if (!$request->has('selectedWithdrawals')) {
            return redirect()->back()->with('error', 'Please select at least one withdrawal.');
        }

        $selectedWithdrawals = $request->input('selectedWithdrawals');
        $action = $request->input('action');

        if ($action === 'complete') {
            WithdrawalHistory::whereIn('id', $selectedWithdrawals)
                ->update(['status' => 'completed']);

            return redirect()->route('admin.withdraw.index')->with('success', 'Withdrawals marked as completed successfully!');
        }

        if ($action === 'hold') {
            $hold_duration = (int) (Setting::getValue('withdraw_hold_duration') ?? 40);
            WithdrawalHistory::whereIn('id', $selectedWithdrawals)
                ->update([
                    'status' => 'hold',
                    'hold_due_date' => Carbon::now()->addDays($hold_duration),
                ]);

            $template = EmailTemplate::where('name', 'withdrawal_hold')->first();

            if ($template) {
                $withdrawals = WithdrawalHistory::with('user')
                    ->whereIn('id', $selectedWithdrawals)
                    ->get();

                foreach ($withdrawals as $index => $withdrawal) {
                    if ($withdrawal->user && $withdrawal->user->email) {
                        SendGenericEmail::dispatch(
                            $withdrawal->user,
                            $template,
                            [
                                'user_name' => $withdrawal->user->name,
                                'amount' => number_format($withdrawal->amount, 2),
                                'currency' => siteSymbol(),
                                'sitename' => siteName(),
                                'year' => date('Y'),
                            ]
                        )->delay(now()->addSeconds($index * 3));
                    }
                }

            }

            return redirect()->route('admin.withdraw.index')->with('success', 'Withdrawals marked as hold successfully and email notifications sent!');
        }

        return redirect()->back()->with('error', 'Invalid action.');
    }



    public function CancelWithdraw(Request $request)
    {
        $withdrawalId = $request->input('withdraw-id');
        $withdrawal = WithdrawalHistory::findOrFail($withdrawalId);
        $user = $withdrawal->user;

        if ($request->has('confirmCancel')) {
            $user->balance += $withdrawal->amount;
            $user->save();

            $withdrawal->status = 'refunded';
        } else {
            $withdrawal->status = 'rejected';
        }

        $withdrawal->save();

        return redirect()->back()->with('success', 'Withdrawal status updated successfully.');
    }


}
