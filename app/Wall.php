<?php 
namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Wall extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wall';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
          'Wall_Name', 'Temp_Name', 'Temp_ID','Deceased_Name','Deceased_Father_Name','Deceased_Husband_Name',
		   'Relation_With_Deceased','DOB_Of_Deceased', 'DOD_Of_Deceased','Deceased_Photo','Demise_Message','Is_Shareable'
      ];    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}