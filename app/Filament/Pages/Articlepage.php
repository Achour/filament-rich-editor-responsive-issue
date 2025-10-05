<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class Articlepage extends Page
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.articlepage';

    public ?array $data = [];

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                FieldSet::make('status')
                    ->label('Status')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Toggle to publish or unpublish the service.')
                            ->default(true)
                            ->inline()
                            ->onColor('gray')
                            ->offColor('danger'),
                    ]),

                Section::make('Basic Info')

                    ->schema([

                        Select::make('category')->options([
                            'Car Services' => 'Car Services',
                            'Food Services' => 'Food Services',
                            'Watch Services' => 'Watch Services',
                            'Educational Services' => 'Educational Services',
                            'Real Estate Services' => 'Real Estate Services',
                            'Travel Services' => 'Travel Services',
                            'Services Providers' => 'Services Providers',
                            'Health & Wellness' => 'Health & Wellness',
                            'Business & Freelancers Services' => 'Business & Freelancers Services',
                            'Services Seeking' => 'Services Seeking',
                        ])->searchable()->required(),
                        Grid::make(1)

                            ->schema([
                                TextInput::make('title')->required()->placeholder('Write a clear and concise title for your service'),
                                RichEditor::make('description')
                                    ->toolbarButtons(
                                        ['bold', 'italic', 'underline', 'strike', 'highlight', 'link', 'undo', 'redo'],
                                    )
                                    ->placeholder('Write a description for your service')->columnSpanFull(),
                                Hidden::make('type')->default('service'),
                                Hidden::make('user_id')->default(fn () => Auth::id()),
                                Hidden::make('profile_id')->default(fn () => Auth::user()->profile?->id ?? null),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Details')
                    ->schema([

                        Repeater::make('features')
                            ->schema([
                                Grid::make(2)->schema([
                                    Select::make('key')
                                        ->label('Feature Type')
                                        ->options([
                                            'Availability' => 'Availability',
                                            'Duration' => 'Duration',
                                            'Expertise' => 'Expertise',
                                            'Guarantee' => 'Guarantee',
                                            'Payment Options' => 'Payment Options',
                                        ])
                                        ->searchable()
                                        ->required(),
                                    TextInput::make('value')
                                        ->label('Feature Value')
                                        ->required(),
                                ]),
                            ])
                            ->addActionLabel('Add Feature')
                            ->columnSpanFull(),
                    ])->columnSpanFull(),
            ]);
    }
}
