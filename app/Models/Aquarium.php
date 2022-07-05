<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aquarium extends Model
{
    use HasFactory;

    // モデルとテーブルの紐づけ
    protected $table = 'aquariums';

    //データの取得(ランダム)
    static function getRandomData($pageCount)
    {
        $data['aquariums'] = Aquarium::inRandomOrder()->orderBy('id', 'desc')->simplePaginate($pageCount);
        return $data;
    }
}
