<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Ties a Filament resource to the permission subject it belongs to, so the
 * navigation entry, the buttons and the routes all follow the same grant.
 *
 * A resource using this trait declares:
 *
 *     protected static string $permissionSubject = 'pages';
 *
 * Filament calls these static checks itself, which is why no policy class is
 * needed for each model.
 */
trait AuthorizesResource
{
    protected static function allows(string $ability): bool
    {
        $subject = static::$permissionSubject ?? null;

        if ($subject === null) {
            return true;
        }

        return (bool) auth()->user()?->can("$subject.$ability");
    }

    public static function canViewAny(): bool
    {
        return static::allows('view');
    }

    public static function canView(Model $record): bool
    {
        return static::allows('view');
    }

    public static function canCreate(): bool
    {
        return static::allows('create');
    }

    public static function canEdit(Model $record): bool
    {
        return static::allows('update');
    }

    public static function canDelete(Model $record): bool
    {
        return static::allows('delete');
    }

    public static function canDeleteAny(): bool
    {
        return static::allows('delete');
    }
}
