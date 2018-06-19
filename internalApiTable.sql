CREATE TABLE `internal_api` (
  `methodName` varchar(255) NOT NULL DEFAULT '',
  `securityKey` varchar(255) NOT NULL DEFAULT '',
  `prepareDataStatement` text,
  `getDataStatement` text,
  PRIMARY KEY (`methodName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Trigger for creating random API key after inserting a new method

BEGIN

    SET @string := 'abcdefghijklmnopqrstuvwxyz0123456789';
    SET @i := 1;
    SET @hash := '';

    WHILE (@i <= 32) DO
        SET @hash := CONCAT(@hash, SUBSTRING(@string, FLOOR(RAND() * 36 + 1), 1));
        SET @i := @i + 1;
    END WHILE;

    SET NEW.securityKey := @hash;

END