<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use App\Filament\Support\SectionSchema;
use App\Models\PageSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * The blocks that make up a page. The editing form is generated from the
 * section's type — see config/sections.php and Filament\Support\SectionSchema.
 */
class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $title = 'Sections';

    protected static ?string $recordTitleAttribute = 'key';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Block')
                ->schema([
                    Forms\Components\TextInput::make('key')
                        ->required()
                        ->maxLength(120)
                        ->unique(ignoreRecord: true)
                        ->disabledOn('edit')
                        ->helperText('Where this block sits in the site content, e.g. home.faq. Cannot be changed later.'),

                    Forms\Components\Select::make('type')
                        ->required()
                        ->live()
                        ->searchable()
                        ->options(collect(config('sections.types', []))
                            ->map(fn (array $type, string $key) => $type['label'] ?? $key)
                            ->sort()
                            ->all())
                        ->helperText('Decides which fields this block offers.'),

                    Forms\Components\Toggle::make('is_visible')
                        ->label('Shown on the site')
                        ->default(true),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ])
                ->columns(2),

            // Rebuilt whenever the type changes, so the fields always match.
            Forms\Components\Group::make()
                ->key('section-body')
                ->schema(fn (Forms\Get $get): array => SectionSchema::make($get('type')))
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('key')
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Block')
                    ->weight('medium')
                    ->description(fn (PageSection $record) => $record->typeLabel())
                    ->searchable(),
                Tables\Columns\TextColumn::make('summary')
                    ->label('Preview')
                    ->getStateUsing(fn (PageSection $record) => static::preview($record))
                    ->wrap()
                    ->limit(90)
                    ->color('gray'),
                Tables\Columns\TextColumn::make('languages')
                    ->badge()
                    ->getStateUsing(fn (PageSection $record) => static::missingLocales($record))
                    ->color(fn (string $state) => $state === 'complete' ? 'success' : 'danger')
                    ->tooltip('Locales with nothing filled in'),
                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Live')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add section'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit content')->slideOver(false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }

    /** First readable line of the block, so the list is scannable. */
    protected static function preview(PageSection $record): ?string
    {
        $values = $record->resolve(config('locales.default', 'az'));

        foreach (['title', 'name', 'label', 'tagline', 'siteName', 'brand'] as $candidate) {
            if (filled($values[$candidate] ?? null) && is_string($values[$candidate])) {
                return $values[$candidate];
            }
        }

        $first = collect($values)->first(fn ($value) => is_string($value) && filled($value));

        return $first ?: null;
    }

    /**
     * Locales this block has no content for at all. A half-filled tab is fine:
     * the API falls back field by field.
     *
     * @return array<int, string>
     */
    protected static function missingLocales(PageSection $record): array
    {
        $translated = array_filter(
            $record->schema(),
            fn (array $field) => ! ($field['shared'] ?? false)
        );

        if ($translated === []) {
            return ['complete'];
        }

        $data = $record->data ?? [];

        $missing = collect(config('locales.supported', []))
            ->reject(fn (string $locale) => filled(array_filter($data[$locale] ?? [])))
            ->map(fn (string $locale) => strtoupper($locale))
            ->values()
            ->all();

        return $missing ?: ['complete'];
    }
}
