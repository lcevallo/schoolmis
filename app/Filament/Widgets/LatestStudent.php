<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Student;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestStudent extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Student::orderBy('created_at', 'desc') // Ordena por la columna created_at en orden descendente
                    ->limit(5)
            )
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
            ]);
    }
}
