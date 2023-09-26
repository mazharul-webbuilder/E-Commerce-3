<?php

namespace Database\Seeders;

use App\Models\OfferTournament;
use Illuminate\Database\Seeder;

class OfferTournamentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OfferTournament::insert([
            [
                'required_position_name'=>'VIP Member',
                'total_needed_position'=>24,
                'total_needed_referral'=>25,
                'duration'=>20,
                'constrain_title'=>OfferTournament::OFFER_TYPE[0],
                'duration_type'=>'fixed'
            ],
            [
                'required_position_name'=>'Partner',
                'total_needed_position'=>20,
                'total_needed_referral'=>25,
                'duration'=>30,
                'constrain_title'=>OfferTournament::OFFER_TYPE[1],
                'duration_type'=>'fixed'
            ],
            [
                'required_position_name'=>'Star',
                'total_needed_position'=>15,
                'total_needed_referral'=>25,
                'duration'=>30,
                'constrain_title'=>OfferTournament::OFFER_TYPE[2],
                'duration_type'=>'fixed'
            ],
            [
                'required_position_name'=>'Sub Controller',
                'total_needed_position'=>10,
                'total_needed_referral'=>25,
                'duration'=>30,
                'constrain_title'=>OfferTournament::OFFER_TYPE[3],
                'duration_type'=>'fixed'
            ],
            [
                'required_position_name'=>'Controller',
                'total_needed_position'=>5,
                'total_needed_referral'=>25,
                'duration'=>30,
                'constrain_title'=>OfferTournament::OFFER_TYPE[4],
                'duration_type'=>'fixed'
            ],
            [
                'required_position_name'=>'Diamond Partner',
                'total_needed_position'=>10,
                'total_needed_referral'=>25,
                'duration'=>30,
                'constrain_title'=>OfferTournament::OFFER_TYPE[5],
                'duration_type'=>'fixed'
            ],
        ]);
    }
}
