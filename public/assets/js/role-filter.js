$(document).ready(function () {
    console.log("Role filter script loaded");

    // Ensure department select exists
    const departmentSelect = $('#department_id');
    if (departmentSelect.length === 0) {
        console.warn("Department select element (#department_id) not found. Exiting role-filter.js.");
        return; // Exit script if #department_id is not found
    }

    // Ensure roles grid exists
    const rolesGrid = $('#roles_grid');
    if (rolesGrid.length === 0) {
        console.warn("Roles grid element (#roles_grid) not found. Exiting role-filter.js.");
        return; // Exit script if #roles_grid is not found
    }

    // Filter roles when department selection changes
    departmentSelect.on('change', function () {
        const deptId = $(this).val() || 'null';
        console.log("Selected department:", deptId);

        $('.role-item').each(function () {
            const roleDept = $(this).data('dept-id');
            if (roleDept == deptId || roleDept == 'null') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Trigger filtering on page load (in case a department is preselected)
    departmentSelect.trigger('change');

    // Handler for "Show All Roles" button
    $('#showAllRolesBtn').on('click', function () {
        $('.role-item').show();
        console.log("Showing all roles");
    });

    // Handler for "Filter by Department" button
    $('#filterRolesBtn').on('click', function () {
        const deptId = departmentSelect.val() || 'null';
        if (!deptId || deptId === '') {
            alert("Please select a department first");
            return;
        }

        $('.role-item').each(function () {
            const roleDept = $(this).data('dept-id');
            if (roleDept == deptId || roleDept == 'null') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        console.log("Filtered roles for department:", deptId);
    });
});
