--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.9
-- Dumped by pg_dump version 9.3.11
-- Started on 2016-03-02 16:03:45 CET

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = lexique, pg_catalog;

INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (79, 100, 'ST', 'Situation', NULL, 0, '100');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (80, 100, 'EV', 'En village', NULL, 79, '100.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (81, 100, 'EC', 'En écart', NULL, 79, '100.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (82, 100, 'IS', 'Isolé', NULL, 79, '100.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (84, 101, 'EC', 'Elements communs', NULL, 83, '101.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (85, 101, 'FI', 'Ferme isolée', NULL, 84, '101.001.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (86, 101, 'CAZ', 'Cazelle ou capitelle', NULL, 84, '101.001.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (87, 101, 'JAS', 'Jasse ou bergerie', NULL, 84, '101.001.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (88, 101, 'ABR', 'Aire à battre', NULL, 84, '101.001.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (89, 101, 'FOUR', 'Four', NULL, 84, '101.001.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (90, 101, 'MOU', 'Moulin : à vent ou à eau', NULL, 84, '101.001.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (96, 101, 'CH', 'Chapelle', 'Liée à l''agropastoralisme', 93, '101.002.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (91, 101, 'CLE', 'Clède', NULL, 84, '101.001.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (92, 101, 'CROI', 'Croix', 'Liée à l''agropastoralisme', 84, '101.001.008');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (93, 101, 'ES', 'Element spécifiques', NULL, 83, '101.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (94, 101, 'PM', 'Pont moutonnier', 'Pont situés sur le passage d''une draille', 93, '101.002.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (95, 101, 'BD', 'Borne de délimitation ou montjoies gravés', NULL, 93, '101.002.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (97, 101, 'FL', 'Filature de laine', NULL, 93, '101.002.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (98, 101, 'CF', 'Cave à fromage', NULL, 93, '101.002.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (99, 101, 'TC', 'Toit citerne', NULL, 93, '101.002.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (100, 101, 'FL', 'Fosse à loup', NULL, 93, '101.002.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (101, 101, 'CT', 'Clocher de tourmente', NULL, 93, '101.002.008');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (102, 101, 'ZONE', 'Zones', NULL, 83, '101.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (103, 101, 'HAM', 'Hameau', NULL, 103, '101.003.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (104, 101, 'CLA', 'Clapas', NULL, 103, '101.003.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (107, 102, 'S', 'Sud', NULL, 105, '102.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (108, 102, 'E', 'Est', NULL, 105, '102.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (109, 102, 'O', 'Ouest', NULL, 105, '102.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (105, 102, 'ORIENTATION', 'Orientation', NULL, 0, '102');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (106, 102, 'N', 'Nord', NULL, 105, '102.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (83, 101, 'DENOMINATION', 'Dénomination', NULL, 0, '101');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (115, 104, 'TYPE_ROCHE', 'Type de roche', NULL, 0, '104');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (110, 103, 'VISIBILITE', 'Visibilité', NULL, 0, '103');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (111, 103, 'IV', 'Intégralement visible (intérieur/extérieur)', NULL, 110, '103.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (112, 103, 'EVVI', 'Seul l''exterieur est visible, proximité immédiate', NULL, 110, '103.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (113, 103, 'EVVE', 'Seul l''exterieur est visible, vue éloinée', NULL, 110, '103.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (114, 103, 'IM', 'Impossible', NULL, 110, '103.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (116, 104, 'CALC', 'Calcaire', NULL, 115, '104.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (118, 104, 'GRA', 'Granite', NULL, 115, '104.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (117, 104, 'SCH', 'Schiste', NULL, 115, '104.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (119, 105, 'ETAT', 'Etat', NULL, 0, '105');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (126, 106, 'ACCESSIBILITE', 'Accessibilité', NULL, 0, '106');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (120, 105, 'BE', 'Bon état', NULL, 119, '105.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (128, 106, 'RNG', 'Route non goudronnée; piste', NULL, 126, '106.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (129, 106, 'SRB', 'Sentier de randonnée balisé', NULL, 126, '106.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (130, 106, 'SEN', 'Sentier', NULL, 126, '106.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (131, 106, 'AUCUN', 'Pas d''accès depuis le domaine public', NULL, 126, '106.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (132, 107, 'STATUT', 'Statut', NULL, 0, '107');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (127, 106, 'RG', 'Route goudronnée', NULL, 126, '106.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (121, 105, 'EM', 'Etat moyen', NULL, 119, '105.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (122, 105, 'ME', 'Mauvais état', NULL, 119, '105.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (123, 105, 'RE', 'Restauré', NULL, 119, '105.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (124, 105, 'REM', 'Remanié', NULL, 119, '105.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (125, 105, 'RUI', 'Ruines', NULL, 119, '105.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (133, 107, 'PR', 'Privé', NULL, 132, '107.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (134, 107, 'PUB', 'Public', NULL, 132, '107.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (135, 107, 'COM', 'Communal', NULL, 132, '107.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (137, 107, 'AUTRE', 'Autre', NULL, 132, '107.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (138, 108, 'INTERPRETATION', 'Interprétation', NULL, 0, '107');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (136, 107, 'DEP', 'Départemental', NULL, 132, '107.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (139, 108, 'SCI', 'Intéret scientifique', NULL, 138, '107.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (141, 108, 'EST', 'Intéret esthétique', NULL, 138, '107.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (142, 108, 'AUCUN', 'Pas d''intéret', NULL, 138, '107.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (140, 108, 'PEDA', 'Intéret pédagogique', NULL, 138, '107.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (143, 109, 'DATATION', 'Datation', NULL, 0, '109');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (144, 110, 'ETAT_DONNEES', 'Etat de traitement des données', NULL, 0, '110');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (145, 110, 'TR', 'Traitée', NULL, 144, '110.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (146, 110, 'EC', 'En cours', NULL, 144, '110.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (147, 110, 'AT', 'A traiter', NULL, 144, '110.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (148, 111, 'SOURCE_PB', 'Sources', NULL, 111, '111');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (149, 111, 'EICC', 'Entente Causse Cévennes', NULL, 148, '111.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (150, 111, 'PnRGC', 'PnR des Grands Causses', NULL, 148, '111.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (151, 111, 'PnC', 'Parc National des Cévennes', NULL, 148, '111.003');


--
-- TOC entry 3394 (class 0 OID 0)
-- Dependencies: 224
-- Name: t_thesaurus_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: geonatadmin
--

SELECT pg_catalog.setval('t_thesaurus_id_seq', 142, true);


--

