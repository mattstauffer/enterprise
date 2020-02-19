<?php

namespace App\Nova;

use App\Imports\ContentImport;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Sgd\ImportCard\ImportCard;

class Content extends Resource
{
    public static $model = 'App\Content';

    public static $group = 'Gemini';

    public static $title = 'title';

    public static $importer = ContentImport::class;

    public static function label()
    {
        return 'Content';
    }

    public static $searchRelations = [
        'event' => ['title'],
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Event')->sortable(),
            Text::make('Type')->sortable(),
            Text::make('Title')->sortable(),
            Trix::make('Content'),
        ];
    }

    public function cards(Request $request)
    {
        return [
            (new ImportCard(self::class))->withSample(url('documents/content.xlsx')),
        ];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
