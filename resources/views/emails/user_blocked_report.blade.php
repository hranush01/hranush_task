
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Blocked Report</title>
</head>
<body>
<p>Dear {{ $user->name }},</p>

<p>Your account has been blocked:</p>

<p><strong>Report Text:</strong> {{ $reportText }}</p>

<p>Thank you</p>p
</body>
</html>
