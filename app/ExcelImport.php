<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcelImport extends Model
{
    //
	protected $table = 'excel';

    protected $fillable = [
    		'excel_file',
    		'excel_data'
    ];
}
