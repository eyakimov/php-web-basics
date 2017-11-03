<h1>Add project</h1>
<form method="POST" action="<?= $params['action']; ?>">
    Name: <input type="text" name="name" value="" />
    <br/>
    Description: <input type="text" name="description" value="" />
    <br/>
    End Date: <input type="date" name="end_date" value="" />
    <br/>
    <input type="submit" name="save" value="Save"/>
    <input type="submit" name="cancel" value="Cancel"/>
</form>

