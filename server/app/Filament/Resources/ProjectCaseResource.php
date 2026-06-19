<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectCaseResource\Pages;
use App\Models\ProjectCase;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\RichEditor;

class ProjectCaseResource extends Resource
{
    protected static ?string $model = ProjectCase::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Кейсы';

    protected static ?string $pluralLabel = 'Кейсы';

    protected static ?string $slug = 'cases';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('Название')->required(),
                Textarea::make('description')->label('Краткое описание'),
                TextInput::make('image')->label('URL изображения'),
                FileUpload::make('image_upload')->label('Загрузить изображение')
                    ->image()->disk('public')->directory('case-images')
                    ->afterStateUpdated(function ($state, $set) {
                        $set('image', asset('storage/case-images/' . $state));
                    }),
                TagsInput::make('tags')->label('Теги'),
                Select::make('category')->label('Категория')->options([
                    'development' => 'Разработка',
                    'design' => 'Дизайн',
                    'seo' => 'SEO',
                    'content' => 'Контент',
                    'analytics' => 'Аналитика',
                ]),
                RichEditor::make('full_description')->label('Полное описание'),
                TextInput::make('result')->label('Результат (кратко)'),
                Textarea::make('task')->label('Задача'),
                Textarea::make('solution')->label('Решение'),
                Repeater::make('results')->label('Результаты')->schema([
                    TextInput::make('item')->label('Результат'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Название')->searchable()->sortable(),
                TextColumn::make('category')->label('Категория'),
                TextColumn::make('result')->label('Результат'),
                TextColumn::make('created_at')->label('Дата')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->options([
                    'development' => 'Разработка',
                    'design' => 'Дизайн',
                    'seo' => 'SEO',
                    'content' => 'Контент',
                    'analytics' => 'Аналитика',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectCases::route('/'),
            'create' => Pages\CreateProjectCase::route('/create'),
            'edit' => Pages\EditProjectCase::route('/{record}/edit'),
        ];
    }
}
