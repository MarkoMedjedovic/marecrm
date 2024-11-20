<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'nickname',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'memo',
        'has_cash_loan',
        'has_home_loan'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function scopeSearchCustomers($query, $input = null)
    {
        /*if(!empty($input)){
            if(Customer::where('name', 'like', '%'.$input.'%')->orWhere('first_name', 'like', '%'.$input.'%')->orWhere('last_name', 'like', '%'.$input.'%')->orWhere('tel', 'like', $input.'%')->exists())
            {
                return $query->where('name', 'like', '%'.$input.'%')->orWhere('first_name', 'like', '%'.$input.'%')->orWhere('last_name', 'like', '%'.$input.'%')->orWhere('tel', 'like', $input.'%');
            }

        }*/ 
        
        if(!empty($input)){
            if(Customer::whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%".$input."%"])->orWhere('tel', 'like', $input.'%')->exists())
            {
                return $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%".$input."%"])->orWhere('tel', 'like', $input.'%');
            }

        }
    }
}
