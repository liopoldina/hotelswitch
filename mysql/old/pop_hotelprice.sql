CREATE DEFINER=`root`@`localhost` PROCEDURE `pop_hotelprice`(IN tablename VARCHAR(40))
BEGIN
DECLARE a INT;
DECLARE dias INT;
DECLARE dt date;

SET a=1;
SET dias=3;
SET dt='2020/01/01';

SET @s = CONCAT('DELETE FROM ', tablename);
PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

WHILE a <= dias DO

SET @s = CONCAT('INSERT INTO ', tablename,' values (''', dt,''', 99.49, 149.49)');

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET a=a+1;
SET dt=dt + INTERVAL 1 DAY;
END WHILE;

    
END