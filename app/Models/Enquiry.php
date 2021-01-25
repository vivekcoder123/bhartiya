<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
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
}
