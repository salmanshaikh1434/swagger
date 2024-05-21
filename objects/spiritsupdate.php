<?php
// added by salman to update multiple records.
class spiritsupdate
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function UpdateQueryBuilder($data)
    {
        $table = array_keys((array) $data)[0];
        if ($table == 'query') {
            return 'OK';
            exit;
        }
        $q = 'DESCRIBE ' . $table;
        $stmt = $this->conn->prepare($q);
        $stmt->execute();

        $query = "INSERT INTO " . $table . " (";
        $columns = array();
        $columnTypes = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $columns[] = "`" . $row['Field'] . "`";
            $columnTypes[$row['Field']] = $row['Type'];
        }
        $query .= implode(",", $columns) . ") VALUES ";

        if (isset($data->$table)) {
            $values = array();
            foreach ($data->$table as $record) {
                $rowValues = array();
                foreach ($columns as $column) {
                    $column = str_replace('`', '', $column);
                    if (!isset($record->$column) || $record->$column === null) {
                        $type = $columnTypes[$column];
                        if (strpos($type, 'int') !== false || strpos($type, 'float') !== false) {
                            $value = 0;
                        } elseif (strpos($type, 'bool') !== false) {
                            $value = 0;
                        } elseif (strpos($type, 'datetime') !== false) {
                            $value = 'NOW()';
                        } else {
                            $value = '';
                        }
                    } else {
                        $value = $record->$column;
                    }

                    $escapedValue = $this->conn->quote($value);
                    $columnType = $columnTypes[$column];

                    if (strpos($columnType, 'int') !== false || strpos($columnType, 'float') !== false) {
                        $rowValues[] = $escapedValue;
                    } elseif (strpos($columnType, 'bool') !== false) {
                        $rowValues[] = ($value ? '1' : '0');
                    } else {
                        $rowValues[] = $escapedValue;
                    }
                }
                $values[] = "(" . implode(",", $rowValues) . ")";
            }
            $query .= implode(",", $values);
            $query .= " ON DUPLICATE KEY UPDATE ";

            $updateValues = array();
            foreach ($columns as $column) {
                $column = str_replace('`', '', $column);

                if ($column == 'tstamp') {
                    $updateValues[] = "`tstamp`" . "=" . 'NOW()';
                } else {
                    $updateValues[] = "`" . $column . "`" . "=VALUES(" . "`" . $column . "`" . ")";
                }
            }
            $query .= implode(",", $updateValues);
        }

        $query = str_replace("'NOW()'", "NOW" . "()", $query);

        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return 'OK';
            exit;
        } else {
            $stmterror = $stmt->errorinfo();
            return $stmterror;
        }
    }




}