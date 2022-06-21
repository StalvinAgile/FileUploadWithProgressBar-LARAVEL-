<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    public $table = 'file_uploads';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'file_name'
  ];
}
