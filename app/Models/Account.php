<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'accounts';

    protected $fillable = ['name','email','cell_phone','status','type'];
	
}
