<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'id_laporan',
        'user_id',
        'jenis_laporan',
        'kategori',
        'judul',
        'deskripsi',
        'kecamatan',
        'desa',
        'detail_alamat',
        'foto',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'foto' => 'array',
        ];
    }

    /**
     * Boot: auto-generate ID laporan
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($laporan) {
            if (empty($laporan->id_laporan)) {
                $prefix = $laporan->jenis_laporan === 'pengaduan' ? 'ADU' : 'ASP';
                $laporan->id_laporan = $prefix . '-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Relationship: pelapor
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get route key name for route model binding
     */
    public function getRouteKeyName(): string
    {
        return 'id_laporan';
    }
}
