<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $primaryKey='id';
  protected $table = "comments";
  protected $fillable = ["email", "name", "comment", "status", "id_parent", "reply", "created_at", "updated_at"];
}
