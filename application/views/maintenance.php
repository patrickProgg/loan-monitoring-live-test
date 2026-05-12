<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .maintenance-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card maintenance-card shadow-lg p-5 text-center" style="max-width: 500px;">
            <div class="mb-4">
                <i class="display-1">🔧</i>
            </div>
            <h1 class="h2 mb-3">Server Maintenance</h1>
            <div class="alert alert-warning">
                <strong>503 Service Unavailable</strong>
            </div>
            <p class="text-muted mb-4">
                We're currently performing scheduled maintenance.
                Please try again in a few minutes.
            </p>
            <div class="progress mb-3">
                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 75%"></div>
            </div>
            <small class="text-muted">
                Last checked:
                <?= date('Y-m-d H:i:s') ?>
            </small>
        </div>
    </div>
</body>

</html>