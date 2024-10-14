<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerAdvertismentResource\Pages;
use App\Filament\Resources\BannerAdvertismentResource\RelationManagers;
use App\Models\BannerAdvertisment;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerAdvertismentResource extends Resource
{
    protected static ?string $model = BannerAdvertisment::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

  protected static ?string $navigationGroup = 'Other';

    public static function form(Form $form): Form
    { 
        return $form
            ->schema([
              Section::make('Banner Information')
              ->description('Silahkan isi informasi banner')
              ->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(255),
                
                TextInput::make('link')
                ->activeUrl()
                ->required()
                ->maxLength(255),
                
                Select::make('is_active')
                ->options([
                  'active'=>'Active',
                  'not_active'=>'Not Active',
                  ])
                ->required(),
                
                Select::make('type')
                ->options([
                  'banner'=>"Banner",
                  'square'=>"Square",
                ])
                ])->columns(2),

                Section::make('Thumbnail')
                ->description('Berikan gambar banner advertisment')
                ->schema([

                  FileUpload::make('thumbnail')
                  ->image()
                  ->required(),
                ]),    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                  TextColumn::make('name')
                ->searchable(),

                TextColumn::make('link')
                ->searchable()
                ->limit(30),

                TextColumn::make('is_active')
                ->badge()
                ->color(fn (string $state): string => match($state){
                  'active' => 'success',
                  'not_active' => 'danger',
                }),

                ImageColumn::make('thumbnail')
                ->width('100%')
                ->height('100%')
            ])
            ->filters([
                //
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
            'index' => Pages\ListBannerAdvertisments::route('/'),
            'create' => Pages\CreateBannerAdvertisment::route('/create'),
            'edit' => Pages\EditBannerAdvertisment::route('/{record}/edit'),
        ];
    }
}
