<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'questionnaire_id', 'answer'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
}
