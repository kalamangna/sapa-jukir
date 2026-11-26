<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang boleh diisi secara massal.
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'status',
    ];

    /**
     * Atribut yang disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, self::auditAttributes($model->getAttributes())));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', self::auditAttributes($model->getOriginal()), self::auditAttributes($model->getChanges())));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', self::auditAttributes($model->getOriginal()), null));
    }

    private static function auditAttributes(array $attributes): array
    {
        unset($attributes['password'], $attributes['remember_token']);

        return $attributes;
    }

    /**
     * Mengecek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Mengecek apakah user adalah operator.
     */
    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    /**
     * Mengecek apakah user adalah pimpinan.
     */
    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    /**
     * Mengecek apakah akun aktif.
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }
}