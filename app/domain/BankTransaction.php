<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model
{
    protected $fillable = ['transaction_date', 'transaction_id', 'amount','description','type'];
}
