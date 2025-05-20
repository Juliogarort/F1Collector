<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'f1collector_discounts';

    protected $fillable = [
        'code', 'type', 'discount_amount', 'discount_percentage',
        'category_id', 'product_id', 'usage_limit', 'used', 'expires_at'
    ];

    protected $dates = ['expires_at'];

    public function isValid()
    {
        return ($this->usage_limit === null || $this->used < $this->usage_limit)
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function apply($total)
    {
        if (!$this->isValid()) return $total;

        if ($this->discount_amount) {
            return max(0, $total - $this->discount_amount);
        }

        if ($this->discount_percentage) {
            return $total - ($total * ($this->discount_percentage / 100));
        }

        return $total;
    }
}
