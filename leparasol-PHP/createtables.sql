--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2
-- Dumped by pg_dump version 12.2

-- Started on 2020-05-12 14:29:03

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 205 (class 1259 OID 16425)
-- Name: Administrator; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Administrator" (
    firstname text NOT NULL,
    lastname text,
    mail text,
    passwd text
);


ALTER TABLE public."Administrator" OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 16440)
-- Name: Beach; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Beach" (
    name_beach text NOT NULL,
    caracteristics text,
    nudity text,
    privacy text,
    departement text,
    localisation text,
    frequentation text,
    description text,
    note double precision
);


ALTER TABLE public."Beach" OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 16409)
-- Name: City; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."City" (
    name_city text,
    departement text
);


ALTER TABLE public."City" OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 16394)
-- Name: Collaborator; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Collaborator" (
    firstname name COLLATE pg_catalog."default",
    lastname name COLLATE pg_catalog."default",
    passwd text,
    mail text
);


ALTER TABLE public."Collaborator" OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 16656)
-- Name: Commentaire; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Commentaire" (
    commentaire text,
    plage text,
    "Note" double precision,
    nom text,
    prenom text,
    id integer NOT NULL
);


ALTER TABLE public."Commentaire" OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 16662)
-- Name: Commentaire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public."Commentaire" ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public."Commentaire_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 204 (class 1259 OID 16414)
-- Name: Departement; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Departement" (
    name_departement text NOT NULL
);


ALTER TABLE public."Departement" OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 16670)
-- Name: Reponse; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Reponse" (
    id integer NOT NULL,
    "réponse" text,
    nom text,
    "prénom" text
);


ALTER TABLE public."Reponse" OWNER TO postgres;

--
-- TOC entry 2852 (class 0 OID 16425)
-- Dependencies: 205
-- Data for Name: Administrator; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Administrator" (firstname, lastname, mail, passwd) FROM stdin;
Gautier	Poursin	gautier.poursin@hotmail.fr	53fmcv5
Gautier	Poursin	gautir.poursin@hotmail.fr	53fmcv5
Gautier	Poursin	gautir.poursin@hotmail.fr	53fmcv5
Gautier	Poursin	gautir.poursin@hotmail.fr	53fmcv5
Gautier	Poursin	gautir.poursin@hotmail.fr	53fmcv5
Gautier	Poursin	gauti.poursin@hotmail.fr	azertyu
Joseph	Elang	joseph.elang@ensiie.fr	josephE
Andrew	Farndon	andrew.farndon@ensiie.fr	andrewF
Theo	Lazzaroni	theo.lazzaroni@ensiie.fr	theoLazza
\.


--
-- TOC entry 2853 (class 0 OID 16440)
-- Dependencies: 206
-- Data for Name: Beach; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Beach" (name_beach, caracteristics, nudity, privacy, departement, localisation, frequentation, description, note) FROM stdin;
plage de Jul	sable	nudiste	privée	Cote-d Or	Couchey	élevée	Petite  plage familiale au nord de Couchey	5
Plage du Lac Kir	sable	non nudiste	publique	Cote-d Or	Dijon	élevée	Plage légèrement trop algueuse	3
Plage de Lazza	galet	nudiste	privée	Jura	Lons 	faible	Belle plage	3.9
Plage d'Andrew	sable	non nudiste	publique	Ille-et-Vilaine	Saint-Malo	élevée	Plage idéal pour planter des radis	1.9166666666667
Plage du Cap	sable	non nudiste	publique	Herault	Cap d Adge	élevée	Grand plage avec quelques palmiers pour se mettre a l'ombre	1.415
Plage du vieux port	sable	non nudiste	publique	Bouches-du-Rhône	Marseille	élevée	Plage très jolie situé à proximité du vieux port.	2.875
Plage du Soleil	sable	non nudiste	privée	Alpes-Maritimes	Nice	faible	Petit plage sympathique pour se dorer la pillule	2.5833333333333
Plage de Nice	sable	non nudiste	publique	Alpes-Maritimes	Nice	élevée	Plage de sable fin	2.0666666666667
Plage test	sable	non nudiste	publique	Alpes-Maritimes	Nice	faible	test	4
\.


--
-- TOC entry 2850 (class 0 OID 16409)
-- Dependencies: 203
-- Data for Name: City; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."City" (name_city, departement) FROM stdin;
Dijon	Cote-d Or
Nice	Alpes-Maritimes
Nice	Alpes-Maritimes
Lons 	Jura
Saint-Malo	Ille-et-Vilaine
Dijon	Cote-d Or
Couchey	Cote-d Or
Cap d Adge	Herault
Marseille	Bouches-du-Rhône
Evry	Essonne
\.


--
-- TOC entry 2849 (class 0 OID 16394)
-- Dependencies: 202
-- Data for Name: Collaborator; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Collaborator" (firstname, lastname, passwd, mail) FROM stdin;
Antoine	Dupont	amodifier	\N
Gautier	Poursin	53fmcv5Chiddy	\N
Gautie	Poursi	amodifier	\N
Gautie	Poursi	amodifier	\N
Theo	Lazzaroni	$2y$10$o1dMWhfei5Pbg.olHAqjJuBzFC5nvBQrjfttwmW1jtXtjtTUw7uRy	theo.lazzaroni@ensiie.fr
Theo	Lazzaroni	$2y$10$0v2L.kVSpqSyKG2vHlnhGeJuS4n6g35FLuqAxlO6Os4EYE4HaU//e	theo.lazzaroni@ensiie.fr
Andrew	Farndon	$2y$10$VJCi16gW6eOu.yyb6OcnEOYZNRQul.zA388w6zvHSyU2QidhOfzQy	andrew.farndon@ensiie.fr
Luca	Micciche	michou21	luca.micciche@ensiie.fr
Marc	Dupont	MarcoPolo	marc.dupont@hotmail.fr
bb	aa	azerty	a.b@hotmail.fr
bob	aa	bobdylan	bobdylan@ensiie.fr
Gautier	Poursin	53fmcv5Chiddy	gautier.poursin@ensiie.fr
Gautier	Poursin	53fmcv5	gautier.poursin@hotmail.fr
\.


--
-- TOC entry 2854 (class 0 OID 16656)
-- Dependencies: 207
-- Data for Name: Commentaire; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Commentaire" (commentaire, plage, "Note", nom, prenom, id) FROM stdin;
Plage sympathique et chaleureuse	Plage de Lazza	4	Poursin	Gautier	15
Belle plage, mais quelques déchets	plage de Jul	3	Poursin	Gautier	26
Pas mal	plage de Jul	4.5	Poursin	Gautier	31
Très décu...	Plage du Cap	2	Poursin	Gautier	33
Jolie plage	Plage d'Andrew	3	Poursin	Gautier	36
Pas incroybale	Plage d'Andrew	2	Poursin	Gautier	37
Incroyable	Plage du vieux port	4.5	Poursin	Gautier	39
Belle plage de ville	Plage du vieux port	4	Dupont	Marc	40
Belle petite plage	Plage du Soleil	4	Poursin	Gautier	41
SYMPA	Plage du Soleil	4	Poursin	Gautier	42
ok	Plage de Nice	3	Poursin	Gautier	43
\.


--
-- TOC entry 2851 (class 0 OID 16414)
-- Dependencies: 204
-- Data for Name: Departement; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Departement" (name_departement) FROM stdin;
Yonne
\.


--
-- TOC entry 2856 (class 0 OID 16670)
-- Dependencies: 209
-- Data for Name: Reponse; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Reponse" (id, "réponse", nom, "prénom") FROM stdin;
2	 Dommage que j'y sois allé un jour de pluie	Poursin	Gautier
22	 Un joli paysage autour qui plus est! A recommander	\N	Theo
22	 Un joli paysage autour qui plus est! A recommander	\N	Theo
22	 Un joli paysage autour qui plus est! A recommander	\N	Theo
22	 Jolie petite anglais sur place	Farndon	Andrew
25	 Je ne suis pas d'accord avec vous, beacuoup de femme présentes	Poursin	Gautier
23	 Je ne suis pas d'accord avec vous, il y a beaucoup de femmes	Poursin	Gautier
23	 je suis ok	Poursin	Gautier
26	 Aucun déchets quand j'y suis allé!	Poursin	Gautier
33	 Au contraire j'ai été ravi	Dupont	Marc
26	 nulle	Poursin	Gautier
\.


--
-- TOC entry 2870 (class 0 OID 0)
-- Dependencies: 208
-- Name: Commentaire_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Commentaire_id_seq"', 45, true);


--
-- TOC entry 2720 (class 2606 OID 16575)
-- Name: Departement pk_dep; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Departement"
    ADD CONSTRAINT pk_dep PRIMARY KEY (name_departement);


--
-- TOC entry 2721 (class 1259 OID 16592)
-- Name: fki_fk_beach; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_fk_beach ON public."Beach" USING btree (departement);


--
-- TOC entry 2722 (class 1259 OID 16610)
-- Name: fki_fk_city_beach; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_fk_city_beach ON public."Beach" USING btree (localisation);


--
-- TOC entry 2718 (class 1259 OID 16584)
-- Name: fki_fk_dep; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_fk_dep ON public."City" USING btree (departement);


--
-- TOC entry 2862 (class 0 OID 0)
-- Dependencies: 205
-- Name: TABLE "Administrator"; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public."Administrator" TO PUBLIC;


--
-- TOC entry 2863 (class 0 OID 0)
-- Dependencies: 206
-- Name: TABLE "Beach"; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public."Beach" TO PUBLIC;


--
-- TOC entry 2864 (class 0 OID 0)
-- Dependencies: 203
-- Name: TABLE "City"; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public."City" TO PUBLIC;


--
-- TOC entry 2865 (class 0 OID 0)
-- Dependencies: 202
-- Name: TABLE "Collaborator"; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public."Collaborator" TO PUBLIC;


--
-- TOC entry 2866 (class 0 OID 0)
-- Dependencies: 202
-- Name: COLUMN "Collaborator".firstname; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL(firstname) ON TABLE public."Collaborator" TO postgres;


--
-- TOC entry 2867 (class 0 OID 0)
-- Dependencies: 202
-- Name: COLUMN "Collaborator".lastname; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL(lastname) ON TABLE public."Collaborator" TO postgres;


--
-- TOC entry 2868 (class 0 OID 0)
-- Dependencies: 202
-- Name: COLUMN "Collaborator".passwd; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL(passwd) ON TABLE public."Collaborator" TO postgres;


--
-- TOC entry 2869 (class 0 OID 0)
-- Dependencies: 204
-- Name: TABLE "Departement"; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public."Departement" TO PUBLIC;


-- Completed on 2020-05-12 14:29:04

--
-- PostgreSQL database dump complete
--

