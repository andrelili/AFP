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
            ['name'=>'Skandináv kanapé','price'=>199990,'category'=>'Nappali',
            'img'=>'https://images.pexels.com/photos/20390760/pexels-photo-20390760.jpeg', 'stock'=>10],
            ['name'=>'Tölgyfa étkezőasztal','price'=>149990,'category'=>'Étkező',
            'img'=>'https://www.butormirek.hu/13159/tomor-tolgyfa-etkezogarnitura-6-szemely-reszere.jpg', 'stock'=>5],
            ['name'=>'Fa ágykeret','price'=>179990,'category'=>'Hálószoba',
            'img'=>'https://img.butor1.hu/detailed/3581/agy-avicavu-118_3581621.jpg?w=900&h=675&func=fit&org_if_sml=1', 'stock'=>7],
            ['name'=>'Irodaszék','price'=>59990,'category'=>'Iroda',
            'img'=>'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg', 'stock'=>12],
            ['name'=>'Komód 4 fiók, fehér','price'=>49990,'category'=>'Hálószoba', 
            'img'=>'https://www.vidaxl.hu/dw/image/v2/BFNS_PRD/on/demandware.static/-/Sites-vidaxl-catalog-master-sku/default/dwd711a3e2/hi-res/436/6356/447/242545/image_1_242545.jpg?sw=600', 'stock'=>8],
            ['name'=>'Étkezőszékek (2 db)','price'=>39990,'category'=>'Étkező',
            'img'=>'https://sarokuzlethaz.hu/wp-content/uploads/2024/11/undef_src_sa_picid_771895_x_1800_type_whitesh_image.jpg', 'stock'=>15],
            ['name'=>'TV-szekrény tölgyből','price'=>79990,'category'=>'Nappali',
            'img'=>'https://www.perfect-design.hu/public/0746/product/1913/374/big/thor-modern-fenyo-tv-szekreny-200cm-masolat-38810_4776d26e29da395a4c40b72350ec5250.jpg', 'stock'=>6],
            ['name'=>'Állólámpa','price'=>19990,'category'=>'Nappali', 
            'img'=>'https://www.ikea.com/hu/hu/images/products/skaftet-allolampa-alap-ivelt-fekete__0801019_pe768082_s5.jpg?f=s', 'stock'=>20],
        ];

          foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']], 
                $product 
            );
        }

        $this->info('Alapértelmezett termékek betöltve, duplikáció nélkül.');

    }
}
