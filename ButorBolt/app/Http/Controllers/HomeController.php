<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(){
        $products = [
          ['id'=>1,'name'=>'Skandináv kanapé','price'=>199990, 'category'=>'Nappali',
          'img'=>'https://images.pexels.com/photos/20390760/pexels-photo-20390760.jpeg'],
          ['id'=>2,'name'=>'Tölgyfa étkezőasztal','price'=>149990, 'category'=>'Étkező',
          'img'=>'https://www.butormirek.hu/13159/tomor-tolgyfa-etkezogarnitura-6-szemely-reszere.jpg'],
          ['id'=>3,'name'=>'Fa ágykeret','price'=>179990, 'category'=>'Hálószoba',
          'img'=>'https://img.butor1.hu/detailed/3581/agy-avicavu-118_3581621.jpg?w=900&h=675&func=fit&org_if_sml=1'],
          ['id'=>4,'name'=>'Irodaszék','price'=>59990, 'category'=>'Iroda',
          'img'=>'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg'],
          ['id'=>5,'name'=>'Komód 4 fiók, fehér','price'=>49990, 'category'=>'Hálószoba', 
          'img'=>'https://www.vidaxl.hu/dw/image/v2/BFNS_PRD/on/demandware.static/-/Sites-vidaxl-catalog-master-sku/default/dwd711a3e2/hi-res/436/6356/447/242545/image_1_242545.jpg?sw=600'],
          ['id'=>6,'name'=>'Étkezőszékek (2 db)','price'=>39990, 'category'=>'Étkező',
          'img'=>'https://sarokuzlethaz.hu/wp-content/uploads/2024/11/undef_src_sa_picid_771895_x_1800_type_whitesh_image.jpg'],
          ['id'=>7,'name'=>'TV-szekrény tölgyből','price'=>79990, 'category'=>'Nappali',
          'img'=>'https://www.perfect-design.hu/public/0746/product/1913/374/big/thor-modern-fenyo-tv-szekreny-200cm-masolat-38810_4776d26e29da395a4c40b72350ec5250.jpg'],
          ['id'=>8,'name'=>'Állólámpa','price'=>19990, 'category'=>'Nappali', 
          'img'=>'https://www.ikea.com/hu/hu/images/products/skaftet-allolampa-alap-ivelt-fekete__0801019_pe768082_s5.jpg?f=s'],
        ];

        $categories = collect($products)->pluck('category')->unique()->sort()->values()->all();

        return view('home', compact('products', 'categories'));
    }
}
