<?php
use App\Models\AffiliateSetting;
use App\Models\CompanyCommission;
use App\Models\GameAssetCommission;
use App\Models\TopSellerCommission;

function affiliateSetting(){
    return AffiliateSetting::query()->first();
}
 function companyCommission($amount,$source){
     CompanyCommission::create([
         'amount' => $amount,
         'commission_source' => $source,
     ]);
 }
 function gameAssetCommission($amount,$source){
     GameAssetCommission::create([
         'amount' => $amount,
         'commission_source' => $source,
     ]);
 }
 function topSellerCommission($amount,$source){
     TopSellerCommission::create([
         'amount' => $amount,
         'commission_source' => $source,
     ]);
 }
