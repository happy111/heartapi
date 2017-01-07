<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer extends Model {

   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'customers';

   /**
    * The database primary key value.
    *
    * @var string
    */
   protected $primaryKey = 'id';

   /**
    * Attributes that should be mass-assignable.
    *
    * @var array
    */
   protected $fillable = ['user_id','fname', 'lname', 'mname', 'dob', 'facebook', 'mobile',  'pass', 'status'];

   public function country() {
      return $this->belongsTo("App\country", 'country_id');
   }

   public function state() {
      return $this->belongsTo("App\state", 'state_id');
   }

   public function city() {
      return $this->belongsTo("App\cities", 'city_id');
   }

}
