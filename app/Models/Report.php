<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [''];
    // protected $fillable = [
    //     'user_id',
    //     'description',
    //     'type',
    //     'province',
    //     'regency',
    //     'subdistrict',
    //     'village',
    //     'voting',
    //     'viewers',
    //     'image',
    //     'statement',
    // ];

// App\Models\Report.php
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

// public function user()
// {
//     return $this->belongsTo(User::class);
// }

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function responses()
{
    return $this->hasMany(Response::class);
}

protected $casts = [
    'voting' => 'array',
];

// protected $attributes = [
//     'voting' => '{"total_votes": 0, "voters": []}',
// ];


}
