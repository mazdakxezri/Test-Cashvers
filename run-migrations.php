<?php
/**
 * Migration Runner for Hostinger - IMPROVED VERSION
 */

echo "<!DOCTYPE html><html><head><title>Running Migrations</title></head><body>";
echo "<h2>🔧 Running Database Migrations...</h2>";
echo "<pre style='background: #f5f5f5; padding: 20px; border-radius: 8px; overflow: auto;'>";

// Step 1: Check if we're in the right directory
echo "Step 1: Checking paths...\n";
echo "Current directory: " . __DIR__ . "\n";
echo "Looking for: " . __DIR__ . "/coree/artisan\n";

if (!file_exists(__DIR__ . '/coree/artisan')) {
    echo "<strong style='color: red;'>❌ ERROR: artisan file not found!</strong>\n";
    echo "Expected location: " . __DIR__ . "/coree/artisan\n";
    echo "\n<strong>SOLUTION: Run migrations manually via phpMyAdmin instead.</strong>\n";
    echo "</pre>";
    echo "<p><a href='#sql-instructions'>See SQL instructions below</a></p>";
    echo "</body></html>";
    exit;
}

echo "✅ artisan file found!\n\n";

// Step 2: Try to run migrations
echo "Step 2: Running migrations...\n";
echo "Command: cd coree && php artisan migrate --force\n\n";

// Change to coree directory
$oldDir = getcwd();
chdir(__DIR__ . '/coree');

// Check for vendor directory
if (!file_exists('vendor/autoload.php')) {
    echo "<strong style='color: orange;'>⚠️ WARNING: vendor directory not found!</strong>\n";
    echo "This means composer dependencies are not installed.\n";
    echo "Migrations cannot run via artisan.\n\n";
    echo "<strong>SOLUTION: Use phpMyAdmin method instead (see below)</strong>\n";
    chdir($oldDir);
    echo "</pre>";
    echo "<hr>";
    echo "<div id='sql-instructions'>";
    showManualSQL();
    echo "</div>";
    echo "</body></html>";
    exit;
}

// Try to run migrations
$output = [];
$returnCode = 0;

exec('php artisan migrate --force 2>&1', $output, $returnCode);

foreach ($output as $line) {
    echo htmlspecialchars($line) . "\n";
}

chdir($oldDir);

if ($returnCode === 0) {
    echo "\n<strong style='color: green; font-size: 20px;'>✅ MIGRATIONS COMPLETED SUCCESSFULLY!</strong>\n";
    echo "</pre>";
    echo "<hr>";
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745; margin: 20px 0;'>";
    echo "<h3 style='color: #155724; margin-top: 0;'>✅ Success!</h3>";
    echo "<p style='color: #155724;'><strong>All database tables have been created.</strong></p>";
    echo "<p style='color: #155724;'>Now:</p>";
    echo "<ol style='color: #155724;'>";
    echo "<li><strong>DELETE THIS FILE</strong> (run-migrations.php) from your server immediately!</li>";
    echo "<li>Go to your website and hard refresh (Cmd+Shift+R or Ctrl+Shift+R)</li>";
    echo "<li>Daily Login Bonus and Lootbox features will now appear!</li>";
    echo "</ol>";
    echo "</div>";
    echo "<p><a href='/earn' style='background: #00B8D4; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block;'>Go to Dashboard</a></p>";
} else {
    echo "\n<strong style='color: red; font-size: 20px;'>❌ MIGRATION FAILED!</strong>\n";
    echo "Error code: {$returnCode}\n";
    echo "</pre>";
    echo "<hr>";
    echo "<div id='sql-instructions'>";
    showManualSQL();
    echo "</div>";
}

echo "</body></html>";

function showManualSQL() {
    echo "<h3>📋 Manual Migration via phpMyAdmin</h3>";
    echo "<p>Since artisan cannot run, please use phpMyAdmin instead:</p>";
    echo "<ol>";
    echo "<li>Log into <strong>Hostinger</strong></li>";
    echo "<li>Go to <strong>Databases</strong> → <strong>phpMyAdmin</strong></li>";
    echo "<li>Select database: <code>u876970906_testserver</code></li>";
    echo "<li>Click <strong>SQL</strong> tab</li>";
    echo "<li>Copy and paste the SQL from the file: <code>MIGRATION-SQL.txt</code></li>";
    echo "<li>Click <strong>Go</strong></li>";
    echo "</ol>";
    echo "<p><a href='/MIGRATION-SQL.txt' target='_blank' style='background: #007bff; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-block;'>View SQL File</a></p>";
}
?>
