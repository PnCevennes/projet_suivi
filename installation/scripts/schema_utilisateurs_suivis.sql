--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.6
-- Dumped by pg_dump version 9.4.6
-- Started on 2016-05-24 10:29:45 CEST

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 8 (class 2615 OID 16390)
-- Name: utilisateurs; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA utilisateurs;


--
-- TOC entry 1 (class 3079 OID 11861)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2123 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = utilisateurs, pg_catalog;

--
-- TOC entry 209 (class 1255 OID 18058)
-- Name: getusersbyapplicationid(integer); Type: FUNCTION; Schema: utilisateurs; Owner: -
--

CREATE FUNCTION getusersbyapplicationid(idapp integer) RETURNS SETOF record
    LANGUAGE sql
    AS $$
	SELECT 
		groupe,id_role,identifiant, nom_role, prenom_role, desc_role, pass, email, id_organisme, organisme,id_unite, remarques, pn, 
		session_appli, date_insert, date_update,max(id_droit) as id_droit_max,id_application
	FROM (
		SELECT 
			u.groupe, u.id_role, u.identifiant, u.nom_role, prenom_role, desc_role, pass, email, id_organisme, organisme, id_unite, remarques, pn, 
			session_appli, date_insert, date_update,c.id_droit,c.id_application
		FROM utilisateurs.t_roles u
		JOIN utilisateurs.cor_role_droit_application c ON c.id_role = u.id_role
		WHERE c.id_application = idapp  AND u.groupe = false
		UNION
		 SELECT  
			u.groupe, u.id_role, u.identifiant, u.nom_role, prenom_role, desc_role, pass, email, id_organisme, organisme, id_unite, remarques, pn, 
			session_appli, date_insert, date_update,c.id_droit,c.id_application
		FROM utilisateurs.t_roles u
		JOIN utilisateurs.cor_roles g ON g.id_role_utilisateur = u.id_role
		JOIN utilisateurs.cor_role_droit_application c ON c.id_role = g.id_role_groupe
		WHERE c.id_application = idapp AND u.groupe = false
	 )a
	 GROUP BY 
		groupe,id_role,identifiant, nom_role, prenom_role, desc_role, pass, email, id_organisme, organisme,id_unite, remarques, pn, 
		session_appli, date_insert, date_update,id_application;
$$;


--
-- TOC entry 195 (class 1255 OID 16391)
-- Name: modify_date_insert(); Type: FUNCTION; Schema: utilisateurs; Owner: -
--

CREATE FUNCTION modify_date_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.date_insert := now();
    NEW.date_update := now();
    RETURN NEW;
END;
$$;


--
-- TOC entry 208 (class 1255 OID 16392)
-- Name: modify_date_update(); Type: FUNCTION; Schema: utilisateurs; Owner: -
--

CREATE FUNCTION modify_date_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.date_update := now();
    RETURN NEW;
END;
$$;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 184 (class 1259 OID 16430)
-- Name: cor_role_droit_application; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE cor_role_droit_application (
    id_role integer NOT NULL,
    id_droit integer NOT NULL,
    id_application integer NOT NULL
);


--
-- TOC entry 175 (class 1259 OID 16396)
-- Name: cor_roles; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE cor_roles (
    id_role_groupe integer NOT NULL,
    id_role_utilisateur integer NOT NULL
);


--
-- TOC entry 176 (class 1259 OID 16399)
-- Name: t_roles_id_seq; Type: SEQUENCE; Schema: utilisateurs; Owner: -
--

CREATE SEQUENCE t_roles_id_seq
    START WITH 1000000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 177 (class 1259 OID 16401)
-- Name: t_roles; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE t_roles (
    groupe boolean DEFAULT false NOT NULL,
    id_role integer DEFAULT nextval('t_roles_id_seq'::regclass) NOT NULL,
    identifiant character varying(100),
    nom_role character varying(50),
    prenom_role character varying(50),
    desc_role text,
    pass character varying(100),
    email character varying(250),
    id_organisme integer,
    organisme character(32),
    id_unite integer,
    remarques text,
    pn boolean,
    session_appli character varying(50),
    date_insert timestamp without time zone,
    date_update timestamp without time zone
);


SET search_path = public, pg_catalog;

--
-- TOC entry 190 (class 1259 OID 16714)
-- Name: v_users_geotrek; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW v_users_geotrek AS
 SELECT a.id_role,
    a.identifiant AS username,
    a.pass AS password,
    a.email,
    a.structure,
    a.lang,
    a.nom_role AS last_name,
    a.prenom_role AS first_name,
    max(a.id_droit) AS level,
    a.id_application,
    a.id_unite
   FROM ( SELECT u.id_role,
            u.identifiant,
            u.pass,
            u.email,
            'PNC'::text AS structure,
            'fr'::text AS lang,
            u.nom_role,
            u.prenom_role,
            c.id_droit,
            c.id_application,
            u.id_unite
           FROM (utilisateurs.t_roles u
             JOIN utilisateurs.cor_role_droit_application c ON ((c.id_role = u.id_role)))
          WHERE ((c.id_application = 200) AND (u.groupe = false))
        UNION
         SELECT g.id_role_utilisateur,
            u.identifiant,
            u.pass,
            u.email,
            'PNC'::text AS structure,
            'fr'::text AS lang,
            u.nom_role,
            u.prenom_role,
            c.id_droit,
            c.id_application,
            u.id_unite
           FROM ((utilisateurs.t_roles u
             JOIN utilisateurs.cor_roles g ON ((g.id_role_utilisateur = u.id_role)))
             JOIN utilisateurs.cor_role_droit_application c ON ((c.id_role = g.id_role_groupe)))
          WHERE ((c.id_application = 200) AND (u.groupe = false))) a
  GROUP BY a.id_role, a.identifiant, a.email, a.pass, a.structure, a.lang, a.nom_role, a.prenom_role, a.id_application, a.id_unite;


SET search_path = utilisateurs, pg_catalog;

--
-- TOC entry 180 (class 1259 OID 16415)
-- Name: bib_droits; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE bib_droits (
    id_droit integer NOT NULL,
    nom_droit character varying(50),
    desc_droit text
);


--
-- TOC entry 181 (class 1259 OID 16421)
-- Name: bib_observateurs; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE bib_observateurs (
    codeobs character varying(6) NOT NULL,
    nom character varying(100),
    prenom character varying(100),
    orphelin integer
);


--
-- TOC entry 178 (class 1259 OID 16409)
-- Name: bib_organismes_id_seq; Type: SEQUENCE; Schema: utilisateurs; Owner: -
--

CREATE SEQUENCE bib_organismes_id_seq
    START WITH 1000000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 179 (class 1259 OID 16411)
-- Name: bib_organismes; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE bib_organismes (
    nom_organisme character varying(100) NOT NULL,
    adresse_organisme character varying(128),
    cp_organisme character varying(5),
    ville_organisme character varying(100),
    tel_organisme character varying(14),
    fax_organisme character varying(14),
    email_organisme character varying(100),
    id_organisme integer DEFAULT nextval('bib_organismes_id_seq'::regclass) NOT NULL
);


--
-- TOC entry 182 (class 1259 OID 16424)
-- Name: bib_unites_id_seq; Type: SEQUENCE; Schema: utilisateurs; Owner: -
--

CREATE SEQUENCE bib_unites_id_seq
    START WITH 1000000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 183 (class 1259 OID 16426)
-- Name: bib_unites; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE bib_unites (
    nom_unite character varying(50) NOT NULL,
    adresse_unite character varying(128),
    cp_unite character varying(5),
    ville_unite character varying(100),
    tel_unite character varying(14),
    fax_unite character varying(14),
    email_unite character varying(100),
    id_unite integer DEFAULT nextval('bib_unites_id_seq'::regclass) NOT NULL
);


--
-- TOC entry 174 (class 1259 OID 16393)
-- Name: cor_role_menu; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE cor_role_menu (
    id_role integer NOT NULL,
    id_menu integer NOT NULL
);


--
-- TOC entry 2124 (class 0 OID 0)
-- Dependencies: 174
-- Name: TABLE cor_role_menu; Type: COMMENT; Schema: utilisateurs; Owner: -
--

COMMENT ON TABLE cor_role_menu IS 'gestion du contenu des menus utilisateurs dans les applications';


--
-- TOC entry 185 (class 1259 OID 16433)
-- Name: t_applications; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE t_applications (
    id_application integer NOT NULL,
    nom_application character varying(50) NOT NULL,
    desc_application text
);


--
-- TOC entry 186 (class 1259 OID 16439)
-- Name: t_applications_id_application_seq; Type: SEQUENCE; Schema: utilisateurs; Owner: -
--

CREATE SEQUENCE t_applications_id_application_seq
    START WITH 1000000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2125 (class 0 OID 0)
-- Dependencies: 186
-- Name: t_applications_id_application_seq; Type: SEQUENCE OWNED BY; Schema: utilisateurs; Owner: -
--

ALTER SEQUENCE t_applications_id_application_seq OWNED BY t_applications.id_application;


--
-- TOC entry 187 (class 1259 OID 16441)
-- Name: t_menus; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE t_menus (
    id_menu integer NOT NULL,
    nom_menu character varying(50) NOT NULL,
    desc_menu text,
    id_application integer
);


--
-- TOC entry 2126 (class 0 OID 0)
-- Dependencies: 187
-- Name: TABLE t_menus; Type: COMMENT; Schema: utilisateurs; Owner: -
--

COMMENT ON TABLE t_menus IS 'table des menus déroulants des applications. Les roles de niveau groupes ou utilisateurs devant figurer dans un menu sont gérés dans la table cor_role_menu_application.';


--
-- TOC entry 188 (class 1259 OID 16447)
-- Name: t_menus_id_menu_seq; Type: SEQUENCE; Schema: utilisateurs; Owner: -
--

CREATE SEQUENCE t_menus_id_menu_seq
    START WITH 1000000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2127 (class 0 OID 0)
-- Dependencies: 188
-- Name: t_menus_id_menu_seq; Type: SEQUENCE OWNED BY; Schema: utilisateurs; Owner: -
--

ALTER SEQUENCE t_menus_id_menu_seq OWNED BY t_menus.id_menu;


--
-- TOC entry 194 (class 1259 OID 127520)
-- Name: tmp_obs_occ_personne; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE tmp_obs_occ_personne (
    id_personne integer,
    remarque character varying,
    fax character varying,
    portable character varying,
    tel_pro character varying,
    tel_perso character varying,
    pays character varying,
    ville character varying,
    code_postal character varying,
    adresse_1 character varying,
    prenom character varying,
    nom character varying,
    email character varying,
    role character varying,
    specialite character varying,
    mot_de_passe character varying,
    createur integer,
    titre character varying,
    date_maj date
);


--
-- TOC entry 189 (class 1259 OID 16683)
-- Name: tmp_pnc_personne; Type: TABLE; Schema: utilisateurs; Owner: -; Tablespace: 
--

CREATE TABLE tmp_pnc_personne (
    id integer NOT NULL,
    id_obs_occ integer,
    id_point_ecoute integer,
    id_saisie_km integer,
    id_db_pnc integer,
    prenom text,
    nom text,
    email text,
    mot_de_passe text,
    obr_parc boolean,
    saisie_flore boolean,
    saisie_eau boolean,
    code character varying(250)
);


--
-- TOC entry 191 (class 1259 OID 16719)
-- Name: v_users_geotrek; Type: VIEW; Schema: utilisateurs; Owner: -
--

CREATE VIEW v_users_geotrek AS
 SELECT a.id_role,
    ((string_to_array((a.identifiant)::text, '@'::text))[1])::character varying(100) AS username,
    a.pass AS password,
    a.email,
    a.structure,
    a.lang,
    a.nom_role AS last_name,
    a.prenom_role AS first_name,
    max(a.id_droit) AS level,
    a.id_application,
    a.id_unite
   FROM ( SELECT u.id_role,
            u.identifiant,
            u.pass,
            u.email,
            'PNC'::text AS structure,
            'fr'::text AS lang,
            u.nom_role,
            u.prenom_role,
            c.id_droit,
            c.id_application,
            u.id_unite
           FROM (t_roles u
             JOIN cor_role_droit_application c ON ((c.id_role = u.id_role)))
          WHERE ((c.id_application = 200) AND (u.groupe = false))
        UNION
         SELECT g.id_role_utilisateur,
            u.identifiant,
            u.pass,
            u.email,
            'PNC'::text AS structure,
            'fr'::text AS lang,
            u.nom_role,
            u.prenom_role,
            c.id_droit,
            c.id_application,
            u.id_unite
           FROM ((t_roles u
             JOIN cor_roles g ON ((g.id_role_utilisateur = u.id_role)))
             JOIN cor_role_droit_application c ON ((c.id_role = g.id_role_groupe)))
          WHERE ((c.id_application = 200) AND (u.groupe = false))) a
  GROUP BY a.id_role, a.identifiant, a.email, a.pass, a.structure, a.lang, a.nom_role, a.prenom_role, a.id_application, a.id_unite;


--
-- TOC entry 192 (class 1259 OID 18059)
-- Name: v_userslist_forall_applications; Type: VIEW; Schema: utilisateurs; Owner: -
--

CREATE VIEW v_userslist_forall_applications AS
 SELECT a.groupe,
    a.id_role,
    a.identifiant,
    a.nom_role,
    a.prenom_role,
    a.desc_role,
    a.pass,
    a.email,
    a.id_organisme,
    a.organisme,
    a.id_unite,
    a.remarques,
    a.pn,
    a.session_appli,
    a.date_insert,
    a.date_update,
    max(a.id_droit) AS id_droit_max,
    a.id_application
   FROM ( SELECT u.groupe,
            u.id_role,
            u.identifiant,
            u.nom_role,
            u.prenom_role,
            u.desc_role,
            u.pass,
            u.email,
            u.id_organisme,
            u.organisme,
            u.id_unite,
            u.remarques,
            u.pn,
            u.session_appli,
            u.date_insert,
            u.date_update,
            c.id_droit,
            c.id_application
           FROM (t_roles u
             JOIN cor_role_droit_application c ON ((c.id_role = u.id_role)))
          WHERE (u.groupe = false)
        UNION
         SELECT u.groupe,
            u.id_role,
            u.identifiant,
            u.nom_role,
            u.prenom_role,
            u.desc_role,
            u.pass,
            u.email,
            u.id_organisme,
            u.organisme,
            u.id_unite,
            u.remarques,
            u.pn,
            u.session_appli,
            u.date_insert,
            u.date_update,
            c.id_droit,
            c.id_application
           FROM ((t_roles u
             JOIN cor_roles g ON ((g.id_role_utilisateur = u.id_role)))
             JOIN cor_role_droit_application c ON ((c.id_role = g.id_role_groupe)))
          WHERE (u.groupe = false)) a
  GROUP BY a.groupe, a.id_role, a.identifiant, a.nom_role, a.prenom_role, a.desc_role, a.pass, a.email, a.id_organisme, a.organisme, a.id_unite, a.remarques, a.pn, a.session_appli, a.date_insert, a.date_update, a.id_application;


--
-- TOC entry 193 (class 1259 OID 117446)
-- Name: v_userslist_forall_menu; Type: VIEW; Schema: utilisateurs; Owner: -
--

CREATE VIEW v_userslist_forall_menu AS
 SELECT a.groupe,
    a.id_role,
    a.identifiant,
    a.nom_role,
    a.prenom_role,
    ((upper((a.nom_role)::text) || ' '::text) || (a.prenom_role)::text) AS nom_complet,
    a.desc_role,
    a.pass,
    a.email,
    a.id_organisme,
    a.organisme,
    a.id_unite,
    a.remarques,
    a.pn,
    a.session_appli,
    a.date_insert,
    a.date_update,
    a.id_menu
   FROM ( SELECT u.groupe,
            u.id_role,
            u.identifiant,
            u.nom_role,
            u.prenom_role,
            u.desc_role,
            u.pass,
            u.email,
            u.id_organisme,
            u.organisme,
            u.id_unite,
            u.remarques,
            u.pn,
            u.session_appli,
            u.date_insert,
            u.date_update,
            c.id_menu
           FROM (t_roles u
             JOIN cor_role_menu c ON ((c.id_role = u.id_role)))
          WHERE (u.groupe = false)
        UNION
         SELECT u.groupe,
            u.id_role,
            u.identifiant,
            u.nom_role,
            u.prenom_role,
            u.desc_role,
            u.pass,
            u.email,
            u.id_organisme,
            u.organisme,
            u.id_unite,
            u.remarques,
            u.pn,
            u.session_appli,
            u.date_insert,
            u.date_update,
            c.id_menu
           FROM ((t_roles u
             JOIN cor_roles g ON ((g.id_role_utilisateur = u.id_role)))
             JOIN cor_role_menu c ON ((c.id_role = g.id_role_groupe)))
          WHERE (u.groupe = false)) a;


--
-- TOC entry 1967 (class 2604 OID 16449)
-- Name: id_application; Type: DEFAULT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY t_applications ALTER COLUMN id_application SET DEFAULT nextval('t_applications_id_application_seq'::regclass);


--
-- TOC entry 1968 (class 2604 OID 16450)
-- Name: id_menu; Type: DEFAULT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY t_menus ALTER COLUMN id_menu SET DEFAULT nextval('t_menus_id_menu_seq'::regclass);


--
-- TOC entry 1978 (class 2606 OID 16452)
-- Name: bib_droits_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY bib_droits
    ADD CONSTRAINT bib_droits_pkey PRIMARY KEY (id_droit);


--
-- TOC entry 1980 (class 2606 OID 16454)
-- Name: bib_observateurs_pk; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY bib_observateurs
    ADD CONSTRAINT bib_observateurs_pk PRIMARY KEY (codeobs);


--
-- TOC entry 1984 (class 2606 OID 16456)
-- Name: cor_role_droit_application_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_pkey PRIMARY KEY (id_role, id_droit, id_application);


--
-- TOC entry 1970 (class 2606 OID 16458)
-- Name: cor_role_menu_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY cor_role_menu
    ADD CONSTRAINT cor_role_menu_pkey PRIMARY KEY (id_role, id_menu);


--
-- TOC entry 1972 (class 2606 OID 16460)
-- Name: cor_roles_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY cor_roles
    ADD CONSTRAINT cor_roles_pkey PRIMARY KEY (id_role_groupe, id_role_utilisateur);


--
-- TOC entry 1976 (class 2606 OID 16462)
-- Name: pk_bib_organismes; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY bib_organismes
    ADD CONSTRAINT pk_bib_organismes PRIMARY KEY (id_organisme);


--
-- TOC entry 1982 (class 2606 OID 16464)
-- Name: pk_bib_services; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY bib_unites
    ADD CONSTRAINT pk_bib_services PRIMARY KEY (id_unite);


--
-- TOC entry 1974 (class 2606 OID 16466)
-- Name: pk_roles; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY t_roles
    ADD CONSTRAINT pk_roles PRIMARY KEY (id_role);


--
-- TOC entry 1990 (class 2606 OID 129035)
-- Name: pk_tmp_pnc_personne; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tmp_pnc_personne
    ADD CONSTRAINT pk_tmp_pnc_personne PRIMARY KEY (id);


--
-- TOC entry 1986 (class 2606 OID 16468)
-- Name: t_applications_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY t_applications
    ADD CONSTRAINT t_applications_pkey PRIMARY KEY (id_application);


--
-- TOC entry 1988 (class 2606 OID 16470)
-- Name: t_menus_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: -; Tablespace: 
--

ALTER TABLE ONLY t_menus
    ADD CONSTRAINT t_menus_pkey PRIMARY KEY (id_menu);


--
-- TOC entry 2001 (class 2620 OID 16471)
-- Name: modify_date_insert_trigger; Type: TRIGGER; Schema: utilisateurs; Owner: -
--

CREATE TRIGGER modify_date_insert_trigger BEFORE INSERT ON t_roles FOR EACH ROW EXECUTE PROCEDURE modify_date_insert();


--
-- TOC entry 2002 (class 2620 OID 16472)
-- Name: modify_date_update_trigger; Type: TRIGGER; Schema: utilisateurs; Owner: -
--

CREATE TRIGGER modify_date_update_trigger BEFORE UPDATE ON t_roles FOR EACH ROW EXECUTE PROCEDURE modify_date_update();


--
-- TOC entry 1997 (class 2606 OID 16473)
-- Name: cor_role_droit_application_id_application_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_id_application_fkey FOREIGN KEY (id_application) REFERENCES t_applications(id_application) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1998 (class 2606 OID 16478)
-- Name: cor_role_droit_application_id_droit_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_id_droit_fkey FOREIGN KEY (id_droit) REFERENCES bib_droits(id_droit) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1999 (class 2606 OID 16483)
-- Name: cor_role_droit_application_id_role_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_id_role_fkey FOREIGN KEY (id_role) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1991 (class 2606 OID 16488)
-- Name: cor_role_menu_application_id_menu_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY cor_role_menu
    ADD CONSTRAINT cor_role_menu_application_id_menu_fkey FOREIGN KEY (id_menu) REFERENCES t_menus(id_menu) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1992 (class 2606 OID 16493)
-- Name: cor_role_menu_application_id_role_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY cor_role_menu
    ADD CONSTRAINT cor_role_menu_application_id_role_fkey FOREIGN KEY (id_role) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1993 (class 2606 OID 16498)
-- Name: cor_roles_id_role_groupe_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY cor_roles
    ADD CONSTRAINT cor_roles_id_role_groupe_fkey FOREIGN KEY (id_role_groupe) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1994 (class 2606 OID 16503)
-- Name: cor_roles_id_role_utilisateur_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY cor_roles
    ADD CONSTRAINT cor_roles_id_role_utilisateur_fkey FOREIGN KEY (id_role_utilisateur) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2000 (class 2606 OID 16508)
-- Name: t_menus_id_application_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY t_menus
    ADD CONSTRAINT t_menus_id_application_fkey FOREIGN KEY (id_application) REFERENCES t_applications(id_application) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1995 (class 2606 OID 16513)
-- Name: t_roles_id_organisme_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY t_roles
    ADD CONSTRAINT t_roles_id_organisme_fkey FOREIGN KEY (id_organisme) REFERENCES bib_organismes(id_organisme) ON UPDATE CASCADE;


--
-- TOC entry 1996 (class 2606 OID 16518)
-- Name: t_roles_id_unite_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: -
--

ALTER TABLE ONLY t_roles
    ADD CONSTRAINT t_roles_id_unite_fkey FOREIGN KEY (id_unite) REFERENCES bib_unites(id_unite) ON UPDATE CASCADE;


--
-- TOC entry 2122 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-05-24 10:29:48 CEST

--
-- PostgreSQL database dump complete
--

