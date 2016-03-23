--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.11
-- Dumped by pg_dump version 9.3.11
-- Started on 2016-03-11 14:10:25 CET

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = lexique, pg_catalog;


--
-- TOC entry 3426 (class 0 OID 0)
-- Dependencies: 222
-- Name: lexique_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('lexique_id_seq', 1, false);


--
-- TOC entry 3415 (class 0 OID 35969)
-- Dependencies: 211
-- Data for Name: t_thesaurus; Type: TABLE DATA; Schema: lexique; Owner: dbadmin
--

INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (1, 1, 'age', 'age', NULL, 0, '001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (2, 2, 'sexe', 'sexe', NULL, 0, '002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (3, 3, 'effectif', 'effectif', NULL, 0, '003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (4, 4, 'mode_obs', 'modes d''observation', NULL, 0, '004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (5, 5, 'activite', 'activite', 'activité des colonies ou individus observés', 0, '005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (7, 7, 'type_site', 'type de site', NULL, 0, '007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (8, 1, 'Juvénile', 'Juvénile', NULL, 1, '001.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (9, 1, 'Adulte', 'Adulte', NULL, 1, '001.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (10, 1, 'Indéterminé', 'Indéterminé', NULL, 1, '001.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (11, 2, 'Femelle', 'Femelle', NULL, 2, '002.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (12, 2, 'Indéterminé', 'Indéterminé', NULL, 2, '002.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (13, 2, 'Male', 'Male', NULL, 2, '002.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (14, 3, '0-10', '0-10', NULL, 3, '003.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (15, 3, '100-1000', '100-1000', NULL, 3, '003.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (16, 3, '>1000', '>1000', NULL, 3, '003.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (17, 3, '10-100', '10-100', NULL, 3, '003.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (18, 4, 'OG', 'Observé en Gîte', NULL, 4, '004.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (19, 4, 'CG', 'Capture en Gîte', NULL, 4, '004.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (20, 4, 'CE', 'Capture en Extérieur', NULL, 4, '004.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (21, 4, 'EE', 'Entendu en Extérieur', NULL, 4, '004.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (22, 4, 'OE', 'Observé en Extérieur', NULL, 4, '004.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (23, 4, 'EG', 'Entendu en Gîte', NULL, 4, '004.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (25, 5, 'T', 'Transit', NULL, 5, '005.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (26, 5, 'R', 'Reproduction', NULL, 5, '005.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (27, 5, 'H', 'Hivernage', NULL, 5, '005.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (28, 5, 'C', 'Chasse', NULL, 5, '005.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (29, 5, 'D', 'Déplacement', NULL, 5, '005.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (34, 7, 'Hors gîte', 'Hors gîte', NULL, 7, '007.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (35, 7, 'Gîte -> Rocher', 'Gîte -> Rocher', NULL, 7, '007.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (36, 7, 'Gîte -> Bâti', 'Gîte -> Bâti', NULL, 7, '007.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (37, 7, 'Indéterminé', 'Indéterminé', NULL, 7, '007.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (38, 7, 'Gîte -> Arbre', 'Gîte -> Arbre', NULL, 7, '007.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (39, 7, 'Gîte -> Mine', 'Gîte -> Mine', NULL, 7, '007.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (40, 7, 'Gîte -> Grotte', 'Gîte -> Grotte', NULL, 7, '007.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (32, 6, 'R1', 'Reproduction probable', NULL, 6, '006.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (30, 6, 'R2', 'Reproduction certaine', NULL, 6, '006.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (33, 6, '0', 'Pas de reproduction', NULL, 6, '006.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (24, 5, 'Cad', 'Cadavre', NULL, 4, '005.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (41, 8, 'Type_site_obs', 'Typologie site observation', NULL, 0, '008');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (42, 8, 'Grotte', 'Grotte', NULL, 41, '008.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (43, 8, 'Mine', 'Mine', NULL, 41, '008.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (44, 8, 'Bati', 'Bati', NULL, 41, '008.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (45, 8, 'Arbre', 'Arbre', NULL, 41, '008.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (46, 8, 'Linéaire forestier', 'Linéaire forestier', NULL, 41, '008.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (47, 8, 'Linéaire relief', 'Linéaire relief', NULL, 41, '008.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (48, 8, 'Point d''eau', 'Point d''eau', NULL, 41, '008.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (49, 8, 'Rivière', 'Rivière', NULL, 41, '008.008');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (50, 8, 'Village', 'Village', NULL, 41, '008.009');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (51, 8, 'Forêt', 'Forêt', NULL, 41, '008.0010');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (52, 8, 'Autre', 'Autre', NULL, 41, '008.0011');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (53, 9, 'Statut validation', 'Statut de validation', NULL, 0, '009');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (54, 9, 'Validé', 'Validé', NULL, 53, '009.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (56, 9, 'Non valide', 'Non valide', NULL, 53, '009.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (6, 6, 'preuve_repro', 'preuve repro', 'preuves de reproduction', 0, '006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (55, 9, 'A valider', 'A valider', NULL, 53, '009.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (59, 10, 'nulle', 'Nulle (pas de pénétrations enthropiques)', NULL, 10, '010.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (60, 10, 'faible', 'Faible (site peu accessible, peu connu)', NULL, 10, '010.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (61, 10, 'moyenne', 'Moyenne (accessibilité à pied, proximité PR)', NULL, 10, '010.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (58, 10, 'fréquentation', 'fréquentation', NULL, 0, '010');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (63, 11, 'menaces', 'menaces', NULL, 0, '011');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (65, 11, 'destruction', 'Destruction/Dérangement direct (visite des sites)', NULL, 11, '011.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (66, 11, 'dégradation', 'Dégradation (Réfection des sites accueillant des individus)', NULL, 11, '011.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (68, 11, 'modification', 'Modifications du milieu (coupes de bois, défrichement, mise en culture)', NULL, 11, '011.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (67, 11, 'traitement', 'Traitements chimiques proches', NULL, 11, '011.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (62, 10, 'forte', 'Importante (accès facile, proximité GR, bâti remarquable souvent visité)', NULL, 10, '010.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (69, 5, 'SG', 'Sortie de gîte', NULL, 5, '005.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (70, 4, 'DT', 'Détecteur', NULL, 4, '004.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (64, -11, 'aucune', 'Aucune', NULL, -11, '011.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (71, 12, 'Indices', 'Indices', 'Indices', 0, '012');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (72, 12, 'IG', 'Guano', '', 12, '012.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (73, 12, 'RP', 'Restes de proies', NULL, 12, '012.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (74, 12, 'CV', 'Cadavre', NULL, 12, '012.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (75, 12, 'A', 'Autres', NULL, 12, '012.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (78, 13, 'FC', 'Fermeture avec chiropière', NULL, 13, '013.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (76, 13, 'Amenagements', 'Amenagements', 'Amenagements', 0, '013');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (77, 13, 'NC', 'Nichoir', NULL, 13, '013.001');
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
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (137, 107, 'AUTRE', 'Autre', NULL, 132, '107.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (79, 100, 'SITUATION', 'Situation', NULL, 0, '100');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (144, 110, 'ETAT_DONNEES', 'Etat de traitement des données', NULL, 0, '110');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (143, 109, 'DATATION', 'Datation', NULL, 0, '109');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (138, 108, 'INTERPRETATION', 'Interprétation', NULL, 0, '108');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (139, 108, 'SCI', 'Intéret scientifique', NULL, 138, '108.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (140, 108, 'PEDA', 'Intéret pédagogique', NULL, 138, '108.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (141, 108, 'EST', 'Intéret esthétique', NULL, 138, '108.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (142, 108, 'AUCUN', 'Pas d''intéret', NULL, 138, '108.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (145, 110, 'TR', 'Traitée', NULL, 144, '110.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (146, 110, 'EC', 'En cours', NULL, 144, '110.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (147, 110, 'AT', 'A traiter', NULL, 144, '110.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (149, 111, 'EICC', 'Entente Causse Cévennes', NULL, 148, '111.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (151, 111, 'PnC', 'Parc National des Cévennes', NULL, 148, '111.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (150, 111, 'PnRGC', 'PnR des Grands Causses', NULL, 148, '111.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (152, 112, 'MURS_MATIRIAUX', 'Mur matériaux', NULL, 0, '112');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (182, 113, 'APM', 'Appareil mixte ', NULL, 181, '113.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (155, 112, 'CIM', 'Ciment amiante', NULL, 153, '112.001.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (156, 112, 'MET', 'Metal', NULL, 152, '112.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (157, 112, 'ACI', 'Acier', NULL, 156, '112.002.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (158, 112, 'ALL', 'Alluminum', NULL, 156, '112.002.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (159, 112, 'FER', 'Fer', NULL, 156, '112.002.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (160, 112, 'PIER', 'Pierre', NULL, 152, '112.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (161, 112, 'BASA', 'Basalte', NULL, 160, '112.003.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (153, 112, 'CIMENT', 'Ciment', NULL, 152, '112.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (195, 113, 'PAMET', 'Pan de métal', NULL, 181, '113.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (206, 115, NULL, 'Toit matériaux', NULL, 0, '115');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (184, 113, 'PARP', 'parpaing de béton', NULL, 183, '113.002.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (185, 113, 'BETAR', 'Béton armé', NULL, 181, '113.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (183, 113, 'BETAGG', 'Béton aggloméré', NULL, 181, '113.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (186, 113, 'MAC', 'Maçonnerie', NULL, 181, '113.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (187, 113, 'GAL', 'galet', NULL, 186, '113.004.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (188, 113, 'MOEL', 'moellon', NULL, 186, '113.004.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (189, 113, 'MOELSS', 'moellon sans chaîne en pierre de taille ', NULL, 186, '113.004.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (190, 113, 'PIERT', 'pierre de taille ', NULL, 186, '113.004.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (191, 113, 'GDAPP', 'grand appareil', NULL, 190, '113.004.004.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (192, 113, 'MOAPP', 'moyen appareil', NULL, 190, '113.004.004.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (193, 113, 'PTAPP', 'petit appareil', NULL, 190, '113.004.004.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (194, 113, 'PABOIS', 'Pan de bois', NULL, 181, '113.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (196, 114, 'REVET', 'Revetement', NULL, 0, '114');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (197, 114, 'PARM', 'Parement', NULL, 196, '114.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (198, 114, 'REVET', 'Revêtement', NULL, 196, '114.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (199, 114, 'BAD', 'Badigeon', NULL, 198, '114.002.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (200, 114, 'CAR', 'Carrelage mural', NULL, 198, '114.002.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (201, 114, 'END', 'Enduit', NULL, 198, '114.002.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (204, 114, 'ENDPART', 'Enduit partiel', NULL, 201, '114.002.003.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (203, 114, 'ENDIMIT', 'Enduit d''imitation', NULL, 201, '114.002.003.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (162, 112, 'CALC', 'calcaire', NULL, 160, '112.003.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (163, 112, 'GRA', 'granite', NULL, 160, '112.003.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (164, 112, 'GRE', 'grès', NULL, 160, '112.003.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (165, 112, 'LAV', 'lave', NULL, 160, '112.003.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (166, 112, 'QUAR', 'quartz', NULL, 160, '112.003.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (167, 112, 'SCHI', 'schiste', NULL, 160, '112.003.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (168, 112, 'TUF', 'tuf', NULL, 160, '112.003.008');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (169, 112, 'PART', 'Pierre artificielle', NULL, 152, '112.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (170, 112, 'PLA', 'Plâtre', NULL, 152, '112.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (171, 112, 'TER', 'Terre', NULL, 152, '112.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (172, 112, 'BAU', 'bauge', NULL, 171, '112.006.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (173, 112, 'BRI', 'brique', NULL, 171, '112.006.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (174, 112, 'PISE', 'pisé', NULL, 171, '112.006.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (175, 112, 'TORC', 'torchis', NULL, 171, '112.006.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (176, 112, 'VEGE', 'Végétal en gros œuvre', NULL, 152, '112.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (177, 112, 'BOIS', 'bois', NULL, 176, '112.007.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (178, 112, 'PAIL', 'paille', NULL, 176, '112.007.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (179, 112, 'VER', 'Verre', NULL, 152, '112.008');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (180, 112, 'PVER', 'pavé de verre', NULL, 179, '112.008.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (154, 112, 'BET', 'Béton', NULL, 153, '112.001.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (181, 113, 'MURS_MEO', 'Murs mise en oeuvre', NULL, 0, '113');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (202, 114, 'CREP', 'Crépi', NULL, 301, '114.002.003.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (205, 114, 'ROC', 'Rocaille', NULL, 198, '114.002.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (148, 111, 'SOURCE_PB', 'Sources', NULL, 0, '111');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (235, 116, NULL, 'Couvrement', NULL, 0, '116');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (207, 115, NULL, 'Bitume', NULL, 206, '115.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (208, 115, NULL, 'Ciment en couverture', NULL, 206, '115.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (209, 115, NULL, 'béton en couverture', NULL, 208, '115.002.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (210, 115, NULL, 'Matériau synthétique en couverture', NULL, 206, '115.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (211, 115, NULL, 'pierre artificielle', NULL, 210, '115.003.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (212, 115, NULL, 'Métal en couverture', NULL, 206, '115.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (213, 115, NULL, 'acier en couverture', NULL, 220, '115.004.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (214, 115, NULL, 'cuivre en couverture', NULL, 220, '115.004.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (215, 115, NULL, 'fer en couverture ', NULL, 220, '115.004.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (216, 115, NULL, 'tôle galvanisée', NULL, 223, '115.004.003.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (217, 115, NULL, 'tôle nervurée', NULL, 223, '115.004.003.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (218, 115, NULL, 'tôle ondulée ', NULL, 223, '115.004.003.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (219, 115, NULL, 'zinc en couverture ', NULL, 220, '115.004.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (220, 115, NULL, 'Pierre en couverture', NULL, 206, '115.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (221, 115, NULL, 'ardoise en couverture ', NULL, 220, '115.004.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (222, 115, NULL, 'calcaire en couverture ', NULL, 220, '115.004.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (223, 115, NULL, 'gneiss en couverture ', NULL, 220, '115.004.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (224, 115, NULL, 'granite en couverture ', NULL, 220, '115.004.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (225, 115, NULL, 'grès en couverture ', NULL, 220, '115.004.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (226, 115, NULL, 'schiste en couverture ', NULL, 220, '115.004.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (227, 115, NULL, 'tuf en couverture ', NULL, 220, '115.004.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (228, 115, NULL, 'Terre en couverture', NULL, 206, '115.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (229, 115, NULL, 'Végétal en couverture', NULL, 206, '115.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (230, 115, NULL, 'bardeau', NULL, 229, '115.006.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (231, 115, NULL, 'bois en couverture', NULL, 229, '115.006.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (232, 115, NULL, 'chaume', NULL, 229, '115.006.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (233, 115, NULL, 'roseau', NULL, 229, '115.006.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (234, 115, NULL, 'Verre en couverture', NULL, 206, '115.007');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (236, 116, NULL, 'Béton en couvrement', NULL, 235, '116.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (237, 116, NULL, 'Charpente apparente', NULL, 235, '116.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (238, 116, NULL, 'Fausse voûte', NULL, 235, '116.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (239, 116, NULL, 'Lambris de couvrement', NULL, 235, '116.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (240, 116, NULL, 'Roche en couvrement', NULL, 235, '116.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (241, 116, NULL, 'Voûte', NULL, 235, '116.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (242, 116, NULL, 'coupole', NULL, 241, '116.006.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (243, 116, NULL, 'cul-de-four', NULL, 241, '116.006.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (244, 116, NULL, 'Voûte à cantons', NULL, 241, '116.006.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (245, 116, NULL, 'Voûte à nervures multiples', NULL, 244, '116.006.003.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (246, 116, NULL, 'Voûte à un quartier', NULL, 244, '116.006.003.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (247, 116, NULL, 'Voûte d''arêtes', NULL, 244, '116.006.003.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (248, 116, NULL, 'Voûte d''ogives', NULL, 244, '116.006.003.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (249, 116, NULL, 'Voûte en berceau ', NULL, 241, '116.006.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (250, 116, NULL, 'Voûte en berceau brisé', NULL, 249, '116.006.004.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (251, 116, NULL, 'Voûte en berceau en anse-de-panier', NULL, 249, '116.006.004.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (252, 116, NULL, 'Voûte en berceau plein-cintre', NULL, 249, '116.006.004.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (253, 116, NULL, 'voûte en berceau segmentaire', NULL, 249, '116.006.004.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (254, 116, NULL, 'Voûte en demi-berceau ', NULL, 249, '116.006.004.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (255, 116, NULL, 'Voûte en éventails', NULL, 254, '116.006.004.005.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (256, 116, NULL, 'Voûte en pendentifs', NULL, 254, '116.006.004.005.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (257, 116, NULL, 'Voûte plate ', NULL, 254, '116.006.004.005.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (258, 117, 'DATATION_TYPE', 'Type de datation', NULL, 0, '117');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (259, 117, 'DENDRO', 'Datation par dendrochronologie', NULL, 258, '117.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (260, 117, 'SOUR', 'Daté par source', NULL, 258, '117.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (261, 117, 'TRADORAL', 'Daté par tradition orale', NULL, 258, '117.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (262, 117, 'TRAHISTO', 'Daté par travaux historiques', NULL, 258, '117.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (263, 117, 'EXACTE', 'Porte la date', NULL, 258, '117.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (266, 109, 'ANTIQUITE', 'Antiquité', NULL, 143, '109.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (265, 109, 'PROTOH', 'Protohistoire', NULL, 143, '109.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (264, 109, 'PREHIS', 'Préhistoire', NULL, 143, '109.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (267, 109, 'MOYEN_AGE', 'Moyen-Age', NULL, 143, '109.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (268, 109, 'COMTEM', 'Époque contemporaine', NULL, 143, '109.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (269, 109, 'MODERN', 'Temps modernes', NULL, 143, '109.006');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (270, 109, 'XVI', 'XVI', NULL, 269, '109.006.001');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (271, 109, 'XVII', 'XVII', NULL, 269, '109.006.002');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (272, 109, 'XVIII', 'XVIII', NULL, 269, '109.006.003');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (273, 109, 'XIX', 'XIX', NULL, 269, '109.006.004');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (274, 109, 'XX', 'XX', NULL, 269, '109.006.005');
INSERT INTO t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) VALUES (275, 109, 'XXI', 'XXI', NULL, 269, '109.006.006');


--
-- TOC entry 3428 (class 0 OID 0)
-- Dependencies: 224
-- Name: t_thesaurus_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('t_thesaurus_id_seq', 275, true);


--
-- TOC entry 3429 (class 0 OID 0)
-- Dependencies: 225
-- Name: taxonomie_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('taxonomie_id_seq', 1, false);


-- Completed on 2016-03-11 14:10:26 CET

--
-- PostgreSQL database dump complete
--
