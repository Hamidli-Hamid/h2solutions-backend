<?php

namespace App\Filament\Support;

use Filament\Forms;

/**
 * The SEO block every addressable record shares — pages as well as services,
 * projects and blog posts. Declared once so the fields, wording and behaviour
 * stay identical wherever they appear.
 *
 * Every field is optional: left empty, the frontend keeps the value it derives
 * from the page content itself.
 */
class SeoFields
{
    public static function section(): Forms\Components\Section
    {
        return Forms\Components\Section::make('SEO & sharing')
            ->description('Optional overrides. Empty fields keep the automatic value built from the page content.')
            ->collapsed()
            ->schema([
                ...LocaleTabs::make([
                    Forms\Components\TextInput::make('seo_title.%locale%')
                        ->label('Meta title')
                        ->maxLength(180)
                        ->helperText('Aim for 50–60 characters.'),
                    Forms\Components\Textarea::make('seo_description.%locale%')
                        ->label('Meta description')
                        ->rows(3)
                        ->maxLength(320)
                        ->helperText('Aim for 120–160 characters.'),
                ]),

                Forms\Components\FileUpload::make('og_image')
                    ->label('Share image')
                    ->image()
                    ->disk('public')
                    ->directory('seo')
                    ->maxSize(4096)
                    ->imageEditor()
                    ->helperText('Shown when the page is shared. The share card reuses the meta title and description above. 1200×630 works best.')
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('robots_index')
                    ->label('Allow indexing')
                    ->default(true),

                Forms\Components\Toggle::make('robots_follow')
                    ->label('Allow following links')
                    ->default(true),
            ])
            ->columns(2);
    }
}
