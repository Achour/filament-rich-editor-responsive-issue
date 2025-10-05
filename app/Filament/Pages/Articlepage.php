<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Articlepage extends Page
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.articlepage';

    public ?array $data = [];

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                FieldSet::make('Article Details')
                    ->schema([
                        TextInput::make('author')
                            ->required()
                            ->placeholder('Enter author name'),
                        TextInput::make('category')
                            ->required()
                            ->placeholder('Enter article category'),
                    ])->columnSpanFull(),
                Section::make('Article Information')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->placeholder('Enter article title'),
                                // comment this RichEditor the issue will be gone
                                RichEditor::make('content')
                                    ->toolbarButtons(
                                        ['bold', 'italic', 'underline', 'strike', 'highlight', 'link', 'undo', 'redo'],
                                    )
                                    ->placeholder('Describe your car or any additional details buyers should know')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull(),

            ])
            ->statePath('data');
    }
}
