<?php

namespace App\Nova;

use App\Nova\Actions\DeactivateUser;
use App\Nova\Metrics\Users;
use App\Nova\Metrics\UsersPerDay;
use App\Nova\Metrics\UsersPerStatus;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends Resource
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
    public static $model = \App\Models\User::class;

    /**
     * The pagination per-page options configured for this resource.
     *
     * @return array
     */
    public static $perPageOptions = [50, 100, 150];

    /**
     * The visual style used for the table. Available options are 'tight' and 'default'.
     *
     * @var string
     */
    public static $tableStyle = 'default';

    /**
     * Indicates whether the resource should automatically poll for new resources.
     *
     * @var bool
     */
    public static $polling = true;

    /**
     * Indicates whether to show the polling toggle button inside Nova.
     *
     * @var bool
     */
    public static $showPollingToggle = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'last_name', 'email',
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
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('First Name')
                ->sortable(),

            Text::make('Last Name')
                ->sortable(),

            Text::make('Email')
                ->sortable(),

            Number::make('Phone'),

            Boolean::make('Email Verified', function () {
                $verified = (is_null($this->email_verified_at)) ? false : true;

                return $verified;
            })->hideFromIndex(),

            BelongsTo::make('Account Type', 'accountType', 'App\Nova\AccountType')
                ->sortable(),

            BelongsTo::make('Status'),

            Text::make('Gender')->hideFromIndex(),

            Boolean::make('Consent')->sortable()
                ->hideFromIndex(),

            HasOne::make('Business'),

            HasMany::make('Bookings')

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
        return [
            new Users,
            new UsersPerDay,
            new UsersPerStatus,
        ];
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
        return [
            (new Actions\ActivateUser)
                ->confirmText('Are you sure you want to activate this account?')
                ->confirmButtonText('Activate')
                ->cancelButtonText('Cancel'),
            (new Actions\DeactivateUser)
                ->confirmText('Are you sure you want to deactivate this account?')
                ->confirmButtonText('Deactivate')
                ->cancelButtonText('Cancel'),
        ];
    }
}
