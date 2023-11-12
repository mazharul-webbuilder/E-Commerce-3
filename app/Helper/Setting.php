<?php

use App\Models\Settings;
use App\Models\Diamond;
use App\Models\CoinUseHistory;
use App\Models\OfferTournament;
use App\Models\UserToken;
use Carbon\Carbon;
use App\Models\CampaignDetail;
use App\Models\ShareHolderSetting;
use App\Models\Campaign;
use App\Models\Currency;
use App\Models\Ecommerce\Product;
use App\Models\CoinEarningHistory;
use App\Models\ShareHolder;
use App\Models\ShareOwner;
use App\Models\User;
use App\Models\DiamondSellHistory;
use App\Models\DiamondUseHistory;
use App\Models\WithdrawHistory;
use App\Models\BalanceTransferHistory;
use App\Models\TokenUseHistory;
use App\Models\TokenTransferHistory;
use Illuminate\Support\Facades\DB;
use App\Models\ShareTransferHistory;
use App\Models\WithdrawPayment;
use App\Models\Tournament;
use App\Models\Club;
use App\Models\AffiliateSetting;



const ORDER_TYPE = ['all', 'pending', 'processing', 'shipping', 'delivered', 'declined', 'date'];
const CAMPAIGN_TYPE = ['rank', 'diamond', 'download', 'vip'];

const COIN_USD_RATE=0.002;

const BALANCE_TYPE=['marketing'=>'marketing','paid'=>'paid','game_asset'=>'game_asset',
    'crypto_asset'=>'crypto_asset','free_coin'=>'free_coin','win_balance'=>'win_balance','share_balance'=>'share_balance'];

const COIN_EARNING_SOURCE = [
    'tournament_winning' => 'tournament_winning', 'betting' => 'betting', 'rank_updating' => 'rank_updating',
    'diamond_partner_updating' => 'diamond_partner_updating', 'referral_code_use' => 'referral_code_use', 'diamond_use' => 'diamond_use', 'tournament_registration' => 'tournament_registration',
    'club_registration_parent_commission' => 'club_registration_parent_commission', 'club_registration_owner_commission' => 'club_registration_owner_commission',
    'club_tournament_registration_owner_commission' => 'club_tournament_registration_owner_commission', 'withdraw_commission' => 'withdraw_commission',
    'game_assets' => 'game_assets', 'share_fund_history' => 'share_fund_history', 'recovery_fund' => 'recovery_fund','home_game_registration'=>'home_game_registration',
    'home_game_asset'=>'home_game_asset','home_game_wining'=>'home_game_wining','withdraw_saving'=>'withdraw_saving','generation_commission'=>'generation_commission'
];

function rank_constant()
{
    return [
        'member_to_vip',
        'vip_to_partner',
        'partner_to_star',
        'star_to_sub_controller',
        'sub_controller_to_controller',
    ];
}

function rank_title()
{
    return [
        'Member to VIP',
        'VIP to Partner',
        'Partner to Star',
        'Star to Sub-Controller',
        'Sub-Controller to Controller',
    ];
}

function rank_name()
{
    return [
        'Partner',
        'Star',
        'Sub-controller',
        'Controller',
    ];
}

function setting()
{
    $setting = Settings::first();
    return $setting;
}

function diamond_setting()
{
    $diamond = Diamond::first();
    return $diamond;
}

function coin_use_history($data)
{
    CoinUseHistory::create($data);
}

function transfer_commission($amount, $commission)
{
    $result = (($amount * $commission) / 100);
    return $result;
}
function campaign_history($user, $type)
{
    $current_rank = $user->rank;
    if ($user->parent_id != null) {
        if ($type === CAMPAIGN_TYPE[0]) {

            if ($current_rank->priority == 2) {
                campaign_history_common($user, Campaign::OFFER_TYPE['partner']);
            } elseif ($current_rank->priority == 3) {
                campaign_history_common($user, Campaign::OFFER_TYPE['star']);
            } elseif ($current_rank->priority == 4) {
                campaign_history_common($user, Campaign::OFFER_TYPE['sub_controller']);
            } elseif ($current_rank->priority == 5) {
                campaign_history_common($user, Campaign::OFFER_TYPE['controller']);
            }
        } elseif ($type == CAMPAIGN_TYPE[1]) {
            campaign_history_common($user, Campaign::OFFER_TYPE['diamond_partner']);
        } elseif ($type == CAMPAIGN_TYPE[3]) {
            campaign_history_common($user, Campaign::OFFER_TYPE['vip']);
        } elseif ($type == CAMPAIGN_TYPE[2]) {
            campaign_history_common($user, Campaign::OFFER_TYPE['download']);
        }
    }
}
function campaign_history_common($user, $constrain_title)
{

    if ($constrain_title == CAMPAIGN_TYPE['2']) {
        CampaignDetail::create([
            'user_id' => $user->id,
            'parent_id' => $user->parent_id,
            'constrain_title' => $constrain_title,
        ]);
    } else {
        $totay = Carbon::today()->format('Y-m-d');

        $campaign = Campaign::where('constrain_title', $constrain_title)
            ->where('start_date', '<=', $totay)
            ->where('end_date', '>=', $totay)
            ->where('status', 1)
            ->first();

        if (!empty($campaign)) {
            CampaignDetail::create([
                'user_id' => $user->id,
                'parent_id' => $user->parent_id,
                'constrain_title' => $constrain_title,
                'campaign_id' => $campaign->id
            ]);
        }
    }
}

function get_campaign_detail($offer_tournament_id, $tournament_id)
{
    $data = CampaignDetail::where('offer_tournament_id', $offer_tournament_id)
        ->where('tournament_id', $tournament_id)
        ->get();
    return $data;
}
function share_holder_setting()
{
    $setting = ShareHolderSetting::first();
    return $setting;
}

function provide_winning_prize($tournament, $user, $bonus_point)
{
    if ($tournament->game_type == 1) {
        $user->win_balance += $bonus_point;
        $user->save();
        coin_earning_history($user->id, $bonus_point, COIN_EARNING_SOURCE['tournament_winning'],BALANCE_TYPE['win_balance']);
    } elseif ($tournament->game_type = 2) {
        UserToken::create([
            'user_id' => $user->id,
            'token_number' => strtoupper(uniqid("GRT")),
            'getting_source' => UserToken::getting_source[3],
            'type' => UserToken::token_type[1]
        ]);
    }
}
function currency_code($currency_code)
{
    return Currency::where('currency_code', $currency_code)->first();
}
function default_currency()
{
    return Currency::where('is_default', 1)->first();
}
function currency_convertor($amount, $convert_to)
{
    $default_currency = default_currency();
    return $default_currency[$convert_to] * $amount;
}

function string_replace($text)
{
    return str_replace('_', ' ', $text);
}
function calculate_shipping_charge($carts, $type)
{
    $total_shipping = 0;
    foreach ($carts as $cart) {
        if ($type === 'delivery_charge_in_dhaka') {
            $product = Product::find($cart->product_id)->delivery_charge_in_dhaka;
        } else {
            $product = Product::find($cart->product_id)->delivery_charge_out_dhaka;
        }
        $total_shipping = $total_shipping + $product;
    }
    return $total_shipping;
}

function coin_earning_history($user_id, $earning_coin, $earning_source,$balance_type)
{
    CoinEarningHistory::create([
        'user_id' => $user_id,
        'earning_coin' => $earning_coin,
        'earning_source' => $earning_source,
        'balance_type'=>$balance_type
    ]);
}

function get_share_owners()
{
    return ShareOwner::query()->orderBy('id', 'desc')->get();
}

function get_share_holders()
{
    return ShareHolder::query()->orderBy('id', 'desc')->get();
}


function get_total_diamond_balance()
{
    return User::query()->where('paid_diamond', '>', 0)->orderBy('id', 'DESC')->get();
}

function get_total_purchase_diamond()
{
    return DiamondSellHistory::query()->orderBy('id', 'DESC')->get();
}

function get_total_purchase_used()
{
    return DiamondUseHistory::query()->orderBy('id', 'DESC')->get();
}

function get_users()
{
    return User::query()->orderBy('id', 'DESC')->get();
}

function get_earn_wining_coin($coin_earning_source)
{
    return CoinEarningHistory::where('earning_source', $coin_earning_source)->get();
}

function get_total_withdraw($status)
{
    return WithdrawHistory::where('status', $status)->get();
}

function get_total_balance_transfer($constant_title)
{
    return BalanceTransferHistory::query()->where('constant_title', $constant_title)->get();
}
function get_coin_uses_history($purpose)
{

    return CoinUseHistory::query()->where('purpose', $purpose)->orderBy('id', 'DESC')->get();
}

function get_user_token($type)
{
    return UserToken::query()->whereType($type)->whereStatus(1)->orderBy('id', 'desc')->get();
}

function get_token_used_history($type)
{
    return TokenUseHistory::whereHas('user_token', function ($query) use ($type) {
        $query->where('type', $type);
    })->get();
}

function get_source_wise_token($gettingsource)
{
    return UserToken::query()->whereGettingSource($gettingsource)->orderBy('id', 'DESC')->get();
}

function get_transfer_token_history($type)
{
    return TokenTransferHistory::whereHas('user_token', function ($query) use ($type) {
        $query->where('type', $type);
    })->get();
}

function get_share_holder_list()
{
    return ShareHolder::query()
        ->select('share_owner_id', DB::raw('count(id) as total_share'), DB::raw('sum(share_purchase_price) as total_purchase_cost'))
        ->groupBy('share_owner_id')
        ->get();
}

function get_income_balance_shareholder()
{
}

function get_share_transfer_history()
{
    return ShareTransferHistory::query()->get();
}

function withdraw_payments()
{
    return WithdrawPayment::query()->get();
}
function get_data_applied_users()
{
    return User::query()->where('apply_data', 1)->get();
}

function get_admin_tournament($game_type)
{
    return Tournament::where('game_type', $game_type)
        ->where('tournament_owner', Tournament::TOURNAMENT_OWNER[0])
        ->get();
}

function get_tournament_type($game_type)
{
    switch ($game_type) {
        case 1:
            return "Regular";
        case 2:
            return "League";
        case 3:
            return "Campaign";
        case 4:
            return "Offer";
    }
}
function get_total_club()
{
    return Club::query()->orderBy('id', 'desc')->get();
}

function get_user($id){
    return User::find($id);
}

function dollar_to_other($dollar_amount){

    $total_bdt= currency_code('BDT')->currency_code." ".number_format(currency_convertor($dollar_amount,'convert_to_bdt'),2);
    $total_inr=currency_code('INR')->currency_code." ".number_format(currency_convertor($dollar_amount,'convert_to_inr'),2);
    $data=array('total_bdt'=>$total_bdt,'total_inr'=>$total_inr);
    return $data;
}

if (!function_exists('getAffiliateSetting')) {
    function getAffiliateSetting()
    {
        return AffiliateSetting::first();
    }
}




