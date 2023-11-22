<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BalanceTransferHistory;
use App\Models\CoinEarningHistory;
use App\Models\DiamondSellHistory;
use App\Models\RankUpdateHistory;
use App\Models\ShareHolder;
use App\Models\ShareTransferHistory;
use App\Models\TokenTransferHistory;
use App\Models\TokenUseHistory;
use App\Models\Tournament;
use App\Models\User;
use App\Models\WithdrawHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{


    public function rank_wise_user($rank_name, $type)
    {
        $users = get_rank_wise_user($rank_name, $type);
        return view('webend.report.rank_wise_user', compact('users', 'rank_name', 'type'));
    }


    public function rank_wise_user_search_by_date(Request $request, $rank_name, $type)
    {
        if ($request->isMethod("POST")) {
            $users = User::whereHas('rank', function ($query) use ($rank_name) {
                $query->where('priority', $rank_name);
            })->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $users = User::whereHas('rank', function ($query) use ($rank_name) {
                $query->where('priority', $rank_name);
            })->get();
        }

        return view('webend.report.rank_wise_user', compact('users', 'rank_name', 'type'));
    }

    public function share_owner()
    {
        $datas = get_share_owners();
        return view('webend.report.share_owner', compact('datas'));
    }

    public function share_holder_list()
    {
        $datas = get_share_holders();
        return view('webend.report.share_holder', compact('datas'));
    }


    public function get_share_holders_by_date(Request $request)
    {

        if ($request->isMethod("POST")) {
            $datas = ShareHolder::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $datas = ShareHolder::query()->orderBy('id', 'DESC')->get();
        }

        return view('webend.report.share_holder', compact('datas'));
    }



    public function diamond_holder_user()
    {
        $users = get_total_diamond_balance();
        return view('webend.report.diamond_holder_user', compact('users'));
    }



    public function diamond_holder_user_by_date(Request $request)
    {

        if ($request->isMethod("POST")) {


            $users = User::where('paid_diamond', '>', 0)->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $users = User::query()->where('paid_diamond', '>', 0)->orderBy('id', 'DESC')->get();
        }

        return view('webend.report.diamond_holder_user', compact('users'));
    }



    public function diamond_purchase_history()
    {
        $datas = get_total_purchase_diamond();
        return view('webend.report.diamond_purchase_history', compact('datas'));
    }


    public function diamond_purchase_history_by_date(Request $request)
    {
        if ($request->isMethod("POST")) {
            $datas = DiamondSellHistory::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $datas = DiamondSellHistory::query()->orderBy('id', 'DESC')->get();
        }

        return view('webend.report.diamond_purchase_history', compact('datas'));
    }




    public function diamond_used_history_report()
    {
        $datas = get_total_purchase_used();
        return view('webend.report.diamond_used_history', compact('datas'));
    }

    public function get_earning_coin($earning_source)
    {
        $datas = get_earn_wining_coin($earning_source);
        return view('webend.report.coin_earning_list', compact('datas', 'earning_source'));
    }

    public function earning_coin_by_date(Request $request, $earning_source)
    {
        if ($request->isMethod("POST")) {
            $datas =  CoinEarningHistory::where('earning_source', $earning_source)->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $datas = CoinEarningHistory::where('earning_source', $earning_source)->get();
        }

        return view('webend.report.diamond_purchase_history', compact('datas'));
    }


    public function get_withdraw_coin($status)
    {
        $withdraws = get_total_withdraw($status);
        return view('webend.report.get_withdraw_coin', compact('withdraws'));
    }


    public function get_withdraw_coin_date(Request $request, $status)
    {
        if ($request->isMethod("POST")) {
            $withdraws =  WithdrawHistory::where('status', $status)
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)->get();
        } else {
            $withdraws = WithdrawHistory::where('status', $status)->get();
        }

        return view('webend.report.get_withdraw_coin', compact('withdraws'));
    }


    public function get_transfer_balance($constant_title)
    {
        $histories = get_total_balance_transfer($constant_title);
        return view('webend.report.get_balance_transfer', compact('histories'));
    }

    public function get_transfer_balance_date(Request $request, $constant_title)
    {
        if ($request->isMethod("POST")) {
            $histories =  BalanceTransferHistory::query()->where('constant_title', $constant_title)
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)->get();
        } else {
            $histories = BalanceTransferHistory::query()->where('constant_title', $constant_title)->get();
        }
        return view('webend.report.get_balance_transfer', compact('histories'));
    }



    public function get_coin_uses_history($purpose)
    {
        $histories = get_coin_uses_history($purpose);
        return view('webend.report.get_coin_uses_history', compact('histories'));
    }

    public function get_user_token($type)
    {
        $tokens = get_user_token($type);
        return view('webend.report.get_user_token', compact('tokens'));
    }

    public function get_token_used_history($type)
    {
        $histories = get_token_used_history($type);
        return view('webend.report.get_token_used_history', compact('histories'));
    }

    public function get_token_used_history_date(Request $request, $type)
    {
        if ($request->isMethod("POST")) {
            $histories =  TokenUseHistory::whereHas('user_token', function ($query) use ($type) {
                $query->where('type', $type);
            })->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)->get();
        } else {
            $histories = TokenUseHistory::whereHas('user_token', function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
        }

        return view('webend.report.get_token_used_history', compact('histories'));
    }



    public function get_source_wise_token($getting_source)
    {
        $tokens = get_source_wise_token($getting_source);
        return view('webend.report.get_user_token', compact('tokens'));
    }


    public function get_source_wise_token_date(Request $request, $type)
    {
        if ($request->isMethod("POST")) {

            $tokens = TokenTransferHistory::whereHas('user_token', function ($query) use ($type) {
                $query->where('type', $type);
            })->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $tokens = TokenTransferHistory::whereHas('user_token', function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
        }

        return view('webend.report.get_user_token', compact('tokens'));
    }







    public function get_token_transfer_history($type)
    {
        $histories = get_transfer_token_history($type);
        return view('webend.report.get_token_transfer_history', compact('histories'));
    }


    public function get_token_transfer_history_date(Request $request, $type)
    {
        if ($request->isMethod("POST")) {

            $histories = TokenTransferHistory::whereHas('user_token', function ($query) use ($type) {
                $query->where('type', $type);
            })->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $histories = TokenTransferHistory::whereHas('user_token', function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
        }

        return view('webend.report.get_token_transfer_history', compact('histories'));
    }


    public function get_share_transfer_history()
    {
        $histories = get_share_transfer_history();
        return view('webend.report.get_share_transfer_history', compact('histories'));
    }

    public function share_transfer_history_by_date(Request $request)
    {
        if ($request->isMethod("POST")) {
            $histories = ShareTransferHistory::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $histories = ShareTransferHistory::query()->orderBy('id', 'DESC')->get();
        }

        return view('webend.report.get_share_transfer_history', compact('histories'));
    }

    /**
     * Display Coin earning history
    */
    public function coin_earning_history(): View
    {
        return view('webend.report.get_coin_earning_history');
    }

    /**
     * Get datatable of coin_earning_history_datatable
    */
    public function coin_earning_history_datatable(Request $request): JsonResponse
    {
        $histories = CoinEarningHistory::whereType('user')->orderBy('id', 'DESC')->get();

        if (isset($request->startDate) && isset($request->endDate)) {
            $histories = CoinEarningHistory::whereDate('created_at', '>=', $request->startDate)
                ->whereDate('created_at', '<=', $request->endDate)->get();
        }

        return DataTables::of($histories)
            ->addIndexColumn()
            ->addColumn('username', function (CoinEarningHistory $history){
                return $history->user?->name;
            })->addColumn('userPlayerId', function (CoinEarningHistory $history){
                return $history->user?->playerid;
            })->addColumn('earning_source', function (CoinEarningHistory $history){
                return string_replace($history->earning_source);
            })->addColumn('earningDate', function (CoinEarningHistory $history){
                return Carbon::parse($history->created_at)->format('d-m-Y');
            })
            ->rawColumns(['username', 'userPlayerId', 'earning_source'])->make(true);
    }

    public function coin_earn_history_search_by_date(Request $request)
    {
        if ($request->isMethod("POST")) {
            $histories = CoinEarningHistory::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $histories = CoinEarningHistory::query()->orderBy('id', 'DESC')->get();
        }
        return view('webend.report.get_coin_earning_history', compact('histories'));
    }

    public function get_data_applied_users()
    {
        $datas = get_data_applied_users();
        return view('webend.report.get_data_applied_user', compact('datas'));
    }

    public function get_admin_tournament($game_type)
    {

        $tournaments = get_admin_tournament($game_type);
        return view('webend.report.get_admin_tournament', compact('tournaments', 'game_type'));
    }

    public function filter_admin_tournament($game_type, $player_type)
    {
        if ($player_type == "all") {
            $tournaments = get_admin_tournament($game_type);
        } else {
            $tournaments = Tournament::where('game_type', $game_type)
                ->where('player_type', $player_type)
                ->where('tournament_owner', Tournament::TOURNAMENT_OWNER[0])
                ->get();
        }
        return view('webend.report.get_admin_tournament', compact('tournaments', 'game_type'));
    }
}
