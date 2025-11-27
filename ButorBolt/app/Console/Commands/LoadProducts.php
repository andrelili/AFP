<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class LoadProducts extends Command
{
    protected $signature = 'products:load';

    protected $description = 'Betölti a 8 alapértelmezett terméket az adatbázisba';

 public function handle()
{
    $products = [
        [
            'name' => 'Skandináv kanapé',
            'price' => 199990,
            'category' => 'Nappali',
            'img' => 'https://images.pexels.com/photos/20390760/pexels-photo-20390760.jpeg',
            'stock' => 10,
            'description' => 'Letisztult vonalvezetésű, kényelmes háromszemélyes kanapé, amely a modern skandináv dizájnt hozza el otthonába. Tartós, szürke szövetkárpittal és stabil falábakkal rendelkezik.'
        ],
        [
            'name' => 'Tölgyfa étkezőasztal',
            'price' => 149990,
            'category' => 'Étkező',
            'img' => 'https://cosmos-home.net/web/image/product.image/7430/image?unique=36f9acd',
            'stock' => 5,
            'description' => 'Masszív, tömör tölgyfából készült étkezőasztal, amely természetes eleganciát sugároz. 4-6 személy számára ideális választás családi vacsorákhoz.'
        ],
        [
            'name' => 'Fa ágykeret',
            'price' => 179990,
            'category' => 'Hálószoba',
            'img' => 'https://img.butor1.hu/detailed/3581/agy-avicavu-118_3581621.jpg?w=900&h=675&func=fit&org_if_sml=1',
            'stock' => 7,
            'description' => 'Klasszikus stílusú, rendkívül stabil szerkezetű fa ágykeret. Időtálló dizájnja nyugodt és meleg hangulatot teremt a hálószobában.'
        ],
        [
            'name' => 'Irodaszék',
            'price' => 59990,
            'category' => 'Iroda',
            'img' => 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg',
            'stock' => 12,
            'description' => 'Ergonomikus kialakítású, modern forgószék állítható magassággal és dönthető háttámlával. Hosszú távú munkavégzéshez is kiváló kényelmet biztosít.'
        ],
        [
            'name' => 'Komód 4 fiók, fehér',
            'price' => 49990,
            'category' => 'Hálószoba',
            'img' => 'https://www.vidaxl.hu/dw/image/v2/BFNS_PRD/on/demandware.static/-/Sites-vidaxl-catalog-master-sku/default/dwd711a3e2/hi-res/436/6356/447/242545/image_1_242545.jpg?sw=600',
            'stock' => 8,
            'description' => 'Praktikus, négyfiókos fehér komód, amely bőséges tárolóhelyet biztosít ruháknak vagy egyéb tárgyaknak. Minimalista stílusa minden hálószobába illik.'
        ],
        [
            'name' => 'Étkezőszékek (2 db)',
            'price' => 39990,
            'category' => 'Étkező',
            'img' => 'https://sarokuzlethaz.hu/wp-content/uploads/2024/11/undef_src_sa_picid_771895_x_1800_type_whitesh_image.jpg',
            'stock' => 15,
            'description' => 'Két darabos étkezőszék szett modern, mégis otthonos megjelenéssel. Kényelmes, párnázott ülőfelület és tartós kialakítás jellemzi őket.'
        ],
        [
            'name' => 'TV-szekrény tölgyből',
            'price' => 79990,
            'category' => 'Nappali',
            'img' => 'https://www.perfect-design.hu/public/0746/product/1913/374/big/thor-modern-fenyo-tv-szekreny-200cm-masolat-38810_4776d26e29da395a4c40b72350ec5250.jpg',
            'stock' => 6,
            'description' => 'Stílusos médiaállvány tölgyfa hatású felülettel. Nyitott polcokkal a lejátszóknak és zárt tárolókkal a kábelek, kiegészítők elrejtéséhez.'
        ],
        [
            'name' => 'Állólámpa',
            'price' => 19990,
            'category' => 'Nappali',
            'img' => 'https://www.ikea.com/hu/hu/images/products/skaftet-allolampa-alap-ivelt-fekete__0801019_pe768082_s5.jpg?f=s',
            'stock' => 20,
            'description' => 'Elegáns, íves kialakítású állólámpa, amely hangulatos világítást biztosít a nappaliban. Tökéletes választás olvasósarokba vagy kiegészítő fényforrásnak.'
        ],
    ];

    foreach ($products as $product) {
        // Itt cseréltem le updateOrCreate-re, hogy frissüljön a leírás!
        Product::updateOrCreate(
            ['name' => $product['name']], // Keresés név alapján
            $product // Adatok frissítése/létrehozása
        );
    }

    $this->info('Termékek és leírások sikeresen betöltve/frissítve!');
}
}