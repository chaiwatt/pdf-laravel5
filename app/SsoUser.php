<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SsoUser extends Model
{
    protected $table = 'sso_users';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'name',
                            'username',
                            'password',
                            'picture',
                            'email',
                            'contact_name',
                            'contact_tax_id',
                            'contact_prefix_name',
                            'contact_prefix_text',
                            'contact_first_name',
                            'contact_last_name',
                            'contact_tel',
                            'contact_fax',
                            'contact_phone_number',
                            'contact_address_no',
                            'contact_building',
                            'contact_street',
                            'contact_moo',
                            'contact_soi',
                            'contact_subdistrict',
                            'contact_district',
                            'contact_province',
                            'contact_zipcode',
                            'contact_position',
                            'block',
                            'sendEmail',
                            'registerDate',
                            'lastvisitDate',
                            'params',
                            'lastResetTime',
                            'resetCount',
                            'applicanttype_id',
                            'date_niti',
                            'person_type',
                            'tax_number',
                            'nationality',
                            'date_of_birth',
                            'branch_code',
                            'branch_type',
                            'prefix_name',
                            'prefix_text',
                            'person_first_name',
                            'person_last_name',
                            'address_no',
                            'building',
                            'street',
                            'moo',
                            'soi',
                            'subdistrict',
                            'district',
                            'province',
                            'zipcode',
                            'tel',
                            'fax',
                            'personfile',
                            'corporatefile',
                            'remember_token',
                            'state',
                            'google2fa_status',
                            'google2fa_secret',
                            'latitude','longitude','juristic_status','check_api',
                            'name_en','address_en','moo_en','soi_en','street_en','subdistrict_en','district_en','province_en','zipcode_en',
                            'contact_address_en','contact_moo_en','contact_soi_en','contact_street_en','contact_subdistrict_en','contact_district_en','contact_province_en','contact_zipcode_en'
                        ];
}
