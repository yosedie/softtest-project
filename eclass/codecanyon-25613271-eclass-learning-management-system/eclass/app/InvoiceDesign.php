<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDesign extends Model
{
    protected $table = 'invoice_design'; 
	
    protected $fillable = ['logo_enable', 'print_type', 'border_enable', 'border_radius', 'border_color', 'border_style', 'date_format'];

}
