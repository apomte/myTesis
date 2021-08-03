-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2021 at 02:12 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tesis`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_precio_producto` (`n_cantidad` INT, `n_precio` DECIMAL(10,2), `codigo` INT)  BEGIN
	DECLARE nueva_existencia int;
    DECLARE nuevo_total decimal(10,2);
    DECLARE nuevo_precio decimal(10,2);
    
    DECLARE cant_actual int;
    DECLARE pre_actual decimal(10,2);
    
    DECLARE actual_existencia int;
    DECLARE actual_precio decimal(10,2);
    
    SELECT precio,existencia INTO actual_precio,actual_existencia FROM producto WHERE codproducto = codigo;
    SET nueva_existencia = actual_existencia + n_cantidad;
    SET nuevo_total = (actual_existencia * actual_precio) + (n_cantidad * n_precio);
    SET nuevo_precio = nuevo_total / nueva_existencia;
    
    UPDATE producto SET existencia = nueva_existencia, precio = nuevo_precio WHERE codproducto = codigo;
    
    SELECT nueva_existencia,nuevo_precio;
    
  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `rif` int(10) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`idcliente`, `rif`, `nombre`, `telefono`, `direccion`, `dateadd`, `usuario_id`, `status`) VALUES
(1, 65842000, 'José Rafael Urdaneta Urtado', 2122517472, 'palo verde jose feliz rivas', '2021-05-12 10:09:58', 1, 1),
(2, 1122334455, 'julio del nogal', 2147483647, 'petare,barrio de pakistan', '2021-05-12 10:12:39', 23, 1),
(3, 25412, 'inocencio ramirez', 2147483647, 'prado del este .este', '2021-05-12 10:15:08', 5, 0),
(4, 5645456, 'feliciano blanco goncalvez', 2147483647, 'pedro camejo sur', '2021-05-12 10:18:04', 5, 1),
(5, 0, 'maria romero', 2147483647, 'jose feliz rivas', '2021-05-12 10:21:36', 5, 1),
(6, 0, 'gina romero', 2122578542, 'prado del este .este', '2021-05-12 11:10:23', 1, 1),
(7, 1234567890, 'marta cecilia', 2147483647, 'veneziela', '2021-05-12 11:29:11', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(11) NOT NULL,
  `nofactura` bigint(11) DEFAULT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `preciototal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `nofactura` bigint(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `preciototal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entradas`
--

INSERT INTO `entradas` (`correlativo`, `codproducto`, `fecha`, `cantidad`, `precio`, `usuario_id`) VALUES
(1, 1, '2021-05-18 10:13:03', 100, '250000.00', 1),
(2, 2, '2021-05-18 10:17:19', 50, '1000000.00', 1),
(3, 3, '2021-05-18 13:54:54', 200, '200000.00', 1),
(4, 4, '2021-05-18 13:56:34', 10, '254.00', 1),
(5, 5, '2021-05-18 14:00:14', 25, '300000.00', 1),
(6, 6, '2021-05-18 14:00:42', 200, '1200000.00', 1),
(7, 7, '2021-05-18 14:14:42', 24, '99999999.99', 1),
(8, 8, '2021-05-19 10:14:01', 24, '99999999.99', 1),
(9, 9, '2021-05-19 10:14:13', 200, '1200000.00', 1),
(10, 10, '2021-05-19 11:12:44', 100, '25000000.00', 1),
(11, 11, '2021-05-19 11:15:10', 50, '23343434.00', 1),
(12, 12, '2021-05-21 10:56:37', 1000, '2000.00', 1),
(13, 12, '2021-05-21 13:54:18', 1000, '4000.00', 1),
(14, 2, '2021-05-21 14:00:13', 100, '500000.00', 1),
(15, 9, '2021-05-22 11:07:35', 50, '5000.00', 1),
(16, 9, '2021-05-22 11:07:38', 50, '5000.00', 1),
(17, 9, '2021-05-22 11:07:40', 50, '5000.00', 1),
(18, 9, '2021-05-22 11:07:40', 50, '5000.00', 1),
(19, 9, '2021-05-22 11:07:40', 50, '5000.00', 1),
(20, 9, '2021-05-22 11:07:40', 50, '5000.00', 1),
(21, 9, '2021-05-22 11:07:40', 50, '5000.00', 1),
(22, 9, '2021-05-22 11:07:41', 50, '5000.00', 1),
(23, 4, '2021-05-22 11:11:21', 100, '1000.00', 1),
(24, 12, '2021-05-22 11:24:22', 2000, '3000.00', 1),
(25, 12, '2021-05-22 11:28:08', -2000, '3000.00', 1),
(26, 4, '2021-05-22 11:30:35', 1000, '0.00', 1),
(27, 4, '2021-05-22 11:30:56', 2000, '1000.00', 1),
(28, 13, '2021-05-22 13:23:39', 1000, '6500.00', 1),
(29, 13, '2021-05-24 11:22:35', 100, '6400.00', 1),
(30, 13, '2021-05-24 12:06:54', 100, '6500.00', 1),
(31, 13, '2021-05-24 12:06:56', 100, '6500.00', 1),
(32, 13, '2021-05-24 12:06:56', 100, '6500.00', 1),
(33, 13, '2021-05-24 12:06:56', 100, '6500.00', 1),
(34, 13, '2021-05-24 12:08:47', 100, '6600.00', 1),
(35, 12, '2021-05-24 12:10:18', 100, '3500.00', 1),
(36, 12, '2021-05-24 12:10:52', 100, '4000.00', 1),
(37, 13, '2021-05-24 12:16:26', 100, '7000.00', 1),
(38, 13, '2021-05-24 12:17:19', 100, '8000.00', 1),
(39, 13, '2021-05-24 12:20:22', 100, '1800.00', 1),
(40, 13, '2021-05-24 12:25:24', 100, '10000.00', 1),
(41, 13, '2021-05-24 12:27:06', 100, '9500.00', 1),
(42, 11, '2021-05-24 12:31:15', 100, '36522.00', 1),
(43, 13, '2021-05-24 12:43:14', 100, '9500.00', 1),
(44, 13, '2021-05-24 12:45:22', 100, '150000.00', 1),
(45, 13, '2021-05-24 12:46:35', 50, '14000.00', 1),
(46, 12, '2021-05-24 09:19:04', 50, '4000.00', 1),
(47, 12, '2021-05-24 09:21:00', 50, '3500.00', 1),
(48, 10, '2021-05-24 09:39:44', 25, '5000000.00', 1),
(49, 13, '2021-05-24 09:45:34', 50, '20000.00', 1),
(50, 12, '2021-05-27 09:55:00', 50, '2500.00', 1),
(51, 12, '2021-05-27 12:22:45', 25, '3000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `totalfactura` decimal(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `codproducto` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`codproducto`, `descripcion`, `proveedor`, `precio`, `existencia`, `foto`, `date_add`, `usuario_id`, `status`) VALUES
(1, 'teclado usb', 3, '250000.00', 100, 'img_producto.png', '2021-05-18 10:13:03', 1, 1),
(2, 'telefono samsung', 2, '666666.67', 150, 'img_producto.png', '2021-05-18 10:17:19', 1, 1),
(3, 'Guitarra Electrica', 6, '200000.00', 200, 'img_producto.png', '2021-05-18 13:54:54', 1, 1),
(4, 'oreja', 7, '676.06', 3110, 'img_producto.png', '2021-05-18 13:56:34', 1, 1),
(5, 'manquernas', 5, '300000.00', 25, 'img_a6177bb908913d081fcd80b280c7f38d.jpg', '2021-05-18 14:00:14', 1, 1),
(6, 'colchones', 9, '1200000.00', 200, 'img_producto.png', '2021-05-18 14:00:42', 1, 1),
(7, 'antivirus', 4, '99999999.99', 24, 'img_producto.png', '2021-05-18 14:14:42', 1, 1),
(8, 'antivirus', 4, '99999999.99', 24, 'img_producto.png', '2021-05-19 10:14:01', 1, 1),
(9, 'colchones', 9, '153846.15', 650, 'img_producto.png', '2021-05-19 10:14:13', 1, 1),
(10, 'RESMAS DE PAPEL B100 E 44', 10, '3874.00', 125, 'img_producto.png', '2021-05-19 11:12:44', 1, 1),
(11, 'recibos de papel', 13, '666666.67', 150, 'img_producto.png', '2021-05-19 11:15:10', 1, 1),
(12, 'impresora', 7, '2021.05', 2375, 'img_producto.png', '2021-05-21 10:56:37', 1, 1),
(13, 'PAPEL 20 40 OFICIO', 9, '10000.00', 2400, 'img_producto.png', '2021-05-22 13:23:39', 1, 1);

--
-- Triggers `producto`
--
DELIMITER $$
CREATE TRIGGER `Tentradas` AFTER INSERT ON `producto` FOR EACH ROW BEGIN
        	INSERT INTO entradas( codproducto,cantidad,precio,usuario_id)
            VALUES (new.codproducto,new.existencia,new.precio,new.usuario_id);
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`, `date_add`, `usuario_id`, `status`) VALUES
(1, 'chaguarmas', 'carlos Gonxans', 123456789, 'los palos grandes', '2021-05-17 08:55:04', 1, 0),
(2, 'AVG1299', 'jorge cremades', 54885669223, 'avenida los cerritos verdes', '2021-05-17 08:55:04', 1, 0),
(3, 'CASIO', 'Julio Estrada', 123456789, 'los cortijos ', '2021-05-17 08:55:04', 23, 1),
(4, 'COMPUMALLl', 'Roberto Estrada', 123456789, 'pequeña Venecia Venezuela', '2021-05-17 08:55:04', 1, 1),
(5, 'MR OLIMPIA', 'Elena Franco Morales', 123456796, 'vuelta el ahorcado', '2021-05-17 08:55:04', 23, 1),
(6, 'HAT3XEN', 'Fernando Guerra', 123456789, 'el tambor', '2021-05-17 08:55:04', 1, 1),
(7, 'ARABES C.A', 'Roben lamata', 123456789, 'pakistam', '2021-05-17 08:55:04', 1, 1),
(8, 'MATEA IG', 'Julieta Contreras', 89476787, 'la emplanada', '2021-05-17 08:55:04', 1, 1),
(9, 'NEGRA IPOLITA', 'Felix Arnoldo Rojas', 476378276, 'los roques', '2021-05-17 08:55:04', 23, 1),
(10, 'AL QUA IR C.A', 'Oscar Maldonado', 788376787, 'el muelle de san blas', '2021-05-17 08:55:04', 23, 1),
(11, 'EPSOM NOR', 'Angel Cardona', 123456789, 'la vuelta al gato', '2021-05-17 08:55:04', 23, 1),
(12, 'banesco', 'maria romero', 2122517472, 'pedro camejo sur', '2021-05-17 10:06:45', 1, 1),
(13, 'banco del sur', 'gina valentina', 212256689, 'barrio el tanque', '2021-05-17 10:07:26', 1, 1),
(14, 'dixon bello', 'maria del mar', 2411125487, 'valencia ,carabobo', '2021-05-17 10:17:06', 23, 1),
(15, 'la mata.c.a', 'carlos el pie', 41258769852, 'jose feliz rivas', '2021-05-17 10:19:26', 19, 1),
(16, 'NORTON SECURITY INC', 'George harris', 4245587952, 'America del norte', '2021-05-18 12:15:55', 1, 1),
(17, 'AVAST SECURITY', 'CLAR MARX', 2122517472, 'US FLORIDA ALICANTE', '2021-05-22 13:21:22', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'administrador'),
(2, 'supervisor'),
(3, 'vendedor');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `status`) VALUES
(1, 'Jefferson Aponte Romero', 'apomte_1@hotmail.com', 'admin', '202cb962ac59075b964b07152d234b70', 1, 1),
(2, 'veronica reyes del mazo', 'veronica@hotmail.com', 'vero', '202cb962ac59075b964b07152d234b70', 3, 1),
(3, 'Gina romero Vergara ', 'gina@hotmail.com', 'gina', '202cb962ac59075b964b07152d234b70', 3, 1),
(4, 'miguel angel landa rodriguez', 'miguel@hotmail.com', 'miguel', '202cb962ac59075b964b07152d234b70', 3, 1),
(5, 'Noelia pinto Hernández moreno', 'noelia@hotmail.com', 'noelia', '202cb962ac59075b964b07152d234b70', 2, 1),
(6, 'marta Cecilia Arocha', 'marta_1@hotmail.com', 'marta', '202cb962ac59075b964b07152d234b70', 3, 1),
(9, 'carlos morales gonzales', 'morales@hotmail.com', 'carlos', '202cb962ac59075b964b07152d234b70', 3, 1),
(10, 'vicente gonzales calvo', 'vicente@hotmail.com', 'vicen', '123', 3, 1),
(11, 'maria vergara', 'mariav@hotmail.com', 'marian', '123', 3, 1),
(12, 'marina vergara', 'marina@hotmail.com', 'marina', '123', 3, 1),
(13, 'ginox alcantara', 'ginox@hotmail.com', 'ginox', '123', 3, 1),
(14, 'jeison torres', 'jeison@hotmail.com', 'jeison', '123', 3, 1),
(15, 'yatsuri yamile', 'yatsuri@hotmail.com', 'yatsuri', '123', 2, 1),
(16, 'michel jordan', 'michel@hotmail.com', 'michel', '123', 2, 1),
(17, 'rosendo alvarez', 'rosendo@hotmail.com', 'rosendo', '123', 3, 1),
(18, 'margarito nieves', 'margarito@hotmail.com', 'margarito', '123', 2, 1),
(19, 'dixon bello', 'dixon@hotmail.com', 'dixon', '202cb962ac59075b964b07152d234b70', 2, 1),
(20, 'rafael urdaneta', 'rafael@hotmail.com', 'rafael', '202cb962ac59075b964b07152d234b70', 3, 1),
(21, 'josefa matias', 'matias@hotmail.com', 'matia', '202cb962ac59075b964b07152d234b70', 3, 1),
(23, 'maria romero', 'maria-romero-1@hotmail.com', 'maria', '202cb962ac59075b964b07152d234b70', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indexes for table `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nofactura` (`nofactura`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indexes for table `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codcliente` (`codcliente`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`),
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`);

--
-- Constraints for table `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE;

--
-- Constraints for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
