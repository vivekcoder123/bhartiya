<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    const ENQUIRY_SUBMITTED = 0;
    const ENQUIRY_SUBMITTED_NAME = "SUBMITTED";
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
    public function designation(){
        return $this->hasOne('App\Models\Designation','id','designation_id');
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
