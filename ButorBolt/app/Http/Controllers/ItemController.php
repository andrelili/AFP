<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                'desc'=>'Kényelmes, letisztult skandináv kanapé prémium anyagokból, modern nappalikba.'
            ],
            [
                'id'=>2,
                'name'=>'Tölgyfa étkezőasztal',
                'price'=>149990,
                'img'=>'https://www.butormirek.hu/13159/tomor-tolgyfa-etkezogarnitura-6-szemely-reszere.jpg',
                'desc'=>'Masszív tömör tölgyfa étkezőasztal, akár 6 személy részére. Természetes fa erezet, elegáns kidolgozás.'
            ],
            [
                'id'=>3,
                'name'=>'Fa ágykeret',
                'price'=>179990,
                'img'=>'https://img.butor1.hu/detailed/3581/agy-avicavu-118_3581621.jpg?w=900&h=675&func=fit&org_if_sml=1',
                'desc'=>'Modern fa ágykeret, természetes árnyalatú kivitelben, minden hálószoba dísze.'
            ],
            [
                'id'=>4,
                'name'=>'Irodaszék',
                'price'=>59990,
                'img'=>'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg',
                'desc'=>'Ergonomikus irodaszék hálós háttámlával és kényelmes ülőfelülettel a hosszú munkanapokra.'
            ],
            [
                'id'=>5,
                'name'=>'Komód 4 fiók, fehér',
                'price'=>49990,
                'img'=>'https://www.vidaxl.hu/dw/image/v2/BFNS_PRD/on/demandware.static/-/Sites-vidaxl-catalog-master-sku/default/dwd711a3e2/hi-res/436/6356/447/242545/image_1_242545.jpg?sw=600',
                'desc'=>'Letisztult, modern komód 4 tágas fiókkal, fehér színben – ideális hálószobába vagy előszobába.'
            ],
            [
                'id'=>6,
                'name'=>'Étkezőszékek (2 db)',
                'price'=>39990,
                'img'=>'https://sarokuzlethaz.hu/wp-content/uploads/2024/11/undef_src_sa_picid_771895_x_1800_type_whitesh_image.jpg',
                'desc'=>'Elegáns, kényelmes étkezőszékek (2 db-os szett), modern formatervezéssel és puha kárpitozással.'
            ],
            [
                'id'=>7,
                'name'=>'TV-szekrény tölgyből',
                'price'=>79990,
                'img'=>'https://www.perfect-design.hu/public/0746/product/1913/374/big/thor-modern-fenyo-tv-szekreny-200cm-masolat-38810_4776d26e29da395a4c40b72350ec5250.jpg',
                'desc'=>'Prémium TV-szekrény tölgy színben, bőséges tárolóhellyel, modern megjelenéssel.'
            ],
            [
                'id'=>8,
                'name'=>'Állólámpa',
                'price'=>19990,
                'img'=>'https://www.ikea.com/hu/hu/images/products/skaftet-allolampa-alap-ivelt-fekete__0801019_pe768082_s5.jpg?f=s',
                'desc'=>'Letisztult, ívelt állólámpa fekete színben – tökéletes kiegészítő bármely nappaliba vagy hálószobába.'
            ],
        ];

        $item = collect($products)->firstWhere('id', (int)$id);
        if (!$item) abort(404);

        return view('item', compact('item'));
    }
}
