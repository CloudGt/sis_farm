Use Apdahum;
alter table `apdahum`.`bodegam` ,add column `afecto` enum ('S','N')  DEFAULT 'S' NOT NULL  after `caducidad`;
commit;
update bodegam set activo='N' where id_producto in(2268,2270,2272);
commit;


alter table `apdahum`.`presentacion` ,add column `Activo` enum ('S','N')  DEFAULT 'S' NOT NULL  after `Presentacion`;
