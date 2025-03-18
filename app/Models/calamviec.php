<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class calamviec extends Model
{
    protected $table = 'calamviec';
    protected $fillable = ['TenLoaiCa', 'Giobatdau', 'Gioketthuc'];
    public $timestamps = false;
    public function lichLamViec()
    {
        return $this->hasMany(lichlamviec::class, 'ca_id');
    }
}
