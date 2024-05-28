<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rent extends Model
{
  use HasFactory;

  public const STATUS_APPROVED = 'APPROVED';
  public const STATUS_REJECTED = 'REJECTED';
  public const STATUS_PENDING = 'PENDING';
  public const STATUS_CANCELLED = 'CANCELLED';
  public const STATUS_RETURNED = 'RETURNED';

  protected $fillable = [
    'user_id',
    'book_id',
    'due_date',
    'return_date',
    'status',
    'reason',
  ];


  public function borrower()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function book()
  {
    return $this->belongsTo(Book::class, 'book_id');
  }
}
