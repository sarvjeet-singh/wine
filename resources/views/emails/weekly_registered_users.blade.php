<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Registered Users</title>
</head>
<body>
    <h1>Weekly Registered Users</h1>
    <p>Here is the list of users who registered this week:</p>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->firstname }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->contact_number }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
