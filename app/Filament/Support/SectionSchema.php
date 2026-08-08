<?php

namespace App\Filament\Support;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Illuminate\Support\Str;

/**
 * Turns the field descriptors in config/sections.php into a Filament form.
 *
 * Because the form is generated, a new kind of block only needs a `types` entry
 * in that config — no resource, no migration, no frontend change.
 */
class SectionSchema
{
    /**
     * The editable body of one section: translated fields in locale tabs,
     * language-independent fields underneath.
     *
     * @return array<int, Component>
     */
    public static function make(?string $type): array
    {
        $fields = config("sections.types.$type.fields");

        if (blank($type) || blank($fields)) {
            return [
                Forms\Components\Placeholder::make('no_schema')
                    ->hiddenLabel()
                    ->content('Choose a section type to edit its content.'),
            ];
        }

        $translated = array_filter($fields, fn (array $field) => ! ($field['shared'] ?? false));
        $shared = array_filter($fields, fn (array $field) => $field['shared'] ?? false);

        $schema = [];

        if ($translated !== []) {
            $schema[] = Forms\Components\Section::make('Content')
                ->description('One tab per language. Leave a field empty to fall back to ' . strtoupper(config('locales.default', 'az')) . '.')
                ->schema(LocaleTabs::build(
                    fn (string $locale) => self::fields($translated, "data.$locale")
                ));
        }

        if ($shared !== []) {
            $schema[] = Forms\Components\Section::make('Same in every language')
                ->description('Links, images and switches that do not get translated.')
                ->schema(self::fields($shared, 'shared'))
                ->columns(2);
        }

        return $schema;
    }

    /**
     * @param  array<string, array<string, mixed>>  $fields
     * @return array<int, Component>
     */
    public static function fields(array $fields, string $prefix = ''): array
    {
        $components = [];

        foreach ($fields as $name => $descriptor) {
            $components[] = self::field($name, $descriptor, $prefix);
        }

        return $components;
    }

    private static function field(string $name, array $descriptor, string $prefix): Component
    {
        $path = $prefix === '' ? $name : "$prefix.$name";
        $label = $descriptor['label'] ?? Str::headline($name);
        $type = $descriptor['type'] ?? 'text';

        $component = match ($type) {
            'textarea' => Forms\Components\Textarea::make($path)
                ->rows($descriptor['rows'] ?? 3),

            'rich' => Forms\Components\RichEditor::make($path),

            'url' => Forms\Components\TextInput::make($path)
                ->url()
                ->prefixIcon('heroicon-o-link'),

            'icon' => Forms\Components\TextInput::make($path)
                ->placeholder('heroicon-o-sparkles')
                ->datalist(self::iconSuggestions()),

            'date' => Forms\Components\DatePicker::make($path)
                ->native(false)
                ->format('Y-m-d'),

            'toggle' => Forms\Components\Toggle::make($path)
                ->inline(false),

            'image' => Forms\Components\FileUpload::make($path)
                ->image()
                ->disk('public')
                ->directory('content')
                ->maxSize(4096)
                ->imageEditor(),

            // Sizes derived from another upload — shown, never edited.
            'image_set' => Forms\Components\Placeholder::make($path . '_preview')
                ->content(fn (Forms\Get $get) => self::describeSet($get($path)))
                ->columnSpanFull(),

            // A plain list of strings, e.g. paragraphs or bullet points.
            'list' => Forms\Components\Repeater::make($path)
                ->simple(
                    ($descriptor['rows'] ?? 1) > 1
                        ? Forms\Components\Textarea::make('value')->rows($descriptor['rows'])->required()
                        : Forms\Components\TextInput::make('value')->required()
                )
                ->defaultItems(0)
                ->reorderable()
                ->collapsible()
                ->columnSpanFull(),

            'key_values' => Forms\Components\KeyValue::make($path)
                ->keyLabel('Key')
                ->valueLabel('Text')
                ->reorderable()
                ->columnSpanFull(),

            'repeater' => Forms\Components\Repeater::make($path)
                ->schema(self::fields($descriptor['fields'] ?? []))
                ->itemLabel(fn (array $state) => $state[$descriptor['itemLabel'] ?? 'title'] ?? null)
                ->defaultItems(0)
                ->reorderable()
                ->collapsible()
                ->cloneable()
                ->columnSpanFull(),

            default => Forms\Components\TextInput::make($path)
                ->maxLength($descriptor['maxLength'] ?? 255),
        };

        $component = $component->label($label);

        if (filled($descriptor['help'] ?? null)) {
            $component = $component->helperText($descriptor['help']);
        }

        if (in_array($type, ['textarea', 'rich', 'image'], true)) {
            $component = $component->columnSpanFull();
        }

        return $component;
    }

    /** Human summary of a generated size set. */
    private static function describeSet(mixed $value): string
    {
        if (! is_array($value) || $value === []) {
            return 'Nothing generated yet — upload a favicon source and save.';
        }

        $sizes = array_filter(array_keys($value), 'is_numeric');
        sort($sizes);

        $summary = count($sizes) . ' PNG size(s): ' . implode(', ', array_map(
            fn ($size) => "{$size}×{$size}",
            $sizes
        ));

        return isset($value['ico']) ? "$summary — plus favicon.ico" : $summary;
    }

    /** A short list of common heroicons, offered as autocomplete. */
    private static function iconSuggestions(): array
    {
        return [
            'heroicon-o-academic-cap',
            'heroicon-o-bolt',
            'heroicon-o-briefcase',
            'heroicon-o-building-office-2',
            'heroicon-o-chart-bar',
            'heroicon-o-chat-bubble-left-right',
            'heroicon-o-clipboard-document-list',
            'heroicon-o-code-bracket-square',
            'heroicon-o-computer-desktop',
            'heroicon-o-cube-transparent',
            'heroicon-o-device-phone-mobile',
            'heroicon-o-eye',
            'heroicon-o-globe-alt',
            'heroicon-o-inbox-arrow-down',
            'heroicon-o-light-bulb',
            'heroicon-o-magnifying-glass',
            'heroicon-o-rocket-launch',
            'heroicon-o-server-stack',
            'heroicon-o-shield-check',
            'heroicon-o-sparkles',
            'heroicon-o-wrench-screwdriver',
        ];
    }
}
