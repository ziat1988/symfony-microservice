<?php

namespace App\DataFixtures;

use App\Factory\ProductFactory;
use App\Factory\ProductPromotionFactory;
use App\Factory\PromotionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // product
       ProductFactory::createMany(10);

        // promotion
        $promotions = PromotionFactory::createSequence([
            ['name'=>'Black Friday half price sale','type'=>'date_range_multiplier','adjustment'=>0.5,'criteria'=>['from'=>'2023-11-11','to'=>'2023-30-11']] ,
            ['name'=>'Voucher OU812','type'=>'fixed_price_voucher','adjustment'=>100,'criteria'=>['code'=>'OU812']] ,
            ['name'=>'Buy One Get Second Half Off','type'=>'even_items_multiplier','adjustment'=>0.5] ,
        ]);


        $product = ProductFactory::random()->object();

        foreach ($promotions as $promotion){
            ProductPromotionFactory::new()->create(['promotion' => $promotion,'product'=>$product]);
        }



        //ensure a product appear at least three times
        /*
        ProductPromotionFactory::createMany(3,function(){
            return [
                'product'=>ProductFactory::first(),
                'promotion'=>PromotionFactory::random()
            ];
        });
        */

        $manager->flush();

    }
}
