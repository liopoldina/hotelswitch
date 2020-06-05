CREATE DEFINER=`root`@`localhost` PROCEDURE `new_hotelprice`(IN tablename VARCHAR(40))
BEGIN

SET @s = CONCAT('CREATE TABLE IF NOT EXISTS hoteldata.', tablename,'(
  `Date` DATE NULL,
  `Room1` DECIMAL(6,2) NULL,
  `Room2` DECIMAL(6,2) NULL)');
PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


END