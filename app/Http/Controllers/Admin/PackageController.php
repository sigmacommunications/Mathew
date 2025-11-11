<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use stripe\Stripe as Stripe;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;



class PackageController extends Controller
{


    public function index()
    {
        $packages = Package::orderBy('id', 'asc')->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Display a listing of the resource.
     */
    // Create
    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'period' => 'required',
        ]);

        // return $request->all();
        // return $request->period;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripeProduct = StripeProduct::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $stripePrice = StripePrice::create([
            'unit_amount' => $request->amount * 100,
            'currency' => 'usd',
            'product' => $stripeProduct->id,
            'recurring' => [
                'interval' => $request->period,
            ],
        ]);

        $Package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'period' => $request->period,
            'stripe_plan' => $stripePrice->id,
        ]);

        return redirect()->route('package.index')
            ->with('success', 'Package created successfully.');
    }

    // Read


    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    // Update
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required',
            // 'amount' => 'required',
            'description' => 'required',
        ]);

        if (
            $package->name == $request->name &&
            $package->description == $request->description
        ) {
            return redirect()->route('package.index')
                ->with('info', 'There is no change you have done!');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripeplan = StripePrice::retrieve($package->stripe_plan);
        $stripeProductId = $stripeplan->product;
        StripeProduct::update(
            $stripeProductId,
            [
                'name' => $request->name,
                'description' => $request->description,
            ]
        );

        // Create a new Stripe Price for the product with the updated amount
        // $newStripePrice = StripePrice::create([
        //     'unit_amount' => $request->amount * 100, // Convert to cents
        //     'currency' => 'usd',
        //     'product' => $stripeProductId,
        //     'recurring' => [
        //         'interval' => 'month', // Use the appropriate interval
        //     ],
        // ]);

        $package->update($request->all());

        return redirect()->route('package.index')
            ->with('success', 'Package updated successfully');
    }

    // Delete
    public function destroy(Package $package)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripeplan = \Stripe\Plan::retrieve($package->stripe_plan);
            $stripeProductId = $stripeplan->product;
            $stripeplan->delete();
            StripeProduct::retrieve($stripeProductId)->delete();
            $package->delete();
            return response()->json(['success' => true, 'message' => 'Package deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Package.'], 500);
        }
    }
}
