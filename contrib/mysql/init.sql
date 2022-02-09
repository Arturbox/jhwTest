CREATE
USER 'treasury'@'%' IDENTIFIED BY 'IcD_cCX:M2j*y';
CREATE
DATABASE IF NOT EXISTS treasury;
GRANT ALL
ON treasury.* TO 'treasury'@'%';

FLUSH
PRIVILEGES;
