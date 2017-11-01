<h1>List all cars</h1>
<table>
    <th>Make</th>
    <th>Model</th>
    <th>Year</th>

    <?php foreach ($cars as $car): ?>
        <tr>		 
            <td><?php echo($car['make']); ?></td>
            <td><?php echo($car['model']); ?></td>
            <td><?php echo($car['year']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
