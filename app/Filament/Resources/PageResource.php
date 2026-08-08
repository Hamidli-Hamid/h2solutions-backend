<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers\SectionsRelationManager;
use App\Filament\Support\SeoFields;
use App\Models\Page;
use App\Filament\Concerns\AuthorizesResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    use AuthorizesResource;

    protected static string $permissionSubject = 'pages';

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Pages & sections';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Page')
                ->schema([
                    Forms\Components\TextInput::make('label')
                        ->required()
                        ->maxLength(120)
                        ->helperText('Name shown in this admin only.'),

                    Forms\Components\TextInput::make('key')
                        ->required()
                        ->maxLength(120)
                        ->unique(ignoreRecord: true)
                        ->disabledOn('edit')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (?string $state, Forms\Set $set) => $set('key', Str::slug((string) $state)))
                        ->helperText('Identifier the website asks for. Cannot be changed once the page exists.'),

                    Forms\Components\Select::make('group')
                        ->required()
                        ->default('page')
                        ->options([
                            'page' => 'Page — a real route',
                            'layout' => 'Layout — appears on every page',
                            'template' => 'Template — SEO defaults of a detail route',
                        ]),

                    Forms\Components\TextInput::make('path')
                        ->label('Route')
                        ->maxLength(180)
                        ->placeholder('/about')
                        ->helperText('Path under the language prefix, e.g. /services/{slug}.'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ])
                ->columns(2),

            SeoFields::section(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('key')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                Tables\Columns\TextColumn::make('path')
                    ->label('Route')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'layout' => 'warning',
                        'template' => 'info',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('sections_count')
                    ->counts('sections')
                    ->label('Sections'),
                Tables\Columns\IconColumn::make('robots_index')
                    ->label('Indexed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('group')->options([
                    'page' => 'Page',
                    'layout' => 'Layout',
                    'template' => 'Template',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit content'),
            ])
            ->paginated(false);
    }

    public static function getRelations(): array
    {
        return [
            SectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
