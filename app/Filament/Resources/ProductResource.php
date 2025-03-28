<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Textarea::make('description')->required(),
                Forms\Components\TextInput::make('price')->numeric()->required(),
                Forms\Components\Group::make([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->disk('public')
                        ->directory('products')
                        ->nullable(), // Supaya tidak wajib upload file
                
                    Forms\Components\TextInput::make('image_url')
                        ->label('Image URL')
                        ->url()
                        ->placeholder('https://example.com/image.jpg')
                        ->nullable(), // Supaya tidak wajib isi URL
                ]),
                Forms\Components\TextInput::make('stock')->numeric()->required(),
            ]);
    }

    public static function table(Tables\Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\ImageColumn::make('image')
                ->label('Image')
                ->getStateUsing(fn ($record) => $record->image_url ?? asset('storage/products/' . $record->image)),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('stock'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
