<!-- application/views/donation/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Donation</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Edit Donation</h2>
    <form action="<?= base_url('donation/update/' . $donation['id']) ?>" method="POST">
        <div class="form-group">
            <label for="recipient_name">Recipient Name</label>
            <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="<?= $donation['recipient_name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?= $donation['type'] ?>" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?= $donation['amount'] ?>" required>
        </div>
        <div class="form-group">
            <label for="date_given">Date Given</label>
            <input type="date" class="form-control" id="date_given" name="date_given" value="<?= $donation['date_given'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('donation') ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
