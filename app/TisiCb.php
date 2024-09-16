<?php

namespace App;

use App\SsoUser;
use Illuminate\Database\Eloquent\Model;

class TisiCb extends Model
{
    protected $table = "app_certi_cb";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_no',
                            'applicanttype_id',
                            'name',
                            'tax_id',
                            'cb_name',
                            'start_date',
                            'status',
                            'standard_change',
                            'app_certi_cb_export_id',
                            'accereditation_no',
                            'type_standard',
                            'name_standard',
                            'branch_type',
                            'branch',
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
                            'details',
                            'desc_delete',
                            'review',
                            'token',
                            'save_date',
                            'checkbox_confirm',
                            'created_by',
                            'agent_id',
                            'updated_by',
                            'get_date',
                            'check_badge',
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
                            'cb_latitude',
                            'cb_longitude',
                            'cb_address_no_eng',
                            'cb_moo_eng',
                            'cb_soi_eng',
                            'cb_street_eng',
                            'cb_province_eng',
                            'cb_amphur_eng',
                            'cb_district_eng',
                            'cb_postcode_eng',
                            'name_en_standard',
                            'name_short_standard'
        

                            ];
    public function ssoUser()
    {
        return $this->belongsTo(SsoUser::class, 'created_by');
    }

}
