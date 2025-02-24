@php
    $persons = $field['persons']; // List of persons passed from the controller
    $existingAdmins = \App\Models\Administrator::whereIn('id', $field['existingAdmins'])
        ->pluck('level', 'id')
        ->toArray();
    $adminRemarks = \App\Models\Administrator::whereIn('id', $field['existingAdmins'])
        ->pluck('remark', 'id')
        ->toArray();
@endphp

<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 60px;">Admin Check</th> <!-- Set width -->
            <th>First Name</th>
            <th>Last Name</th>
            <th style="width: 60px;">Admin Level</th> <!-- Set width -->
            <th style="width: 30px;">Remark</th> <!-- Set width -->
        </tr>
    </thead>
    <tbody>
        @foreach ($persons as $person)
            @php
                $isAdmin = isset($existingAdmins[$person->id]);
            @endphp
            <tr>
                <td>
                    <input type="checkbox" name="person_ids[]" value="{{ $person->id }}" class="person-checkbox"
                        {{ $isAdmin ? 'checked' : '' }}>
                </td>
                <td>{{ $person->first_name }}</td>
                <td>{{ $person->last_name }}</td>
                <td>
                    <input type="text" name="level[{{ $person->id }}]" class="form-control level-field"
                        value="{{ $isAdmin ? $existingAdmins[$person->id] : '' }}" {{ $isAdmin ? '' : 'disabled' }}
                        style="width: 100px;">
                </td>
                <td>
                    <input type="text" name="remark[{{ $person->id }}]" class="form-control remark-field"
                        value="{{ $isAdmin ? $adminRemarks[$person->id] : '' }}" {{ $isAdmin ? '' : 'disabled' }}
                        style="width: 150px;">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function() {



          // Disable checkboxes and associated fields for already checked admins
          $('input.person-checkbox').each(function() {
                    if (this.checked) {
                        $(this).attr("disabled",
                        true); // Disable checkbox to prevent unchecking
                        const personId = this.value;
                        $('input[name="level[' + personId + ']"]').attr("disabled",
                            true); // Disable the level field
                        $('input[name="remark[' + personId + ']"]').attr("disabled",
                            true); // Disable the remark field
                    }
                });
        // Enable/disable level and remark fields based on checkbox changes
        document.querySelectorAll('.person-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const personId = this.value;
                const levelField = document.querySelector(`input[name="level[${personId}]"]`);
                const remarkField = document.querySelector(`input[name="remark[${personId}]"]`);

              
                // Enable/disable fields based on checkbox state, but only for unchecked boxes
                if (this.checked) {
                    levelField.disabled = false;
                    levelField.required = true;
                    remarkField.disabled = false;
                } else {
                    levelField.disabled = true;
                    levelField.required = false;
                    remarkField.disabled = true;
                }
            });
        });

        // Exclude disabled fields from form submission
        document.querySelector('form').addEventListener('submit', function() {
            document.querySelectorAll('input[disabled]').forEach(input => input.removeAttribute(
            'name'));
        });
    });
</script>

{{-- @php
    $persons = $field['persons']; // List of persons passed from the controller
    $existingAdmins = \App\Models\Administrator::whereIn('id', $field['existingAdmins'])->pluck('level', 'id')->toArray();
    $adminRemarks = \App\Models\Administrator::whereIn('id', $field['existingAdmins'])->pluck('remark', 'id')->toArray();
@endphp

<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 60px;">Admin Check</th> <!-- Set width -->
            <th>First Name</th>
            <th>Last Name</th>
            <th style="width: 60px;">Admin Level</th> <!-- Set width -->
            <th style="width: 30px;">Remark</th> <!-- Set width -->
        </tr>
    </thead>
    <tbody>
        @foreach ($persons as $person)
            @php
                $isAdmin = isset($existingAdmins[$person->id]);
            @endphp
            <tr>
                <td>
                    <input type="checkbox" name="person_ids[]" value="{{ $person->id }}" class="person-checkbox"
                        {{ $isAdmin ? 'checked disabled' : '' }}>
                </td>
                <td>{{ $person->first_name }}</td>
                <td>{{ $person->last_name }}</td>
                <td>
                    <input type="text" name="level[{{ $person->id }}]" class="form-control level-field"
                        value="{{ $isAdmin ? $existingAdmins[$person->id] : '' }}"
                        {{ $isAdmin ? 'disabled' : '' }} style="width: 100px;">
                </td>
                <td>
                    <input type="text" name="remark[{{ $person->id }}]" class="form-control remark-field"
                        value="{{ $isAdmin ? $adminRemarks[$person->id] : '' }}"
                        {{ $isAdmin ? 'disabled' : '' }} style="width: 150px;">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

 {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Disable checkboxes and associated fields for already checked admins
        document.querySelectorAll('.person-checkbox').forEach(checkbox => {
            const personId = checkbox.value;
            const levelField = document.querySelector(`input[name="level[${personId}]"]`);
            const remarkField = document.querySelector(`input[name="remark[${personId}]"]`);

            // If the checkbox is checked (admin), disable the checkbox and the fields
            if (checkbox.checked) {
                checkbox.disabled = true; // Disable checkbox to prevent unchecking
                levelField.disabled = true; // Disable the level field
                remarkField.disabled = true; // Disable the remark field
            }

            // Enable/disable level and remark fields based on checkbox changes
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    levelField.disabled = false;
                    remarkField.disabled = false;
                } else {
                    levelField.disabled = true;
                    remarkField.disabled = true;
                }
            });
        });

        // Exclude disabled fields from form submission
        document.querySelector('form').addEventListener('submit', function () {
            document.querySelectorAll('input[disabled]').forEach(input => input.removeAttribute('name'));
        });
    });
</script>  --}}
