INSERT INTO `internal_api` (`methodName`, `securityKey`, `prepareDataStatement`, `getDataStatement`)
VALUES
	('getClients', 'MOST_SECRET_HASH', 'set @num=1;', 'SELECT \nadded, COUNT(id) clientCount__number,promoCode\nFROM clients c\nGROUP BY added,promoCode;');
