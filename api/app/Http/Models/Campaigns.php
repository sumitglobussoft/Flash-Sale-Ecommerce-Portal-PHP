<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Campaigns extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'campaigns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['campaign_id', 'by_user_id', 'for_shop_id', 'campaign_type', 'campaign_banner', 'discount_type', 'discount_value', 'available_from', 'available_upto', 'for_category_ids', 'for_product_ids', 'campaign_status', 'status_set_by'];


    /**
     * @return int
     */

    public function getFlashsaleDetail()
    {

        try {
            $result = DB::table("campaigns")
                ->select()
                ->where('available_from', '<', time())
                ->where('available_upto', '>', time())
                ->where('campaign_type', 2)
                ->get();

        } catch (QueryException $e) {
            echo $e;
        }
        if ($result) {
            return $result;
        } else {
            return 0;
        }

    }


    public function getDailyspecialDetail()
    {

        try {
            $result = DB::table("campaigns")
                ->select()
                ->where('available_from', '<', time())
                ->where('available_upto', '>', time())
                ->where('campaign_type', 1)
                ->get();

        } catch (QueryException $e) {
            echo $e;
        }
        if ($result) {
            return $result;
        } else {
            return 0;
        }

    }


    public function getCampaignProduct()
    {


    }


}