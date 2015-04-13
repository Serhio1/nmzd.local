PGDMP                         s           nmzd    9.3.6    9.3.6 S    P           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            Q           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            R           1262    16656    nmzd    DATABASE     v   CREATE DATABASE nmzd WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';
    DROP DATABASE nmzd;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            S           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    6            T           0    0    public    ACL     �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                  postgres    false    6            �            3079    11789    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            U           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    198            �            1259    16666    control_work_type    TABLE     W   CREATE TABLE control_work_type (
    id bigint NOT NULL,
    name character varying
);
 %   DROP TABLE public.control_work_type;
       public         postgres    false    6            �            1259    16672    id_disc    SEQUENCE     i   CREATE SEQUENCE id_disc
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_disc;
       public       postgres    false    6            �            1259    16674 
   discipline    TABLE     �  CREATE TABLE discipline (
    id integer DEFAULT nextval('id_disc'::regclass) NOT NULL,
    semester integer NOT NULL,
    title character varying,
    general_hours integer,
    lect_hours integer,
    lab_hours integer,
    pract_hours integer,
    sem_hours integer,
    self_hours integer,
    ind_hours integer,
    id_speciality character varying(4),
    id_subspeciality character varying
);
    DROP TABLE public.discipline;
       public         postgres    false    171    6            �            1259    16681    id_ind    SEQUENCE     h   CREATE SEQUENCE id_ind
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_ind;
       public       postgres    false    6            �            1259    16683    id_lab    SEQUENCE     h   CREATE SEQUENCE id_lab
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_lab;
       public       postgres    false    6            �            1259    16831    id_lab_structure    SEQUENCE     r   CREATE SEQUENCE id_lab_structure
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.id_lab_structure;
       public       postgres    false    6            �            1259    16685    id_lect    SEQUENCE     i   CREATE SEQUENCE id_lect
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_lect;
       public       postgres    false    6            �            1259    16687    id_lit    SEQUENCE     h   CREATE SEQUENCE id_lit
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_lit;
       public       postgres    false    6            �            1259    16820    id_menu_item    SEQUENCE     n   CREATE SEQUENCE id_menu_item
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.id_menu_item;
       public       postgres    false    6            �            1259    16809    id_menus    SEQUENCE     j   CREATE SEQUENCE id_menus
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_menus;
       public       postgres    false    6            �            1259    16689 	   id_module    SEQUENCE     k   CREATE SEQUENCE id_module
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
     DROP SEQUENCE public.id_module;
       public       postgres    false    6            �            1259    16691    id_pract    SEQUENCE     j   CREATE SEQUENCE id_pract
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_pract;
       public       postgres    false    6            �            1259    16693    id_self    SEQUENCE     i   CREATE SEQUENCE id_self
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_self;
       public       postgres    false    6            �            1259    16695    id_sem    SEQUENCE     h   CREATE SEQUENCE id_sem
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_sem;
       public       postgres    false    6            �            1259    16697 
   id_session    SEQUENCE     l   CREATE SEQUENCE id_session
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 !   DROP SEQUENCE public.id_session;
       public       postgres    false    6            �            1259    16699    id_tq    SEQUENCE     g   CREATE SEQUENCE id_tq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_tq;
       public       postgres    false    6            �            1259    16701    id_type    SEQUENCE     i   CREATE SEQUENCE id_type
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    DROP SEQUENCE public.id_type;
       public       postgres    false    6            �            1259    16703 
   individual    TABLE     
  CREATE TABLE individual (
    id_individual integer DEFAULT nextval('id_ind'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);
    DROP TABLE public.individual;
       public         postgres    false    173    6            �            1259    16710 
   laboratory    TABLE     
  CREATE TABLE laboratory (
    id_laboratory integer DEFAULT nextval('id_lab'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);
    DROP TABLE public.laboratory;
       public         postgres    false    174    6            �            1259    16823    laboratory_structure    TABLE     g  CREATE TABLE laboratory_structure (
    id integer DEFAULT nextval('id_lab_structure'::regclass) NOT NULL,
    discipline_id integer,
    theme text,
    purpose text,
    theory text,
    execution_order text,
    content_structure text,
    requirements text,
    individual_variants text,
    literature text,
    type text,
    title character varying
);
 (   DROP TABLE public.laboratory_structure;
       public         postgres    false    197    6            �            1259    16717    lection    TABLE       CREATE TABLE lection (
    id_lect integer DEFAULT nextval('id_lect'::regclass) NOT NULL,
    id_disc integer,
    semester integer,
    theme character varying(255),
    hours smallint,
    literature integer[],
    questions integer[],
    id_theme integer
);
    DROP TABLE public.lection;
       public         postgres    false    175    6            �            1259    16724 
   literature    TABLE     P   CREATE TABLE literature (
    id integer DEFAULT nextval('id_lit'::regclass)
);
    DROP TABLE public.literature;
       public         postgres    false    176    6            �            1259    16735 	   practical    TABLE       CREATE TABLE practical (
    id_pract integer DEFAULT nextval('id_pract'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);
    DROP TABLE public.practical;
       public         postgres    false    178    6            �            1259    16742    self    TABLE     �   CREATE TABLE self (
    id_self integer DEFAULT nextval('id_self'::regclass) NOT NULL,
    id_disc integer,
    semester smallint,
    theme character varying,
    questions integer[],
    hours smallint,
    literature integer[],
    id_theme integer
);
    DROP TABLE public.self;
       public         postgres    false    179    6            �            1259    16749    seminary    TABLE       CREATE TABLE seminary (
    id_disc integer,
    semester smallint,
    theme character varying,
    questions integer[],
    hours smallint,
    literature integer[],
    id_seminary integer DEFAULT nextval('id_sem'::regclass) NOT NULL,
    id_theme integer
);
    DROP TABLE public.seminary;
       public         postgres    false    180    6            �            1259    16756    sessions    TABLE     �   CREATE TABLE sessions (
    id_disc integer NOT NULL,
    session_data text,
    id integer DEFAULT nextval('id_session'::regclass)
);
    DROP TABLE public.sessions;
       public         postgres    false    181    6            �            1259    16763    themes_questions    TABLE     �   CREATE TABLE themes_questions (
    id_tq integer DEFAULT nextval('id_tq'::regclass) NOT NULL,
    name character varying(255),
    id_discipline integer,
    id_parent integer,
    types_id smallint[],
    num_tq integer
);
 $   DROP TABLE public.themes_questions;
       public         postgres    false    182    6            �            1259    16770    types    TABLE     �   CREATE TABLE types (
    id integer DEFAULT nextval('id_type'::regclass) NOT NULL,
    title character varying(100),
    key character varying(50)
);
    DROP TABLE public.types;
       public         postgres    false    183    6            G           2613    16449    16449    BLOB     &   SELECT pg_catalog.lo_create('16449');
 &   SELECT pg_catalog.lo_unlink('16449');
             postgres    false            H           2613    16450    16450    BLOB     &   SELECT pg_catalog.lo_create('16450');
 &   SELECT pg_catalog.lo_unlink('16450');
             postgres    false            I           2613    16451    16451    BLOB     &   SELECT pg_catalog.lo_create('16451');
 &   SELECT pg_catalog.lo_unlink('16451');
             postgres    false            J           2613    16452    16452    BLOB     &   SELECT pg_catalog.lo_create('16452');
 &   SELECT pg_catalog.lo_unlink('16452');
             postgres    false            K           2613    16478    16478    BLOB     &   SELECT pg_catalog.lo_create('16478');
 &   SELECT pg_catalog.lo_unlink('16478');
             postgres    false            L           2613    16479    16479    BLOB     &   SELECT pg_catalog.lo_create('16479');
 &   SELECT pg_catalog.lo_unlink('16479');
             postgres    false            +          0    16666    control_work_type 
   TABLE DATA               .   COPY control_work_type (id, name) FROM stdin;
    public       postgres    false    170   �T       -          0    16674 
   discipline 
   TABLE DATA               �   COPY discipline (id, semester, title, general_hours, lect_hours, lab_hours, pract_hours, sem_hours, self_hours, ind_hours, id_speciality, id_subspeciality) FROM stdin;
    public       postgres    false    172   �T       V           0    0    id_disc    SEQUENCE SET     .   SELECT pg_catalog.setval('id_disc', 4, true);
            public       postgres    false    171            W           0    0    id_ind    SEQUENCE SET     /   SELECT pg_catalog.setval('id_ind', 260, true);
            public       postgres    false    173            X           0    0    id_lab    SEQUENCE SET     /   SELECT pg_catalog.setval('id_lab', 197, true);
            public       postgres    false    174            Y           0    0    id_lab_structure    SEQUENCE SET     8   SELECT pg_catalog.setval('id_lab_structure', 41, true);
            public       postgres    false    197            Z           0    0    id_lect    SEQUENCE SET     0   SELECT pg_catalog.setval('id_lect', 314, true);
            public       postgres    false    175            [           0    0    id_lit    SEQUENCE SET     .   SELECT pg_catalog.setval('id_lit', 1, false);
            public       postgres    false    176            \           0    0    id_menu_item    SEQUENCE SET     4   SELECT pg_catalog.setval('id_menu_item', 1, false);
            public       postgres    false    195            ]           0    0    id_menus    SEQUENCE SET     0   SELECT pg_catalog.setval('id_menus', 75, true);
            public       postgres    false    194            ^           0    0 	   id_module    SEQUENCE SET     1   SELECT pg_catalog.setval('id_module', 76, true);
            public       postgres    false    177            _           0    0    id_pract    SEQUENCE SET     1   SELECT pg_catalog.setval('id_pract', 263, true);
            public       postgres    false    178            `           0    0    id_self    SEQUENCE SET     0   SELECT pg_catalog.setval('id_self', 191, true);
            public       postgres    false    179            a           0    0    id_sem    SEQUENCE SET     /   SELECT pg_catalog.setval('id_sem', 182, true);
            public       postgres    false    180            b           0    0 
   id_session    SEQUENCE SET     1   SELECT pg_catalog.setval('id_session', 2, true);
            public       postgres    false    181            c           0    0    id_tq    SEQUENCE SET     /   SELECT pg_catalog.setval('id_tq', 3803, true);
            public       postgres    false    182            d           0    0    id_type    SEQUENCE SET     .   SELECT pg_catalog.setval('id_type', 8, true);
            public       postgres    false    183            9          0    16703 
   individual 
   TABLE DATA               n   COPY individual (id_individual, id_disc, semester, theme, questions, hours, literature, id_theme) FROM stdin;
    public       postgres    false    184   .U       :          0    16710 
   laboratory 
   TABLE DATA               n   COPY laboratory (id_laboratory, id_disc, semester, theme, questions, hours, literature, id_theme) FROM stdin;
    public       postgres    false    185   W       E          0    16823    laboratory_structure 
   TABLE DATA               �   COPY laboratory_structure (id, discipline_id, theme, purpose, theory, execution_order, content_structure, requirements, individual_variants, literature, type, title) FROM stdin;
    public       postgres    false    196   �X       ;          0    16717    lection 
   TABLE DATA               e   COPY lection (id_lect, id_disc, semester, theme, hours, literature, questions, id_theme) FROM stdin;
    public       postgres    false    186   KY       <          0    16724 
   literature 
   TABLE DATA               !   COPY literature (id) FROM stdin;
    public       postgres    false    187   �[       =          0    16735 	   practical 
   TABLE DATA               h   COPY practical (id_pract, id_disc, semester, theme, questions, hours, literature, id_theme) FROM stdin;
    public       postgres    false    188   �[       >          0    16742    self 
   TABLE DATA               b   COPY self (id_self, id_disc, semester, theme, questions, hours, literature, id_theme) FROM stdin;
    public       postgres    false    189   �]       ?          0    16749    seminary 
   TABLE DATA               j   COPY seminary (id_disc, semester, theme, questions, hours, literature, id_seminary, id_theme) FROM stdin;
    public       postgres    false    190   q_       @          0    16756    sessions 
   TABLE DATA               6   COPY sessions (id_disc, session_data, id) FROM stdin;
    public       postgres    false    191   ya       A          0    16763    themes_questions 
   TABLE DATA               \   COPY themes_questions (id_tq, name, id_discipline, id_parent, types_id, num_tq) FROM stdin;
    public       postgres    false    192   b       B          0    16770    types 
   TABLE DATA               (   COPY types (id, title, key) FROM stdin;
    public       postgres    false    193   eb       M          0    0    BLOBS    BLOBS                                false   c       �           2606    16777    control_work_type_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY control_work_type
    ADD CONSTRAINT control_work_type_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.control_work_type DROP CONSTRAINT control_work_type_pkey;
       public         postgres    false    170    170            �           2606    16779    discipline_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY discipline
    ADD CONSTRAINT discipline_pkey PRIMARY KEY (id, semester);
 D   ALTER TABLE ONLY public.discipline DROP CONSTRAINT discipline_pkey;
       public         postgres    false    172    172    172            �           2606    16781    id_seminary 
   CONSTRAINT     T   ALTER TABLE ONLY seminary
    ADD CONSTRAINT id_seminary PRIMARY KEY (id_seminary);
 >   ALTER TABLE ONLY public.seminary DROP CONSTRAINT id_seminary;
       public         postgres    false    190    190            �           2606    16783    individual_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY individual
    ADD CONSTRAINT individual_pkey PRIMARY KEY (id_individual);
 D   ALTER TABLE ONLY public.individual DROP CONSTRAINT individual_pkey;
       public         postgres    false    184    184            �           2606    16785    laboratory_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY laboratory
    ADD CONSTRAINT laboratory_pkey PRIMARY KEY (id_laboratory);
 D   ALTER TABLE ONLY public.laboratory DROP CONSTRAINT laboratory_pkey;
       public         postgres    false    185    185            �           2606    16830    laboratory_structure_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY laboratory_structure
    ADD CONSTRAINT laboratory_structure_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.laboratory_structure DROP CONSTRAINT laboratory_structure_pkey;
       public         postgres    false    196    196            �           2606    16787    lections_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY lection
    ADD CONSTRAINT lections_pkey PRIMARY KEY (id_lect);
 ?   ALTER TABLE ONLY public.lection DROP CONSTRAINT lections_pkey;
       public         postgres    false    186    186            �           2606    16791    practical_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY practical
    ADD CONSTRAINT practical_pkey PRIMARY KEY (id_pract);
 B   ALTER TABLE ONLY public.practical DROP CONSTRAINT practical_pkey;
       public         postgres    false    188    188            �           2606    16793 	   self_pkey 
   CONSTRAINT     J   ALTER TABLE ONLY self
    ADD CONSTRAINT self_pkey PRIMARY KEY (id_self);
 8   ALTER TABLE ONLY public.self DROP CONSTRAINT self_pkey;
       public         postgres    false    189    189            �           2606    16795    sessions_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id_disc);
 @   ALTER TABLE ONLY public.sessions DROP CONSTRAINT sessions_pkey;
       public         postgres    false    191    191            �           2606    16797    themes_questions_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY themes_questions
    ADD CONSTRAINT themes_questions_pkey PRIMARY KEY (id_tq);
 P   ALTER TABLE ONLY public.themes_questions DROP CONSTRAINT themes_questions_pkey;
       public         postgres    false    192    192            �           2606    16799 
   types_pkey 
   CONSTRAINT     G   ALTER TABLE ONLY types
    ADD CONSTRAINT types_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.types DROP CONSTRAINT types_pkey;
       public         postgres    false    193    193            +      x������ � �      -   �   x�m���@C�3Ul���)�
R)�p�����B�쎘�#Y�l'1�F,���Ï_��s��΂�oq���s��A�ˎ�)&97b����'x��c%8*o�Q�b�5�7��X��iۨ�a�P�      9   �  x�U�M�[A��~gB���R_"�,g;�Mvޅ�=%���
��m������9}���/�{|���˦�5��j�MRo��f�}���z��u^r�wK���h@Z
Lj`���l) 6(��R@zb_f���A���9�̖"�4qk�e�Z��,o)Rz&��h)���ȜgR�Z��J�Eò�[�#6�l�)0�\�RS`���h���)0P�����b3i㳥�.g.�NL҉	ѐNotb�N��z�&6V6�N��4.�NX����F'�t�o:�U��	/�F'\z:��F'�t"dN'���Dxin:,�N��D�4:�3�d4:�H'�̹Hg4:�Vi�hX6�XbS�It:���\2:���7�tF�s�[��,�:��zNV��\ru:Qtʛ����DљB'Xvu:Sl�9Y�Δ��%����~��zݥc���=e�J��x�b���K�ҟv�?���=��=Ǽ>\����_F      :   �  x�U�;jCQD���b��j�M�J�6�&����gdc��1h`>>ܾ�G?��{?~�m����{~�{�}��f<4A�5�85�����y�m�<^��8o9/�gIa�!P�J
tj0.5���� m��������&���gj֥�,%�����ZI��ӹ���"B�N�()b��Dò6K��H��)Ю�h\Ҷ�@[7~m�LjLS�!5.�,M�.6=m���S�\�
���!�(t��N�&�E�ClmP�Đ��K�Љ���!�(tb�N̋NL�E�Slf�:1���(tb�N,�s�N:�fj.:��l�Klm�Љ%=��B'6�Ė97��B'�N���e�Љ-6��x�Ӥ�qI�tZ�)o
�tz�ӒN:-�V:!6��x��\�+�H:�MHgT:�t��	��J��M>'Q�t��\2�K~|�|=���If<�� �b�b�r�)2����I�������[??����Lr_�      E   ?   x�34�4�L������愁�M�^l��.l��A���.l���bÅ A ����=... m��      ;   (  x�m�=j�QDk���p5�&R�tkH��]��3c� ��������2�������|y�ѿ���˞U�ua���9	��j���k{}�M&v3�ɬ'�6b�c��d�S'��s|��g������&�+f��f��fRL�9f����1�lq��.��lq�	b.�-n��!�˦�"Sf�P��%1����s�L�&���,���A�l���$��"R���5[�n�4�,�0[�b�c`�H�L^��j;K�,�	gg��%;�e��Y�)Ƥ��{b�i�Ġ�W�Lc'�I1,��NL�̎1vbn�y�4vb�NL���i�Ĥ�XCL�5vb)fu��K=/Y�N��C;�؉M;��Nl�-c'�b�9)c'�zn^���8�zS�ig;qv3m'˖�G1����G=/Y�N\�	�)��������s{;q��dgg�g����v�MAl2��h;CvF�qvB1�g'��cg'�N�)�%��Dۙ�]�ٙ�Ɏqv�z&/9?.����=��1���)�zZ�T�Xq.3�W*n?���#�	���7�Ѷ瘏����I��      <      x������ � �      =   �  x�U���[ADc�o1ff�Q3?�h�M�8Sf���"n5!�z�0k��z���������?�������v��ޚ�Ҡ4[4I��5V���9��>��lr^<GKI��h��l)�P�C4��)6Y6��H���i)r����FK�I֭ˮ�R@l@��Z
HOp�e-�t�2'5�Rl+�ߚͲ+Z�-6�l����ssɅ��,:��LjvKq�4)�*{Z�#6�664���KZ��tb�hH�5:1P�-��F'��̲itb����5:1I'&DC:�щI:��h�l�KlV�4:���������pDC:��	#���N�z�&6Fot¤�qIot�I'\�4��N���β�脋M='��KO���D�Nț� ���DDiR4U�щ�zN�ә�3�dt:��7I:�әEg
�ɲ����s�NHOp��t��7 ���Dѹ�NT�N��zN�ӹ�������?_��t�$3���Ǐ�#+�lW����jW���	I��7�{����u]�'�|G      >   �  x�U���QD��oY��}���p�p�'�&3�w�f�C3��z��m�1�x>�����ハ����Y?��e;ޚY5����|k�Ks�/;�}ޯ3��<[K�a�IjfK�4��Ĥf�!6Q6�����i)r�!׭I��[�<�q�TY�)6Y6�)0�\���|Ѭ�|h
�&Dòn�&6F�-�-9sI_-�9�9���9Dò~Z�)6�l����srIotbF9�hH�7:�H'�M'V�mtb�͢�X�sqI4:�I'�̹H'�ث47��,�F'���itbK��%���!�82�!�ht�Ҹh�l�GlN�t:]z:�D�ӋN�9�tF�ӋN:�e��	���It:!=�%�Ӊ�S�) �N'��:�������It:Cz���%������K� ��=圯 )�*f��[J��Ѯ���&�7�1���q]�/�B�      ?   �  x�U�ˊ[AD��~K��T��*��d��w��{��u�1�t|�q���x��k�ُ�����/~�l��=��ʌg�de:3��Lf��x챷�؞�Y���x��-<�Ge���v&Ze���q��=�!-�����U�d�}g0*�vMZ��q¤�N#I��ȶ7d�4�Ē9��ʐii���̐YwIfJ�5��U8�8W�˙�ʐ�2i��5Ĺ�l�vܹI���ڶ�pzcF�D3e�wf�N�Z�'�؉^w��X�D�v�N7f�N�m'F��Ό؉q��81�N��Np,vb$7NOf�N�m'f��d:�N�Z�9�N̺3Hr���m'�pqN�6�);�LM�k���NX�$ib'|ۉ�M	�t��̔�A�.v5��jgw�d��A;�7�jg��(;A��v�ր8�v��IB��<�'�N��,;A�P;�XC��v�q'I���?�?���F�̗�c<��D�\M��/%.�i�IIz����4[ٞ^�~����0e|t      @   �   x�M���0�3{��5t(ݫ�K�bZ����dz���o��H�V�����,��ŐF։����#?3B�K�+�x�7{s0s4Gs���F_՗���@�P����W���P���H��gH�M�r�e�l�w��s���Jt      A   <   x�%ʱ�0B�fI��p�a�I�݃��?�$4n��(zU�;�u0i������|���      B   �   x�=���@��ۇ1��ilN��hb�`cmca|��@�>���Ga����73V��F�%_�F�Z����8��sX�h�<��D��鐦
Iv��a9�/hŒ��@3Ƕx��0qwhЫ8�Y,��B)�
^B��$�����D��'m�f�	���k�kZ�����qs      M   A@      x�          B@      x�          C@      x�          D@      x�          ^@      x�          _@      x�              