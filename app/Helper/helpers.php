<?php


use App\Models\BidderCommissionHistory;
use App\Models\Biding_details;
use App\Models\Diamond_uses;
use App\Models\Roundludoboard;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\Notification;
use App\Models\Playerinboard;
use App\Models\RoundSettings;
use App\Models\Tournament;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use App\Models\Admin\SmsCredential;
use App\Models\Merchant\Merchant;
use App\Models\Ecommerce\Product;
use App\Models\Seller\Seller;
use App\Models\Affiliate\Affiliator;
use App\Models\AdvertisementSetting;


 const PAYMENT_TYPE=[
     '1'=>'Mobile Banking',
     '2'=>'Banking',
     '3'=>'Paytm',
     '4'=>'Payment Gateway',
 ];
function sms_credential(){
    $data=SmsCredential::first();
    return $data;
}
/**
 * return Total Merchants
*/
if (!function_exists('total_merchants')) {
    function total_merchants()
    {
        return Merchant::count();
    }
}

/**
 * return Total Sellers
*/
if (!function_exists('total_sellers')) {
    function total_sellers()
    {
        return Seller::count();
    }
}

/**
 * return Total affiliators
*/
if (!function_exists('total_affiliators')) {
    function total_affiliators()
    {
        return Affiliator::count();
    }
}

/**
 * return  total_admin_product
*/
if (!function_exists('total_admin_product')) {
    function total_admin_product()
    {
        return Product::where('admin_id', '!=', null)->count();
    }
}

/**
 * return  total_merchant_product
*/
if (!function_exists('total_merchant_product')) {
    function total_merchant_product()
    {
        return Product::where('admin_id', '=', null)->count();
    }
}


if (!function_exists('send_sms')) {
    function send_sms($phone, $text)
    {
        Curl::to('https://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php')
            ->withData(array(
                'masking' => sms_credential()->masking,
                'userName' => sms_credential()->username,
                'password' => sms_credential()->password_key,
                'receiver' => $phone,
                'MsgType' => sms_credential()->message_type,
                'message' => $text,
            ))->get();
    }
}

if (!function_exists('api_response')){
    function api_response($type=null,$message=null,$data=null,$status =null){
        return response()->json([
            'type' => $type,
            'message' => $message,
            'data' => $data,
            'status' => $status,
        ]);
    }
}

//    for round diamond use and condition  start
if (!function_exists('round_diamond')) {
    function round_diamond($player, $tournament_id, $round_type, $game_id, $round_id)    {
        $round_settings = RoundSettings::where('tournament_id', $tournament_id)->where('round_type', $round_type)->first();
        $used_diamond = Diamond_uses::where('tournament_id', $tournament_id)->where('game_id', $game_id)->where('round_id', $round_id)->sum('diamond_use');
        $tournament_diamond_limit = Tournament::find($tournament_id);
        if ($round_settings->diamond_limit != null) {
            if ($tournament_diamond_limit->diamond_limit > $used_diamond) {
                if (Auth::user()->paid_diamond >= $round_settings->diamond_limit) {
                    $player['round_diamond'] = $round_settings->diamond_limit;
                } elseif (Auth::user()->paid_diamond < $round_settings->diamond_limit) {
                    $player['round_diamond'] = Auth::user()->paid_diamond;
                }
            } else {
                $player['round_diamond'] = 0;
            }
        } else {
            $player['round_diamond'] = 0;
        }
        return $player;
    }
}
//    for round diamond use and condition  end


function price_format($price){
    return default_currency()->currency_code." ".$price;
}

function check_digital($carts){

    foreach ($carts as $cart){
        if($cart->product->category->digital_asset == 1){
            $tyde= 1;
            break;
        }else{
            $tyde=0;
        }
    }
    return $tyde;
}

function player_name($id)
{
    $player = User::find($id)->name;
    return $player;
}
function player_id($id)
{
    $player = User::find($id)->playerid;
    return $player;
}

function game_type($id)
{
    foreach(config('app.game_type') as $name => $gametype_value){
        if ($id == $gametype_value){
            return $name;
        }
    }
}

function notification($datas)
{
    if (!empty($datas)){
        Notification::create($datas);
    }
}

function player_email($id)
{
    $player = User::find($id)->email;
    return $player;
}
function player_phone($id)
{
    $player = User::find($id)->phone;
    return $player;
}
function tournament_name($id)
{
    $tournament_name = Tournament::find($id)->tournament_name;
    return $tournament_name;
}

function two_player_win()
{
   $player_in_board = Playerinboard::where('first_winner',Auth::user()->id)->pluck('round_id');
    $round = \App\Models\Gameround::whereIn('id',$player_in_board)->where('round_no','final')->pluck('game_id');
    $game = \App\Models\Game::whereIn('id',$round)->pluck('tournament_id');
    $tournament = Tournament::whereIn('id',$game)->where('player_type','2p')->count();
    return $tournament;
}
function totall_tournament_win()
{
    $player_in_board = Playerinboard::where('first_winner',Auth::user()->id)->pluck('round_id');
    $round = \App\Models\Gameround::whereIn('id',$player_in_board)->where('round_no','final')->pluck('game_id');
    $game = \App\Models\Game::whereIn('id',$round)->pluck('tournament_id');
    $tournament = Tournament::whereIn('id',$game)->count();
    return $tournament;
}
function four_player_win()
{
    $player_in_board = Playerinboard::where('first_winner',Auth::user()->id)->pluck('round_id');
    $round = \App\Models\Gameround::whereIn('id',$player_in_board)->where('round_no','final')->pluck('game_id');
    $game = \App\Models\Game::whereIn('id',$round)->pluck('tournament_id');
    $tournament = Tournament::whereIn('id',$game)->where('player_type','4p')->count();
    return $tournament;
}

function win_percentange()
{
    $total_win = Playerinboard::where('first_winner',Auth::user()->id)->orWhere('second_winner',Auth::user()->id)->count();
    $total_played = Playerinboard::where('player_one',Auth::user()->id)->orWhere('player_two',Auth::user()->id)->orWhere('player_three',Auth::user()->id)->orWhere('player_four',Auth::user()->id)->count();

    $percentage =  $total_win * 100;
    if (($percentage > 0) && ($total_played > 0)){
        $result = $percentage / $total_played;
    }else{
        $result = 0;
    }
    return number_format((float)$result, 2, '.', '');
}
function total_game_win(){
    $total_win = Playerinboard::where('first_winner',Auth::user()->id)->orWhere('second_winner',Auth::user()->id)->count();
    return $total_win;
}

function win_percentange_of_Month($id)
{
   // $total_win=0;
    $total_win = Playerinboard::where('first_winner',$id)->orWhere('second_winner',$id)->whereMonth('created_at', Carbon::now()->month)->count();


    $total_played = Playerinboard::where('player_one',$id)->orWhere('player_two',$id)->orWhere('player_three',$id)->orWhere('player_four',$id)->whereMonth('created_at', Carbon::now()->month)->count();
    $percentage =  $total_win * 100;
    if (($percentage > 0) && ($total_played > 0)){
        $result = $percentage / $total_played;
    }else{
        $result =0;
    }
    return number_format((float)$result, 2, '.', '');
}

function total_tournament_play_in_month($id){
    $total_played = Playerinboard::where('player_one',$id)->orWhere('player_two',$id)->orWhere('player_three',$id)->orWhere('player_four',$id)->whereMonth('created_at', Carbon::now()->month)->count();

    if ($total_played > 0)
    {
        return $total_played;
    }else{
        return 0;
    }
}



function bidding_result($board_id)
{
    try {
        DB::beginTransaction();
        $board = Roundludoboard::find($board_id);

        $tournament  = Tournament::find($board->tournament_id);

        if ($board != null){
            $bidding_details = Biding_details::where('tournament_id',$board->tournament_id)->where('round_id',$board->round_id)->where('board_id',$board->id)->get()->groupBy('bided_to');
            if (count($bidding_details) > 1){
                $player_in_board = Playerinboard::where('board_id',$board->id)->first();

                if ($player_in_board != null){
                    $bidding_details_winner = Biding_details::where('tournament_id',$board->tournament_id)->where('round_id',$board->round_id)->where('board_id',$board->id)->where('bided_to',$player_in_board->first_winner)->get();
                    $bidding_details_winner_amount = Biding_details::where('tournament_id',$board->tournament_id)->where('round_id',$board->round_id)->where('board_id',$board->id)->where('bided_to',$player_in_board->first_winner)->sum('bid_amount');
                    if (count($bidding_details_winner) >0){
                        $bidding_details_looser_coin = Biding_details::where('tournament_id',$board->tournament_id)->where('round_id',$board->round_id)->where('board_id',$board->id)->where('bided_to','!=',$player_in_board->first_winner)->sum('bid_amount');
                        $bidding_details_looser = Biding_details::where('tournament_id',$board->tournament_id)->where('round_id',$board->round_id)->where('board_id',$board->id)->where('bided_to','!=',$player_in_board->first_winner)->get();

                        $settings = Settings::first();
                        $result  = $settings->bidder_commission / 100;
                        $output = $bidding_details_looser_coin * $result;
                        $module = $output / $bidding_details_winner_amount;
                        $module = number_format((float)$module, 2, '.', '');

                        $result_admin  = $settings->admin_commission_from_bid / 100;
                        $output_admin = $bidding_details_looser_coin * $result_admin;
                        $module_admin = $output_admin / $bidding_details_winner_amount;
                        $module_admin = number_format((float)$module_admin, 2, '.', '');
                        foreach ($bidding_details_winner as $data_winner)
                        {
                            $user = User::find($data_winner->userid);
                            $user->update([
                                'paid_coin' => $user->paid_coin + ($data_winner->bid_amount * $module) +  $data_winner->bid_amount,
                            ]);
                            $data_winner->status = 1;
                            $data_winner->save();
                            BidderCommissionHistory::create([
                                'bidder_id' => $data_winner->userid,
                                'bidded_to_id' => $data_winner->bided_to,
                                'board_id' => $board->id,
                                'bid_amount' => $data_winner->bid_amount,
                                'bidder_amount' => $data_winner->bid_amount * $module,
                                'admin_commission' =>($data_winner->bid_amount * $module_admin),
                            ]);
                        }

                    }else{
                        $bidding_details_looser = Biding_details::where('tournament_id',$board->tournament_id)->where('round_id',$board->round_id)->where('board_id',$board->id)->where('bided_to','!=',$player_in_board->first_winner)->get();
//                                return $bidding_details_looser;
                        foreach ($bidding_details_looser as $data)
                        {
                            $user = User::find($data->userid);
                            $user->update([
                                'paid_coin' => $user->paid_coin += $data->bid_amount,
                            ]);
                            $data->status = 1;
                            $data->save();
                        }

                    }
                }else{
                    return api_response('success','Board Not found.');
                }
            }else{
                $player_in_board = Playerinboard::where('board_id',$board->id)->first();
                $bidding_details_looser = Biding_details::where('tournament_id',$board->tournament_id)->where('round_id',$board->round_id)->where('board_id',$board->id)->where('bided_to',$player_in_board->first_winner)->get();

                foreach ($bidding_details_looser as $data)
                {
                    $user = User::find($data->userid);
                    $user->update([
                        'paid_coin' => $user->paid_coin + $data->bid_amount,
                    ]);
                    $data->status = 1;
                    $data->save();
                }
                DB::commit();
                return api_response('success','Coin Refunded Because Biding on one side 1.');
            }

        }else{
            return api_response('success','Board Not Found.');
        }
    }catch (\Exception $ex){
        DB::rollBack();
        return $ex->getMessage();
    }

}
function verify_status($token,$user)
{
    $user_status = UserDevice::where('user_id',$user)->where('device_token',$token)->first();
    if ($user_status != null)
    {
        if ($user_status->status == 0){
            $output = false;
        }elseif ($user_status->status == 1){
            $output = true;
        }
    }else{
        $device_id = UserDevice::create([
            'device_token' =>$token,
            'user_id' => $user,
            'status' => 0, //0 means not verified
        ]);
        $output = false;
    }
    return $output;
}


function notification_store($title,$type,$tournament_id,$offer_id)
{
    $offer_tournament_notification = new Notification();
    $offer_tournament_notification->offer_tournament_id = $offer_id;
    $offer_tournament_notification->type = $type;
    $offer_tournament_notification->title = $title;
    $offer_tournament_notification->tournament_id = $tournament_id;
    $offer_tournament_notification->save();
}

function remain_running_board($id,$round_id){
    $board=Roundludoboard::find($id);
    $datas=Roundludoboard::where(['tournament_id'=>$board->tournament_id,'game_id'=>$board->game_id,'round_id'=>$round_id,'status'=>1])->get();
    return count($datas);
}

function get_advertisement_setting(){
    return AdvertisementSetting::first();
}

if (!function_exists('calculatePercentage')) {
    function calculatePercentage(int|float $number, int|float $percentage): int|float
    {
        return ($number * $percentage) / 100;
    }
}

if (!function_exists('getProductTotalReview')) {
    function getProductTotalReview($product): int
    {
        return $product?->reviews?->count();
    }
}

if (!function_exists('getProductAverageRating')) {
    function getProductAverageRating($product): int|float
    {
        $reviews = \App\Models\Ecommerce\Review::where('product_id', $product->id)->get();

        $numberOfRatings = $reviews->count();

        $sumOfRatings = $reviews->sum('rating');

        if ($numberOfRatings > 0) {
            return $sumOfRatings / $numberOfRatings;
        } else {
            return 0;
        }
    }

}

