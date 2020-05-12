--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.21
-- Dumped by pg_dump version 9.5.19

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: array_intersect(anyarray, anyarray); Type: FUNCTION; Schema: public; Owner: toraux
--

CREATE FUNCTION public.array_intersect(anyarray, anyarray) RETURNS anyarray
    LANGUAGE sql
    AS $_$
    SELECT ARRAY(
        SELECT UNNEST($1)
        INTERSECT
        SELECT UNNEST($2)
    );
$_$;


ALTER FUNCTION public.array_intersect(anyarray, anyarray) OWNER TO toraux;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: comment; Type: TABLE; Schema: public; Owner: toraux
--

CREATE TABLE public.comment (
    idcomment integer NOT NULL,
    idsujet integer,
    replyto integer,
    content text,
    date date,
    utilisateur character varying(50)
);


ALTER TABLE public.comment OWNER TO toraux;

--
-- Name: comment_idcomment_seq; Type: SEQUENCE; Schema: public; Owner: toraux
--

CREATE SEQUENCE public.comment_idcomment_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comment_idcomment_seq OWNER TO toraux;

--
-- Name: comment_idcomment_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: toraux
--

ALTER SEQUENCE public.comment_idcomment_seq OWNED BY public.comment.idcomment;


--
-- Name: correction; Type: TABLE; Schema: public; Owner: toraux
--

CREATE TABLE public.correction (
    id integer,
    nomcorrection character varying(50),
    utilisateur character varying(50)
);


ALTER TABLE public.correction OWNER TO toraux;

--
-- Name: sujet; Type: TABLE; Schema: public; Owner: toraux
--

CREATE TABLE public.sujet (
    nom character varying(50) NOT NULL,
    matiere character varying(50) NOT NULL,
    annee integer NOT NULL,
    filiere character varying(50) NOT NULL,
    concours character varying(50) NOT NULL,
    themes character varying(50),
    utilisateur character varying(50),
    id integer NOT NULL
);


ALTER TABLE public.sujet OWNER TO toraux;

--
-- Name: sujet_id_seq; Type: SEQUENCE; Schema: public; Owner: toraux
--

CREATE SEQUENCE public.sujet_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sujet_id_seq OWNER TO toraux;

--
-- Name: sujet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: toraux
--

ALTER SEQUENCE public.sujet_id_seq OWNED BY public.sujet.id;


--
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: toraux
--

CREATE TABLE public.utilisateur (
    user_id character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    question_num character varying(50) NOT NULL,
    answer character varying(50) NOT NULL,
    mail character varying(100),
    filiere character varying(10),
    niveau character varying(50),
    photo character varying(50),
    admin integer
);


ALTER TABLE public.utilisateur OWNER TO toraux;

--
-- Name: idcomment; Type: DEFAULT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.comment ALTER COLUMN idcomment SET DEFAULT nextval('public.comment_idcomment_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.sujet ALTER COLUMN id SET DEFAULT nextval('public.sujet_id_seq'::regclass);


--
-- Data for Name: comment; Type: TABLE DATA; Schema: public; Owner: toraux
--

COPY public.comment (idcomment, idsujet, replyto, content, date, utilisateur) FROM stdin;
39	22	\N	cc	\N	drive3
\.


--
-- Name: comment_idcomment_seq; Type: SEQUENCE SET; Schema: public; Owner: toraux
--

SELECT pg_catalog.setval('public.comment_idcomment_seq', 40, true);


--
-- Data for Name: correction; Type: TABLE DATA; Schema: public; Owner: toraux
--

COPY public.correction (id, nomcorrection, utilisateur) FROM stdin;
26	3975ccinp_electromagnetisme_2009_mp.pdf	dank
\.


--
-- Data for Name: sujet; Type: TABLE DATA; Schema: public; Owner: toraux
--

COPY public.sujet (nom, matiere, annee, filiere, concours, themes, utilisateur, id) FROM stdin;
centrale_maths2.pdf	Maths	2010	MP	CENTRALE	\N	dank	22
maths_mines-telecom.pdf	Maths	2014	MP	MT	\N	dank	23
ccinp_electromagnetisme_2009_mp.pdf	PC	2009	MP	CCP	Electromagnétisme	dank	26
oraux_psi_213_maths.jpg	Maths	2007	PSI	CCP	\N	castor	31
oraux_psi_212_maths.jpg	Maths	2012	PSI	CCP	\N	castor	32
oral_ccpinpPSI.jpg	Maths	2016	PSI	CCP	\N	castor	33
oral_maths_mines_beos.pdf	Maths	2019	PC	MT	\N	castor	34
\.


--
-- Name: sujet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: toraux
--

SELECT pg_catalog.setval('public.sujet_id_seq', 34, true);


--
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: toraux
--

COPY public.utilisateur (user_id, password, question_num, answer, mail, filiere, niveau, photo, admin) FROM stdin;
castor	president	Poste Entreprise	tresorier	a.elmahouli@gmail.com	MP	\N	castor.jpeg	\N
dank	SG	animal	chien	a.elmahouli@gmail.com	MP	3/2	dank.png	1
drive3	sape	Animal préféré	chien	a.elmahouli@gmail.com		\N		\N
\.


--
-- Name: comment_pkey; Type: CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT comment_pkey PRIMARY KEY (idcomment);


--
-- Name: sujet_pkey; Type: CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.sujet
    ADD CONSTRAINT sujet_pkey PRIMARY KEY (id);


--
-- Name: utilisateur_pkey; Type: CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_pkey PRIMARY KEY (user_id);


--
-- Name: constraint_fk_reply; Type: FK CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT constraint_fk_reply FOREIGN KEY (replyto) REFERENCES public.comment(idcomment) ON DELETE CASCADE;


--
-- Name: constraint_fk_sujet; Type: FK CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT constraint_fk_sujet FOREIGN KEY (idsujet) REFERENCES public.sujet(id) ON DELETE CASCADE;


--
-- Name: constraint_fk_sujet; Type: FK CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.correction
    ADD CONSTRAINT constraint_fk_sujet FOREIGN KEY (id) REFERENCES public.sujet(id) ON DELETE CASCADE;


--
-- Name: constraint_fk_user; Type: FK CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT constraint_fk_user FOREIGN KEY (utilisateur) REFERENCES public.utilisateur(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: constraint_fk_user; Type: FK CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.correction
    ADD CONSTRAINT constraint_fk_user FOREIGN KEY (utilisateur) REFERENCES public.utilisateur(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: constraint_fk_user; Type: FK CONSTRAINT; Schema: public; Owner: toraux
--

ALTER TABLE ONLY public.sujet
    ADD CONSTRAINT constraint_fk_user FOREIGN KEY (utilisateur) REFERENCES public.utilisateur(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

