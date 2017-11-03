<table>
    <th>Name</th>
    <th>Job Title</th>
    <th>Hire Date</th>
    <th>Salary</th>
    <th>Actions</th>
    <?php foreach ($params as $row) : ?>
        <tr>
            <td>
                <?= $row['first_name']; ?>
            </td>
            <td>
                <?= $row['job_title']; ?>
            </td>
            <td>
                <?= $row['hire_date']; ?>
            </td>
            <td>
                <?= $row['salary']; ?>
            </td>
            <td>
                <a href="?controller=EmployeeController&action=addProjects&employee_id=<?= $row['employee_id']; ?>">Add Project</a>
                <br/>
                <a href="?controller=EmployeeController&action=viewProjects&employee_id=<?= $row['employee_id']; ?>">View Projects</a>
                <br/>
                <a target="_blank" href="?controller=EmployeeController&action=viewAddresses&employee_id=<?= $row['employee_id']; ?>">View Adresses</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

