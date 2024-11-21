<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if the table name is not the plural of the model name)
    protected $table = 'questionnaires';

    // Define the fields that are mass assignable
    protected $fillable = ['question'];

    public function vendorQuestionnaires()
    {
        return $this->hasMany(VendorQuestionnaire::class);
    }
}