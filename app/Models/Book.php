<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
  use HasFactory, SoftDeletes;

  public const STATUS_NOT_AVAILABLE = 0;
  public const STATUS_AVAILABLE = 1;


  protected $fillable = [
    'title',
    'author',
    'genre',
    'book_number',
    'is_available',
  ];

  public function prettyStatus()
  {
    return $this->is_available ? 'Available' : 'Not Available';
  }

  public function rents()
  {
    return $this->hasMany(Rent::class, 'book_id');
  }
}
