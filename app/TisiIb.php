<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TisiIb extends Model
{
    protected $table = "app_certi_ib";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_no',
                            'applicanttype_id',
                            'name',
                            'status',
                            'standard_change',
                            'type_unit',
                            'name_unit',
                            'branch',
                            'branch_type',
                            'type_standard',
                            'app_certi_ib_export_id',
                            'accereditation_no',
                             'checkbox_address',
                             'address',
                             'allay',
                             'village_no',
                             'road',
                             'province_id',
                             'amphur_id',
                             'district_id',
                             'postcode',
                             'tel',
                             'tel_fax',
                             'contactor_name',
                             'email',
                             'contact_tel',
                             'telephone',
                             'petitioner',
                             'desc_delete',
                             'review',
                             'token',
                             'date',
                             'checkbox_confirm',
                             'created_by', //tb10_nsw_lite_trader
                             'agent_id',
                             'updated_by',
                             'start_date',
                             'tax_id',
                             'hq_address',
                             'hq_moo',
                             'hq_soi',
                             'hq_road',
                             'hq_subdistrict_id',
                             'hq_district_id',
                             'hq_province_id',
                             'hq_zipcode',
                             'hq_date_registered',
                             'hq_telephone',
                             'hq_fax',
             
                             'ib_latitude', 
                             'ib_longitude', 
             
                             'name_en_unit',
                             'name_short_unit',
             
                             'ib_address_no_eng',
                             'ib_moo_eng',
                             'ib_soi_eng',
                             'ib_street_eng',
                             'ib_province_eng',
                             'ib_amphur_eng',
                             'ib_district_eng',
                             'ib_postcode_eng'
                            ];
    public function ssoUser()
    {
        return $this->belongsTo(SsoUser::class, 'created_by');
    }                         
}
