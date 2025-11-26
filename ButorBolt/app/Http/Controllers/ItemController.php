<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
class ItemController extends Controller
{
    public function show($id)
    {
            $products = [
                [
                    'id'=>1,
                    'name'=>'Skandináv kanapé',
                    'price'=>199990,
                    'img'=>'https://images.pexels.com/photos/20390760/pexels-photo-20390760.jpeg',
                    'desc'=>'Kényelmes, letisztult skandináv kanapé prémium anyagokból, modern nappalikba.',
                    'category'=>'Kanapék',
                ],
                [
                    'id'=>2,
                    'name'=>'Tölgyfa étkezőasztal',
                    'price'=>149990,
                    'img'=>asset('images/tolgyfa_asztal.jpg.webp'),
                    'desc'=>'Masszív tömör tölgyfa étkezőasztal, akár 6 személy részére. Természetes fa erezet, elegáns kidolgozás.',
                    'category'=>'Asztalok',
                ],
                [
                    'id'=>3,
                    'name'=>'Fa ágykeret',
                    'price'=>179990,
                    'img'=>'https://img.butor1.hu/detailed/3581/agy-avicavu-118_3581621.jpg?w=900&h=675&func=fit&org_if_sml=1',
                    'desc'=>'Modern fa ágykeret, természetes árnyalatú kivitelben, minden hálószoba dísze.',
                    'category'=>'Ágyak',
                ],
                [
                    'id'=>4,
                    'name'=>'Irodaszék',
                    'price'=>59990,
                    'img'=>'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg',
                    'desc'=>'Ergonomikus irodaszék hálós háttámlával és kényelmes ülőfelülettel a hosszú munkanapokra.',
                    'category'=>'Székek',
                ],
                [
                    'id'=>5,
                    'name'=>'Komód 4 fiók, fehér',
                    'price'=>49990,
                    'img'=>'https://www.vidaxl.hu/dw/image/v2/BFNS_PRD/on/demandware.static/-/Sites-vidaxl-catalog-master-sku/default/dwd711a3e2/hi-res/436/6356/447/242545/image_1_242545.jpg?sw=600',
                    'desc'=>'Letisztult, modern komód 4 tágas fiókkal, fehér színben – ideális hálószobába vagy előszobába.',
                    'category'=>'Tárolók',
                ],
                [
                    'id'=>6,
                    'name'=>'Étkezőszékek (2 db)',
                    'price'=>39990,
                    'img'=>'https://sarokuzlethaz.hu/wp-content/uploads/2024/11/undef_src_sa_picid_771895_x_1800_type_whitesh_image.jpg',
                    'desc'=>'Elegáns, kényelmes étkezőszékek (2 db-os szett), modern formatervezéssel és puha kárpitozással.',
                    'category'=>'Székek',
                ],
                [
                    'id'=>7,
                    'name'=>'TV-szekrény tölgyből',
                    'price'=>79990,
                    'img'=>'https://www.perfect-design.hu/public/0746/product/1913/374/big/thor-modern-fenyo-tv-szekreny-200cm-masolat-38810_4776d26e29da395a4c40b72350ec5250.jpg',
                    'desc'=>'Prémium TV-szekrény tölgy színben, bőséges tárolóhellyel, modern megjelenéssel.',
                    'category'=>'Tárolók',
                ],
                [
                    'id'=>8,
                    'name'=>'Állólámpa',
                    'price'=>19990,
                    'img'=>'https://www.ikea.com/hu/hu/images/products/skaftet-allolampa-alap-ivelt-fekete__0801019_pe768082_s5.jpg?f=s',
                    'desc'=>'Letisztult, ívelt állólámpa fekete színben – tökéletes kiegészítő bármely nappaliba vagy hálószobába.',
                    'category'=>'Világítás',
                ],
            ];

            $item = collect($products)->firstWhere('id', (int)$id);
            if (!$item) abort(404);

            $stock = $this->getStock((int)$id);

            $reviews = Review::where('item_id', (int)$id)
                ->orderBy('created_at', 'desc')
                ->get();

            $userHasReviewed = false;
            if (Auth::check()) {
                $userHasReviewed = Review::where('item_id', (int)$id)
                    ->where('user_id', Auth::id())
                    ->exists();
            }

            return view('item', compact('item','stock','reviews', 'userHasReviewed'));
        }

        private function readStockFile(): array{
            $path = resource_path('data/stock.json');
            if (!file_exists($path)){
                return [];
            }
            $json = file_get_contents($path);
            return json_decode($json, true) ?? [];
        }

        private function getStock(int $id):int{
            $list = $this->readStockFile();
            foreach ($list as $r){
                if (isset($r['id']) && $r['id'] === $id) return (int)($r['stock'] ?? 0);
            }
            return 0;
        }

       public function addReview(Request $request, $id)
        {
            if (!$request->user()) {
                return redirect()->back()->with('login_required', 'Értékelés írásához jelentkezz be.');
            }

            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:500',
            ]);

            $user = $request->user();
            $already = Review::where('item_id', (int)$id)
                ->where('user_id', $user->id)
                ->exists();
            if ($already) {
                return redirect()->back()->with('info', 'Már értékelted ezt a terméket. Köszönjük visszajelzésed!');
            }

            $userName = null;
            if ($user) {
                if (!empty($user->username)) {
                    $userName = $user->username;
                } elseif (!empty($user->name)) {
                    $userName = $user->name;
                } else {
                    $first = $user->first_name ?? '';
                    $last = $user->last_name ?? '';
                    $userName = trim($first . ' ' . $last);
                    if ($userName === '') $userName = null;
                }
            }

            $itemName = $this->getProductName((int)$id);

            Review::create([
                'item_id' => (int)$id,
                'item_name' => $itemName,
                'user_id' => $user->id,
                'user_name' => $userName,
                'rating' => (int)$request->input('rating'),
                'comment' => $request->input('comment'),
            ]);

            return redirect()->back()->with('success', 'Köszönjük az értékelést!');
        }

        private function getProductName(int $id): ?string
        {
            $products = [
                1 => 'Skandináv kanapé',
                2 => 'Tölgyfa étkezőasztal',
                3 => 'Fa ágykeret',
                4 => 'Irodaszék',
                5 => 'Komód 4 fiók, fehér',
                6 => 'Étkezőszékek (2 db)',
                7 => 'TV-szekrény tölgyből',
                8 => 'Állólámpa',
            ];

            return $products[$id] ?? null;
        }

    }
