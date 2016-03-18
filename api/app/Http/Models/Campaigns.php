<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Campaigns extends Model

{
    private static $_instance = null;
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

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Campaigns();
        return self::$_instance;
    }


    /**
     * Get All Flashsale Based on available from and available upto time.
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 23-02-2016
     * @author Vini Dubey <vinidubey@globussoft.com>
     */
    public function getFlashsaleDetail($where, $selectedColumns = ['*'])
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select()
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
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