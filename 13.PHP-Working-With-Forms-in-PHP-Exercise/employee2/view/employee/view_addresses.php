<h4>Address for employee <?= $params[0]['first_name'].' '.$params[0]['last_name'];?></h4>
<table>
    <th>Address</th>
    <th>Town</th>
    <?php foreach ($params as $row) : ?>
        <tr>
            <td>
                <?= $row['address']; ?>
            </td>
            <td>
                <?= $row['town']; ?>
            </td>
           
        </tr>
    <?php endforeach; ?>
</table>

