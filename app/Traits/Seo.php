<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;

trait Seo
{
   
   public function metadata($key)
   {
       $seo=get_option($key,true);

       if ($key == 'seo_home') {
           JsonLdMulti::setTitle($seo->site_name ?? env('APP_NAME'));
           JsonLdMulti::setDescription($seo->matadescription ?? null);
           JsonLdMulti::addImage(asset($seo->preview ?? null));

           SEOMeta::setTitle($seo->site_name ?? env('APP_NAME'));
           SEOMeta::setDescription($seo->matadescription ?? null);
           SEOMeta::addKeyword($seo->matatag ?? null);

           SEOTools::setTitle($seo->site_name ?? env('APP_NAME'));
           SEOTools::setDescription($seo->matadescription ?? null);
           SEOTools::opengraph()->addProperty('keywords', $seo->matatag ?? null);
           SEOTools::opengraph()->addProperty('image', asset($seo->preview ?? null));
           SEOTools::twitter()->setTitle($seo->site_name ?? env('APP_NAME'));
           SEOTools::twitter()->setSite($seo->twitter_site_title ?? null);
           SEOTools::jsonLd()->addImage(asset($seo->preview ?? null));
       }
       else{
           JsonLdMulti::setTitle($seo->site_name ?? env('APP_NAME'));
           JsonLdMulti::setDescription($seo->matadescription ?? null);
           JsonLdMulti::addImage(asset($seo->preview ?? null));

           SEOMeta::setTitle($seo->site_name ?? env('APP_NAME'));
           SEOMeta::setDescription($seo->matadescription ?? null);
           SEOMeta::addKeyword($seo->matatag ?? null);

           SEOTools::setTitle($seo->site_name ?? env('APP_NAME'));
           SEOTools::setDescription($seo->matadescription ?? null);
           SEOTools::opengraph()->addProperty('keywords', $seo->matatag ?? null);
           SEOTools::opengraph()->addProperty('image', asset($seo->preview ?? null));
           SEOTools::twitter()->setTitle($seo->site_name ?? env('APP_NAME'));
           SEOTools::jsonLd()->addImage(asset($seo->preview ?? null));
       }
   }


   public function pageMetaData($data)
   {
         JsonLdMulti::setTitle($data['title'] ?? env('APP_NAME'));
         JsonLdMulti::setDescription($data['description'] ?? null);
         JsonLdMulti::addImage($data['preview'] ?? null);

         SEOMeta::setTitle($data['title'] ?? env('APP_NAME'));
         SEOMeta::setDescription($data['description'] ?? null);
         SEOTools::setTitle($data['title'] ?? env('APP_NAME'));
         SEOTools::setDescription($data['description'] ?? null);
         SEOMeta::addKeyword($data['tags'] ?? null);

         SEOTools::opengraph()->addProperty('keywords', $data['tags'] ?? null);
         SEOTools::opengraph()->addProperty('image', $data['preview'] ?? null);
         SEOTools::twitter()->setTitle($data['title'] ?? env('APP_NAME'));
         SEOTools::jsonLd()->addImage($data['preview'] ?? null);  
   }

}    