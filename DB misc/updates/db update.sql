ALTER TABLE  `stock_perpetual_stock_register` ADD UNIQUE (
`id_item` ,
`date`
);


CREATE TABLE IF NOT EXISTS `stock_final_stock` (
`id_final_stock` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `total_in` float NOT NULL,
  `total_out` float NOT NULL,
  `total_in_hand` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Sales store only';

ALTER TABLE `stock_final_stock`
 ADD PRIMARY KEY (`id_final_stock`);

ALTER TABLE `stock_final_stock`
MODIFY `id_final_stock` int(11) NOT NULL AUTO_INCREMENT;