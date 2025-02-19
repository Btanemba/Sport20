

@php
    $persons = $field['persons']; // List of persons passed from the controller
    $existingAdmins = $field['existingAdmins']; // List of existing admins
@endphp

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Person</th>
            <th>Admin Level</th>
            <th>Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($persons as $person)
            @php
                $isAdmin = in_array($person->id, $existingAdmins); // Check if the person is already an admin
            @endphp
            <tr>
                <td>
                    <input type="checkbox" name="person_ids[]" value="{{ $person->id }}" class="person-checkbox"
                        {{ $isAdmin ? 'checked' : '' }}>
                    {{ $person->first_name }} {{ $person->last_name }} <!-- Display person's name -->
                </td>
                <td>
                    <input type="text" name="level[{{ $person->id }}]" class="form-control level-field"
                        value="{{ $isAdmin ? \App\Models\Administrator::find($person->id)->level : '' }}"
                        {{ $isAdmin ? '' : 'disabled' }} style="width: 100px;"> <!-- Reduced width -->
                </td>
                <td>
                    <input type="text" name="remark[{{ $person->id }}]" class="form-control remark-field"
                        value="{{ $isAdmin ? \App\Models\Administrator::find($person->id)->remark : '' }}"
                        {{ $isAdmin ? '' : 'disabled' }} style="width: 150px;"> <!-- Reduced width -->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.person-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const personId = this.value;
                const levelField = document.querySelector(`input[name="level[${personId}]"]`);
                const remarkField = document.querySelector(`input[name="remark[${personId}]"]`);

                if (this.checked) {
                    levelField.removeAttribute('disabled');
                    levelField.setAttribute('required', 'required');
                    remarkField.removeAttribute('disabled');
                } else {
                    levelField.setAttribute('disabled', 'disabled');
                    levelField.removeAttribute('required');
                    remarkField.setAttribute('disabled', 'disabled');
                }
            });
        });

        // Exclude disabled fields from form submission
        document.querySelector('form').addEventListener('submit', function (e) {
            document.querySelectorAll('input[disabled]').forEach(input => {
                input.removeAttribute('name'); // Remove the name attribute to exclude it from submission
            });
        });
    });
</script>
