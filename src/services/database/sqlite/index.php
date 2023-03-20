<?
class SQLite_Client {
    private $database_handle;
    private $app_config_file;

    /**
     * @param String $config_file_path - file path where the application config file is located
     */
    function __construct($config_file_path) {
        if (!file_exists($config_file_path)) {
            throw new Exception("Could not find application config file ($config_file_path)");
        }

        $json = file_get_contents($config_file_path);
        $app_config = json_decode($json, TRUE);
        $database_file_path = __DIR__ . $app_config['DATABASE_FILE_PATH'];

        $database_handle = new SQLite3($database_file_path, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

        if (!$database_handle) {
            throw new Exception("Could not initialize or create database at ($database_file_path)");
        } else {
            $this->database_handle = $database_handle;
            $this->app_config_file = $config_file_path;
            error_log("Opened database at ($database_file_path) successfully");
        }
    }

    /**
     * Runs a seeding script to initialize the database tables
     * @param Array $seed_sql - list of sql commands to execute for seeding the database
     */
    function seed_database($seed_sql) {
        $json = file_get_contents($this->app_config_file);
        $app_config = json_decode($json, TRUE);

        if (!$app_config['DATABASE_INITIALIZED']) {
            foreach ($seed_sql as $sql) {
                $this->database_handle->exec($sql);
            }

            $app_config['DATABASE_INITIALIZED'] = TRUE;
            $updated_app_config = json_encode($app_config, JSON_PRETTY_PRINT);
            file_put_contents($this->app_config_file, $updated_app_config, LOCK_EX);
        }
    }

    /**
     * Fetches a handle to the database 
     * @return Object
     */
    function get_handle() {
        return $this->database_handle;
    }
};

?>