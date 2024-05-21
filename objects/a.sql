DELIMITER $ $ ALTER ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `brw` AS
SELECT
    `inv`.`type` AS `type`,
    `inv`.`name` AS `name`,
    `inv`.`sname` AS `sname`,
    `inv`.`pack` AS `pack`,
    `inv`.`sku` AS `sku`,
    `inv`.`typename` AS `typename`,
    `inv`.`invclub` AS `invclub`,
    `inv`.`image` AS `image`,
    `stk`.`store` AS `store`,
    `stk`.`back` + `stk`.`floor` AS `stock`,
    `stk`.`stat` AS `stat`,
    `stk`.`sloc` AS `sloc`,
    `stk`.`tstamp` AS `tstamp`,
    `stk`.`isdel` AS `isdel`,
    `stk`.`lreg` AS `lreg`,
    `stk`.`lstore` AS `lstore`,
    `inv`.`tags` AS `tags`,
    IF(
        (
            SELECT
                COUNT(0)
            FROM
                `prc`
            WHERE
                `prc`.`store` = `stk`.`store`
                AND `prc`.`sku` = `stk`.`sku`
        ) > 0,
(
            SELECT
                `prc`.`price`
            FROM
                `prc`
            WHERE
                `prc`.`store` = `stk`.`store`
                AND `prc`.`level` = '1'
                AND `prc`.`sku` = `stk`.`sku`
        ),
(
            SELECT
                `prc`.`price`
            FROM
                `prc`
            WHERE
                `prc`.`store` = 1
                AND `prc`.`level` = '1'
                AND `prc`.`sku` = `stk`.`sku`
        )
    ) AS `price`
FROM
    (
        `inv`
        JOIN (
            `prc`
            JOIN `stk`
        )
    )
WHERE
    `stk`.`sku` = `inv`.`sku`
    AND `prc`.`sku` = `stk`.`sku`
    AND `prc`.`level` = '1' $ $ DELIMITER;