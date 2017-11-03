<table>
    <th>Name</th>
    <th>Description</th>
    <th>Start Date</th>
    <th>End Date</th>
    <?php foreach ($params as $row) : ?>
        <tr>
            <td>
                <?= $row['name']; ?>
            </td>
            <td>
                <?= $row['description']; ?>
            </td>
            <td>
                <?= $row['start_date']; ?>
            </td>
            <td>
                <?= $row['end_date']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

