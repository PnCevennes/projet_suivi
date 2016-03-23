-- Table: patrimoinebati.pr_site_infos
DROP TABLE IF EXISTS patrimoinebati.rel_pbsite_fichiers;
DROP VIEW IF EXISTS patrimoinebati.vue_pb_site;
DROP TABLE IF EXISTS patrimoinebati.pr_site_infos;

CREATE TABLE patrimoinebati.pr_site_infos
(
  id serial NOT NULL,
  fk_bs_id integer NOT NULL,
  pb_des_code_ref character varying(250),
  pb_des_denomination_locale character varying(250),
  pb_des_nom_synononymes character varying(250),
  pb_loc_lieudit character varying(250),
  pb_loc_situation integer,
  pb_loc_orientation integer,
  pb_loc_visibilite integer,
  pb_loc_accessibilite integer,
  pb_loc_statut integer,
  pb_his_datation_type integer,
  pb_his_datation_periode integer,
  pb_his_datation_exacte character varying(250),
  pb_des_dimensions_larg double precision,
  pb_des_dimensions_long double precision,
  pb_des_dimensions_haut double precision,
  pb_des_dimensions_e double precision,
  pb_des_dimensions_d double precision,
  pb_des_environnement_proche text,
  pb_des_mur_misenoeuvre integer,
  pb_des_mur_revetement integer,
  pb_des_toit integer,
  pb_des_couvrement integer,
  pb_des_complementaire text,
  pb_des_etat integer,
  pb_interpretation integer,
  pb_commentaire text,
  pb_traitement_donnees integer,
  pb_source integer,
  pb_dossiercandidature BOOLEAN,
  CONSTRAINT cis_pk PRIMARY KEY (id),
  CONSTRAINT fk_bs FOREIGN KEY (fk_bs_id)
      REFERENCES suivi.pr_base_site (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE patrimoinebati.pr_site_infos
  OWNER TO dbadmin;

-- Index: patrimoinebati.uniq_49ec129cf6bd1646

-- DROP INDEX patrimoinebati.uniq_49ec129cf6bd1646;

CREATE UNIQUE INDEX uniq_49ec129cf6bd1646
  ON patrimoinebati.pr_site_infos
  USING btree
  (fk_bs_id);




-- DROP TABLE chiro.rel_pbsite_thesaurus_murgrosoeuvre;

CREATE TABLE patrimoinebati.rel_pbsite_thesaurus_murgrosoeuvre
(
  site_id integer NOT NULL,
  thesaurus_id integer NOT NULL,
  CONSTRAINT pk_murgrosoeuvre_f PRIMARY KEY (site_id, thesaurus_id),
  CONSTRAINT fk_pbsite_murgrosoeuvre FOREIGN KEY (site_id)
      REFERENCES suivi.pr_base_site (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE,
  CONSTRAINT fk_thesaurus_murgrosoeuvre FOREIGN KEY (thesaurus_id)
      REFERENCES lexique.t_thesaurus (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);


CREATE TABLE patrimoinebati.rel_pbsite_fichiers
(
  site_id integer NOT NULL,
  fichier_id integer NOT NULL,
  commentaire character varying(100),
  CONSTRAINT pk_cs_f PRIMARY KEY (site_id, fichier_id),
  CONSTRAINT fk_pbsite FOREIGN KEY (site_id)
      REFERENCES suivi.pr_base_site (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE,
  CONSTRAINT fk_uploads FOREIGN KEY (fichier_id)
      REFERENCES suivi.uploads (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE patrimoinebati.rel_pbsite_fichiers
  OWNER TO dbadmin;


CREATE OR REPLACE VIEW patrimoinebati.vue_pb_site AS
 SELECT s.id,
    s.bs_nom,
    s.bs_code,
    s.bs_date,
    s.bs_description,
    s.bs_obr_id,
    s.meta_create_timestamp,
    s.meta_update_timestamp,
    s.meta_numerisateur_id,
    array_to_json(s.bs_ref_commune)::text AS ref_commune,
    st_asgeojson(s.geom) AS geom,
    (((obr.nom_role::text || ' '::text) || obr.prenom_role::text))::character varying(255) AS nom_observateur,
    s.bs_type_id,
    the_type.libelle AS type_lieu,
    c.pb_source
   FROM patrimoinebati.pr_site_infos c
     JOIN suivi.pr_base_site s ON c.fk_bs_id = s.id
     LEFT JOIN utilisateurs.t_roles obr ON obr.id_role = s.bs_obr_id
     LEFT JOIN lexique.t_thesaurus the_type ON the_type.id = s.bs_type_id
  ORDER BY s.id;

ALTER TABLE patrimoinebati.vue_pb_site
  OWNER TO dbadmin;
