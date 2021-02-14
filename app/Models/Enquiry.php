<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $table = 'enquiries';
    protected $guarded = "id";

    const ENQUIRY_SUBMITTED = 0;
    const CUSTOMER_CONTACTED = 2;
    const DOCUMENTS_UPLOAD_PENDING = 3;
    const APPLICATION_SENT_FOR_SIGNATURE = 4;
    const SENT_BACK_BY_BANK = 5;
    const LOGIN_ACCEPTED_BY_BANK = 6;
    const ADDITIONAL_DOCUMENT_REQUIRED = 7;
    const APPROVAL_PENDING = 8;
    const APPROVED = 1;
    const PENDING_FOR_DISBURSEMENT = 11;
    const LOAN_DISBURSED = 100;
    const REJECTED = 21;
    const REJECTED_RELOOK = 22;
    const SALARY = "Salary";
    const BUSINESS = "Business";
    const STATUSES_ARRAY = [
        'ENQUIRY SUBMITTED'=>self::ENQUIRY_SUBMITTED,
        'CUSTOMER CONTACTED'=>self::CUSTOMER_CONTACTED,
        'DOCUMENTS UPLOAD PENDING'=>self::DOCUMENTS_UPLOAD_PENDING,
        'APPLICATION SENT FOR SIGNATURE'=>self::APPLICATION_SENT_FOR_SIGNATURE,
        'SENT BACK BY BANK'=>self::SENT_BACK_BY_BANK,
        'LOGIN ACCEPTED BY BANK'=>self::LOGIN_ACCEPTED_BY_BANK,
        'ADDITIONAL DOCUMENT REQUIRED'=>self::ADDITIONAL_DOCUMENT_REQUIRED,
        'APPROVAL PENDING'=>self::APPROVAL_PENDING,
        'APPROVED'=>self::APPROVED,
        'PENDING FOR DISBURSEMENT'=>self::PENDING_FOR_DISBURSEMENT,
        'LOAN DISBURSED'=>self::LOAN_DISBURSED,
        'REJECTED'=>self::REJECTED,
        'REJECTED RELOOK'=>self::REJECTED_RELOOK
    ];
    const STATUS_NAME_QUERY = "(CASE WHEN status=0 THEN 'ENQUIRY SUBMITTED'
    WHEN status=2 THEN 'CUSTOMER CONTACTED'
    WHEN status=3 THEN 'DOCUMENTS UPLOAD PENDING'
    WHEN status=4 THEN 'APPLICATION SENT FOR SIGNATURE'
    WHEN status=5 THEN 'SENT BACK BY BANK'
    WHEN status=6 THEN 'LOGIN ACCEPTED BY BANK'
    WHEN status=7 THEN 'ADDITIONAL DOCUMENT REQUIRED'
    WHEN status=8 THEN 'APPROVAL PENDING'
    WHEN status=1 THEN 'APPROVED'
    WHEN status=11 THEN 'PENDING FOR DISBURSEMENT'
    WHEN status=100 THEN 'LOAN DISBURSED'
    WHEN status=21 THEN 'REJECTED'
    WHEN status=22 THEN 'REJECTED RELOOK'
    ELSE NULL END
    ) as status_name";

    public function service(){
        return $this->hasOne('App\Models\Service','id','service_id');
    }
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
    public function relationship_manager(){
        return $this->hasOne('App\Models\Staff','id','relationship_manager_id');
    }
    public function bank(){
        return $this->hasOne('App\Models\Bank','id','bank_id');
    }
    public function propose_bank(){
        return $this->hasOne('App\Models\Bank','id','propose_bank_id');
    }

    public function location(){
        return $this->hasOne('App\Models\Location','id','location_id');
    }

    public function enquiry_status(){
        return $this->hasMany('App\Models\EnquiryStatusTracking','enquiry_id','id');
    }

    public function enquiry_activiy(){
        return $this->hasMany('App\Models\EnquiryActivityTracking','enquiry_id','id');
    }

    public function existing_loan(){
        return $this->hasMany('App\Models\ExistingLoanDetail','enquiry_id','id');
    }
}
