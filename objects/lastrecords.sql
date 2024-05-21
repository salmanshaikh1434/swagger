DELIMITER $ $ USE `asidb` $ $ DROP PROCEDURE IF EXISTS `sp_CheckMissingIds` $ $ CREATE DEFINER = `root` @`localhost` PROCEDURE `sp_CheckMissingIds`(
    IN tableName VARCHAR(255),
    IN columnName VARCHAR(255),
    IN storeno INT,
    IN curValue INT
) BEGIN DECLARE MissingId INT;

DECLARE MaxId INT;

loop_label: LOOP
SET
    @MissingId = 0;

SET
    @sql = '';

IF storeno = 0 THEN
SET
    @sql = CONCAT(
        'SELECT `',
        columnName,
        '` INTO @MissingId FROM ',
        tableName,
        ' WHERE `',
        columnName,
        '` = ',
        curValue
    );

ELSE
SET
    @sql = CONCAT(
        'SELECT `',
        columnName,
        '` INTO @MissingId FROM ',
        tableName,
        ' WHERE `',
        columnName,
        '` = ',
        curValue,
        ' AND `STORE` = ',
        storeno,
        ' '
    );

END IF;

PREPARE stmt
FROM
    @sql;

EXECUTE stmt;

DEALLOCATE PREPARE stmt;

IF @MissingId = 0 THEN
SELECT
    curValue AS MissingId;

LEAVE loop_label;

-- Exit the loop when @MissingId is NULL
END IF;

SET
    curValue = curValue + 1;

END LOOP loop_label;

PREPARE stmt
FROM
    @sql;

EXECUTE stmt;

DEALLOCATE PREPARE stmt;

SELECT
    @MissingId AS MissingId;

END $ $ DELIMITER;