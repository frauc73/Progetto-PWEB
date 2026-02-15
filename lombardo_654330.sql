-- Progettazione Web
DROP DATABASE if exists lombardo_654330;
CREATE DATABASE  lombardo_654330;
USE  lombardo_654330;
-- MySQL dump 10.13  Distrib 5.7.24, for osx11.1 (x86_64)
--
-- Host: localhost    Database: lombardo_654330
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Eventi`
--

DROP TABLE IF EXISTS `Eventi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Eventi` (
  `IdPost` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStampPost` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `User` varchar(50) NOT NULL,
  `HomeTeam` varchar(50) NOT NULL,
  `GoalHT` int(1) NOT NULL,
  `AwayTeam` varchar(50) NOT NULL,
  `GoalAT` int(1) NOT NULL,
  `NomeStadio` varchar(50) NOT NULL,
  `DataMatch` date NOT NULL,
  `PathFotoRicordo` varchar(50) DEFAULT NULL,
  `DescrizionePost` text NOT NULL,
  PRIMARY KEY (`IdPost`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Eventi`
--

LOCK TABLES `Eventi` WRITE;
/*!40000 ALTER TABLE `Eventi` DISABLE KEYS */;
INSERT INTO `Eventi` VALUES (3,'2026-01-13 10:32:33','FraUC73','Inter Milan',2,'SSC Napoli',2,'San Siro','2026-01-11','src/posts/post_69661f41d21cb.jpg','Flower of Naples!'),(5,'2026-01-21 23:10:04','alethesir','AS Roma',1,'Hellas Verona',3,'Stadio Olimpico','2024-03-09','src/posts/post_69715ccc64f4f.jpg','Partita ottima per il divertimento, meno per il risultato. Un complimento speciale a Dybala, 8 milioni a stagione, praticamente 1 milione a partita. Io mi spacco la schiena in fabbrica 8 ore e sti pupazzi stanno sempre a terra. Ultima partita della Roma che vedrò in vita mia!'),(6,'2026-01-22 10:16:23','FraUC73','West Ham United',2,'AFC Bournemouth',2,'London Stadium','2025-04-05','src/posts/post_6971f8f716e75.jpeg','Esperienza unica! Ho trascorso una giornata indimenticabile con una persona speciale. West Ham are massive, everywhere we go!'),(7,'2026-01-23 22:29:44','Gameover','AC Milan',0,'Juventus FC',1,'San Siro','2016-05-21',NULL,'Partita alquanto deludente, ma bellissima esperienza.'),(11,'2026-02-12 17:37:28','AntonioP','Pisa Sporting Club',0,'Atalanta BC',3,'Arena Garibaldi – Stadio Romeo Anconetani','2026-02-08',NULL,'ciaone'),(14,'2026-02-13 17:40:54','FraUC73','SSC Napoli',3,'Juventus FC',3,'Stadio Diego Armando Maradona','2011-11-29','src/posts/post_698f61c53bea2.jpg','La mia prima partita allo stadio?'),(15,'2026-02-14 16:27:55','Tita64','Como 1907',1,'AC Milan',2,'Stadio Giuseppe Sinigaglia','2026-02-07',NULL,'Prova inserimento evento'),(16,'2026-02-14 16:32:33','Tita64','Como 1907',1,'ACF Fiorentina',2,'Stadio Giuseppe Sinigaglia','2026-02-14',NULL,'Prova input'),(17,'2026-02-14 17:58:18','Prattikiller','ACF Fiorentina',2,'AC Milan',1,'Stadio Artemio Franchi','2023-03-04',NULL,'Partita da parte della Viola bella ed emozionante, dovuto anche alla ricorrenza della perdita del nostro grande capitano Francesco, abbiamo vinto anche per te !!');
/*!40000 ALTER TABLE `Eventi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Following`
--

DROP TABLE IF EXISTS `Following`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Following` (
  `User` varchar(50) NOT NULL,
  `Followed` varchar(50) NOT NULL,
  PRIMARY KEY (`User`,`Followed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Following`
--

LOCK TABLES `Following` WRITE;
/*!40000 ALTER TABLE `Following` DISABLE KEYS */;
INSERT INTO `Following` VALUES ('alethesir','Gameover'),('AntonioP','FraUC73'),('FraUC73','alethesir'),('FraUC73','AntonioP'),('FraUC73','Gameover'),('FraUC73','MR_26'),('FraUC73','nivea03'),('FraUC73','Prattikiller'),('Gameover','alethesir'),('Gameover','FraUC73'),('MR_26','FraUC73'),('MR_26','Gameover'),('nivea03','FraUC73'),('nivea03','Gameover'),('Prattikiller','FraUC73'),('Prattikiller','Gameover');
/*!40000 ALTER TABLE `Following` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Notifiche`
--

DROP TABLE IF EXISTS `Notifiche`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Notifiche` (
  `IdNotifica` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStampNotifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Mittente` varchar(16) NOT NULL,
  `Destinatario` varchar(16) NOT NULL,
  `TipoNotifica` varchar(50) NOT NULL,
  PRIMARY KEY (`IdNotifica`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Notifiche`
--

LOCK TABLES `Notifiche` WRITE;
/*!40000 ALTER TABLE `Notifiche` DISABLE KEYS */;
INSERT INTO `Notifiche` VALUES (15,'2026-02-14 18:00:35','Prattikiller','Gameover','follow'),(17,'2026-02-14 18:14:42','FraUC73','Prattikiller','follow'),(18,'2026-02-14 23:25:28','alethesir','Gameover','follow');
/*!40000 ALTER TABLE `Notifiche` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recensioni`
--

DROP TABLE IF EXISTS `Recensioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recensioni` (
  `IdRecensione` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStampPost` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Username` varchar(50) NOT NULL,
  `Stadio` varchar(50) NOT NULL,
  `Settore` varchar(50) NOT NULL,
  `DataRecensione` date NOT NULL,
  `VotoVisibilita` tinyint(1) NOT NULL,
  `Copertura` enum('Si','No','Parzialmente','') NOT NULL,
  `VotoDistanzaCampo` tinyint(1) NOT NULL,
  `VotoAccessibilita` tinyint(1) NOT NULL,
  `VotoParcheggio` tinyint(1) DEFAULT NULL,
  `VotoGestioneIngressi` tinyint(1) NOT NULL,
  `VotoServiziIgenici` tinyint(1) DEFAULT NULL,
  `VotoRistorazione` tinyint(1) DEFAULT NULL,
  `Descrizione` text DEFAULT NULL,
  PRIMARY KEY (`IdRecensione`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recensioni`
--

LOCK TABLES `Recensioni` WRITE;
/*!40000 ALTER TABLE `Recensioni` DISABLE KEYS */;
INSERT INTO `Recensioni` VALUES (1,'2026-01-14 16:41:51','FraUC73','Arena Garibaldi – Stadio Romeo Anconetani','Settore Opsiti','2024-10-31',3,'No',3,5,NULL,3,1,2,NULL),(3,'2026-01-21 23:13:18','alethesir','Allianz Stadium','Tribuna','2016-01-06',5,'Si',2,2,4,5,NULL,4,NULL),(4,'2026-01-23 22:32:21','Gameover','Stadio Olimpico','Curva','2016-05-21',4,'Parzialmente',3,4,3,2,1,2,NULL),(5,'2026-02-05 18:50:53','nivea03','Allianz Stadium','Tribuna','2025-06-20',5,'Si',3,3,5,5,1,5,NULL),(6,'2026-02-07 10:35:20','FraUC73','Allianz Stadium','Settore Ospiti','2023-04-23',5,'Parzialmente',4,3,NULL,1,4,2,NULL),(7,'2026-02-10 19:09:50','AntonioP','Stadio Arechi','Settore Ospiti','2026-02-07',4,'No',4,2,4,4,3,2,NULL),(8,'2026-02-12 17:18:18','FraUC73','Stamford Bridge','Distinti','2025-04-05',5,'Si',5,5,NULL,5,5,3,NULL),(9,'2026-02-12 17:20:52','FraUC73','Parc des Princes','Curva','2026-02-11',4,'Parzialmente',3,4,5,5,3,1,NULL),(10,'2026-02-12 17:22:03','FraUC73','Camp Nou','Settore Ospiti','2026-02-08',1,'No',1,4,NULL,4,3,4,NULL),(11,'2026-02-12 17:26:31','FraUC73','Stadio Nicola Ceravolo','Curva','2019-03-24',3,'No',3,3,2,4,2,4,'Atmosfera incredibile, la CMC è una delle 7 meraviglie del Mondo moderno.'),(13,'2026-02-14 23:05:18','FraUC73','Stadio Diego Armando Maradona','Distinti','2025-11-09',3,'Parzialmente',2,3,3,3,NULL,4,'Stadio passionale, atmosfera unica!');
/*!40000 ALTER TABLE `Recensioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Cognome` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PathFotoProfilo` varchar(50) DEFAULT NULL,
  `NomeSquadraSupportata` varchar(50) DEFAULT NULL,
  `DescrizioneProfilo` text DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'FraUC73','$2y$10$qe6X.r6zqJcD/AMLoHy8n.I/lpYBwik66qiD6c/kHDI2M8Mvb8jYm','Francesco','Lombardo','flombardo515@gmail.com','../src/profile_pic/profile_pic_6973f0dd5d276.jpeg','SSC Napoli','Sono il creatore del sito!'),(2,'Anto081','$2y$10$pLXSH7XKc0V4zuCloSmsz.OMD6j99ogD0PLn9k6XtGPkpDjAiofO6','Antonio','Lombardo','alombardo595@gmail.com',NULL,NULL,NULL),(3,'alethesir','$2y$10$l4rEFHLZoBoR1k6MugsRWOu08zygQoWlow3dYf23skvtApO4nauja','Alessandro','Placanica','alexplacanica@gmail.com','../src/profile_pic/profile_pic_699104738f3e7.jpeg','Juventus FC',NULL),(4,'Gameover','$2y$10$zwGtD8PJ2fC0M10ZtIDeE.9V0RizVFg/03Kxkmj7hzJW0iDUNqh.2','Donato','Amelio','donatoameliodonato@gmail.com','../src/profile_pic/profile_pic_699103f1beb36.jpeg','AC Milan','Forza Milan sempre.'),(5,'nivea03','$2y$10$aX/xnpnMWkAJ2dDQUI//3erLU/jHSIPY5Ma0LHl23h8h.aCmdfrLe','Antonia','Doria','antoniadoria2003@gmail.com','../src/profile_pic/profile_pic_6984e547bf5ba.jpeg','Juventus FC','profilo brillante di trivi a'),(6,'MR_26','$2y$10$Yok4avKglr8j04/80m55oeacbT6CDyHFj2I1d13FbNZ0GbCz2Dfc6','Mario','Rossi','mariorossi26@gmail.com','../src/profile_pic/default.png','Genoa CFC',NULL),(7,'AntonioP','$2y$10$rtLKe1fnfFZYN2SAUl3N/OXfBXFPbDvQ9IyLLra.2O9YUiT0EOPDa','Antonio','Pepe','anthonypepe2004@gmail.com','../src/profile_pic/profile_pic_699104105e92d.jpeg','SSC Napoli',NULL),(8,'Tita64','$2y$10$md7DVAiQSoBBGeKRPwCxous7H.yzNTrp/oCbWaD4TaXWS8I9UesFS','Concetta','Mantella','emailprova@gmail.com','../src/profile_pic/default.png',NULL,NULL),(9,'Prattikiller','$2y$10$Gi2paEO/NDQS3FjsF3J7UexXl4K0r9AgwCf1OLZeBTvrTpm9BN2d.','Vincenzo','Prattichizzo','vincpratt@gmail.com','../src/profile_pic/profile_pic_699105956a893.jpeg','ACF Fiorentina','Forza Viola sempre!!!');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dati_squadre`
--

DROP TABLE IF EXISTS `dati_squadre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dati_squadre` (
  `Nome` varchar(24) NOT NULL,
  `Campionato` varchar(15) DEFAULT NULL,
  `Paese` varchar(12) DEFAULT NULL,
  `NomeStadio` varchar(50) DEFAULT NULL,
  `CompetizioneEuropea` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dati_squadre`
--

LOCK TABLES `dati_squadre` WRITE;
/*!40000 ALTER TABLE `dati_squadre` DISABLE KEYS */;
INSERT INTO `dati_squadre` VALUES ('1.FC Heidenheim 1846','Bundesliga','Germania','Voith-Arena',' NULL'),('1.FC Köln','Bundesliga','Germania','RheinEnergieStadion',' NULL'),('1.FC Union Berlin','Bundesliga','Germania','Stadion An der Alten Forsterei',' NULL'),('1.FSV Mainz 05','Bundesliga','Germania','MEWA Arena',' NULL'),('AC Milan','Serie A','Italia','San Siro',' NULL'),('ACF Fiorentina','Serie A','Italia','Stadio Artemio Franchi',' NULL'),('AFC Bournemouth','Premier League','Inghilterra','Dean Court',' NULL'),('AJ Auxerre','Ligue 1','Francia','Stade Abbé-Deschamps',NULL),('Angers SCO','Ligue 1','Francia','Stade Jean Bouin',' NULL'),('Arsenal FC','Premier League','Inghilterra','Emirates Stadium',' NULL'),('AS Monaco','Ligue 1','Francia','Stade Louis-II',NULL),('AS Roma','Serie A','Italia','Stadio Olimpico',' NULL'),('Aston Villa','Premier League','Inghilterra','Villa Park',' NULL'),('Atalanta BC','Serie A','Italia','Stadio di Bergamo',' NULL'),('Athletic Bilbao','LaLiga','Spagna','Estadio San Mamés',' NULL'),('Atlético de Madrid','LaLiga','Spagna','Estadio Wanda Metropolitano',' NULL'),('Bayer 04 Leverkusen','Bundesliga','Germania','BayArena',' NULL'),('Bayern Munich','Bundesliga','Germania','Allianz Arena',' NULL'),('Bologna FC 1909','Serie A','Italia','Stadio Renato Dall\'Ara',' NULL'),('Borussia Dortmund','Bundesliga','Germania','Signal Iduna Park',' NULL'),('Borussia Mönchengladbach','Bundesliga','Germania','Borussia-Park',' NULL'),('Brentford FC','Premier League','Inghilterra','Brentford Community Stadium',' NULL'),('Brighton & Hove Albion','Premier League','Inghilterra','Amex Stadium',' NULL'),('Burnley FC','Premier League','Inghilterra','Turf Moor',NULL),('CA Osasuna','LaLiga','Spagna','Estadio El Sadar',' NULL'),('Cagliari Calcio','Serie A','Italia','Unipol Domus',' NULL'),('Celta de Vigo','LaLiga','Spagna','Estadio de Balaídos',' NULL'),('Chelsea FC','Premier League','Inghilterra','Stamford Bridge',' NULL'),('Como 1907','Serie A','Italia','Stadio Giuseppe Sinigaglia',' NULL'),('Crystal Palace','Premier League','Inghilterra','Selhurst Park',' NULL'),('Deportivo Alavés','LaLiga','Spagna','Estadio de Mendizorroza',' NULL'),('Eintracht Frankfurt','Bundesliga','Germania','Deutsche Bank Park',' NULL'),('Elche CF','LaLiga','Spagna','Estadio Martínez Valero',' NULL'),('Everton FC','Premier League','Inghilterra','Goodison Park',' NULL'),('FC Augsburg','Bundesliga','Germania','WWK Arena',' NULL'),('FC Barcelona','LaLiga','Spagna','Camp Nou',' NULL'),('FC Lorient','Ligue 1','Francia','Stade Yves Allainmat',' NULL'),('FC Metz','Ligue 1','Francia','Stade Saint-Symphorien',' NULL'),('FC Nantes','Ligue 1','Francia','Stade de la Beaujoire',' NULL'),('FC St. Pauli','Bundesliga','Germania','Millerntor-Stadion',NULL),('FC Toulouse','Ligue 1','Francia','Stadium de Toulouse',' NULL'),('Fulham FC','Premier League','Inghilterra','Craven Cottage',' NULL'),('Genoa CFC','Serie A','Italia','Stadio Luigi Ferraris',' NULL'),('Getafe CF','LaLiga','Spagna','Coliseum Alfonso Pérez',' NULL'),('Girona FC','LaLiga','Spagna','Estadi Montilivi',' NULL'),('Hamburger SV','Bundesliga','Germania','Volksparkstadion',NULL),('Hellas Verona','Serie A','Italia','Stadio Marcantonio Bentegodi',' NULL'),('Inter Milan','Serie A','Italia','San Siro',' NULL'),('Juventus FC','Serie A','Italia','Allianz Stadium',' NULL'),('Le Havre AC','Ligue 1','Francia','Stade Océane',NULL),('Leeds United','Premier League','Inghilterra','Elland Road',NULL),('Levante UD','LaLiga','Spagna','Estadio Ciudad de Valencia',' NULL'),('Liverpool FC','Premier League','Inghilterra','Anfield',' NULL'),('LOSC Lille','Ligue 1','Francia','Stade Pierre-Mauroy',NULL),('Manchester City','Premier League','Inghilterra','Etihad Stadium',' NULL'),('Manchester United','Premier League','Inghilterra','Old Trafford',' NULL'),('Newcastle United','Premier League','Inghilterra','St James’ Park',' NULL'),('Nottingham Forest','Premier League','Inghilterra','The City Ground',' NULL'),('OGC Nice','Ligue 1','Francia','Allianz Riviera',' NULL'),('Olympique Lyon','Ligue 1','Francia','Parc Olympique Lyonnais',' NULL'),('Olympique Marseille','Ligue 1','Francia','Stade Vélodrome',' NULL'),('Paris FC','Ligue 1','Francia','Stade Sébastien-Charléty',' NULL'),('Paris Saint-Germain','Ligue 1','Francia','Parc des Princes',' NULL'),('Parma Calcio 1913','Serie A','Italia','Stadio Ennio Tardini',' NULL'),('Pisa Sporting Club','Serie A','Italia','Arena Garibaldi – Stadio Romeo Anconetani',' NULL'),('Rayo Vallecano','LaLiga','Spagna','Estadio de Vallecas',' NULL'),('RB Leipzig','Bundesliga','Germania','Red Bull Arena',' NULL'),('RC Lens','Ligue 1','Francia','Stade Bollaert-Delelis',' NULL'),('RC Strasbourg Alsace','Ligue 1','Francia','Stade de la Meinau',' NULL'),('RCD Espanyol Barcelona','LaLiga','Spagna','RCD Espanyol Stadium',' NULL'),('RCD Mallorca','LaLiga','Spagna','Estadi de Son Moix',' NULL'),('Real Betis Balompié','LaLiga','Spagna','Estadio Benito Villamarín',' NULL'),('Real Madrid','LaLiga','Spagna','Estadio Santiago Bernabéu',' NULL'),('Real Oviedo','LaLiga','Spagna','Estadio Carlos Tartiere',NULL),('Real Sociedad','LaLiga','Spagna','Reale Arena',' NULL'),('SC Freiburg','Bundesliga','Germania','Europa-Park Stadion',' NULL'),('Sevilla FC','LaLiga','Spagna','Estadio Ramón Sánchez Pizjuán',' NULL'),('SS Lazio','Serie A','Italia','Stadio Olimpico',' NULL'),('SSC Napoli','Serie A','Italia','Stadio Diego Armando Maradona',' NULL'),('Stade Brestois 29','Ligue 1','Francia','Stade Francis-Le Blé',NULL),('Stade Rennais FC','Ligue 1','Francia','Stade de la Route de Lorient',' NULL'),('Sunderland AFC','Premier League','Inghilterra','Stadium of Light',NULL),('SV Werder Bremen','Bundesliga','Germania','Weserstadion',' NULL'),('Torino FC','Serie A','Italia','Stadio Olimpico Grande Torino',' NULL'),('Tottenham Hotspur','Premier League','Inghilterra','Tottenham Hotspur Stadium',' NULL'),('TSG 1899 Hoffenheim','Bundesliga','Germania','PreZero Arena',' NULL'),('Udinese Calcio','Serie A','Italia','Bluenergy Stadium - Stadio Friuli',' NULL'),('US Cremonese','Serie A','Italia','Stadio Giovanni Zini',' NULL'),('US Lecce','Serie A','Italia','Stadio Via del Mare',' NULL'),('US Sassuolo','Serie A','Italia','Mapei Stadium - Città del Tricolore',' NULL'),('Valencia CF','LaLiga','Spagna','Estadio de Mestalla',' NULL'),('VfB Stuttgart','Bundesliga','Germania','Mercedes-Benz Arena',' NULL'),('VfL Wolfsburg','Bundesliga','Germania','Volkswagen Arena',' NULL'),('Villarreal CF','LaLiga','Spagna','Estadio de la Cerámica',' NULL'),('West Ham United','Premier League','Inghilterra','London Stadium',' NULL'),('Wolverhampton Wanderers','Premier League','Inghilterra','Molineux Stadium',' NULL');
/*!40000 ALTER TABLE `dati_squadre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datistadi2025`
--

DROP TABLE IF EXISTS `datistadi2025`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datistadi2025` (
  `Team` varchar(27) NOT NULL,
  `City` varchar(24) DEFAULT NULL,
  `Stadium` varchar(47) DEFAULT NULL,
  `Capacity` varchar(9) DEFAULT NULL,
  `Latitude` varchar(11) DEFAULT NULL,
  `Longitude` varchar(11) DEFAULT NULL,
  `Country` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`Team`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datistadi2025`
--

LOCK TABLES `datistadi2025` WRITE;
/*!40000 ALTER TABLE `datistadi2025` DISABLE KEYS */;
INSERT INTO `datistadi2025` VALUES ('1. FC Kaiserslautern       ','Kaiserslautern','Fritz-Walter-Stadion','    49780',' 49.434722 ',' 7.776667  ','Germania'),('1. FC Köln                 ','Cologne','RheinEnergieStadion','    50000',' 50.933497 ',' 6.874997  ','Germania'),('1. FC Nürnberg             ','Nuremberg','Grundig-Stadion','    50000',' 49.426111 ',' 11.125833 ','Germania'),('1. FSV Mainz 05            ','Mainz','Coface Arena','    34000',' 49.984167 ',' 8.224167  ','Germania'),('A.F.C. Bournemouth         ','Bournemouth','Goldsands Stadium','    12000',' 50.735277 ',' -1.83833  ','Inghilterra'),('Aberdeen and Inverness C.T.','Aberdeen','Pittodrie Stadium','    22199',' 57.159167 ',' -2.088889 ','Scozia'),('AC Milan                   ','Milano','San Siro','    75710','           ','           ','Italia'),('Ajaccio                    ','Ajaccio','Stade François Coty','    10660',' 41.931081 ',' 8.776725  ','Francia'),('Almería                    ','Almería','Estadio del Mediterráneo','    22000',' 36.84     ',' -2.435278 ','Spagna'),('Arsenal                    ','London','Emirates Stadium','    60361',' 51.555    ',' -0.108611 ','Inghilterra'),('AS Monaco                  ','Monaco','Stade Louis II','    18500',' 43.727606 ',' 7.415614  ','Francia'),('Aston Villa                ','Birmingham','Villa Park','    42785',' 52.509167 ',' -1.884722 ','Inghilterra'),('Atalanta                   ','Bergamo','Gewiss Stadium','    24950','           ','           ','Italia'),('Athletic Bilbao            ','Bilbao','San Mamés','    53332',' 43.264284 ',' -2.950366 ','Spagna'),('Atlético Madrid            ','Madrid','Wanda Metropolitano','    70460',' 40.401719 ',' -3.720606 ','Spagna'),('Auxerre                    ','Auxerre','Stade de l\'Abbé-Deschamps','    24493',' 47.786753 ',' 3.588664  ','Francia'),('Barcelona                  ','Barcelona','Camp Nou','    99354',' 41.38087  ',' 2.122802  ','Spagna'),('Bari                       ','Bari','Stadio San Nicola','    58270','           ','           ','Italia'),('Barnsley                   ','Barnsley','Oakwell','    23009',' 53.552222 ',' -1.4675   ','Inghilterra'),('Bastia                     ','Bastia','Stade Armand Cesari','    16480',' 42.6514   ',' 9.442619  ','Francia'),('Bayer Leverkusen           ','Leverkusen','BayArena','    30210',' 51.038256 ',' 7.002206  ','Germania'),('Bayern Munich              ','Munich','Allianz Arena','    71000',' 48.218775 ',' 11.624753 ','Germania'),('Betis                      ','Seville','Benito Villamarín','    52500',' 37.356389 ',' -5.981389 ','Spagna'),('Birmingham City            ','Birmingham','St Andrew\'s Stadium','    30079',' 52.475703 ',' -1.868189 ','Inghilterra'),('Blackburn Rovers           ','Blackburn','Ewood Park','    31154',' 53.728611 ',' -2.489167 ','Inghilterra'),('Blackpool                  ','Blackpool','Bloomfield Road','    16220',' 53.804722 ',' -3.048056 ','Inghilterra'),('Bologna                    ','Bologna','Stadio Renato Dall\'Ara','    36000','           ','           ','Italia'),('Bolton Wanderers           ','Bolton','Reebok Stadium','    28100',' 53.580556 ',' -2.535556 ','Inghilterra'),('Bordeaux                   ','Bordeaux','Stade Chaban-Delmas','    34462',' 44.829167 ',' -0.597778 ','Francia'),('Borussia Dortmund          ','Dortmund','Signal Iduna Park','    80645',' 51.492569 ',' 7.451842  ','Germania'),('Borussia Mönchengladbach   ','Mönchengladbach','Borussia-Park','    54010',' 51.174583 ',' 6.385464  ','Germania'),('Bradford City              ','Bradford','Valley Parade','    25136',' 53.804222 ',' -1.759022 ','Inghilterra'),('Brentford                  ','London','Griffin Park','    12763',' 51.488183 ',' -0.302639 ','Inghilterra'),('Brescia                    ','Brescia','Stadio Mario Rigamonti','    19500','           ','           ','Italia'),('Brest                      ','Brest','Stade Francis-Le Blé','    16000',' 48.402932 ',' -4.461694 ','Francia'),('Brighton & Hove Albion     ','Brighton','American Express Community Stadium','    22374',' 50.861822 ',' -0.083278 ','Inghilterra'),('Bristol City               ','Bristol','Ashton Gate','    21497',' 51.44     ',' -2.620278 ','Inghilterra'),('Burnley                    ','Burnley','Turf Moor','    22546',' 53.789167 ',' -2.230278 ','Inghilterra'),('Bury F.C.                  ','Bury','Gigg Lane','    11840',' 53.5805055',' -2.294822 ','Inghilterra'),('Caen                       ','Caen','Stade Michel d\'Ornano','    21500',' 49.179461 ',' -0.396767 ','Francia'),('Cagliari                   ','Cagliari','Unipol Domus','    16416','           ','           ','Italia'),('Cardiff City               ','Cardiff','Cardiff City Stadium','    26828',' 51.472778 ',' -3.203056 ','Inghilterra'),('Carrarese                  ','Carrara','Stadio dei Marmi','     3520','           ','           ','Italia'),('Catanzaro                  ','Catanzaro','Stadio Nicola Ceravolo','    14650','           ','           ','Italia'),('Celta de Vigo              ','Vigo','Balaídos','    31800',' 42.211842 ',' -8.739711 ','Spagna'),('Celtic                     ','Glasgow','Celtic Park','    60832',' 55.849711 ',' -4.205589 ','Scozia'),('Cesena                     ','Cesena','Orogel Stadium-Dino Manuzzi','    20194','           ','           ','Italia'),('Charlton Athletic          ','Greenwich','The Valley','    27111',' 51.486389 ',' 0.036389  ','Inghilterra'),('Chelsea                    ','London','Stamford Bridge','    42449',' 51.481667 ',' -0.191111 ','Inghilterra'),('Cittadella                 ','Cittadella','Stadio Pier Cesare Tombolato','     7623','           ','           ','Italia'),('Colchester United          ','Colchester','Colchester Community Stadium','    10105',' 51.923394 ',' 0.897703  ','Inghilterra'),('Como                       ','Como','Stadio Giuseppe Sinigaglia','    13602','           ','           ','Italia'),('Cosenza                    ','Cosenza','Stadio San Vito-Gigi Marulla','    20987','           ','           ','Italia'),('Coventry City              ','Coventry','Ricoh Arena','    32609',' 52.448056 ',' -1.495556 ','Inghilterra'),('Cremonese                  ','Cremona','Stadio Giovanni Zini','    15191','           ','           ','Italia'),('Crewe Alexandra            ','Crewe','Alexandra Stadium','    10153',' 53.0874194',' -2.4357472','Inghilterra'),('Crystal Palace             ','London','Selhurst Park','    26309',' 51.398333 ',' -0.085556 ','Inghilterra'),('Deportivo La Coruña        ','A Coruña','Riazor','    34600',' 43.368714 ',' -8.417516 ','Spagna'),('Derby County               ','Derby','Pride Park Stadium','    33597',' 52.915    ',' -1.447222 ','Inghilterra'),('Dijon                      ','Dijon','Stade Gaston Gérard','    15998',' 47.324383 ',' 5.068342  ','Francia'),('Doncaster Rovers           ','Doncaster','Keepmoat Stadium','    15231',' 53.509722 ',' -1.113889 ','Inghilterra'),('Dundee                     ','Dundee','Dens Park','    12085',' 56.475264 ',' -2.973194 ','Scozia'),('Dundee United              ','Dundee','Tannadice Park','    14209',' 56.474703 ',' -2.968961 ','Scozia'),('Dunfermline Athletic       ','Dunfermline','East End Park','    11380',' 56.075308 ',' -3.441906 ','Scozia'),('Eintracht Braunschweig     ','Braunschweig','Eintracht-Stadion','    23325',' 52.29     ',' 10.521667 ','Germania'),('Eintracht Frankfurt        ','Frankfurt','Commerzbank-Arena','    51500',' 50.068572 ',' 8.645458  ','Germania'),('Elche                      ','Elche','Martínez Valero','    36017',' 38.266944 ',' -0.663333 ','Spagna'),('Empoli                     ','Empoli','Stadio Carlo Castellani - Computer Gross Arena','    16167','           ','           ','Italia'),('Espanyol                   ','Cornellà de Llobregat','Cornellà-El Prat','    40500',' 41.347861 ',' 2.075667  ','Spagna'),('Everton                    ','Liverpool','Hill Dickinson','    52888',' 53.438889 ',' -2.966389 ','Inghilterra'),('Évian                      ','Annecy','Parc des Sports','    15660',' 45.916497 ',' 6.118054  ','Francia'),('Falkirk                    ','Falkirk','Falkirk Stadium','     9200',' 56.005136 ',' -3.754269 ','Scozia'),('FC Augsburg                ','Augsburg','SGL arena','    30660',' 48.3225   ',' 10.882222 ','Germania'),('FC St. Pauli               ','Hamburg','Millerntor-Stadion','    24487',' 53.554444 ',' 9.967778  ','Germania'),('Fiorentina                 ','Firenze','Stadio Artemio Franchi','    43118','           ','           ','Italia'),('Fortuna Düsseldorf         ','Düsseldorf','Esprit Arena','    54600',' 51.261667 ',' 6.733056  ','Germania'),('Frosinone                  ','Frosinone','Stadio Benito Stirpe','    16227','           ','           ','Italia'),('Fulham                     ','London','Craven Cottage','    25700',' 51.475    ',' -0.221667 ','Inghilterra'),('Genoa                      ','Genoa','Stadio Luigi Ferraris','    33205','           ','           ','Italia'),('Getafe                     ','Getafe','Coliseum Alfonso Pérez','    17700',' 40.325556 ',' -3.714722 ','Spagna'),('Gillingham F.C.            ','Gillingham','Priestfield','    11582',' 51.38425  ',' 0.5607527 ','Inghilterra'),('Granada                    ','Granada','Nuevo Los Cármenes','    22524',' 37.152967 ',' -3.595736 ','Spagna'),('Grimsby Town               ','Cleethorpes','Blundell park','     9062',' 53.570225 ',' -0.046497 ','Inghilterra'),('Guingamp                   ','Guingamp','Stade du Roudourou','    18126',' 48.566285 ',' -3.164599 ','Francia'),('Hamburger SV               ','Hamburg','Imtech Arena','    57000',' 53.587158 ',' 9.898617  ','Germania'),('Hamilton Academical        ','Hamilton','New Douglas Park','     6078',' 55.782156 ',' -4.058503 ','Scozia'),('Hannover 96                ','Hanover','HDI-Arena','    49000',' 52.360067 ',' 9.731197  ','Germania'),('Heart of Midlothian        ','Edinburgh','Tynecastle Stadium','    17420',' 55.939167 ',' -3.232222 ','Scozia'),('Hellas Verona              ','Verona','Stadio Marcantonio Bentegodi','    31713','           ','           ','Italia'),('Hertha BSC                 ','Berlin','Olympiastadion','    74244',' 52.514722 ',' 13.239444 ','Germania'),('Hibernian                  ','Edinburgh','Easter Road','    20421',' 55.961667 ',' -3.165556 ','Scozia'),('Huddersfield Town A.F.C.   ','Huddersfield','The John Smith\'s Stadium','    24500',' 53.65416  ',' -1.76833  ','Inghilterra'),('Hull City                  ','Kingston upon Hull','KC Stadium','    25404',' 53.746111 ',' -0.367778 ','Inghilterra'),('Inter Milan                ','Milano','San Siro','    75710','           ','           ','Italia'),('Inverness C.T.             ','Iverness','Caledonian Stadium','     7918',' 57.494722 ',' -4.2175   ','Scozia'),('Ipswich Town               ','Ipswich','Portman Road','    30311',' 52.055061 ',' 1.144831  ','Inghilterra'),('Juve Stabia                ','Castellammare di Stabia','Stadio Romeo Menti','     7642','           ','           ','Italia'),('Juventus                   ','Torino','Allianz Stadium','    41507','           ','           ','Italia'),('Kilmarnock                 ','Kilmarnock','Rugby Park','    18128',' 55.604225 ',' -4.508122 ','Scozia'),('Lazio                      ','Roma','Stadio Olimpico','    67585','           ','           ','Italia'),('Lecce                      ','Lecce','Stadio Via del Mare','    30354','           ','           ','Italia'),('Leeds United               ','Leeds','Elland Road','    39460',' 53.777778 ',' -1.572222 ','Inghilterra'),('Leicester City             ','Leicester','King Power Stadium','    32500',' 52.620278 ',' -1.142222 ','Inghilterra'),('Levante                    ','Valencia','Ciutat de València','    25534',' 39.494722 ',' -0.364167 ','Spagna'),('Lille                      ','Villeneuve-d\'Ascq','Stade Pierre-Mauroy','    50186',' 50.611883 ',' 3.130428  ','Francia'),('Liverpool                  ','Liverpool','Anfield','    61276',' 53.430819 ',' -2.960828 ','Inghilterra'),('Livingston and Gretna      ','Livingston','Almondvale Stadium','    10122',' 55.886167 ',' -3.522872 ','Scozia'),('Lorient                    ','Lorient','Stade du Moustoir','    18890',' 47.748747 ',' -3.369367 ','Francia'),('Luton Town                 ','Luton','Kenilworth Road','    10356',' 51.884167 ',' -0.431667 ','Inghilterra'),('Lyon                       ','Lyon','Stade de Gerland','    41842',' 45.723889 ',' 4.832222  ','Francia'),('Málaga                     ','Málaga','La Rosaleda','    30044',' 36.734092 ',' -4.426422 ','Spagna'),('Mallorca                   ','Palma','Iberostar Stadium','    23142',' 39.59     ',' 2.63      ','Spagna'),('Manchester City            ','Manchester','Etihad Stadium','    47405',' 53.482989 ',' -2.200292 ','Inghilterra'),('Manchester United          ','Stretford','Old Trafford','    75811',' 53.463056 ',' -2.291389 ','Inghilterra'),('Mantova                    ','Mantua','Stadio Danilo Martelli','     6066','           ','           ','Italia'),('Marseille                  ','Marseille','Stade Velodrome','    48000',' 43.269722 ',' 5.395833  ','Francia'),('Middlesbrough              ','Middlesbrough','Riverside Stadium','    34988',' 54.578333 ',' -1.216944 ','Inghilterra'),('Millwall                   ','London','The Den','    20146',' 51.485953 ',' -0.05095  ','Inghilterra'),('Modena                     ','Modena','Stadio Alberto Braglia','    21151','           ','           ','Italia'),('Montpellier                ','Montpellier','Stade de la Mosson','    32939',' 43.622222 ',' 3.811944  ','Francia'),('Monza                      ','Monza','Stadio Brianteo','    17102','           ','           ','Italia'),('Motherwell and Gretna      ','Motherwell','Fir Park','    13742',' 55.779947 ',' -3.980078 ','Scozia'),('Nancy                      ','Tomblaine','Stade Marcel Picot','    20085',' 48.6955   ',' 6.210687  ','Francia'),('Nantes                     ','Nantes','Stade de la Beaujoire','    38285',' 47.255631 ',' -1.525375 ','Francia'),('Napoli                     ','Naples','Stadio Diego Armando Maradona','    54732','           ','           ','Italia'),('Newcastle United           ','Newcastle upon Tyne','Sports Direct Arena','    52409',' 54.975556 ',' -1.621667 ','Inghilterra'),('Nice                       ','Nice','Allianz Riviera','    35624',' 43.723328 ',' 7.258756  ','Francia'),('Norwich City               ','Norwich','Carrow Road','    27010',' 52.622128 ',' 1.308653  ','Inghilterra'),('Nottingham Forest          ','Nottingham','City Ground','    30576',' 52.94     ',' -1.132778 ','Inghilterra'),('Notts County F.C.          ','Nottingham','Meadow Lane','    20211',' 52.9425   ',' -1.137222 ','Inghilterra'),('Oldham Athletic            ','Oldham','Boundary Park','    10638',' 53.555278 ',' -2.128611 ','Inghilterra'),('Osasuna                    ','Pamplona','El Sadar','    19553',' 42.796667 ',' -1.636944 ','Spagna'),('Oxford United              ','Oxford','Kassam Stadium','    12500',' 51.716419 ',' -1.208067 ','Inghilterra'),('Palermo                    ','Palermo','Stadio Renzo Barbera','    36365','           ','           ','Italia'),('Paris Saint-Germain        ','Paris','Parc des Princes','    48712',' 48.841389 ',' 2.253056  ','Francia'),('Parma                      ','Parma','Stadio Ennio Tardini','    22352','           ','           ','Italia'),('Partick Thistle            ','Glasgow','Firhill Stadium','    10887',' 55.881556 ',' -4.269639 ','Scozia'),('Peterborough United        ','Peterborough','London Road Stadium','    15460',' 52.564697 ',' -0.240406 ','Inghilterra'),('Pisa                       ','Pisa','Arena Garibaldi – Stadio Romeo Anconetani','    14000','           ','           ','Italia'),('Plymouth Argyle            ','Plymouth','Home Park','    17150',' 50.38805  ',' -4.150833 ','Inghilterra'),('Port Vale F.C.             ','Burslem','Vale Park','    19052',' 53.049722 ',' -2.1925   ','Inghilterra'),('Portsmouth                 ','Portsmouth','Fratton Park','    20224',' 50.796389 ',' -1.063889 ','Inghilterra'),('Preston North End          ','Preston','Deepdale','    23404',' 53.77222  ',' -2.68805  ','Inghilterra'),('Queens Park Rangers        ','London','Loftus Road','    18439',' 51.509167 ',' -0.232222 ','Inghilterra'),('Racing de Santander        ','Santander','Campos de Sport de El Sardinero','    22222',' 43.476389 ',' -3.793333 ','Spagna'),('Rangers                    ','Glasgow','Ibrox Stadium','    51082',' 55.853206 ',' -4.309258 ','Scozia'),('Rayo Vallecano             ','Madrid','Campo de Vallecas','    15489',' 40.391944 ',' -3.658961 ','Spagna'),('Reading                    ','Reading','Madejski Stadium','    24224',' 51.422222 ',' -0.982778 ','Inghilterra'),('Real Madrid                ','Madrid','Santiago Bernabéu','    85454',' 40.45306  ',' -3.68835  ','Spagna'),('Real Sociedad              ','San Sebastián','Anoeta','    32076',' 43.301378 ',' -1.973617 ','Spagna'),('Reggiana                   ','Reggio Emilia','Mapei Stadium – Città del Tricolore','    21525','           ','           ','Italia'),('Reims                      ','Reims','Stade Auguste-Delaune II','    21684',' 49.246667 ',' 4.025     ','Francia'),('Rennes                     ','Rennes','Stade de la Route de Lorient','    31127',' 48.107458 ',' -1.712839 ','Francia'),('Roma                       ','Roma','Stadio Olimpico','    67585','           ','           ','Italia'),('Ross County                ','Dingvall','Victoria Park','     6310',' 57.595947 ',' -4.418914 ','Scozia'),('Rotherham United           ','Rotherham','New York Stadium','    12021',' 53.4279   ',' -1.362    ','Inghilterra'),('Saint-Étienne              ','Saint-Étienne','Stade Geoffroy-Guichard','    26747',' 45.460833 ',' 4.390278  ','Francia'),('Salernitana                ','Salerno','Stadio Arechi','    20194','           ','           ','Italia'),('Sampdoria                  ','Genoa','Stadio Luigi Ferraris','    33205','           ','           ','Italia'),('Sassuolo                   ','Sassuolo','Mapei Stadium – Città del Tricolore','    21515','           ','           ','Italia'),('SC Freiburg                ','Freiburg','MAGE SOLAR Stadion','    24000',' 47.988889 ',' 7.893056  ','Germania'),('Schalke 04                 ','Gelsenkirchen','Veltins-Arena','    61673',' 51.554503 ',' 7.067589  ','Germania'),('Scunthorpe United          ','Scunthorpe','Glanford Park','     9088',' 53.586725 ',' -0.695266 ','Inghilterra'),('Sevilla                    ','Seville','Ramón Sánchez Pizjuán','    45500',' 37.384    ',' -5.9705   ','Spagna'),('Sheffield United           ','Sheffield','Bramall Lane','    32702',' 53.370278 ',' -1.470833 ','Inghilterra'),('Sheffield Wednesday        ','Sheffield','Hillsborough','    39732',' 53.411389 ',' -1.500556 ','Inghilterra'),('Sochaux                    ','Montbéliard','Stade Auguste Bonal','    20005',' 47.512417 ',' 6.8112    ','Francia'),('Southampton                ','Southampton','St Mary\'s Stadium','    32689',' 50.905833 ',' -1.391111 ','Inghilterra'),('Southend United            ','Prittlewell','Roots Hall','    12392',' 51.549016 ',' 0.7015583 ','Inghilterra'),('Spezia                     ','La Spezia','Stadio Alberto Picco','    11968','           ','           ','Italia'),('Sporting de Gijón          ','Gijón','El Molinón','    30000',' 43.536111 ',' -5.637222 ','Spagna'),('SpVgg Greuther Fürth       ','Fürth','Trolli Arena','    18000',' 49.486944 ',' 10.999167 ','Germania'),('St. Johnstone              ','Perth','McDiarmid Park','    10673',' 56.409686 ',' -3.476928 ','Scozia'),('St. Mirren                 ','Paisley','St. Mirren Park','     8016',' 55.850556 ',' -4.443889 ','Scozia'),('Stockport County           ','Stockport','Edgeley Park','    10841',' 53.39972  ',' -2.16638  ','Inghilterra'),('Stoke City                 ','Stoke-on-Trent','Britannia Stadium','    27740',' 52.988333 ',' -2.175556 ','Inghilterra'),('Südtirol                   ','Bolzano','Stadio Druso','     5539','           ','           ','Italia'),('Sunderland                 ','Sunderland','Stadium of Light','    48707',' 54.9144   ',' -1.3882   ','Inghilterra'),('Swansea City               ','Swansea','Liberty Stadium','    20520',' 51.6422   ',' -3.9351   ','Inghilterra'),('Swindon Town               ','Swindon','County Ground','    15728',' 51.564444 ',' -1.770556 ','Inghilterra'),('Team                       ','City','Stadium',' Capacity',' Latitude  ',' Longitude ','Country'),('Torino                     ','Torino','Stadio Olimpico Grande Torino','    28177','           ','           ','Italia'),('Tottenham Hotspur          ','London','Tottenham Hotspur Stadium','    62850',' 51.603333 ',' -0.065833 ','Inghilterra'),('Toulouse                   ','Toulouse','Stadium Municipal','    35470',' 43.583056 ',' 1.434167  ','Francia'),('Tranmere Rovers            ','Birkenhead','Prenton Park','    16567',' 53.3736111',' -3.0325   ','Inghilterra'),('Troyes                     ','Troyes','Stade de l\'Aube','    21877',' 48.307561 ',' 4.098458  ','Francia'),('TSG 1899 Hoffenheim        ','Sinsheim','Rhein-Neckar Arena','    30150',' 49.239008 ',' 8.888281  ','Germania'),('Udinese                    ','Udine','Stadio Friuli','    25132','           ','           ','Italia'),('Valencia                   ','Valencia','Mestalla','    55000',' 39.474656 ',' -0.358361 ','Spagna'),('Valenciennes               ','Valenciennes','Stade du Hainaut','    25172',' 50.348131 ',' 3.533027  ','Francia'),('Valladolid                 ','Valladolid','Nuevo José Zorrilla','    26512',' 41.644444 ',' -4.761111 ','Spagna'),('Venezia                    ','Venezia','Stadio Pier Luigi Penzo','    11150','           ','           ','Italia'),('VfB Stuttgart              ','Stuttgart','Mercedes-Benz Arena','    60441',' 48.792269 ',' 9.232031  ','Germania'),('VfL Wolfsburg              ','Wolfsburg','Volkswagen Arena','    30000',' 52.431944 ',' 10.803889 ','Germania'),('Villarreal                 ','Villarreal','El Madrigal','    24890',' 39.944167 ',' -0.103611 ','Spagna'),('Walsall F.C.               ','Walsall','Banks\'s Stadium','    11300',' 52.565433 ',' -1.9907055','Inghilterra'),('Watford                    ','Watford','Vicarage Road','    23500',' 51.649836 ',' -0.401486 ','Inghilterra'),('Werder Bremen              ','Bremen','Weserstadion','    42100',' 53.066394 ',' 8.837628  ','Germania'),('West Bromwich Albion       ','West Bromwich','The Hawthorns','    27877',' 52.509167 ',' -1.963889 ','Inghilterra'),('West Ham United            ','London','London Stadium','    62500',' 51.531944 ',' 0.039444  ','Inghilterra'),('Wigan Athletic             ','Wigan','DW Stadium','    25133',' 53.547778 ',' -2.653889 ','Inghilterra'),('Wimbledon                  ','','Selhurst Park','    26255',' 51.398333 ',' -0.085556 ','Inghilterra'),('Wolverhampton Wanderers    ','Wolverhampton','Molineux Stadium','    27828',' 52.590278 ',' -2.130278 ','Inghilterra'),('Yeovil Town                ','Yeovil','Huish Park','     9565',' 50.95027  ',' -2.67488  ','Inghilterra'),('Zaragoza                   ','Zaragoza','La Romareda','    34596',' 41.636592 ',' -0.901822 ','Spagna');
/*!40000 ALTER TABLE `datistadi2025` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-15 18:35:10
