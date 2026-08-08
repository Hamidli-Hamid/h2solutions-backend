<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Filament\Support\LocaleTabs;
use App\Filament\Support\SeoFields;
use App\Filament\Support\TranslationStatus;
use App\Models\BlogPost;
use App\Models\User;
use App\Filament\Concerns\AuthorizesResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    use AuthorizesResource;

    protected static string $permissionSubject = 'blog_posts';

    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identification')->schema([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(140)
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, Forms\Set $set) => $set('slug', Str::slug($state))),
                Forms\Components\Select::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->default(fn () => auth()->id())
                    ->required(),
                Forms\Components\TextInput::make('read_minutes')->numeric()->default(3)->minValue(1)->maxValue(60),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->directory('blog')
                    ->maxSize(4096),
                Forms\Components\Toggle::make('is_published')->default(false),
                Forms\Components\DateTimePicker::make('published_at')->seconds(false)->native(false),
            ])->columns(2),

            Forms\Components\Section::make('Translations')->schema(
                LocaleTabs::make([
                    Forms\Components\TextInput::make('title.%locale%')
                        ->label('Title')
                        ->required()
                        ->maxLength(200),
                    Forms\Components\Textarea::make('excerpt.%locale%')
                        ->label('Excerpt')
                        ->rows(3)
                        ->required()
                        ->maxLength(500),
                    Forms\Components\RichEditor::make('content.%locale%')
                        ->label('Content')
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
                    ->getStateUsing(fn (BlogPost $r) => $r->getTranslation('title', config('locales.default')))
                    ->wrap(),
                TranslationStatus::column(['title', 'excerpt', 'content']),
                Tables\Columns\TextColumn::make('author.name')->label('Author')->toggleable(),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Live'),
                Tables\Columns\TextColumn::make('published_at')->dateTime('Y-m-d H:i')->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Author')
                    ->options(fn () => User::query()->pluck('name', 'id')->all()),
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
