<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyPc extends Model
{
    public function getPcPrice($conditions, $params = []) {
        return $this->join('agency_pc_prices as a_p_p', function($join) {
                $join->on('a_p_p.agency_id', 'agency_pcs.agency_id');
                $join->on('a_p_p.pc_type_id', 'agency_pcs.pc_type_id');
            })
            ->where($conditions)
            ->get();
    }
}
