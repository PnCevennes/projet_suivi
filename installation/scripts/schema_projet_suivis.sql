--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.6
-- Dumped by pg_dump version 9.4.6
-- Started on 2016-05-23 17:31:28 CEST

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = utilisateurs, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 234 (class 1259 OID 18613)
-- Name: t_roles; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
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


ALTER TABLE t_roles OWNER TO dbadmin;

--
-- TOC entry 241 (class 1259 OID 18642)
-- Name: cor_role_menu; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

CREATE TABLE cor_role_menu (
    id_role integer NOT NULL,
    id_menu integer NOT NULL
);


ALTER TABLE cor_role_menu OWNER TO dbadmin;

--
-- TOC entry 3499 (class 0 OID 0)
-- Dependencies: 241
-- Name: TABLE cor_role_menu; Type: COMMENT; Schema: utilisateurs; Owner: dbadmin
--

COMMENT ON TABLE cor_role_menu IS 'gestion du contenu des menus utilisateurs dans les applications';


--
-- TOC entry 232 (class 1259 OID 18608)
-- Name: cor_roles; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

CREATE TABLE cor_roles (
    id_role_groupe integer NOT NULL,
    id_role_utilisateur integer NOT NULL
);


ALTER TABLE cor_roles OWNER TO dbadmin;

--
-- TOC entry 235 (class 1259 OID 18621)
-- Name: bib_droits; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

CREATE TABLE bib_droits (
    id_droit integer NOT NULL,
    nom_droit character varying(50),
    desc_droit text
);


ALTER TABLE bib_droits OWNER TO dbadmin;

--
-- TOC entry 236 (class 1259 OID 18627)
-- Name: bib_observateurs; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

CREATE TABLE bib_observateurs (
    codeobs character varying(6) NOT NULL,
    nom character varying(100),
    prenom character varying(100),
    orphelin integer
);


ALTER TABLE bib_observateurs OWNER TO dbadmin;

--
-- TOC entry 238 (class 1259 OID 18632)
-- Name: bib_organismes; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
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


ALTER TABLE bib_organismes OWNER TO dbadmin;

--
-- TOC entry 240 (class 1259 OID 18638)
-- Name: bib_unites; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
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


ALTER TABLE bib_unites OWNER TO dbadmin;

--
-- TOC entry 231 (class 1259 OID 18605)
-- Name: cor_role_droit_application; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

CREATE TABLE cor_role_droit_application (
    id_role integer NOT NULL,
    id_droit integer NOT NULL,
    id_application integer NOT NULL
);


ALTER TABLE cor_role_droit_application OWNER TO dbadmin;

--
-- TOC entry 242 (class 1259 OID 18645)
-- Name: t_applications; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

CREATE TABLE t_applications (
    id_application integer NOT NULL,
    nom_application character varying(50) NOT NULL,
    desc_application text
);


ALTER TABLE t_applications OWNER TO dbadmin;

--
-- TOC entry 243 (class 1259 OID 18651)
-- Name: t_applications_id_application_seq; Type: SEQUENCE; Schema: utilisateurs; Owner: dbadmin
--

CREATE SEQUENCE t_applications_id_application_seq
    START WITH 1000000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE t_applications_id_application_seq OWNER TO dbadmin;

--
-- TOC entry 3500 (class 0 OID 0)
-- Dependencies: 243
-- Name: t_applications_id_application_seq; Type: SEQUENCE OWNED BY; Schema: utilisateurs; Owner: dbadmin
--

ALTER SEQUENCE t_applications_id_application_seq OWNED BY t_applications.id_application;


--
-- TOC entry 244 (class 1259 OID 18653)
-- Name: t_menus; Type: TABLE; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

CREATE TABLE t_menus (
    id_menu integer NOT NULL,
    nom_menu character varying(50) NOT NULL,
    desc_menu text,
    id_application integer
);


ALTER TABLE t_menus OWNER TO dbadmin;

--
-- TOC entry 3501 (class 0 OID 0)
-- Dependencies: 244
-- Name: TABLE t_menus; Type: COMMENT; Schema: utilisateurs; Owner: dbadmin
--

COMMENT ON TABLE t_menus IS 'table des menus déroulants des applications. Les roles de niveau groupes ou utilisateurs devant figurer dans un menu sont gérés dans la table cor_role_menu_application.';


--
-- TOC entry 245 (class 1259 OID 18659)
-- Name: t_menus_id_menu_seq; Type: SEQUENCE; Schema: utilisateurs; Owner: dbadmin
--

CREATE SEQUENCE t_menus_id_menu_seq
    START WITH 1000000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE t_menus_id_menu_seq OWNER TO dbadmin;

--
-- TOC entry 3502 (class 0 OID 0)
-- Dependencies: 245
-- Name: t_menus_id_menu_seq; Type: SEQUENCE OWNED BY; Schema: utilisateurs; Owner: dbadmin
--

ALTER SEQUENCE t_menus_id_menu_seq OWNED BY t_menus.id_menu;


--
-- TOC entry 3334 (class 2604 OID 18688)
-- Name: id_application; Type: DEFAULT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY t_applications ALTER COLUMN id_application SET DEFAULT nextval('t_applications_id_application_seq'::regclass);


--
-- TOC entry 3335 (class 2604 OID 18689)
-- Name: id_menu; Type: DEFAULT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY t_menus ALTER COLUMN id_menu SET DEFAULT nextval('t_menus_id_menu_seq'::regclass);


--
-- TOC entry 3343 (class 2606 OID 18691)
-- Name: bib_droits_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY bib_droits
    ADD CONSTRAINT bib_droits_pkey PRIMARY KEY (id_droit);


--
-- TOC entry 3345 (class 2606 OID 18693)
-- Name: bib_observateurs_pk; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY bib_observateurs
    ADD CONSTRAINT bib_observateurs_pk PRIMARY KEY (codeobs);


--
-- TOC entry 3337 (class 2606 OID 18695)
-- Name: cor_role_droit_application_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_pkey PRIMARY KEY (id_role, id_droit, id_application);


--
-- TOC entry 3351 (class 2606 OID 18697)
-- Name: cor_role_menu_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY cor_role_menu
    ADD CONSTRAINT cor_role_menu_pkey PRIMARY KEY (id_role, id_menu);


--
-- TOC entry 3339 (class 2606 OID 18699)
-- Name: cor_roles_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY cor_roles
    ADD CONSTRAINT cor_roles_pkey PRIMARY KEY (id_role_groupe, id_role_utilisateur);


--
-- TOC entry 3347 (class 2606 OID 18701)
-- Name: pk_bib_organismes; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY bib_organismes
    ADD CONSTRAINT pk_bib_organismes PRIMARY KEY (id_organisme);


--
-- TOC entry 3349 (class 2606 OID 18703)
-- Name: pk_bib_services; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY bib_unites
    ADD CONSTRAINT pk_bib_services PRIMARY KEY (id_unite);


--
-- TOC entry 3341 (class 2606 OID 18705)
-- Name: pk_roles; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY t_roles
    ADD CONSTRAINT pk_roles PRIMARY KEY (id_role);


--
-- TOC entry 3353 (class 2606 OID 18709)
-- Name: t_applications_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY t_applications
    ADD CONSTRAINT t_applications_pkey PRIMARY KEY (id_application);


--
-- TOC entry 3355 (class 2606 OID 18711)
-- Name: t_menus_pkey; Type: CONSTRAINT; Schema: utilisateurs; Owner: dbadmin; Tablespace: 
--

ALTER TABLE ONLY t_menus
    ADD CONSTRAINT t_menus_pkey PRIMARY KEY (id_menu);


--
-- TOC entry 3366 (class 2620 OID 18712)
-- Name: modify_date_insert_trigger; Type: TRIGGER; Schema: utilisateurs; Owner: dbadmin
--

CREATE TRIGGER modify_date_insert_trigger BEFORE INSERT ON t_roles FOR EACH ROW EXECUTE PROCEDURE modify_date_insert();


--
-- TOC entry 3367 (class 2620 OID 18713)
-- Name: modify_date_update_trigger; Type: TRIGGER; Schema: utilisateurs; Owner: dbadmin
--

CREATE TRIGGER modify_date_update_trigger BEFORE UPDATE ON t_roles FOR EACH ROW EXECUTE PROCEDURE modify_date_update();


--
-- TOC entry 3356 (class 2606 OID 18714)
-- Name: cor_role_droit_application_id_application_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_id_application_fkey FOREIGN KEY (id_application) REFERENCES t_applications(id_application) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3357 (class 2606 OID 18719)
-- Name: cor_role_droit_application_id_droit_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_id_droit_fkey FOREIGN KEY (id_droit) REFERENCES bib_droits(id_droit) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3358 (class 2606 OID 18724)
-- Name: cor_role_droit_application_id_role_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY cor_role_droit_application
    ADD CONSTRAINT cor_role_droit_application_id_role_fkey FOREIGN KEY (id_role) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3363 (class 2606 OID 18729)
-- Name: cor_role_menu_application_id_menu_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY cor_role_menu
    ADD CONSTRAINT cor_role_menu_application_id_menu_fkey FOREIGN KEY (id_menu) REFERENCES t_menus(id_menu) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3364 (class 2606 OID 18734)
-- Name: cor_role_menu_application_id_role_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY cor_role_menu
    ADD CONSTRAINT cor_role_menu_application_id_role_fkey FOREIGN KEY (id_role) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3359 (class 2606 OID 18739)
-- Name: cor_roles_id_role_groupe_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY cor_roles
    ADD CONSTRAINT cor_roles_id_role_groupe_fkey FOREIGN KEY (id_role_groupe) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3360 (class 2606 OID 18744)
-- Name: cor_roles_id_role_utilisateur_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY cor_roles
    ADD CONSTRAINT cor_roles_id_role_utilisateur_fkey FOREIGN KEY (id_role_utilisateur) REFERENCES t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3365 (class 2606 OID 18749)
-- Name: t_menus_id_application_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY t_menus
    ADD CONSTRAINT t_menus_id_application_fkey FOREIGN KEY (id_application) REFERENCES t_applications(id_application) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3361 (class 2606 OID 18754)
-- Name: t_roles_id_organisme_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY t_roles
    ADD CONSTRAINT t_roles_id_organisme_fkey FOREIGN KEY (id_organisme) REFERENCES bib_organismes(id_organisme) ON UPDATE CASCADE;


--
-- TOC entry 3362 (class 2606 OID 18759)
-- Name: t_roles_id_unite_fkey; Type: FK CONSTRAINT; Schema: utilisateurs; Owner: dbadmin
--

ALTER TABLE ONLY t_roles
    ADD CONSTRAINT t_roles_id_unite_fkey FOREIGN KEY (id_unite) REFERENCES bib_unites(id_unite) ON UPDATE CASCADE;


-- Completed on 2016-05-23 17:31:48 CEST

--
-- PostgreSQL database dump complete
--

