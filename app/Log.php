<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Log extends Model
{
    use SoftDeletes;

    /**
     * 論理削除カラム
     */
    protected $dates = ['deleted_at'];

    /**
     * ホワイトリスト
     */
    protected $fillable = ['result'];

    /**
     * JSON serialization
     */
    protected function serializeDate(DateTimeInterface $data)
    {
        return $data->format('Y-m-d H:i:s');
    }
}
