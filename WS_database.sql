CREATE DATABASE wildshop;

USE wildShop;

CREATE TABLE WS_basket
(
    id  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    date DATE                           NOT NULL
);

CREATE TABLE WS_user
(
    id_user        INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    basket_id INT                            NOT NULL,
    FOREIGN KEY (basket_id) REFERENCES ws_orders (id),
    user_name VARCHAR(80)                    NOT NULL,
    password  VARCHAR(80)                    NOT NULL,
    email     VARCHAR(80)                    NOT NULL,
    role      VARCHAR(80)                    NOT NULL,
    birthday  DATE                           NOT NULL
);

CREATE TABLE WS_sub_category
(
    id               INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name_sub_category VARCHAR(80)                    NOT NULL
);

CREATE TABLE WS_product
(
    id             INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    sub_category_id INT                            NOT NULL,
    FOREIGN KEY (sub_category_id) REFERENCES WS_sub_category (id_cat),
    name_product    VARCHAR(80)                    NOT NULL,
    price           FLOAT                          NOT NULL,
    description     TEXT                  NOT NULL,
    nbr_sale INT NULL

);

CREATE TABLE WS_category
(
    id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name_category VARCHAR(80)                    NOT NULL
);

INSERT INTO WS_category(name_category) VALUES ( 'water' );
INSERT INTO WS_category(name_category) VALUES ( 'earth' );
INSERT INTO WS_category(name_category) VALUES ( 'fire' );
INSERT INTO WS_category(name_category) VALUES ( 'wind' );
INSERT INTO WS_category(name_category) VALUES ( 'chemical' );
INSERT INTO WS_category(name_category) VALUES ( 'exterior' );
INSERT INTO WS_sub_category(name_sub_category) VALUES ( 'get_dressed' );
INSERT INTO WS_sub_category(name_sub_category) VALUES ( 'to_eat' );
INSERT INTO WS_sub_category(name_sub_category) VALUES ( 'take_shalter' );
INSERT INTO WS_sub_category(name_sub_category) VALUES ( 'to defend' );
INSERT INTO WS_sub_category(name_sub_category) VALUES ( 'orientation' );
INSERT INTO WS_sub_category(name_sub_category) VALUES ( 'survival_kit' );


INSERT INTO WS_product (sub_category_id_cat,name_product, description, price) VALUES
                                                                              (6,'Kit de premiers secours', 'Ce kit de survie représente le compromis ultime entre un équipement complet et qualitatif. Vous retrouverez tout le matériel nécessaire à votre autonomie dans la nature, sauvage ou même hostile.', 79.99),
                                                                              (5,'Lampe de poche solaire', 'La lampe torche est dotée de trois LED blanches puissantes. Laissez tomber vos prises électriques, vos câbles ou encore vos piles, grâce aux deux manières écologiques de recharger la lampe.

Avec sa manivelle, la lampe de poche dynamo constitue un classique indémodable : une minute de manivelle suffit à faire briller l\'ampoule pendant huit minutes. Mais l\'atout cette lampe réside dans son panneau solaire : il vous suffit de placer la cellule solaire en un lieu ensoleillé pour recharger la batterie ! Repliez la manivelle pour glisser la lampe dans votre poche de pantalon et l\'avoir toujours à portée de main.', 5.99),
                                                                              (2,'Nourriture en conserve', 'Variété de conserves, comme des légumes et des fruits', 5.99),
                                                                              (2,'Bouteille d\'eau filtrante', 'En voyageant à l\'étranger, il est souvent difficile de trouver de l\'eau potable. Même si l\'eau courante est disponible, elle peut ne pas être traitée et donc être dangereuse à boire directement. C\'est pourquoi il est important d\'avoir une gourde filtrante pour simplifier la vie. Les pores du filtre de la gourde sont inférieurs à 0,2 micron, ce qui permet d\'empêcher les bactéries, les parasites, les particules et la quasi-totalité des virus de passer à 99,99 %. De plus, la gourde contient du charbon actif qui peut capter les substances chimiques et les métaux contenus dans l\'eau. Ainsi, en utilisant une gourde filtrante, il est possible de boire de l\'eau en toute sécurité dans les endroits où l\'eau n\'est pas potable.', 39.99),
                                                                              (5,'Radio portable à manivelle', 'La radio de survie MIDLAND ER200 est une radio de survie à énergie autonome, fonctionnant à des températures extrêmes (-20 à 55 degrés), pouvant être rechargée de 3 manières différentes : par dynamo, par énergie solaire et par port USB.
', 49.99),
                                                                              (1,'Couverture de survie', 'Idéale pour préserver la température corporelle dans n''importe quel environnement, notre couverture de survie utilise un film aluminisé avancé, fait de fibres de polyester de polyéthylène aluminisé de 12 microns, initialement développé par la NASA, cela lui permet de refléter jusqu''à 90% de la chaleur du corps. Pratique à utiliser même en situation d''urgence, elle aide à prévenir rapidement du froid ou des chocs thermiques dans des conditions météorologiques extrêmes. Pliable, légère et réutilisable, vous pourrez l''importer dans votre sac à dos, votre voitures, votre trousse de premiers soins, que ce soit au camping, à la maison ou au travail. Notre couverture de Survie est imperméable, coupe-vent et pare-soleil, elle aide à bloquer la pluie, la neige et l''humidité pour vous sécher dans un environnement humide, froid et pluvieux. Son utilisation est presque illimitée : comme tentes, sacs à dos, imperméables, signaux d''urgence, stores, abris d''urgence, coussins de sac de couchage, tapis, tapis de camping, pare-brise, ceintures suspendues, collecteurs d''eau et conteneurs de fonte de neige… Ainsi, il vous sera simple d''apporter votre touche de confort durant vos bivouacs, randonnée, stage de survie, camping ou toutes autres activités de plein air. ', 9.99),
                                                                              (1,'Masque anti-poussière', 'Ce masque est composé d''un tissu filtrant non tissé soufflé par fusion et de 2 élastiques.
Il est efficace entre -10 et 50 degrés de température extérieure, sous un taux d''humidité inférieur à 90%.
Il filtre 95% des particules ayant un diamètre supérieur à 0,3 micron.
Il protège contre la poussière, les bactéries et les virus
Il est homologué KN95 et respecte la norme GB2626-2006KN95', 5.99),
                                                                              (5,'Pince multifonctions', 'Pratique et maniable, cette pince multifonctions est un outil essentiel. En toutes situations, elle vous apportera la solution, que ce soit pour un usage quotidien, à garder dans la voiture, à emporter dans le sac de rando ou pour la survie en pleine nature, cet outil sera votre meilleur allié! ', 7.99),
                                                                              (1,'Gilet réfléchissant', 'Nos gilets de signalisation en polyester jaune et orange sont conformes à la norme européenne EN20471. Avec 7 poches spacieuses - dont une avec une fenêtre pour les laissez-passer de chantier, etc. - pour les smartphones, les clés et les portefeuilles. ', 19.99),
                                                                              (4, 'Arbalète EK Archery Cobra R9','Dotez-vous de cette belle arbalète Cobra R9 d\'une puissance de 90 lbs ! Très facile à armer grâce à son levier inclus, la version Deluxe est livrée avec tout l’équipement nécessaire pour des séances de tir sur cible encore plus divertissantes : un viseur type réflexe pour plus de précision, une crosse réglable et une poignée pour un confort de tir optimal.',199.99),
                                                                              (4,'Fusil À Pompe Fabarm Martial Od Green','Fusil à pompe au design tactique avec sa crosse PRO FORCE dotée d\'une poignée pistolet.
Son traitement cerakote green apporte une touche militaire à ce fusil à pompe FABARM.
Équipé d\'un guidon à fibre optique, il dispose d\'un rail de fixation d\'optique de 21 mm. Il sera possible de monter un viseur point rouge pour faciliter l\'acquisition de cible.
Son système de ventilation du canon donne une apparence vintage et retro au MARTIAL
',1099.99),


                                                                              (5,'Lampe de poche tactique', 'Les nouvelles lampes de poches de la série XT de Klarus ne plaisantent pas, outils d’illumination haute précision, elles ont été développé en pensant à l’auto-défense et à l’utilisation tactique. Une partie de la gamme XT (Extrême tactique), qui inclus déjà les différents modèles de XT11 et XT12, accueille à présent la nouvelle XT1A qui est une vrai lampe tactique à porter tous les jours (EDC every day carry). Elle utilise 1 pile AA ou une batterie 14500, de taille maniable, elle est très facile à transporter dans une poche ou dans un sac.',62.99),
                                                                              (4,'Pied de biche', 'Traité thermiquement pour une durabilité accrue. Griffes polies et rayées pour retirer plus facilement les clous et lever les planches  ', 19.99),
                                                                              (1,'Sac à dos de survie', 'Le sac Alpin Twin est un sac à dos conçu pour les longues expéditions, disposant d\'une capacité de stockage de 110 litres.
Il est muni de deux grandes poches latérales détachables et d\'un grand compartiment central avec un espace réservé au linge sale.
Son système de portage rembourré et ses échafaudages métalliques dorsaux permettent d\'avaler les kilomètres tout en conservant un grand confort d\'utilisation.', 99.99),
                                                                              (6,'Kit de survie en plein air', 'Ce kit de survie catastrophe est un équipement indispensable pour survivre aux catastrophes. Il comprend une boîte de transport anti-choc et étanche, une lampe de poche LED, un bracelet paracorde avec boussole, un couvert multifonction, un sifflet puissant, une scie à fil, de la paracorde, une carte multifonction, une couverture de survie, un stylo tactique, des tournevis, des mousquetons, une compresse d\'alcool, un kit de pêche et un soufflet paille télescopique. Chaque élément a été soigneusement sélectionné pour offrir aux aventuriers une gamme complète d\'outils pratiques pour toutes les situations de survie. Compact et léger, cet équipement est facile à transporter dans votre poche ou votre sac à dos pour être paré à toute situation d\'urgence.', 49.99),
                                                                              (1,'Gants de protection', 'Pour protéger vos mains lors des combats contre les zombies', 24.99),
                                                                              (5,'Sifflet de survie', 'Pour signaler votre présence aux secours ou à d\'autres survivants', 4.99);




create table WS_product_category
(
    id          int auto_increment primary key NOT NULL,
    product_id  int not null,
    category_id int not null
);


INSERT INTO WS_product_category (product_id, category_id) VALUES (1,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (2,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (3,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (4,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (5,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (6,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (7,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (8,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (9,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (1,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (2,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (3,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (4,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (5,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (6,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (7,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (8,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (9,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (1,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (2,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (3,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (4,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (5,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (6,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (7,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (8,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (9,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (1,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (2,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (3,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (4,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (5,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (6,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (7,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (8,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (9,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (1,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (2,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (3,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (4,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (5,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (6,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (7,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (8,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (9,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (1,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (2,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (3,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (4,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (5,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (6,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (7,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (8,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (9,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (10,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (11,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (12,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (12,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (12,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (12,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (12,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (12,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (13,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (14,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (14,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (14,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (14,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (14,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (14,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (15,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (15,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (15,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (15,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (15,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (15,6);
INSERT INTO WS_product_category (product_id, category_id) VALUES (16,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (17,1);
INSERT INTO WS_product_category (product_id, category_id) VALUES (17,2);
INSERT INTO WS_product_category (product_id, category_id) VALUES (17,3);
INSERT INTO WS_product_category (product_id, category_id) VALUES (17,4);
INSERT INTO WS_product_category (product_id, category_id) VALUES (17,5);
INSERT INTO WS_product_category (product_id, category_id) VALUES (17,6);


alter table wildshop.WS_product
    add image varchar(40) not null;

update WS_product set  image= 'product01.png' where id =1;
update WS_product set  image= 'product02.png' where id =2;
update WS_product set  image= 'product03.png' where id =3;
update WS_product set  image= 'product04.png' where id =4;
update WS_product set  image= 'product05.png' where id =5;
update WS_product set  image= 'product06.png' where id =6;
update WS_product set  image= 'product07.png' where id =7;
update WS_product set  image= 'product08.png' where id =8;
update WS_product set  image= 'product09.png' where id =9;
update WS_product set  image= 'product10.png' where id =10;
update WS_product set  image= 'product11.png' where id =11;
update WS_product set  image= 'product12.png' where id =12;
update WS_product set  image= 'product13.png' where id =13;
update WS_product set  image= 'product14.png' where id =14;
update WS_product set  image= 'product15.png' where id =15;
update WS_product set  image= 'product16.png' where id =16;
update WS_product set  image= 'product17.png' where id =17;


create table wildshop.ws_order_content
(
    id               int auto_increment
        primary key,
    order_id         int          not null,
    product_id       int          not null,
    name_product     varchar(100) not null,
    product_quantity int          not null,
    price_per        float        not null,
    constraint order_id
        foreign key (order_id) references wildshop.ws_orders (id),
    constraint product_id
        foreign key (product_id) references wildshop.ws_product (id)
);

create table wildshop.ws_orders
(
    id         int auto_increment
        primary key,
    user_id    int      not null,
    order_date datetime not null,
    shipping   float    not null,
    total      float    not null,
    constraint user_id
        foreign key (user_id) references wildshop.ws_user (id)
);



