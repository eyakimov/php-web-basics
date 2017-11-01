<h1>List all customers</h1>
<table>
    <th>First name</th>
    <th>Family name</th>

    <?php foreach ($customers as $customer): ?>
        <tr>		 
            <td><?php echo($customer['first_name']); ?></td>
            <td><?php echo($customer['family_name']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
