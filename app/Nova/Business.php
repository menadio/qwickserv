<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Business extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Admin';
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Business::class;

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['photos', 'businessHours'];


    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'services'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Avatar::make('Logo'),

            BelongsTo::make('User')->hideFromIndex(),

            Text::make('Business Name', 'name'),

            Textarea::make('Address'),

            Number::make('Contact', 'phone'),

            Image::make('Cover')->hideFromIndex(),

            BelongsTo::make('Category'),

            KeyValue::make('Services')->hideFromIndex(),

            Textarea::make('Description')->alwaysShow(),

            BelongsTo::make('Status'),

            Number::make('View Count')->hideFromIndex(),

            Number::make('Search Count')->hideFromIndex(),

            DateTime::make('Created On', 'created_at')
                ->hideFromIndex(),

            DateTime::make('Updated On', 'updated_at')
                ->hideFromIndex(),

            HasMany::make('Business Photos', 'photos', 'App\Nova\BusinessPhoto'),

            HasMany::make('Business Hours', 'businessHours', 'App\Nova\BusinessHour'),

            HasMany::make('Bookings'),

            HasMany::make('Reviews'),

            HasOne::make('Bank Details', 'businessBank', 'App\Nova\BusinessBank')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
