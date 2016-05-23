--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.13
-- Dumped by pg_dump version 9.2.0
-- Started on 2014-09-04 15:12:21

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = utilisateurs, pg_catalog;

--
-- TOC entry 3284 (class 0 OID 0)
-- Dependencies: 262
-- Name: t_applications_id_application_seq; Type: SEQUENCE SET; Schema: utilisateurs; Owner: geonatuser
--

SELECT pg_catalog.setval('t_applications_id_application_seq', 100, true);


--
SET search_path = utilisateurs, pg_catalog;

INSERT INTO bib_droits (id_droit, nom_droit, desc_droit) VALUES (5, 'validateur', 'Il valide bien sur');
INSERT INTO bib_droits (id_droit, nom_droit, desc_droit) VALUES (4, 'modérateur', 'Peu utilisé');
INSERT INTO bib_droits (id_droit, nom_droit, desc_droit) VALUES (0, 'aucun', 'aucun droit.');
INSERT INTO bib_droits (id_droit, nom_droit, desc_droit) VALUES (1, 'utilisateur', 'Ne peut que consulter');
INSERT INTO bib_droits (id_droit, nom_droit, desc_droit) VALUES (2, 'rédacteur', 'Il possède des droit d''écriture pour créer des enregistrements');
INSERT INTO bib_droits (id_droit, nom_droit, desc_droit) VALUES (6, 'administrateur', 'Il a tous les droits');
INSERT INTO bib_droits (id_droit, nom_droit, desc_droit) VALUES (3, 'référent', 'utilisateur ayant des droits complémentaires au rédacteur (par exemple exporter des données ou autre)');
-- 
-- TOC entry 3275 (class 0 OID 17821)
-- Dependencies: 256
-- Data for Name: bib_organismes; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 
INSERT INTO bib_organismes (nom_organisme, adresse_organisme, cp_organisme, ville_organisme, tel_organisme, fax_organisme, email_organisme, id_organisme) VALUES ('test', '', '', '', '', '', '', 99);
-- 
-- TOC entry 3276 (class 0 OID 17827)
-- Dependencies: 258
-- Data for Name: bib_unites; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 

INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Virtuel', NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('personnels partis', NULL, NULL, NULL, NULL, NULL, NULL, 2);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Stagiaires', NULL, NULL, '', '', NULL, NULL, 3);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Secretariat général', '', '', '', '', NULL, NULL, 4);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Service scientifique', '', '', '', '', NULL, NULL, 5);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Service SI', '', '', '', '', NULL, NULL, 6);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Service Communication', '', '', '', '', NULL, NULL, 7);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Conseil scientifique', '', '', '', NULL, NULL, NULL, 8);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Conseil d''administration', '', '', '', NULL, NULL, NULL, 9);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Partenaire fournisseur', NULL, NULL, NULL, NULL, NULL, NULL, 10);
INSERT INTO bib_unites (nom_unite, adresse_unite, cp_unite, ville_unite, tel_unite, fax_unite, email_unite, id_unite) VALUES ('Autres', NULL, NULL, NULL, NULL, NULL, NULL, 99);
-- 
-- TOC entry 3278 (class 0 OID 17837)
-- Dependencies: 261
-- Data for Name: t_applications; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 
INSERT INTO t_applications (id_application, nom_application, desc_application) VALUES (100, 'application chiro', '');
INSERT INTO t_applications (id_application, nom_application, desc_application) VALUES (150, 'patrimoine bati', '');

-- 
-- TOC entry 3255 (class 0 OID 17445)
-- Dependencies: 189
-- Data for Name: t_roles; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 
INSERT INTO t_roles (groupe, id_role, identifiant, nom_role, prenom_role, desc_role, pass, email, organisme, id_unite, pn, session_appli, date_insert, date_update, id_organisme, remarques) VALUES (true, 20002, NULL, 'grp_en_poste', NULL, 'Tous les agents en poste au PN', NULL, NULL, 'monpn', 99, true, NULL, NULL, NULL, NULL,'groupe test');
INSERT INTO t_roles (groupe, id_role, identifiant, nom_role, prenom_role, desc_role, pass, email, organisme, id_unite, pn, session_appli, date_insert, date_update, id_organisme, remarques) VALUES (false, 1, 'admin', 'Administrateur', 'test', NULL, '21232f297a57a5a743894a0e4a801fc3', '', 'Parc national des Ecrins', 1, true, NULL, NULL, NULL, 99,'utilisateur test à modifier');
-- 
-- TOC entry 3277 (class 0 OID 17831)
-- Dependencies: 259
-- Data for Name: cor_role_droit_application; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 
INSERT INTO cor_role_droit_application (id_role, id_droit, id_application) VALUES (1, 6, 100);
INSERT INTO cor_role_droit_application (id_role, id_droit, id_application) VALUES (1, 6, 150);
-- 
-- TOC entry 3279 (class 0 OID 17845)
-- Dependencies: 263
-- Data for Name: t_menus; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 
INSERT INTO t_menus (id_menu, nom_menu, desc_menu, id_application) VALUES (1000001, 'chiro - Observateurs', 'listes des observateurs chiro', 100);
INSERT INTO t_menus (id_menu, nom_menu, desc_menu, id_application) VALUES (1000004, 'chiro - Validateurs', 'Liste des observateurs chiro', 100);
INSERT INTO t_menus (id_menu, nom_menu, desc_menu, id_application) VALUES (1000006, 'patrimoine bati - observateurs', 'Liste des observateurs', 150);
-- 
-- 
-- TOC entry 3253 (class 0 OID 17437)
-- Dependencies: 186
-- Data for Name: cor_role_menu; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 
INSERT INTO cor_role_menu (id_role, id_menu) VALUES (1, 1000001);
INSERT INTO cor_role_menu (id_role, id_menu) VALUES (1, 1000004);
INSERT INTO cor_role_menu (id_role, id_menu) VALUES (1, 1000006);
-- 
-- TOC entry 3254 (class 0 OID 17440)
-- Dependencies: 187
-- Data for Name: cor_roles; Type: TABLE DATA; Schema: utilisateurs; Owner: geonatuser
-- 
INSERT INTO cor_roles (id_role_groupe, id_role_utilisateur) VALUES (20002, 1);

