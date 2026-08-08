<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\AuthorizesResource;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Support\Permissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    use AuthorizesResource;

    protected static string $permissionSubject = 'users';

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Access';

    protected static ?int $navigationSort = 90;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Account')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(120),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(180),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->minLength(8)
                        ->required(fn (string $operation) => $operation === 'create')
                        ->dehydrated(fn (?string $state) => filled($state))
                        ->dehydrateStateUsing(fn (string $state) => Hash::make($state))
                        ->helperText('Leave empty to keep the current password.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Can sign in')
                        ->default(true)
                        ->helperText('Switch off to revoke access without deleting the account.'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Roles')
                ->description('What this person may do. Without a role the admin panel stays closed.')
                ->schema([
                    Forms\Components\CheckboxList::make('roles')
                        ->hiddenLabel()
                        ->relationship('roles', 'name')
                        ->descriptions(fn () => self::roleDescriptions())
                        ->columns(2)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('medium'),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->label('Roles')
                    ->placeholder('no role — cannot sign in')
                    ->color(fn (string $state) => $state === Permissions::SUPER_ADMIN ? 'danger' : 'success'),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-d')->sortable()->toggleable(),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\SelectFilter::make('roles')->relationship('roles', 'name')->label('Role'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    // Locking yourself out of the panel is not a recoverable
                    // mistake from inside the panel.
                    ->hidden(fn (User $record) => $record->is(auth()->user())),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /** @return array<string, string> */
    private static function roleDescriptions(): array
    {
        return [
            Permissions::SUPER_ADMIN => 'Everything, including users and roles.',
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
