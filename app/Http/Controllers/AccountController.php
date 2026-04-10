<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Wishlist;
use App\Models\WalletTransaction;
use App\Models\Product;

class AccountController extends Controller
{
public function dashboard()
{
    $ordersCount = Order::where('user_id', Auth::id())->count();
    $pendingOrdersCount = Order::where('user_id', Auth::id())->where('status', 'pending')->count();
    $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
    $paymentsCount = Payment::where('user_id', Auth::id())->count();
    $accountBalance = WalletTransaction::where('user_id', Auth::id())->latest('id')->value('balance') ?? 0;
    $recentOrders = Order::where('user_id', Auth::id())->latest()->take(4)->get();
    $recommendedProducts = Product::query()
        ->where('product_type', 'product')
        ->where(function ($query) {
            $query->whereNull('is_active')->orWhere('is_active', true);
        })
        ->orderByRaw("CASE WHEN photo IS NULL OR photo = '' THEN 1 ELSE 0 END")
        ->latest('id')
        ->take(4)
        ->get();

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
        $orders = Order::where('user_id', Auth::id())->get();
        return view('account.orders', compact('orders'));
    }
    public function payments()
    {
        $payments = Payment::where('user_id', Auth::id())->get();
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
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('account.addresses', compact('addresses'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
