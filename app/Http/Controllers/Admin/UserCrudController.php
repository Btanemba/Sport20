<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Person;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        // Disable the default actions column on the far right
        CRUD::setOperationSetting('showActionsColumn', false);
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @return void
     */
    protected function setupListOperation()
    {

        // Add the custom actions column first (on the left)
        CRUD::addColumn([
            'name' => 'actions',
            'type' => 'view',
            'view' => 'vendor.backpack.crud.columns.custom_button', // Path to your custom view
            'orderable' => false,
            'searchable' => false,
        ]);

        CRUD::setOperationSetting('showActionsColumn', false);

        CRUD::setFromDb(); // set columns from db columns.
       
        CRUD::column('person.first_name')->label('First Name');
        CRUD::column('person.last_name')->label('Last Name');
        CRUD::column('person.street')->label('Street');
        CRUD::column('person.number')->label('Number');
        CRUD::column('person.city')->label('City');
        CRUD::column('person.zip')->label('ZIP');
        CRUD::column('person.region')->label('Region');
        CRUD::column('person.country')->label('Country');
        CRUD::column('person.phone')->label('Phone');

        // Disable the default actions column on the far right
        CRUD::setOperationSetting('showActionsColumn', false);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setOperationSetting('showActionsColumn', false);
        CRUD::setValidation(UserRequest::class);

        // User fields
        CRUD::field('email')->label('Email');

        // Person fields
        CRUD::field('person.first_name')->label('First Name');
        CRUD::field('person.last_name')->label('Last Name');
        CRUD::field('person.street')->label('Street');
        CRUD::field('person.number')->label('Number');
        CRUD::field('person.city')->label('City');
        CRUD::field('person.zip')->label('ZIP');
        CRUD::field('person.region')->label('Region');
        CRUD::field('person.country')->label('Country');
        CRUD::field('person.phone')->label('Phone');

        // Active field (Yes/No dropdown)
        CRUD::field('active')
            ->label('Active')
            ->type('select_from_array')
            ->options([1 => 'Yes', 0 => 'No'])
            ->default(1);  // Set the default value to 'Yes'
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Handle the update operation, including the related `person` data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Update the user's email or other fields
        $user->email = request('email');
        $user->save();

        // Now handle the person information
        $person = $user->person ?? new Person();
        $person->first_name = request('person.first_name');
        $person->last_name = request('person.last_name');
        $person->street = request('person.street');
        $person->number = request('person.number');
        $person->city = request('person.city');
        $person->zip = request('person.zip');
        $person->region = request('person.region');
        $person->country = request('person.country');
        $person->phone = request('person.phone');
        $person->user_id = $user->id;

        // Save the person data
        $person->save();

        // Redirect back after update

        return redirect()->to('admin/user');
    }
}
