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
        $stockMap = [];
        foreach ($cart as $id => $row) {
            $stockMap[$id] = $this->getStock((int)$id);
        }

        return view('bag', compact('cart', 'total', 'stockMap'));
    }

    public function add(Request $request, $id)
{
    $product = $this->productById((int)$id);
    if (!$product) {
        return back()->with('error', 'A termék nem található.');
    }

    $qty = max(1, (int)$request->input('qty', 1));
    if ($qty <= 0){
        return back()->with('error', 'Érvénytelen mennyiség.');
    }

    $cart = $request->session()->get('cart', []);
    $currentQty = $cart[$id]['qty'] ?? 0;

    $available = $this->getStock($id);

    if($qty + $currentQty > $available){
        return back()->with('error', 'Nincs ennyi raktáron. Elérhető: '. $available . ' db.');
    }

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
        if($qty <= 0){
            return back()->with('error', 'Érvénytelen mennyiség.');
        }
            $available = $this->getStock((int)$id);
    if ($qty > $available) {
        return back()->with('error', 'Nincs ennyi raktáron. Elérhető: ' . $available . ' db.');
    }
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
        $id = (int)$id;
        $cart = $request->session()->get('cart', []);
        if(isset($cart[$id])){
            $qty = $cart[$id]['qty'];
            unset($cart[$id]);

            $this->adjustStock($id,$qty);
        }

        $request->session()->put('cart', $cart);
        $request->session()->put('cart_count', collect($cart)->sum('qty'));

        return back()->with('success', 'Tétel törölve.');
    }

    public function clear(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        foreach($cart as $id => $item){
            $this->adjustStock((int)$id, $item['qty']);
        }

        $request->session()->forget(['cart', 'cart_count']);
        return back()->with('success', 'Kosár ürítve.');
    }

    private function products(): array
    {
        return [
            ['id'=>1,'name'=>'Skandináv kanapé','price'=>199990,'img'=>'https://images.pexels.com/photos/20390760/pexels-photo-20390760.jpeg'],
            ['id'=>2,'name'=>'Tölgyfa étkezőasztal','price'=>149990,'img'=>'https://foresta.hu/wp-content/uploads/2024/02/kerek_tolgyfa_bovitheto_etkezoasztal-Orbetello-2-768x624.jpg'],
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

        $cart = $request->session()->get('cart', []);
        foreach($cart as $id => $item){
            $this->adjustStock((int)$id, -$item['qty']);
        }

        $request->session()->forget(['cart', 'cart_count']);
        return redirect()->route('checkout')->with('checkout', 'Tovább a megrendeléshez!');
    }

     private function readStockFile(): array
    {
        $path = resource_path('data/stock.json');
        if (!file_exists($path)) {
            return [];
        }
            $json = file_get_contents($path);
    return json_decode($json, true) ?? [];
    }

    private function writeStock(array $list): void
    {
        $path = resource_path('data/stock.json');
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        file_put_contents($path, json_encode(array_values($list), JSON_PRETTY_PRINT));
    }

    private function getStock(int $id): int
    {
    $list = $this->readStockFile();
    foreach ($list as $r) {
        if (isset($r['id']) && $r['id'] === $id) return (int)($r['stock'] ?? 0);
    }
    return 0;
    }


     public function adjustStock(int $id, int $delta): void
    {
        $list = $this->readStockFile();
        $found = false;

        foreach ($list as &$item) {
            if (isset($item['id']) && $item['id'] === $id) {
                $item['stock'] = max(0, (int)($item['stock'] ?? 0) + $delta);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $list[] = ['id' => $id, 'stock' => max(0, $delta)];
        }

        $this->writeStock($list);
    }
}
