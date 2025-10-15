<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BagCheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(fn($row) => $row['price'] * $row['qty']);
        return view('bag', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = $this->productById((int)$id);
        if (!$product) {
            return back()->with('error', 'A termék nem található.');
        }

        $cart = $request->session()->get('cart', []);
        $qty = max(1, (int)$request->input('qty', 1));

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id'    => $product['id'],
                'name'  => $product['name'],
                'price' => $product['price'],
                'img'   => $product['img'],
                'qty'   => $qty,
            ];
        }

        $request->session()->put('cart', $cart);
        $request->session()->put('cart_count', collect($cart)->sum('qty'));

        return back()->with('success', 'Hozzáadva a kosárhoz.');
    }

    public function update(Request $request, $id)
    {
        $qty = max(1, (int)$request->input('qty', 1));
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            $request->session()->put('cart', $cart);
            $request->session()->put('cart_count', collect($cart)->sum('qty'));
        }

        return back()->with('success', 'Kosár frissítve.');
    }

    public function remove(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        Arr::forget($cart, $id);

        $request->session()->put('cart', $cart);
        $request->session()->put('cart_count', collect($cart)->sum('qty'));

        return back()->with('success', 'Tétel törölve.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget(['cart', 'cart_count']);
        return back()->with('success', 'Kosár ürítve.');
    }

    private function products(): array
    {
        return [
            ['id'=>1,'name'=>'Skandináv kanapé','price'=>199990,'img'=>'https://images.pexels.com/photos/20390760/pexels-photo-20390760.jpeg'],
            ['id'=>2,'name'=>'Tölgyfa étkezőasztal','price'=>149990,'img'=>'https://www.butormirek.hu/13159/tomor-tolgyfa-etkezogarnitura-6-szemely-reszere.jpg'],
            ['id'=>3,'name'=>'Fa ágykeret','price'=>179990,'img'=>'https://img.butor1.hu/detailed/3581/agy-avicavu-118_3581621.jpg?w=900&h=675&func=fit&org_if_sml=1'],
            ['id'=>4,'name'=>'Irodaszék','price'=>59990,'img'=>'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg'],
            ['id'=>5,'name'=>'Komód 4 fiók, fehér','price'=>49990,'img'=>'https://www.vidaxl.hu/dw/image/v2/BFNS_PRD/on/demandware.static/-/Sites-vidaxl-catalog-master-sku/default/dwd711a3e2/hi-res/436/6356/447/242545/image_1_242545.jpg?sw=600'],
            ['id'=>6,'name'=>'Étkezőszékek (2 db)','price'=>39990,'img'=>'https://sarokuzlethaz.hu/wp-content/uploads/2024/11/undef_src_sa_picid_771895_x_1800_type_whitesh_image.jpg'],
            ['id'=>7,'name'=>'TV-szekrény tölgyből','price'=>79990,'img'=>'https://www.perfect-design.hu/public/0746/product/1913/374/big/thor-modern-fenyo-tv-szekreny-200cm-masolat-38810_4776d26e29da395a4c40b72350ec5250.jpg'],
            ['id'=>8,'name'=>'Állólámpa','price'=>19990,'img'=>'https://www.ikea.com/hu/hu/images/products/skaftet-allolampa-alap-ivelt-fekete__0801019_pe768082_s5.jpg?f=s'],
        ];
    }
    private function productById(int $id): ?array
    {
        foreach ($this->products() as $p) {
            if ($p['id'] === $id) return $p;
        }
        return null;
    }
    public function order(Request $request)
    {
        //HA LESZ ADATBÁZIS, AKKOR ELLENŐRIZZEN

        //if(!session()->has('user')){
        //    return redirect()->route('bag')->with('error', 'Jelentkezz be a rendeléshez!');
        //}
        $request->session()->forget(['cart', 'cart_count']);
        return redirect()->route('successful.order')->with('successfulOrder', 'A megrendelés sikeresen elküldve!');
    }
}
