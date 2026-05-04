<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypeRegistry;
use App\Build;
use App\CompactibilityChecker;
use App\Models\Builds;

class BuilderController extends Controller
{
    public function index()
    {
        $categories = ProductTypeRegistry::all();
        $cart = session()->get('Builder.cart', new Build());
        $products = $cart->loadProducts();
        $errors = session()->get('Builder.errors', []);
        return view("builder.builder", compact("categories", 'products', 'errors'));
    }

    public function storeItem(Request $request, string $category, string $id)
    {
        if (!ProductTypeRegistry::exists($category)) {
            return redirect()->back()->withErrors("This device type doesn't exist");
        }

        $oldCartData = session()->get('Builder.cart');
        $cart = new Build($oldCartData);
        $cart->addItem($category, $id);

        $service = new CompactibilityChecker($cart);
        session()->put('Builder.errors', $service->validate());
        session()->put('Builder.cart', $cart);

        return redirect($request->return ?? route('builder.index'));
    }
    public function remove(string $category, string $id)
    {
        $oldCartData = session()->get('Builder.cart');
        $cart = new Build($oldCartData);
        $cart->removeItem($category, $id);
        $checker = new CompactibilityChecker($cart);
        session()->put('Builder.errors', $checker->validate());
        session()->put('Builder.cart', $cart);
        return redirect()->route('builder.index')->with('success', 'Component successfully removed');
    }

    public function use(Request $request, Builds $build)
    {
        $cart = new Build();

        foreach ($build->items as $item) {
            for ($i = 0; $i < $item->count; $i++) {
                $cart->addItem($item->category, $item->product_id);
            }
        }
        session()->put('Builder.cart', $cart);

        return redirect()->route('builder.index')->with('success', 'Component successfully added');
    }
    public function create()
    {
        $categories = ProductTypeRegistry::all();
        $oldCartData = session()->get('Builder.cart');
        $cart = new Build($oldCartData);
        $products = $cart->loadProducts();
        return view("builder.save", compact("products", "categories"));
    }
    public function store(Request $request)
    {

        $products = $request->products;
        $categories = ProductTypeRegistry::all();

        $isComplete = true;

        foreach ($categories as $requiredCategory) {
            if (!isset($products[$requiredCategory]) || empty($products[$requiredCategory])) {
                $isComplete = false;
                break;
            }
        }

        $build = Builds::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'isComplete' => $isComplete,
        ]);
        foreach ($request->products as $category => $items) {
            foreach ($items as $item) {
                $build->items()->create([
                    'category' => $category,
                    'product_id' => $item['id'],
                    'count' => $item['count'],
                ]);
            }
        }

        return redirect()->route('builder.index');
    }

    public function allBuild()
    {
        $builds = Builds::with('items')->latest()->get();
        return view('builder.build', compact('builds'));
    }

    public function debug()
    {
        dd(session()->get('Builder.cart'));
    }
}
