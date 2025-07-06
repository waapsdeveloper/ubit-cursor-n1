<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuctiontimersettingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AuctiontimersettingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AuctiontimersettingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\AuctionTimerSetting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/auctiontimersetting');
        CRUD::setEntityNameStrings('auction timer setting', 'auction timer settings');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'auction_id',
            'type' => 'select',
            'entity' => 'auction',
            'attribute' => 'title',
            'model' => 'App\\Models\\Auction',
            'label' => 'Auction',
        ]);
        CRUD::addColumn(['name' => 'timer_style', 'label' => 'Style']);
        CRUD::addColumn(['name' => 'timer_color', 'label' => 'Color']);
        CRUD::addColumn(['name' => 'show_timer', 'type' => 'boolean']);
        CRUD::addColumn(['name' => 'show_days', 'type' => 'boolean']);
        CRUD::addColumn(['name' => 'show_hours', 'type' => 'boolean']);
        CRUD::addColumn(['name' => 'show_minutes', 'type' => 'boolean']);
        CRUD::addColumn(['name' => 'show_seconds', 'type' => 'boolean']);
        CRUD::addColumn(['name' => 'auto_refresh', 'type' => 'boolean']);
        CRUD::addColumn(['name' => 'refresh_interval']);
        CRUD::addColumn(['name' => 'expired_message']);
        CRUD::addColumn(['name' => 'show_warning', 'type' => 'boolean']);
        CRUD::addColumn(['name' => 'warning_threshold']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AuctiontimersettingRequest::class);
        CRUD::addField([
            'name' => 'auction_id',
            'type' => 'select2',
            'entity' => 'auction',
            'attribute' => 'title',
            'model' => 'App\\Models\\Auction',
            'label' => 'Auction',
        ]);
        CRUD::addField([
            'name' => 'timer_style',
            'type' => 'select_from_array',
            'options' => ['compact' => 'Compact', 'detailed' => 'Detailed', 'minimal' => 'Minimal'],
            'label' => 'Timer Style',
        ]);
        CRUD::addField([
            'name' => 'timer_color',
            'type' => 'select_from_array',
            'options' => ['orange' => 'Orange', 'red' => 'Red', 'green' => 'Green', 'purple' => 'Purple'],
            'label' => 'Timer Color',
        ]);
        CRUD::addField(['name' => 'show_timer', 'type' => 'checkbox']);
        CRUD::addField(['name' => 'show_days', 'type' => 'checkbox']);
        CRUD::addField(['name' => 'show_hours', 'type' => 'checkbox']);
        CRUD::addField(['name' => 'show_minutes', 'type' => 'checkbox']);
        CRUD::addField(['name' => 'show_seconds', 'type' => 'checkbox']);
        CRUD::addField(['name' => 'auto_refresh', 'type' => 'checkbox']);
        CRUD::addField(['name' => 'refresh_interval', 'type' => 'number', 'label' => 'Refresh Interval (ms)']);
        CRUD::addField(['name' => 'expired_message', 'type' => 'text']);
        CRUD::addField(['name' => 'show_warning', 'type' => 'checkbox']);
        CRUD::addField(['name' => 'warning_threshold', 'type' => 'number', 'label' => 'Warning Threshold (seconds)']);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
