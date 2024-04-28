<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\Split as ComponentsSplit;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    private static function emptyStateActions(): array
    {
        return [
            Action::make('create')
                ->label('New blog')
                ->url(BlogResource::getUrl('create'))
                ->icon('heroicon-m-plus')
                ->button(),
        ];
    }

    private static function emptyDescription(): string
    {
        return 'Once you create your first blog, it will appear here.';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('')
                        ->schema([
                            TextInput::make('title')->required()->maxLength(255),
                            TextInput::make('slug')->required()->maxLength(255),
                            RichEditor::make('content')
                                ->toolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'h1',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ])
                                ->live(onBlur: true)
                                ->maxLength(3000)
                                ->hint(fn ($state, $component) => strlen($state) .' charaters '. '(left: ' . $component->getMaxLength() - strlen($state) . ' characters)')
                                ->reactive()
                                ->required(),
                            Textarea::make('excerpt')
                                ->required(),
                            Actions::make([
                                Forms\Components\Actions\Action::make('Generate excerpt')
                                    ->action(function (Forms\Get $get, Forms\Set $set) {
                                        $set('excerpt', str($get('content'))->words(1000, end: ''));
                                    })
                            ]),
                            Select::make('tags')->relationship('tags', 'name')->multiple()->native(false)->required(),
                            Select::make('categories')->label('Category')->relationship('categories', 'name')->native(false)->required(),
                        ]),
                    Group::make()->schema([
                        Section::make('Featured Image')->schema([
                            FileUpload::make('featured_image')
                                ->directory('blogImage')
                                ->storeFileNamesIn('original_filename')
                        ]),
                        Section::make('')->schema([
                            Select::make('users')
                                ->label('Author')
                                ->relationship('users', 'email')
                                ->native(false)
                                ->required(),
                            DateTimePicker::make('created_at')
                                ->label('Published at')
                                ->native(false)
                                ->closeOnDateSelection()
                        ])
                    ])->grow(false)
                ])->from('md'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')->circular(),
                TextColumn::make('users.name')->label('Author')->sortable()->searchable(),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('tags.name')->sortable()->searchable(),
                TextColumn::make('categories.name')->sortable()->searchable(),
            ])
            ->filters([
                Filter::make('users.name'),
                Filter::make('title'),
                Filter::make('tags.name'),
                Filter::make('categories.name')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions(self::emptyStateActions())
            ->emptyStateDescription(self::emptyDescription());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            ComponentsSplit::make([
                ComponentsSection::make('')
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('slug'),
                        TextEntry::make('content')
                            ->markdown()
                            ->prose(),
                    ]),
                ComponentsGroup::make()->schema([
                    ComponentsSection::make('Featured Image')->schema([
                        ImageEntry::make('featured_image')
                    ]),
                    ComponentsSection::make('')->schema([
                        TextEntry::make('users.name'),
                        TextEntry::make('created_at')->dateTime()
                    ])
                ])->grow(false)
            ])->from('md'),
        ])->columns(1);
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
