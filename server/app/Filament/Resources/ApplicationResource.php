<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Models\Application;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static ?string $navigationLabel = 'Заявки';

    protected static ?string $pluralLabel = 'Заявки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Имя')->required(),
                TextInput::make('email')->label('Email'),
                TextInput::make('phone')->label('Телефон'),
                TextInput::make('company')->label('Компания'),
                Textarea::make('message')->label('Сообщение'),
                Textarea::make('task_details')->label('Детали задачи'),
                TextInput::make('timeframe')->label('Сроки'),
                TextInput::make('budget')->label('Бюджет'),
                TextInput::make('contact_format')->label('Формат связи'),
                TagsInput::make('services')->label('Интересуют услуги'),
                Select::make('status')->label('Статус')->options([
                    'new' => 'Новая',
                    'in_progress' => 'В работе',
                    'done' => 'Готово',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Имя')->searchable()->sortable(),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('phone')->label('Телефон'),
                BadgeColumn::make('status')->label('Статус')
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'in_progress',
                        'success' => 'done',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Готово',
                        default => $state,
                    }),
                TextColumn::make('created_at')->label('Дата')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'new' => 'Новая',
                    'in_progress' => 'В работе',
                    'done' => 'Готово',
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
            'index' => Pages\ListApplications::route('/'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
