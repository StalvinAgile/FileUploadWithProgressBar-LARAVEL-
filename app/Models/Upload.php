<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    public $table = 'uploads';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'Event_Name'
        , 'Type'
        , 'Parent_Event'
        , 'Organiser'
        , 'Start_Date'
        , 'Start_Time'
        , 'End_Date'
        , 'End_Time'
        , 'Description'
        , 'Featured'
        , 'Active'
        , 'Event_Link'
        , 'Venue_Name'
        , 'Address'
        , 'Town'
        , 'PostCode'
        , 'County'
        , 'Country',
    ];
}