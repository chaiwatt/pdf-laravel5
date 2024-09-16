<?php

namespace App;

use App\SsoUser;
use Illuminate\Database\Eloquent\Model;

class TisiLab extends Model
{

    protected $table = "app_certi_labs";
    protected $primaryKey = 'id';
    protected $fillable = [

        'app_no',
        'applicanttype_id',
        'name',
        'tax_id',
        'purpose_type',
        'standard_id',
        'lab_type',
        'certificate_exports_id',
        'accereditation_no',
        'type_standard',
        'branch_name',
        'branch_type',
        'branch',
        'lab_name',
        'start_date',
        'same_address',
        'address_no',
        'allay',
        'village_no',
        'road',
        'province',
        'amphur',
        'district',
        'postcode',
        'tel',
        'tel_fax',
        'contactor_name',
        'email',
        'contact_tel',
        'telephone',
        'management_lab',
        'status',
        'subgroup',
        'trader_id',
        'created_by',
        'agent_id',
        'desc_delete',
        'attach',
        'attach_pdf',
        'attach_pdf_client_name',
        'checkbox_confirm',
        'token',
        'get_date',
        'lab_latitude',
        'lab_longitude',
        'lab_name_en',
        'lab_name_short',
        'lab_address_no_eng',
        'lab_moo_eng',
        'lab_soi_eng',
        'lab_street_eng',
        'lab_province_eng',
        'lab_amphur_eng',
        'lab_district_eng',
        'lab_postcode_eng',
        'lab_ability',
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
        'hq_fax'
    ];

    public function ssoUser()
    {
        return $this->belongsTo(SsoUser::class, 'created_by');
    }
    
}
