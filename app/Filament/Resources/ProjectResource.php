<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Support\LocaleTabs;
use App\Filament\Support\SeoFields;
use App\Filament\Support\TranslationStatus;
use App\Models\Project;
use App\Filament\Concerns\AuthorizesResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    use AuthorizesResource;

    protected static string $permissionSubject = 'projects';

    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 20;

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
                Forms\Components\TextInput::make('client')->maxLength(120),
                Forms\Components\TextInput::make('year')->numeric()->minValue(2000)->maxValue(2100),
                Forms\Components\TextInput::make('url')->url()->maxLength(255),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->disk('public')
                    ->directory('projects')
                    ->maxSize(4096),
                Forms\Components\Toggle::make('is_published')->default(true),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2),

            Forms\Components\Section::make('Gallery')
                ->description('Project screenshots shown on the detail page. Drag to reorder.')
                ->schema([
                    Forms\Components\FileUpload::make('gallery')
                        ->hiddenLabel()
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->disk('public')
                        ->directory('projects')
                        ->maxSize(4096)
                        ->maxFiles(20)
                        ->imageEditor()
                        ->panelLayout('grid')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Video')
                ->description('Plays at the top of the detail page. An uploaded file wins over the link when both are filled in.')
                ->schema([
                    Forms\Components\FileUpload::make('video_file')
                        ->label('Video file')
                        ->disk('public')
                        ->directory('projects/videos')
                        ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                        // Anything heavier belongs on YouTube/Vimeo; PHP's own
                        // upload_max_filesize still caps this server-side.
                        ->maxSize(51200)
                        ->helperText('MP4 / WebM, max 50 MB.')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('video_url')
                        ->label('Video link')
                        ->url()
                        ->maxLength(255)
                        ->helperText('YouTube or Vimeo link, or a direct .mp4 URL.')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Translations')->schema(
                LocaleTabs::make([
                    Forms\Components\TextInput::make('title.%locale%')
                        ->label('Title')
                        ->required()
                        ->maxLength(160),
                    Forms\Components\Textarea::make('summary.%locale%')
                        ->label('Summary')
                        ->rows(3)
                        ->required()
                        ->maxLength(400),
                    Forms\Components\RichEditor::make('body.%locale%')
                        ->label('Text')
                        ->helperText('The whole project story — shown next to the other projects on the detail page.')
                        ->required()
                        ->disableToolbarButtons(['attachFiles']),
                ])
            ),

            SeoFields::section(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->square()->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (Project $r) => $r->getTranslation('title', config('locales.default'))),
                Tables\Columns\TextColumn::make('client')->searchable(),
                TranslationStatus::column(['title', 'summary', 'body']),
                Tables\Columns\TextColumn::make('year')->sortable(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
