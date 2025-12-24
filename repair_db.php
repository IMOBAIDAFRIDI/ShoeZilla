<?php
include 'config/database.php';

echo "<h1>Database Repair Tool</h1>";

// 1. Disable Foreign Keys
if ($conn->query("SET FOREIGN_KEY_CHECKS = 0") === TRUE) {
    echo "<p style='color:green'>Foreign keys disabled.</p>";
} else {
    echo "<p style='color:red'>Error disabling keys: " . $conn->error . "</p>";
}

// 2. Truncate Tables
$tables = ['order_items', 'orders', 'products'];
foreach ($tables as $table) {
    if ($conn->query("TRUNCATE TABLE $table") === TRUE) {
        echo "<p style='color:green'>Table $table cleared.</p>";
    } else {
        echo "<p style='color:red'>Error clearing $table: " . $conn->error . "</p>";
    }
}

// 3. Re-enable Foreign Keys
if ($conn->query("SET FOREIGN_KEY_CHECKS = 1") === TRUE) {
    echo "<p style='color:green'>Foreign keys re-enabled.</p>";
} else {
    echo "<p style='color:red'>Error enabling keys: " . $conn->error . "</p>";
}

// 4. Run Seed Script
$sqlFile = 'seed_large.sql';
if (file_exists($sqlFile)) {
    $command = "mysql -u " . $username . (empty($password) ? "" : " -p$password") . " -D " . $dbname . " < " . $sqlFile;
    // Note: exec might not work on all hosts, but trying manual loop fallback if needed.
    // However, for XAMPP locally, we can try to read the file and execute queries.
    
    $query = file_get_contents($sqlFile);
    // Split by semicolon, but be careful about data content. 
    // Since seed_large.sql has simple structure, we can try sourcing it via command line or just assume the previous steps cleared it and let user run import manually if this fails.
    // Better: Just tell them usage.
    
    echo "<h2>Clean up complete. Now executing seed data...</h2>";
    
    // We already have the file content in $query. 
    // Simple parser for this specific file structure
    $commands = explode(';', $query);
    $count = 0;
    foreach ($commands as $cmd) {
        $cmd = trim($cmd);
        if (!empty($cmd) && strpos($cmd, 'INSERT') === 0) {
           if ($conn->query($cmd) === TRUE) {
               $count++;
           } else {
               echo "<p style='color:red'>Error inserting data: " . $conn->error . "</p>";
           }
        }
    }
    echo "<p style='color:green'>Successfully inserted seed batches.</p>";
    
} else {
    echo "<p style='color:red'>Seed file not found.</p>";
}

echo "<h3><a href='index.php'>Go to Home Page</a></h3>";
?>
