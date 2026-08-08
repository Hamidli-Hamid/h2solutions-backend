<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\AuthorizesResource;
use App\Filament\Resources\RoleResource\Pages;
use App\Support\Permissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    use AuthorizesResource;

    protected static string $permissionSubject = 'roles';

    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Access';

    protected static ?string $navigationLabel = 'Roles & permissions';

    protected static ?int $navigationSort = 91;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Role')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(80)
                        ->unique(ignoreRecord: true)
                        ->disabled(fn (?Role $record) => $record?->name === Permissions::SUPER_ADMIN)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (?string $state, Forms\Set $set) => $set('name', Str::slug((string) $state)))
                        ->helperText('Short identifier, e.g. editor or translator.'),

                    Forms\Components\Hidden::make('guard_name')->default('web'),
                ]),

            Forms\Components\Section::make('Permissions')
                ->description('What this role may do in each area of the admin.')
                ->schema(self::permissionGroups())
                // Super-admin is allowed everything by rule, so there is
                // nothing to tick — see AppServiceProvider::boot().
                ->hidden(fn (?Role $record) => $record?->name === Permissions::SUPER_ADMIN),

            Forms\Components\Placeholder::make('super_admin_note')
                ->hiddenLabel()
                ->content('This role is allowed everything, including permissions added in the future.')
                ->visible(fn (?Role $record) => $record?->name === Permissions::SUPER_ADMIN),
        ]);
    }

    /**
     * One checkbox group per subject, built from the catalogue so a new area
     * shows up here without touching this file.
     *
     * @return array<int, Forms\Components\Component>
     */
    private static function permissionGroups(): array
    {
        $groups = [];

        foreach (Permissions::grouped() as $label => $options) {
            /* Plain checkbox lists rather than relationship fields: they all
               edit the same relationship, which the page class syncs in one
               go — see CreateRole / EditRole. */
            $groups[] = Forms\Components\CheckboxList::make('permission_groups.' . Str::slug($label))
                ->label($label)
                ->options($options)
                ->columns(4)
                ->bulkToggleable()
                ->columnSpanFull();
        }

        return $groups;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->badge()
                    ->color(fn (string $state) => $state === Permissions::SUPER_ADMIN ? 'danger' : 'gray'),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Permissions')
                    ->formatStateUsing(fn (Model $record, int $state) => $record->name === Permissions::SUPER_ADMIN
                        ? 'all'
                        : (string) $state),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('People'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('Y-m-d H:i')->sortable(),
            ])
            ->defaultSort('name')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (Role $record) => $record->name === Permissions::SUPER_ADMIN),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
