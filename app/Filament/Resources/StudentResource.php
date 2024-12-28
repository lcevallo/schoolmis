<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('John Doe')
                    ->rules(['max:20'])
                    ->required(),

                TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

                Select::make('class_id')
                    ->label('Class')
                    ->live()
                    ->placeholder('Select Class')
                    ->relationship('class','name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('section_id')
                    ->label('Section')
                    ->placeholder('Select Section')
                   ->options(function(Forms\Set $set, Forms\Get $get){
                        $class_id =$get('class_id');
                        // info($class_id);
                        return Section::where('class_id',$class_id)->pluck('name','id')->toArray();
                   })
                    ->required()
                    ->searchable()
                    ->preload(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('class.name')
                    ->label('Class')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('section.name')
                    ->label('Section')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('class_id')
                    ->label('Class')
                    ->multiple()
                    ->preload()
                    ->relationship('class', 'name'),

                SelectFilter::make('section_id')
                    ->label('Section')
                    ->multiple()
                    ->preload()
                    ->relationship('section', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
