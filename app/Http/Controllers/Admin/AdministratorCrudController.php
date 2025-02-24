<?php

namespace App\Http\Controllers\Admin;

use App\Models\Administrator;
use App\Models\Person;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

class AdministratorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Administrator::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administrator');
        CRUD::setEntityNameStrings('administrator', 'administrators');
    }

    protected function setupListOperation()
    {
        // Columns to display in the list view
        CRUD::column('id')->label('Person ID');
        CRUD::column('level')->label('Admin Level');
        CRUD::column('person.first_name')->label('First Name');
        CRUD::column('person.last_name')->label('Last Name');
        CRUD::column('user.email')->label('Email'); // Fetch email from the User model
        CRUD::column('person.region')->label('Region');
        CRUD::column('level')->label('Admin Level');
        // CRUD::column('remark')->label('Remark');
        // CRUD::column('createdBy.email')->label('Created By');
        // CRUD::column('updatedBy.email')->label('Updated By');
         CRUD::column('created_at')->label('Created At');
        CRUD::column('updated_at')->label('Updated At');
    }



    protected function setupCreateOperation()
    {
        // Fetch all persons to display in the form
        $persons = Person::all();

        // Fetch existing administrators
        $existingAdmins = Administrator::pluck('id')->toArray();

        // Add a custom field for the table-like structure
        CRUD::addField([
            'name' => 'person_selection',
            'type' => 'custom_person_selection', // Custom field type
            'persons' => $persons, // Pass the list of persons to the field
            'existingAdmins' => $existingAdmins, // Pass the list of existing admins
        ]);

        // Validation rules
        CRUD::setValidation([
            'person_ids' => 'required|array',
            'person_ids.*' => 'exists:persons,id',
            'level' => 'required|array',
            'level.*' => 'string|max:255', // Ensure each level value is a string
            'remark' => 'nullable|array',
            'remark.*' => 'nullable|string|max:255', // Ensure each remark value is a string
        ]);

        // Hidden field for created_by
        // Add created_by as a hidden field
        CRUD::addField([
            'name' => 'created_by',
            'type' => 'hidden',
            'value' => backpack_user()->id, // Automatically set the creator
        ]);
    }

    protected function setupUpdateOperation()
    {
        // Fields to display in the update form
        CRUD::field('level')->label('Admin Level');
        CRUD::field('remark')->label('Remark')->type('textarea');
        CRUD::field('updated_by')->type('hidden')->value(backpack_user()->id); // Automatically set the updater
    }



    public function store(Request $request)
    {
        $request->validate([
            'person_ids' => 'required|array',
            'person_ids.*' => 'exists:persons,id',
            'level' => 'required|array',
            'level.*' => 'string|max:255', // Ensure each level value is a string
            'remark' => 'nullable|array',
            'remark.*' => 'nullable|string|max:255', // Ensure each remark value is a string
        ]);

        // Fetch all existing administrators
        $existingAdmins = Administrator::pluck('id')->toArray();

        // Process selected persons
        foreach ($request->input('person_ids') as $personId) {
            if (isset($request->input('level')[$personId])) {
                // Update or create the administrator
                Administrator::updateOrCreate(
                    ['id' => $personId],
                    [
                        'level' => $request->input('level')[$personId],
                        'remark' => $request->input('remark')[$personId] ?? null,
                        'created_by' => backpack_user()->id,
                    ]
                );
            }
        }

        // Remove unselected administrators
        $selectedAdmins = $request->input('person_ids', []);
        $adminsToRemove = array_diff($existingAdmins, $selectedAdmins);

        if (!empty($adminsToRemove)) {
            Administrator::whereIn('id', $adminsToRemove)->delete();
        }

        return redirect()->to('admin/administrator')->with('success', 'Administrators updated successfully.');
    }
}
