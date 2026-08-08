<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use App\Filament\Concerns\AuthorizesResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    use AuthorizesResource;

    protected static string $permissionSubject = 'leads';

    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationGroup = 'Inbox';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::whereNull('handled_at')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Lead')->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('phone'),
                Forms\Components\TextInput::make('company'),
                Forms\Components\TextInput::make('service'),
                Forms\Components\Select::make('locale')
                    ->options(fn () => collect(config('locales.supported', []))
                        ->mapWithKeys(fn ($l) => [$l => strtoupper($l)])
                        ->all()),
                Forms\Components\Textarea::make('message')->rows(6)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Meta')->schema([
                Forms\Components\TextInput::make('source_url')->columnSpanFull(),
                Forms\Components\TextInput::make('ip'),
                Forms\Components\Textarea::make('user_agent')->rows(2),
                Forms\Components\DateTimePicker::make('handled_at')->native(false),
            ])->columns(2)->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('service')->badge(),
                Tables\Columns\TextColumn::make('locale')->badge()->color('gray'),
                Tables\Columns\IconColumn::make('handled_at')
                    ->label('Handled')
                    ->boolean()
                    ->getStateUsing(fn (Lead $r) => $r->handled_at !== null),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('handled')
                    ->label('Handled')
                    ->placeholder('All')
                    ->trueLabel('Handled')
                    ->falseLabel('Pending')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('handled_at'),
                        false: fn ($query) => $query->whereNull('handled_at'),
                    ),
                Tables\Filters\SelectFilter::make('locale')
                    ->options(fn () => collect(config('locales.supported', []))
                        ->mapWithKeys(fn ($l) => [$l => strtoupper($l)])
                        ->all()),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_handled')
                    ->label('Mark handled')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Lead $r) => $r->handled_at === null)
                    ->action(fn (Lead $r) => $r->update(['handled_at' => now()])),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'view' => Pages\ViewLead::route('/{record}'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
