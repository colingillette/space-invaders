CREATE DATABASE `spaceinvaders` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(45) NOT NULL,
  `score` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `spaceinvaders`.`scores`
(`id`,
`display_name`,
`score`,
`time`)
VALUES
(1,
'Tester1',
500,
'2019-11-01');

INSERT INTO `spaceinvaders`.`scores`
(`id`,
`display_name`,
`score`,
`time`)
VALUES
(1,
'Tester2',
200,
'2019-11-01');

INSERT INTO `spaceinvaders`.`scores`
(`id`,
`display_name`,
`score`,
`time`)
VALUES
(1,
'Tester3',
900,
'2019-11-01');

INSERT INTO `spaceinvaders`.`scores`
(`id`,
`display_name`,
`score`,
`time`)
VALUES
(1,
'Invader',
8900,
'2019-11-03');

INSERT INTO `spaceinvaders`.`scores`
(`id`,
`display_name`,
`score`,
`time`)
VALUES
(1,
'Tester1',
1200,
'2019-11-07');