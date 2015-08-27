--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = lexique, pg_catalog;

--
-- Data for Name: t_thesaurus; Type: TABLE DATA; Schema: lexique; Owner: -
--

COPY t_thesaurus (id, id_type, code, libelle, description, fk_parent, hierarchie) FROM stdin;
1	1	age	age	\N	0	001
2	2	sexe	sexe	\N	0	002
3	3	effectif	effectif	\N	0	003
4	4	mode_obs	modes d'observation	\N	0	004
5	5	activite	activite	activité des colonies ou individus observés	0	005
7	7	type_site	type de site	\N	0	007
8	1	Juvénile	Juvénile	\N	1	001.002
9	1	Adulte	Adulte	\N	1	001.001
10	1	Indéterminé	Indéterminé	\N	1	001.003
11	2	Femelle	Femelle	\N	2	002.002
12	2	Indéterminé	Indéterminé	\N	2	002.003
13	2	Male	Male	\N	2	002.001
14	3	0-10	0-10	\N	3	003.001
15	3	100-1000	100-1000	\N	3	003.003
16	3	>1000	>1000	\N	3	003.004
17	3	10-100	10-100	\N	3	003.002
18	4	OG	Observé en Gîte	\N	4	004.004
19	4	CG	Capture en Gîte	\N	4	004.006
20	4	CE	Capture en Extérieur	\N	4	004.005
21	4	EE	Entendu en Extérieur	\N	4	004.001
22	4	OE	Observé en Extérieur	\N	4	004.003
23	4	EG	Entendu en Gîte	\N	4	004.002
25	5	T	Transit	\N	5	005.003
26	5	R	Reproduction	\N	5	005.001
27	5	H	Hivernage	\N	5	005.002
28	5	C	Chasse	\N	5	005.004
29	5	D	Déplacement	\N	5	005.005
34	7	Hors gîte	Hors gîte	\N	7	007.006
35	7	Gîte -> Rocher	Gîte -> Rocher	\N	7	007.005
36	7	Gîte -> Bâti	Gîte -> Bâti	\N	7	007.003
37	7	Indéterminé	Indéterminé	\N	7	007.007
38	7	Gîte -> Arbre	Gîte -> Arbre	\N	7	007.004
39	7	Gîte -> Mine	Gîte -> Mine	\N	7	007.002
40	7	Gîte -> Grotte	Gîte -> Grotte	\N	7	007.001
32	6	R1	Reproduction probable	\N	6	006.002
30	6	R2	Reproduction certaine	\N	6	006.003
33	6	0	Pas de reproduction	\N	6	006.001
24	5	Cad	Cadavre	\N	4	005.006
41	8	Type_site_obs	Typologie site observation	\N	0	008
42	8	Grotte	Grotte	\N	41	008.001
43	8	Mine	Mine	\N	41	008.002
44	8	Bati	Bati	\N	41	008.003
45	8	Arbre	Arbre	\N	41	008.004
46	8	Linéaire forestier	Linéaire forestier	\N	41	008.005
47	8	Linéaire relief	Linéaire relief	\N	41	008.006
48	8	Point d'eau	Point d'eau	\N	41	008.007
49	8	Rivière	Rivière	\N	41	008.008
50	8	Village	Village	\N	41	008.009
51	8	Forêt	Forêt	\N	41	008.0010
52	8	Autre	Autre	\N	41	008.0011
53	9	Statut validation	Statut de validation	\N	0	009
54	9	Validé	Validé	\N	53	009.001
56	9	Non valide	Non valide	\N	53	009.003
6	6	preuve_repro	preuve repro	preuves de reproduction	0	006
55	9	A valider	A valider	\N	53	009.002
59	10	nulle	Nulle (pas de pénétrations enthropiques)	\N	10	010.001
60	10	faible	Faible (site peu accessible, peu connu)	\N	10	010.002
61	10	moyenne	Moyenne (accessibilité à pied, proximité PR)	\N	10	010.003
58	10	fréquentation	fréquentation	\N	0	010
63	11	menaces	menaces	\N	0	011
64	11	aucune	Aucune	\N	11	011.001
65	11	destruction	Destruction/Dérangement direct (visite des sites)	\N	11	011.002
66	11	dégradation	Dégradation (Réfection des sites accueillant des individus)	\N	11	011.003
68	11	modification	Modifications du milieu (coupes de bois, défrichement, mise en culture)	\N	11	011.005
67	11	traitement	Traitements chimiques proches	\N	11	011.004
62	10	forte	Importante (accès facile, proximité GR, bâti remarquable souvent visité)	\N	10	010.004
\.


--
-- Name: t_thesaurus_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: -
--

SELECT pg_catalog.setval('t_thesaurus_id_seq', 68, true);


--
-- PostgreSQL database dump complete
--

