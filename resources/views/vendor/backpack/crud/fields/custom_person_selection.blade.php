@php
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
                        {{ $isAdmin ? 'checked' : '' }} > 
                </td>
                <td>{{ $person->first_name }}</td>
                <td>{{ $person->last_name }}</td>
                <td>
                    <input type="text" name="level[{{ $person->id }}]" class="form-control level-field"
                        value="{{ $isAdmin ? $existingAdmins[$person->id] : '' }}"
                        {{ $isAdmin ? '' : 'disabled' }} style="width: 100px;">
                </td>
                <td>
                    <input type="text" name="remark[{{ $person->id }}]" class="form-control remark-field"
                        value="{{ $isAdmin ? $adminRemarks[$person->id] : '' }}"
                        {{ $isAdmin ? '' : 'disabled' }} style="width: 150px;">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        $('input.person-checkbox').each(function(e,element) {
            console.log(element);
            console.log(element.checked);
            if(element.checked) {
                $(element).attr("disabled", true);
                $('input[name="level[' + (e+1) + ']"]').attr("disabled", true)
                $('input[name="remark[' + (e+1) + ']"]').attr("disabled", true)
            }
        });


         document.querySelectorAll('.person-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const personId = this.value;
                const levelField = document.querySelector(`input[name="level[${personId}]"]`);
                const remarkField = document.querySelector(`input[name="remark[${personId}]"]`);

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
        document.querySelector('form').addEventListener('submit', function () {
            document.querySelectorAll('input[disabled]').forEach(input => input.removeAttribute('name'));
        });
    });
</script>
