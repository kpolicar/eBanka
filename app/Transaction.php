<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'user_id',
        'purpose',
        'method',
        'amount',
        'ip_address',
        'transferred_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'ip_address',
    ];

    /**
     * The attributes that should be handled as carbon dates.
     *
     * @var array
     */
    protected $dates = ['transferred_at'];

    /**
     * The user that had made the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The account the transaction was made on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    /**
     * Get the 'type' attribute.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        if($this->attributes['method'] == false) { return 'Dvig'; }
        else { return 'Polog'; }
    }

    /**
     * All the already transferred transactions.
     *
     * @param $query
     */
    public function scopeTransferred($query)
    {
        $query->where('transferred_at', '<=', Carbon::now());
    }

    /**
     * All the not yet transferred transactions.
     *
     * @param $query
     */
    public function scopeUntransferred($query)
    {
        $query->where('transferred_at', '>=', Carbon::now());
    }

    /**
     * Set the 'transferred_at' attribute.
     *
     * @param $date
     */
    public function setTransferredAtAttribute($date)
    {
        $this->attributes['transferred_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
     * Get the 'transferred_at' attribute.
     *
     * @param $date
     * @return Carbon
     */
    public function getTransferredAtAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function formatAmount()
    {
        if($this->attributes['method'] == false)
        {
            return '- €'.  number_format($this->amount, 2);
        }
        else
        {
            return '+ €' . number_format($this->amount, 2);
        }
    }

    public function formatAmountColored($classes)
    {
        $amount = $this->formatAmount();
        if($this->attributes['method'] == false)
        {
            return "<span class='text-danger $classes'>$amount</span>";
        }
        else
        {
            return "<span class='text-success $classes'>$amount</span>";
        }
    }
}
