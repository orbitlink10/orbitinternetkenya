<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Wishlist;
use App\Models\WalletTransaction;
use App\Models\Product;

class AccountController extends Controller
{
public function dashboard()
{
    $userId = Auth::id();
    $ordersQuery = Schema::hasTable('orders')
        ? Order::query()->where('user_id', $userId)
        : null;

    $ordersCount = $ordersQuery ? (clone $ordersQuery)->count() : 0;
    $pendingOrdersCount = $ordersQuery
        ? (clone $ordersQuery)->where('status', 'pending')->count()
        : 0;
    $wishlistCount = Schema::hasTable('wishlists')
        ? Wishlist::where('user_id', $userId)->count()
        : 0;
    $paymentsCount = Schema::hasTable('payments')
        ? Payment::where('user_id', $userId)->count()
        : 0;
    $accountBalance = Schema::hasTable('wallet_transactions')
        ? (WalletTransaction::where('user_id', $userId)->latest('id')->value('balance') ?? 0)
        : 0;
    $recentOrders = $ordersQuery
        ? (clone $ordersQuery)->latest()->take(4)->get()
        : collect();
    $recommendedProducts = Schema::hasTable('products')
        ? Product::query()
            ->where('product_type', 'product')
            ->where(function ($query) {
                $query->whereNull('is_active')->orWhere('is_active', true);
            })
            ->orderByRaw("CASE WHEN photo IS NULL OR photo = '' THEN 1 ELSE 0 END")
            ->latest('id')
            ->take(4)
            ->get()
        : collect();

    return view('account.dashboard', compact(
        'ordersCount',
        'pendingOrdersCount',
        'wishlistCount',
        'paymentsCount',
        'accountBalance',
        'recentOrders',
        'recommendedProducts'
    ));
}


    public function orders()
    {
        $orders = Schema::hasTable('orders')
            ? Order::where('user_id', Auth::id())->get()
            : collect();
        return view('account.orders', compact('orders'));
    }
    public function payments()
    {
        $payments = Schema::hasTable('payments')
            ? Payment::where('user_id', Auth::id())->get()
            : collect();
        return view('account.payments', compact('payments'));
    }

    public function details()
    {
        return view('account.details');
    }

    public function updateDetails(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        
        return redirect()->route('account.details')->with('success', 'Account details updated.');
    }

    public function addresses()
    {
        $addresses = Schema::hasTable('addresses')
            ? DB::table('addresses')->where('user_id', Auth::id())->get()
            : collect();
        return view('account.addresses', compact('addresses'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
