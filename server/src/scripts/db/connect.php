<?php
session_start();
error_reporting(0);

// ============================================================================
// SUPABASE / POSTGRESQL CONNECTION
// ============================================================================
// Load environment variables from .env file
// ============================================================================

// Environment variables are now loaded via dotenv-cli or the hosting provider (Render/Railway).
// No manual loading logic is required here.

// SUPABASE CREDENTIALS (from .env file)
$supabase_host = getenv('SUPABASE_HOST') ?: 'localhost';
$supabase_port = getenv('SUPABASE_PORT') ?: '5432';
$supabase_dbname = getenv('SUPABASE_DBNAME') ?: 'postgres';
$supabase_user = getenv('SUPABASE_USER') ?: 'postgres';
$supabase_password = getenv('SUPABASE_PASSWORD') ?: '';

try {
    $dsn = "pgsql:host=$supabase_host;port=$supabase_port;dbname=$supabase_dbname";
    $db = new PDO($dsn, $supabase_user, $supabase_password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// ============================================================================
// HELPER FUNCTIONS (for backward compatibility with existing code patterns)
// ============================================================================

/**
 * Execute a query and return the result
 * @param PDO $db Database connection
 * @param string $sql SQL query
 * @return PDOStatement|false
 */
function db_query($db, $sql)
{
    try {
        return $db->query($sql);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Fetch a single row as associative array
 * @param PDOStatement $result
 * @return array|false
 */
function db_fetch_array($result)
{
    if ($result === false)
        return false;
    return $result->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fetch all rows as associative array
 * @param PDOStatement $result
 * @return array
 */
function db_fetch_all($result)
{
    if ($result === false)
        return [];
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get number of rows in result
 * @param PDOStatement $result
 * @return int
 */
function db_num_rows($result)
{
    if ($result === false)
        return 0;
    return $result->rowCount();
}

/**
 * Get last inserted ID
 * @param PDO $db
 * @return string
 */
function db_insert_id($db)
{
    return $db->lastInsertId();
}

/**
 * Escape string (for backward compatibility - prefer prepared statements)
 * @param PDO $db
 * @param string $str
 * @return string
 */
function db_escape($db, $str)
{
    return substr($db->quote($str), 1, -1);
}
?>