<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Support\LocaleTabs;
use App\Filament\Support\SeoFields;
use App\Filament\Support\TranslationStatus;
use App\Models\Service;
use App\Filament\Concerns\AuthorizesResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    use AuthorizesResource;

    protected static string $permissionSubject = 'services';

    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identification')->schema([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(120)
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, Forms\Set $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('icon')
                    ->maxLength(120)
                    ->helperText('Heroicon name, e.g. heroicon-o-code-bracket-square'),
                Forms\Components\Toggle::make('is_published')->default(true),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2),

            // `build` (not `make`): the FAQ repeater owns a nested schema, and
            // cloned children would all point at the first tab's container.
            Forms\Components\Section::make('Translations')->schema(
                LocaleTabs::build(fn (string $locale) => [
                    Forms\Components\TextInput::make("title.$locale")
                        ->label('Title')
                        ->required()
                        ->maxLength(160),
                    Forms\Components\Textarea::make("summary.$locale")
                        ->label('Summary')
                        ->rows(3)
                        ->required()
                        ->maxLength(400),
                    Forms\Components\Textarea::make("description.$locale")
                        ->label('Description')
                        ->rows(6)
                        ->required(),
                    Forms\Components\Repeater::make("features.$locale")
                        ->label('Features')
                        ->simple(Forms\Components\TextInput::make('feature')->required())
                        ->defaultItems(0)
                        ->reorderable(),
                    Forms\Components\Repeater::make("faq.$locale")
                        ->label('FAQ')
                        ->helperText('Shown on the service page above "The road to your project" — and submitted to search engines as FAQ structured data.')
                        ->schema([
                            Forms\Components\TextInput::make('question')
                                ->required()
                                ->maxLength(200),
                            Forms\Components\Textarea::make('answer')
                                ->rows(3)
                                ->required(),
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                        ->defaultItems(0)
                        ->collapsible()
                        ->reorderable(),
                ])
            ),

            SeoFields::section(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (Service $r) => $r->getTranslation('title', config('locales.default'))),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                TranslationStatus::column(['title', 'summary', 'description', 'features']),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Live'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('Y-m-d H:i')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
