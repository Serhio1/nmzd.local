--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.5
-- Dumped by pg_dump version 9.3.5
-- Started on 2014-12-02 00:32:51 EET

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 199 (class 3079 OID 11789)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2148 (class 0 OID 0)
-- Dependencies: 199
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 170 (class 1259 OID 16666)
-- Name: control_work_type; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE control_work_type (
    id bigint NOT NULL,
    name character varying
);


ALTER TABLE public.control_work_type OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 16672)
-- Name: id_disc; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_disc
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_disc OWNER TO postgres;

--
-- TOC entry 172 (class 1259 OID 16674)
-- Name: discipline; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE discipline (
    id integer DEFAULT nextval('id_disc'::regclass) NOT NULL,
    semester integer NOT NULL,
    name character varying,
    general_hours integer,
    lect_hours integer,
    lab_hours integer,
    pract_hours integer,
    sem_hours integer,
    self_hours integer,
    ind_hours integer,
    id_spec character varying(4),
    id_subspec character varying
);


ALTER TABLE public.discipline OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 16681)
-- Name: id_ind; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_ind
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_ind OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16683)
-- Name: id_lab; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_lab
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_lab OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 16685)
-- Name: id_lect; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_lect
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_lect OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 16687)
-- Name: id_lit; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_lit
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_lit OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 16820)
-- Name: id_menu_item; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_menu_item
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_menu_item OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 16809)
-- Name: id_menus; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_menus
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_menus OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 16689)
-- Name: id_module; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_module
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_module OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 16691)
-- Name: id_pract; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_pract
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_pract OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 16693)
-- Name: id_self; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_self
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_self OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 16695)
-- Name: id_sem; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_sem
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_sem OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 16697)
-- Name: id_session; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_session
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_session OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 16699)
-- Name: id_tq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_tq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_tq OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 16701)
-- Name: id_type; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE id_type
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_type OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 16703)
-- Name: individual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE individual (
    id_individual integer DEFAULT nextval('id_ind'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions_for_individual integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);


ALTER TABLE public.individual OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 16710)
-- Name: laboratory; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE laboratory (
    id_lab integer DEFAULT nextval('id_lab'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions_for_laboratory integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);


ALTER TABLE public.laboratory OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16717)
-- Name: lection; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lection (
    id_lect integer DEFAULT nextval('id_lect'::regclass) NOT NULL,
    id_disc integer,
    semester integer,
    theme character varying(255),
    hours smallint,
    literature integer[],
    questions_for_lection integer[],
    id_theme integer
);


ALTER TABLE public.lection OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 16724)
-- Name: literature; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE literature (
    id integer DEFAULT nextval('id_lit'::regclass)
);


ALTER TABLE public.literature OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 16812)
-- Name: menu_items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_items (
    id integer DEFAULT nextval('id_menus'::regclass) NOT NULL,
    menu_id integer,
    parent_id integer,
    title character varying,
    url character varying,
    weight smallint
);


ALTER TABLE public.menu_items OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 16801)
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE menus (
    id integer DEFAULT nextval('id_menus'::regclass) NOT NULL,
    menu_key character varying,
    title character varying
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16728)
-- Name: modules; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE modules (
    id integer DEFAULT nextval('id_module'::regclass) NOT NULL,
    name character varying,
    state boolean
);


ALTER TABLE public.modules OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 16735)
-- Name: practical; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE practical (
    id_pract integer DEFAULT nextval('id_pract'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions_for_practical integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);


ALTER TABLE public.practical OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 16742)
-- Name: self; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE self (
    id_self integer DEFAULT nextval('id_self'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions_for_self integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);


ALTER TABLE public.self OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 16749)
-- Name: seminary; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE seminary (
    id_disc integer,
    semester smallint,
    theme character varying,
    questions_for_seminary integer[],
    hours smallint,
    literature integer[],
    id_seminary integer DEFAULT nextval('id_sem'::regclass) NOT NULL,
    id_theme integer
);


ALTER TABLE public.seminary OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 16756)
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sessions (
    id_disc integer NOT NULL,
    session_data text,
    id integer DEFAULT nextval('id_session'::regclass)
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 16763)
-- Name: themes_questions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE themes_questions (
    id_tq integer DEFAULT nextval('id_tq'::regclass) NOT NULL,
    name character varying(255),
    id_discipline integer,
    id_parent integer,
    types_id smallint[],
    num_tq integer
);


ALTER TABLE public.themes_questions OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 16770)
-- Name: types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE types (
    id integer NOT NULL,
    name character varying
);


ALTER TABLE public.types OWNER TO postgres;

--
-- TOC entry 2134 (class 2613 OID 16449)
-- Name: 16449; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('16449');


ALTER LARGE OBJECT 16449 OWNER TO postgres;

--
-- TOC entry 2135 (class 2613 OID 16450)
-- Name: 16450; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('16450');


ALTER LARGE OBJECT 16450 OWNER TO postgres;

--
-- TOC entry 2136 (class 2613 OID 16451)
-- Name: 16451; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('16451');


ALTER LARGE OBJECT 16451 OWNER TO postgres;

--
-- TOC entry 2137 (class 2613 OID 16452)
-- Name: 16452; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('16452');


ALTER LARGE OBJECT 16452 OWNER TO postgres;

--
-- TOC entry 2138 (class 2613 OID 16478)
-- Name: 16478; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('16478');


ALTER LARGE OBJECT 16478 OWNER TO postgres;

--
-- TOC entry 2139 (class 2613 OID 16479)
-- Name: 16479; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('16479');


ALTER LARGE OBJECT 16479 OWNER TO postgres;

--
-- TOC entry 2105 (class 0 OID 16666)
-- Dependencies: 170
-- Data for Name: control_work_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY control_work_type (id, name) FROM stdin;
\.


--
-- TOC entry 2107 (class 0 OID 16674)
-- Dependencies: 172
-- Data for Name: discipline; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY discipline (id, semester, name, general_hours, lect_hours, lab_hours, pract_hours, sem_hours, self_hours, ind_hours, id_spec, id_subspec) FROM stdin;
1	1	Алгоритмізація і програмування	\N	\N	\N	\N	\N	\N	\N	0502	6.050202
\.


--
-- TOC entry 2149 (class 0 OID 0)
-- Dependencies: 171
-- Name: id_disc; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_disc', 1, false);


--
-- TOC entry 2150 (class 0 OID 0)
-- Dependencies: 173
-- Name: id_ind; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_ind', 211, true);


--
-- TOC entry 2151 (class 0 OID 0)
-- Dependencies: 174
-- Name: id_lab; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_lab', 148, true);


--
-- TOC entry 2152 (class 0 OID 0)
-- Dependencies: 175
-- Name: id_lect; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_lect', 257, true);


--
-- TOC entry 2153 (class 0 OID 0)
-- Dependencies: 176
-- Name: id_lit; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_lit', 1, false);


--
-- TOC entry 2154 (class 0 OID 0)
-- Dependencies: 198
-- Name: id_menu_item; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_menu_item', 1, false);


--
-- TOC entry 2155 (class 0 OID 0)
-- Dependencies: 196
-- Name: id_menus; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_menus', 68, true);


--
-- TOC entry 2156 (class 0 OID 0)
-- Dependencies: 177
-- Name: id_module; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_module', 76, true);


--
-- TOC entry 2157 (class 0 OID 0)
-- Dependencies: 178
-- Name: id_pract; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_pract', 210, true);


--
-- TOC entry 2158 (class 0 OID 0)
-- Dependencies: 179
-- Name: id_self; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_self', 146, true);


--
-- TOC entry 2159 (class 0 OID 0)
-- Dependencies: 180
-- Name: id_sem; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_sem', 129, true);


--
-- TOC entry 2160 (class 0 OID 0)
-- Dependencies: 181
-- Name: id_session; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_session', 2, true);


--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 182
-- Name: id_tq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_tq', 3220, true);


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 183
-- Name: id_type; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('id_type', 1, false);


--
-- TOC entry 2119 (class 0 OID 16703)
-- Dependencies: 184
-- Data for Name: individual; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY individual (id_individual, id_disc, semester, theme, questions_for_individual, hours, literature, id_theme) FROM stdin;
\.


--
-- TOC entry 2120 (class 0 OID 16710)
-- Dependencies: 185
-- Data for Name: laboratory; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY laboratory (id_lab, id_disc, semester, theme, questions_for_laboratory, hours, literature, id_theme) FROM stdin;
\.


--
-- TOC entry 2121 (class 0 OID 16717)
-- Dependencies: 186
-- Data for Name: lection; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY lection (id_lect, id_disc, semester, theme, hours, literature, questions_for_lection, id_theme) FROM stdin;
256	1	1	theme1	\N	\N	{3200}	3199
257	1	1	theme1	\N	\N	{3212}	3211
\.


--
-- TOC entry 2122 (class 0 OID 16724)
-- Dependencies: 187
-- Data for Name: literature; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY literature (id) FROM stdin;
\.


--
-- TOC entry 2132 (class 0 OID 16812)
-- Dependencies: 197
-- Data for Name: menu_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY menu_items (id, menu_id, parent_id, title, url, weight) FROM stdin;
51	50	-1	Головна	/	1
64	46	-1	Управління Меню	http://nmzd.local/admin/menu	2
47	46	-1	Управління Модулями	http://nmzd.local/admin/module	1
\.


--
-- TOC entry 2130 (class 0 OID 16801)
-- Dependencies: 195
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY menus (id, menu_key, title) FROM stdin;
46	admin_menu	Меню Адміністрування
50	main_menu	Головне Меню
\.


--
-- TOC entry 2123 (class 0 OID 16728)
-- Dependencies: 188
-- Data for Name: modules; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY modules (id, name, state) FROM stdin;
1	devel	t
2	admin	t
\.


--
-- TOC entry 2124 (class 0 OID 16735)
-- Dependencies: 189
-- Data for Name: practical; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY practical (id_pract, id_disc, semester, theme, questions_for_practical, hours, literature, id_theme) FROM stdin;
\.


--
-- TOC entry 2125 (class 0 OID 16742)
-- Dependencies: 190
-- Data for Name: self; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY self (id_self, id_disc, semester, theme, questions_for_self, hours, literature, id_theme) FROM stdin;
\.


--
-- TOC entry 2126 (class 0 OID 16749)
-- Dependencies: 191
-- Data for Name: seminary; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY seminary (id_disc, semester, theme, questions_for_seminary, hours, literature, id_seminary, id_theme) FROM stdin;
\.


--
-- TOC entry 2127 (class 0 OID 16756)
-- Dependencies: 192
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sessions (id_disc, session_data, id) FROM stdin;
1	a:3:{s:9:"questions";a:10:{i:0;s:6:"theme1";i:1;s:5:"q1_t1";i:2;s:5:"q2_t1";i:3;s:5:"q3_t1";i:4;s:5:"q4_t1";i:5;s:6:"theme2";i:6;s:5:"q1_t2";i:7;s:5:"q2_t2";i:8;s:5:"q3_t2";i:9;s:5:"q4_t2";}s:6:"themes";a:2:{i:0;i:0;i:1;i:5;}s:4:"step";s:9:"set-types";}	2
\.


--
-- TOC entry 2128 (class 0 OID 16763)
-- Dependencies: 193
-- Data for Name: themes_questions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY themes_questions (id_tq, name, id_discipline, id_parent, types_id, num_tq) FROM stdin;
3197	module1	1	-1	{}	0
3199	theme1	1	3197	{}	1
3200	q1_t1	1	3199	{1}	2
3201	q2_t1	1	3199	{}	3
3202	q3_t1	1	3199	{}	4
3203	q4_t1	1	3199	{}	5
3198	module2	1	-1	{}	6
3204	theme2	1	3198	{}	7
3205	q1_t2	1	3204	{}	8
3207	q3_t2	1	3204	{}	9
3208	q4_t2	1	3204	{}	10
3206	q2_t2	1	3204	{}	11
3209	module1	1	-1	{}	0
3211	theme1	1	3209	{}	1
3212	q1_t1	1	3211	{1}	2
3213	q2_t1	1	3211	{}	3
3214	q3_t1	1	3211	{}	4
3215	q4_t1	1	3211	{}	5
3210	module2	1	-1	{}	6
3216	theme2	1	3210	{}	7
3217	q1_t2	1	3216	{}	8
3219	q3_t2	1	3216	{}	9
3220	q4_t2	1	3216	{}	10
3218	q2_t2	1	3216	{}	11
\.


--
-- TOC entry 2129 (class 0 OID 16770)
-- Dependencies: 194
-- Data for Name: types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY types (id, name) FROM stdin;
1	lection
2	practical
3	seminary
4	laboratory
5	individual
6	self
\.


--
-- TOC entry 2140 (class 0 OID 0)
-- Data for Name: BLOBS; Type: BLOBS; Schema: -; Owner: 
--

SET search_path = pg_catalog;

BEGIN;

SELECT pg_catalog.lo_open('16449', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('16450', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('16451', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('16452', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('16478', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('16479', 131072);
SELECT pg_catalog.lo_close(0);

COMMIT;

SET search_path = public, pg_catalog;

--
-- TOC entry 1971 (class 2606 OID 16777)
-- Name: control_work_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY control_work_type
    ADD CONSTRAINT control_work_type_pkey PRIMARY KEY (id);


--
-- TOC entry 1973 (class 2606 OID 16779)
-- Name: discipline_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY discipline
    ADD CONSTRAINT discipline_pkey PRIMARY KEY (id, semester);


--
-- TOC entry 1987 (class 2606 OID 16781)
-- Name: id_seminary; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY seminary
    ADD CONSTRAINT id_seminary PRIMARY KEY (id_seminary);


--
-- TOC entry 1975 (class 2606 OID 16783)
-- Name: individual_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY individual
    ADD CONSTRAINT individual_pkey PRIMARY KEY (id_individual);


--
-- TOC entry 1977 (class 2606 OID 16785)
-- Name: laboratory_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY laboratory
    ADD CONSTRAINT laboratory_pkey PRIMARY KEY (id_lab);


--
-- TOC entry 1979 (class 2606 OID 16787)
-- Name: lections_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lection
    ADD CONSTRAINT lections_pkey PRIMARY KEY (id_lect);


--
-- TOC entry 1997 (class 2606 OID 16816)
-- Name: menu_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_items
    ADD CONSTRAINT menu_items_pkey PRIMARY KEY (id);


--
-- TOC entry 1995 (class 2606 OID 16808)
-- Name: menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- TOC entry 1981 (class 2606 OID 16789)
-- Name: modules_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY modules
    ADD CONSTRAINT modules_pkey PRIMARY KEY (id);


--
-- TOC entry 1983 (class 2606 OID 16791)
-- Name: practical_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY practical
    ADD CONSTRAINT practical_pkey PRIMARY KEY (id_pract);


--
-- TOC entry 1985 (class 2606 OID 16793)
-- Name: self_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY self
    ADD CONSTRAINT self_pkey PRIMARY KEY (id_self);


--
-- TOC entry 1989 (class 2606 OID 16795)
-- Name: sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id_disc);


--
-- TOC entry 1991 (class 2606 OID 16797)
-- Name: themes_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY themes_questions
    ADD CONSTRAINT themes_questions_pkey PRIMARY KEY (id_tq);


--
-- TOC entry 1993 (class 2606 OID 16799)
-- Name: types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY types
    ADD CONSTRAINT types_pkey PRIMARY KEY (id);


--
-- TOC entry 2147 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-12-02 00:32:52 EET

--
-- PostgreSQL database dump complete
--

