<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Person;
use App\Models\User;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->removeAllButtonsFromStack('line');
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
        CRUD::setOperationSetting('showActionsColumn', false);
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'actions',
            'type' => 'view',
            'view' => 'vendor.backpack.crud.columns.custom_button',
            'orderable' => false,
            'searchable' => false,
        ]);

        // Automatically add all columns from the database
        CRUD::setFromDb();

        // Add custom columns for related Person model fields
        CRUD::column('person.first_name')
            ->label('First Name')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('first_name', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.last_name')
            ->label('Last Name')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('last_name', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

            CRUD::column('person.gender')
            ->label('Gender')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('street', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.street')
            ->label('Street')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('street', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.number')
            ->label('Number')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('number', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.city')
            ->label('City')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('city', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.zip')
            ->label('ZIP')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('zip', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.region')
            ->label('Region')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('region', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.country')
            ->label('Country')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('country', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        CRUD::column('person.phone')
            ->label('Phone')
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('person', function ($q) use ($searchTerm) {
                    $q->where('phone', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderable(true); // Make sortable

        // Add 2FA status column
        CRUD::column('two_factor_secret')
            ->label('2FA Status')
            ->type('closure')
            ->function(function ($entry) {
                return $entry->two_factor_secret ? 'Yes' : 'No';
            })
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhere('two_factor_secret', 'like', '%' . $searchTerm . '%');
            })
            ->orderable(true); // Make sortable
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field('email')->label('Email');

        CRUD::field('person.first_name')->label('First Name');
        CRUD::field('person.last_name')->label('Last Name');
        
//        CRUD::field('person.gender')->label('Gender');
        CRUD::field('person.gender')
        ->label('Gender')
        ->type('select_from_array')
        ->options([1 => 'Male', 0 => 'Female']);
       
     
        CRUD::field('person.street')->label('Street');
        CRUD::field('person.number')->label('Number');
        CRUD::field('person.city')->label('City');
        CRUD::field('person.zip')->label('ZIP');
        CRUD::field('person.region')->label('Region');
        CRUD::field('person.country')->label('Country');
        CRUD::field('person.phone')->label('Phone');

        CRUD::field('active')
            ->label('Active')
            ->type('select_from_array')
            ->options([1 => 'Yes', 0 => 'No'])
            ->default(1);

        // Add 2FA field
        CRUD::field('two_factor_secret')
            ->label('2FA Enabled')
            ->type('select_from_array')
            ->options([1 => 'Yes', 0 => 'No'])
            ->default(0);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function update($id)
    {
        // Find the user and update basic details
        $user = User::findOrFail($id);
        $user->email = request('email');
        $user->active = request('active'); // Update the 'active' field
        $user->two_factor_secret = request('two_factor_secret') ? 'enabled' : null; // Update 2FA status
        $user->save();

        // Update or create associated person data
        $person = $user->person ?? new Person();
        $person->first_name = request('person.first_name');
        $person->last_name = request('person.last_name');
        $person->street = request('person.gender');
        $person->street = request('person.street');
        $person->number = request('person.number');
        $person->city = request('person.city');
        $person->zip = request('person.zip');
        $person->region = request('person.region');
        $person->country = request('person.country');
        $person->phone = request('person.phone');
        $person->user_id = $user->id;  // Ensure correct relationship
        $person->save();

        // Redirect after update
        return redirect()->to('admin/user');
    }
}
