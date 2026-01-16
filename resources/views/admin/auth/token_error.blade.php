<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invalid token</title>
    <!-- Include SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Display SweetAlert2 notification
        Swal.fire({
        position: "center",
        icon: "warning",
        title: "Invalid Token",
        text: "The token is invalid or expired. Please try again.",
        showConfirmButton: true,
        }).then(() => {
            // Redirect after the alert finishes
            window.location.href = "{{ route('index') }}";
        });
    </script>
</body>
</html>
