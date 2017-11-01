<table>
    <th>Make</th>
    <th>Model</th>
    <th>Year</th>
    <th>Car ID</th>
    <th>Owner first name</th>
    <th>Owner last name</th>
    <th>Customer ID</th>

    <?php foreach ($cars as $car): ?>
        <tr>		 
            <td><?php echo($car['make']); ?></td>
            <td><?php echo($car['model']); ?></td>
            <td><?php echo($car['year']); ?></td>
            <td><?php echo($car['car_id']); ?></td>
            <td><?php echo($car['first_name']); ?></td>
            <td><?php echo($car['family_name']); ?></td>
            <td><?php echo($car['customer_id']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
