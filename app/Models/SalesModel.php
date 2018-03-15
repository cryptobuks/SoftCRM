<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesModel extends Model
{
    /**
     * table name
     */
    protected $table = 'sales';
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return SalesModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    /**
     * @param $id
     * @param $allInputs
     * @return mixed
     */
    public static function updateRow($id, $allInputs)
    {
        return SalesModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    /**
     * @param $rulesType
     * @return array
     */
    public static function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required'
                ];
        }
    }

    /**
     * @param $id
     * @param $activeType
     * @return bool
     */
    public static function setActive($id, $activeType)
    {
        $findSalesById = SalesModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findSalesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countSales()
    {
        return count(SalesModel::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchSalesByValue($type, $value, $paginationLimit = 10)
    {
        return SalesModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}