<?php

namespace App\Filament\Resources\ServiceResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class ServiceDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $title = 'Под-услуги';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sub_item')->label('Название')->required(),
                Textarea::make('description')->label('Описание')->required(),
                TextInput::make('sort_order')->label('Порядок')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('#'),
                TextColumn::make('sub_item')->label('Название'),
                TextColumn::make('description')->label('Описание')->limit(60),
            ])
            ->defaultSort('sort_order')
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
