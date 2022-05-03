DELIMITER $$
  CREATE TRIGGER ControlHistorial BEFORE INSERT ON `tbl_historial`
  FOR EACH ROW
  BEGIN
    SET @countInsUsu = (SELECT COUNT(*) FROM tbl_historial WHERE id_usu = NEW.id_usu AND id_contenido = NEW.id_contenido);
    IF @countInsUsu >= 1
      THEN SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Este usuario ya ha descargado este apunte';
    END IF;
  END $$
DELIMITER ;