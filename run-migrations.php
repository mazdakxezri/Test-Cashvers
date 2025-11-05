<?php
/**
 * Migration Runner for Hostinger Shared Hosting
 * 
 * Upload this file to your public_html directory and visit it in browser
 * Example: https://test.cashvers.com/run-migrations.php
 * 
 * IMPORTANT: Delete this file after running!
 */

// Change to your project directory
chdir(__DIR__ . '/coree');

// Run migrations
echo "<h2>Running Database Migrations...</h2>";
echo "<pre>";

$output = [];
$returnCode = 0;

exec('php artisan migrate --force 2>&1', $output, $returnCode);

foreach ($output as $line) {
    echo htmlspecialchars($line) . "\n";
}

if ($returnCode === 0) {
    echo "\n<strong style='color: green;'>✅ Migrations completed successfully!</strong>\n";
} else {
    echo "\n<strong style='color: red;'>❌ Migration failed with error code: {$returnCode}</strong>\n";
}

echo "</pre>";

echo "<h3>⚠️ IMPORTANT:</h3>";
echo "<p style='background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;'>";
echo "<strong>For security, delete this file immediately:</strong><br>";
echo "File location: <code>/public_html/run-migrations.php</code>";
echo "</p>";

echo "<hr>";
echo "<p><a href='/earn' style='background: #00B8D4; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block;'>Go to Dashboard</a></p>";
?>

