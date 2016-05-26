--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.13
-- Dumped by pg_dump version 9.3.13
-- Started on 2016-05-26 14:22:41 CEST

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = lexique, pg_catalog;

--
-- TOC entry 3462 (class 0 OID 0)
-- Dependencies: 222
-- Name: base_application_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('base_application_id_seq', 1, false);


--
-- TOC entry 3463 (class 0 OID 0)
-- Dependencies: 223
-- Name: lexique_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('lexique_id_seq', 1, false);


--
-- TOC entry 3464 (class 0 OID 0)
-- Dependencies: 224
-- Name: observateur_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('observateur_id_seq', 1, false);


--
-- TOC entry 3450 (class 0 OID 35969)
-- Dependencies: 212
-- Data for Name: t_thesaurus; Type: TABLE DATA; Schema: lexique; Owner: dbadmin
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
65	11	destruction	Destruction/Dérangement direct (visite des sites)	\N	11	011.002
66	11	dégradation	Dégradation (Réfection des sites accueillant des individus)	\N	11	011.003
68	11	modification	Modifications du milieu (coupes de bois, défrichement, mise en culture)	\N	11	011.005
67	11	traitement	Traitements chimiques proches	\N	11	011.004
62	10	forte	Importante (accès facile, proximité GR, bâti remarquable souvent visité)	\N	10	010.004
69	5	SG	Sortie de gîte	\N	5	005.006
70	4	DT	Détecteur	\N	4	004.007
64	-11	aucune	Aucune	\N	-11	011.001
71	12	Indices	Indices	Indices	0	012
72	12	IG	Guano		12	012.001
73	12	RP	Restes de proies	\N	12	012.002
74	12	CV	Cadavre	\N	12	012.003
75	12	A	Autres	\N	12	012.004
78	13	FC	Fermeture avec chiropière	\N	13	013.002
76	13	Amenagements	Amenagements	Amenagements	0	013
77	13	NC	Nichoir	\N	13	013.001
80	100	EV	En village	\N	79	100.001
81	100	EC	En écart	\N	79	100.002
82	100	IS	Isolé	\N	79	100.003
84	101	EC	Elements communs	\N	83	101.001
88	101	ABR	Aire à battre	\N	84	101.001.004
89	101	FOUR	Four	\N	84	101.001.005
90	101	MOU	Moulin : à vent ou à eau	\N	84	101.001.006
96	101	CH	Chapelle	Liée à l'agropastoralisme	93	101.002.003
91	101	CLE	Clède	\N	84	101.001.007
92	101	CROI	Croix	Liée à l'agropastoralisme	84	101.001.008
93	101	ES	Element spécifiques	\N	83	101.002
94	101	PM	Pont moutonnier	Pont situés sur le passage d'une draille	93	101.002.001
97	101	FL	Filature de laine	\N	93	101.002.004
100	101	FL	Fosse à loup	\N	93	101.002.007
101	101	CT	Clocher de tourmente	\N	93	101.002.008
102	101	ZONE	Zones	\N	83	101.003
103	101	HAM	Hameau	\N	103	101.003.001
104	101	CLA	Clapas	\N	103	101.003.002
107	102	S	Sud	\N	105	102.002
108	102	E	Est	\N	105	102.003
109	102	O	Ouest	\N	105	102.004
105	102	ORIENTATION	Orientation	\N	0	102
106	102	N	Nord	\N	105	102.001
83	101	DENOMINATION	Dénomination	\N	0	101
115	104	TYPE_ROCHE	Type de roche	\N	0	104
87	101	JAS	Jasse	\N	84	101.001.003
86	101	CAZ	Cazelle, Capitelle, Chazelle	\N	84	101.001.002
98	101	CF	Cave à fromages	\N	93	101.002.005
85	101	FI	Ferme	\N	84	101.001.001
110	103	VISIBILITE	Visibilité	\N	0	103
111	103	IV	Intégralement visible (intérieur/extérieur)	\N	110	103.001
112	103	EVVI	Seul l'exterieur est visible, proximité immédiate	\N	110	103.002
114	103	IM	Impossible	\N	110	103.004
116	104	CALC	Calcaire	\N	115	104.001
118	104	GRA	Granite	\N	115	104.003
117	104	SCH	Schiste	\N	115	104.002
119	105	ETAT	Etat	\N	0	105
126	106	ACCESSIBILITE	Accessibilité	\N	0	106
120	105	BE	Bon état	\N	119	105.001
128	106	RNG	Route non goudronnée; piste	\N	126	106.001
129	106	SRB	Sentier de randonnée balisé	\N	126	106.003
130	106	SEN	Sentier	\N	126	106.004
131	106	AUCUN	Pas d'accès depuis le domaine public	\N	126	106.005
132	107	STATUT	Statut	\N	0	107
127	106	RG	Route goudronnée	\N	126	106.002
121	105	EM	Etat moyen	\N	119	105.002
122	105	ME	Mauvais état	\N	119	105.003
123	105	RE	Restauré	\N	119	105.004
124	105	REM	Remanié	\N	119	105.005
125	105	RUI	Ruines	\N	119	105.006
133	107	PR	Privé	\N	132	107.001
134	107	PUB	Public	\N	132	107.002
135	107	COM	Communal	\N	132	107.003
137	107	AUTRE	Autre	\N	132	107.005
136	107	DEP	Départemental	\N	132	107.004
79	100	SITUATION	Situation	\N	0	100
144	110	ETAT_DONNEES	Etat de traitement des données	\N	0	110
143	109	DATATION	Datation	\N	0	109
138	108	INTERPRETATION	Interprétation	\N	0	108
139	108	SCI	Intéret scientifique	\N	138	108.001
140	108	PEDA	Intéret pédagogique	\N	138	108.002
141	108	EST	Intéret esthétique	\N	138	108.003
142	108	AUCUN	Pas d'intéret	\N	138	108.004
145	110	TR	Traitée	\N	144	110.001
146	110	EC	En cours	\N	144	110.001
147	110	AT	A traiter	\N	144	110.001
152	112	MURS_MATIRIAUX	Mur matériaux	\N	0	112
182	113	APM	Appareil mixte 	\N	181	113.001
155	112	CIM	Ciment amiante	\N	153	112.001.002
156	112	MET	Metal	\N	152	112.002
157	112	ACI	Acier	\N	156	112.002.001
158	112	ALL	Alluminum	\N	156	112.002.002
159	112	FER	Fer	\N	156	112.002.003
160	112	PIER	Pierre	\N	152	112.003
161	112	BASA	Basalte	\N	160	112.003.001
153	112	CIMENT	Ciment	\N	152	112.001
195	113	PAMET	Pan de métal	\N	181	113.006
206	115	\N	Toit matériaux	\N	0	115
184	113	PARP	parpaing de béton	\N	183	113.002.001
185	113	BETAR	Béton armé	\N	181	113.003
183	113	BETAGG	Béton aggloméré	\N	181	113.002
186	113	MAC	Maçonnerie	\N	181	113.004
187	113	GAL	galet	\N	186	113.004.001
188	113	MOEL	moellon	\N	186	113.004.002
189	113	MOELSS	moellon sans chaîne en pierre de taille 	\N	186	113.004.003
190	113	PIERT	pierre de taille 	\N	186	113.004.004
191	113	GDAPP	grand appareil	\N	190	113.004.004.001
192	113	MOAPP	moyen appareil	\N	190	113.004.004.002
193	113	PTAPP	petit appareil	\N	190	113.004.004.003
194	113	PABOIS	Pan de bois	\N	181	113.005
196	114	REVET	Revetement	\N	0	114
197	114	PARM	Parement	\N	196	114.001
198	114	REVET	Revêtement	\N	196	114.002
199	114	BAD	Badigeon	\N	198	114.002.001
200	114	CAR	Carrelage mural	\N	198	114.002.002
201	114	END	Enduit	\N	198	114.002.003
204	114	ENDPART	Enduit partiel	\N	201	114.002.003.003
203	114	ENDIMIT	Enduit d'imitation	\N	201	114.002.003.002
162	112	CALC	calcaire	\N	160	112.003.002
163	112	GRA	granite	\N	160	112.003.003
164	112	GRE	grès	\N	160	112.003.004
165	112	LAV	lave	\N	160	112.003.005
166	112	QUAR	quartz	\N	160	112.003.006
167	112	SCHI	schiste	\N	160	112.003.007
168	112	TUF	tuf	\N	160	112.003.008
169	112	PART	Pierre artificielle	\N	152	112.004
170	112	PLA	Plâtre	\N	152	112.005
171	112	TER	Terre	\N	152	112.006
172	112	BAU	bauge	\N	171	112.006.001
173	112	BRI	brique	\N	171	112.006.002
174	112	PISE	pisé	\N	171	112.006.003
175	112	TORC	torchis	\N	171	112.006.004
176	112	VEGE	Végétal en gros œuvre	\N	152	112.007
177	112	BOIS	bois	\N	176	112.007.001
178	112	PAIL	paille	\N	176	112.007.002
179	112	VER	Verre	\N	152	112.008
180	112	PVER	pavé de verre	\N	179	112.008.001
154	112	BET	Béton	\N	153	112.001.001
181	113	MURS_MEO	Murs mise en oeuvre	\N	0	113
202	114	CREP	Crépi	\N	301	114.002.003.001
205	114	ROC	Rocaille	\N	198	114.002.004
148	111	SOURCE_PB	Sources	\N	0	111
113	103	EVVE	Seul l'exterieur est visible, vue éloignée	\N	110	103.003
149	111	EICC	EICC	Entente Causse Cévennes	148	111.001
151	111	PnC	PnC	Parc National des Cévennes	148	111.003
150	111	PnRGC	PNR GC	PnR des Grands Causses	148	111.002
235	116	\N	Couvrement	\N	0	116
207	115	\N	Bitume	\N	206	115.001
208	115	\N	Ciment en couverture	\N	206	115.002
209	115	\N	béton en couverture	\N	208	115.002.001
210	115	\N	Matériau synthétique en couverture	\N	206	115.003
211	115	\N	pierre artificielle	\N	210	115.003.001
212	115	\N	Métal en couverture	\N	206	115.004
213	115	\N	acier en couverture	\N	220	115.004.001
214	115	\N	cuivre en couverture	\N	220	115.004.002
215	115	\N	fer en couverture 	\N	220	115.004.003
216	115	\N	tôle galvanisée	\N	223	115.004.003.001
217	115	\N	tôle nervurée	\N	223	115.004.003.002
218	115	\N	tôle ondulée 	\N	223	115.004.003.003
219	115	\N	zinc en couverture 	\N	220	115.004.004
220	115	\N	Pierre en couverture	\N	206	115.004
221	115	\N	ardoise en couverture 	\N	220	115.004.001
222	115	\N	calcaire en couverture 	\N	220	115.004.002
223	115	\N	gneiss en couverture 	\N	220	115.004.003
224	115	\N	granite en couverture 	\N	220	115.004.004
225	115	\N	grès en couverture 	\N	220	115.004.005
226	115	\N	schiste en couverture 	\N	220	115.004.006
227	115	\N	tuf en couverture 	\N	220	115.004.007
228	115	\N	Terre en couverture	\N	206	115.005
229	115	\N	Végétal en couverture	\N	206	115.006
230	115	\N	bardeau	\N	229	115.006.001
231	115	\N	bois en couverture	\N	229	115.006.002
232	115	\N	chaume	\N	229	115.006.003
233	115	\N	roseau	\N	229	115.006.004
234	115	\N	Verre en couverture	\N	206	115.007
236	116	\N	Béton en couvrement	\N	235	116.001
237	116	\N	Charpente apparente	\N	235	116.002
238	116	\N	Fausse voûte	\N	235	116.003
239	116	\N	Lambris de couvrement	\N	235	116.004
240	116	\N	Roche en couvrement	\N	235	116.005
241	116	\N	Voûte	\N	235	116.006
242	116	\N	coupole	\N	241	116.006.001
243	116	\N	cul-de-four	\N	241	116.006.002
244	116	\N	Voûte à cantons	\N	241	116.006.003
245	116	\N	Voûte à nervures multiples	\N	244	116.006.003.001
246	116	\N	Voûte à un quartier	\N	244	116.006.003.002
247	116	\N	Voûte d'arêtes	\N	244	116.006.003.003
248	116	\N	Voûte d'ogives	\N	244	116.006.003.004
249	116	\N	Voûte en berceau 	\N	241	116.006.004
250	116	\N	Voûte en berceau brisé	\N	249	116.006.004.001
251	116	\N	Voûte en berceau en anse-de-panier	\N	249	116.006.004.002
252	116	\N	Voûte en berceau plein-cintre	\N	249	116.006.004.003
253	116	\N	voûte en berceau segmentaire	\N	249	116.006.004.004
254	116	\N	Voûte en demi-berceau 	\N	249	116.006.004.005
255	116	\N	Voûte en éventails	\N	254	116.006.004.005.001
256	116	\N	Voûte en pendentifs	\N	254	116.006.004.005.002
257	116	\N	Voûte plate 	\N	254	116.006.004.005.003
258	117	DATATION_TYPE	Type de datation	\N	0	117
259	117	DENDRO	Datation par dendrochronologie	\N	258	117.001
260	117	SOUR	Daté par source	\N	258	117.002
261	117	TRADORAL	Daté par tradition orale	\N	258	117.003
262	117	TRAHISTO	Daté par travaux historiques	\N	258	117.004
263	117	EXACTE	Porte la date	\N	258	117.005
290	111	FC48	FC48	Fédération de chasse de Lozère	148	111.004
266	109	ANTIQUITE	Antiquité	\N	143	109.003
265	109	PROTOH	Protohistoire	\N	143	109.002
264	109	PREHIS	Préhistoire	\N	143	109.001
267	109	MOYEN_AGE	Moyen-Age	\N	143	109.004
268	109	COMTEM	Époque contemporaine	\N	143	109.005
269	109	MODERN	Temps modernes	\N	143	109.006
270	109	XVI	XVI	\N	269	109.006.001
271	109	XVII	XVII	\N	269	109.006.002
272	109	XVIII	XVIII	\N	269	109.006.003
273	109	XIX	XIX	\N	269	109.006.004
274	109	XX	XX	\N	269	109.006.005
275	109	XXI	XXI	\N	269	109.006.006
277	101	LAV	Lavogne, Lavagne	\N	93	101.002.010
278	101	BANC	Bancels, Traversiers	\N	103	101.003.003
279	101	BEAL	Béal	\N	103	101.003.004
280	101	BOUI	Bouissière	\N	103	101.003.005
281	101	CALA	Calade	\N	103	101.003.006
282	101	PLFOI	Place de foire	\N	84	101.001.009
283	101	PUI	Puit	\N	93	101.002.011
95	101	BD	Borne de délimitation	\N	93	101.002.002
99	101	TC	Toit-citerne	\N	93	101.002.006
276	101	MONJ	Montjoie	\N	93	101.002.009
284	7	PatrimoineBati	Patrimoine bati	\N	7	007.008
285	117	OBSERVATION	Daté par observation	\N	258	117.006
286	109	XIX-1	1ere moitié du XIX	\N	273	109.006.004.001
287	109	XIX-2	2nd moitié du XIX	\N	273	109.006.004.002
288	109	XX-1	1ere moitié du XX	\N	274	109.006.005.001
289	109	XX-2	2nd moitié du XX	\N	274	109.006.005.002
\.


--
-- TOC entry 3457 (class 0 OID 101035)
-- Dependencies: 262
-- Data for Name: patrimoine_bati_synonymes; Type: TABLE DATA; Schema: lexique; Owner: dbadmin
--

COPY patrimoine_bati_synonymes (id, type, denomination_locale, denomination_nationale, fk_thesaurus) FROM stdin;
1	Elements communs	Aire à battre	Aire à battre	88
6	Elements communs	Four	Four	89
8	Elements communs	Moulin : à vent ou à eau	Moulin : à vent ou à eau	90
12	Elements spécifiques	Chapelle	Chapelle	96
3	Elements communs	Clède	Clède	91
4	Elements communs	Croix	Croix	92
18	Elements spécifiques	Pont moutonnier	Pont	94
14	Elements spécifiques	Filature de laine	Filature de laine	97
15	Elements spécifiques	Fosse à loup	Piège	100
13	Elements spécifiques	Clocher de tourmente	Clocher	101
26	Zones	Hameau	Hameau	103
25	Zones	Clapas	Amoncellement de pierres lié à l'épierrage	104
7	Elements communs	Jasse	Bergerie	87
2	Elements communs	Cazelle, Capitelle, Chazelle	Cabane	86
11	Elements spécifiques	Cave à fromages	Séchoir à fromage 	98
5	Elements communs	Ferme	Ferme	85
16	Elements spécifiques	Lavogne, Lavagne	Abreuvoir	277
21	Zones	Bancels, Traversiers	Terrasses agricoles	278
22	Zones	Béal	Canal	279
23	Zones	Bouissière	Alignement d'arbres	280
24	Zones	Calade	Pavage	281
9	Elements communs	Place de foire	Place de foire	282
20	Elements spécifiques	Puit	Puit	283
10	Elements spécifiques	Borne de délimitation 	Borne de délimitation	95
19	Elements spécifiques	Toit-citerne	Réservoir	99
17	Elements spécifiques	Montjoie	Borne de délimitation	276
\.


--
-- TOC entry 3465 (class 0 OID 0)
-- Dependencies: 261
-- Name: patrimoine_bati_synonymes_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('patrimoine_bati_synonymes_id_seq', 26, true);


--
-- TOC entry 3466 (class 0 OID 0)
-- Dependencies: 225
-- Name: t_thesaurus_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('t_thesaurus_id_seq', 290, true);


--
-- TOC entry 3467 (class 0 OID 0)
-- Dependencies: 226
-- Name: taxonomie_id_seq; Type: SEQUENCE SET; Schema: lexique; Owner: dbadmin
--

SELECT pg_catalog.setval('taxonomie_id_seq', 1, false);


-- Completed on 2016-05-26 14:22:42 CEST

--
-- PostgreSQL database dump complete
--

