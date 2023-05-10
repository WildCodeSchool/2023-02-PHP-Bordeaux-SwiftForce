CREATE DATABASE wildshop;

USE wildshop;

create table WS_category
(
    id            int auto_increment
        primary key,
    name_category varchar(80) not null
);

create table WS_sub_category
(
    id_cat            int auto_increment
        primary key,
    name_sub_category varchar(80) not null
);

create table WS_product
(
    id                  int auto_increment
        primary key,
    sub_category_id_cat int          not null,
    name_product        varchar(80)  not null,
    price               float        not null,
    description         text         not null,
    nbr_sale            int          null,
    image               varchar(300) null,
    constraint ws_product_ibfk_1
        foreign key (sub_category_id_cat) references WS_sub_category (id_cat) on delete cascade
);

create table item
(
    id    int unsigned not null,
    title varchar(255) not null
)
    charset = latin1;

create table ws_orders
(
    id         int auto_increment primary key,
    user_id    int      not null,
    order_date datetime not null,
    shipping   float    not null,
    total      float    not null

);

create table ws_user
(
    id          int auto_increment
        primary key,
    basket_id   int         null,
    user_name   varchar(80) not null,
    WS_password varchar(80) not null,
    email       varchar(80) not null,
    role        varchar(80) null,
    birthday    date        not null

);
ALTER TABLE ws_user
    ADD constraint ws_user_ibfk_1
        foreign key (basket_id) references `ws_orders` (id) on delete cascade ;

ALTER TABLE ws_orders
    ADD constraint user_id
        foreign key (user_id) references ws_user (id) on delete cascade;

create table ws_order_content
(
    id               int auto_increment
        primary key,
    order_id         int          not null,
    product_id       int          not null,
    name_product     varchar(100) not null,
    product_quantity int          not null,
    price_per        float        not null,
    constraint order_id
        foreign key (order_id) references ws_orders (id) on delete cascade ,
    constraint product_id
        foreign key (product_id) references WS_product (id) on delete cascade
);

create table ws_wishlist
(
    id            int auto_increment
        primary key,
    product_id    int         not null,
    product_name  varchar(60) not null,
    product_image varchar(60) not null,
    product_price float       not null,
    user_id       int         not null
);

INSERT INTO wildshop.item (id, title) VALUES (1, 'Stuff');
INSERT INTO wildshop.item (id, title) VALUES (2, 'Doodads');

INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (200, 6, 'Kit de premiers secours', 79, 'Ce kit de survie représente le compromis ultime entre un équipement complet et qualitatif. Vous retrouverez tout le matériel nécessaire à votre autonomie dans la nature, sauvage ou même hostile.', null, 'product01.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (201, 5, 'Lampe de poche solaire', 5.99, 'La lampe torche est dotée de trois LED blanches puissantes. Laissez tomber vos prises électriques, vos câbles ou encore vos piles, grâce aux deux manières écologiques de recharger la lampe.

Avec sa manivelle, la lampe de poche dynamo constitue un classique indémodable : une minute de manivelle suffit à faire briller l\'ampoule pendant huit minutes. Mais l\'atout cette lampe réside dans son panneau solaire : il vous suffit de placer la cellule solaire en un lieu ensoleillé pour recharger la batterie ! Repliez la manivelle pour glisser la lampe dans votre poche de pantalon et l\'avoir toujours à portée de main.', null, 'product02.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (202, 2, 'Nourriture en conserve', 5.99, 'Variété de conserves, comme des légumes et des fruits', null, 'product03.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (203, 2, 'Bouteille d\'eau filtrante', 39.99, 'En voyageant à l\'étranger, il est souvent difficile de trouver de l\'eau potable. Même si l\'eau courante est disponible, elle peut ne pas être traitée et donc être dangereuse à boire directement. C\'est pourquoi il est important d\'avoir une gourde filtrante pour simplifier la vie. Les pores du filtre de la gourde sont inférieurs à 0,2 micron, ce qui permet d\'empêcher les bactéries, les parasites, les particules et la quasi-totalité des virus de passer à 99,99 %. De plus, la gourde contient du charbon actif qui peut capter les substances chimiques et les métaux contenus dans l\'eau. Ainsi, en utilisant une gourde filtrante, il est possible de boire de l\'eau en toute sécurité dans les endroits où l\'eau n\'est pas potable.', null, 'product04.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (204, 5, 'Radio portable à manivelle', 49.99, 'La radio de survie MIDLAND ER200 est une radio de survie à énergie autonome, fonctionnant à des températures extrêmes (-20 à 55 degrés), pouvant être rechargée de 3 manières différentes : par dynamo, par énergie solaire et par port USB.
', null, 'product05.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (205, 1, 'Couverture de survie', 9.99, 'Idéale pour préserver la température corporelle dans n\'importe quel environnement, notre couverture de survie utilise un film aluminisé avancé, fait de fibres de polyester de polyéthylène aluminisé de 12 microns, initialement développé par la NASA, cela lui permet de refléter jusqu\'à 90% de la chaleur du corps. Pratique à utiliser même en situation d\'urgence, elle aide à prévenir rapidement du froid ou des chocs thermiques dans des conditions météorologiques extrêmes. Pliable, légère et réutilisable, vous pourrez l\'importer dans votre sac à dos, votre voitures, votre trousse de premiers soins, que ce soit au camping, à la maison ou au travail. Notre couverture de Survie est imperméable, coupe-vent et pare-soleil, elle aide à bloquer la pluie, la neige et l\'humidité pour vous sécher dans un environnement humide, froid et pluvieux. Son utilisation est presque illimitée : comme tentes, sacs à dos, imperméables, signaux d\'urgence, stores, abris d\'urgence, coussins de sac de couchage, tapis, tapis de camping, pare-brise, ceintures suspendues, collecteurs d\'eau et conteneurs de fonte de neige… Ainsi, il vous sera simple d\'apporter votre touche de confort durant vos bivouacs, randonnée, stage de survie, camping ou toutes autres activités de plein air. ', null, 'product06.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (206, 1, 'Masque anti-poussière', 5, 'Ce masque est composé d\'un tissu filtrant non tissé soufflé par fusion et de 2 élastiques.
Il est efficace entre -10 et 50 degrés de température extérieure, sous un taux d\'humidité inférieur à 90%.
Il filtre 95% des particules ayant un diamètre supérieur à 0,3 micron.
Il protège contre la poussière, les bactéries et les virus
Il est homologué KN95 et respecte la norme GB2626-2006KN95', null, 'product07.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (207, 5, 'Pince multifonctions', 7.99, 'Pratique et maniable, cette pince multifonctions est un outil essentiel. En toutes situations, elle vous apportera la solution, que ce soit pour un usage quotidien, à garder dans la voiture, à emporter dans le sac de rando ou pour la survie en pleine nature, cet outil sera votre meilleur allié! ', null, 'product08.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (208, 1, 'Gilet réfléchissant', 19.99, 'Nos gilets de signalisation en polyester jaune et orange sont conformes à la norme européenne EN20471. Avec 7 poches spacieuses - dont une avec une fenêtre pour les laissez-passer de chantier, etc. - pour les smartphones, les clés et les portefeuilles. ', null, 'product09.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (209, 4, 'Arbalète EK Archery R9', 199, 'Dotez-vous de cette belle arbalète Cobra R9 d\'une puissance de 90 lbs ! Très facile à armer grâce à son levier inclus, la version Deluxe est livrée avec tout l’équipement nécessaire pour des séances de tir sur cible encore plus divertissantes : un viseur type réflexe pour plus de précision, une crosse réglable et une poignée pour un confort de tir optimal.', null, 'product10.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (210, 4, 'Fusil À Pompe Fabarm', 1099, 'Fusil à pompe au design tactique avec sa crosse PRO FORCE dotée d\'une poignée pistolet.Son traitement cerakote green apporte une touche militaire à ce fusil à pompe FABARM.Équipé d\'un guidon à fibre optique, il dispose d\'un rail de fixation d\'optique de 21 mm. Il sera possible de monter un viseur point rouge pour faciliter l\'acquisition de cible.Son système de ventilation du canon donne une apparence vintage et retro au MARTIAL', null, 'product11.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (211, 5, 'Lampe de poche tactique', 62.99, 'Les nouvelles lampes de poches de la série XT de Klarus ne plaisantent pas, outils d’illumination haute précision, elles ont été développé en pensant à l’auto-défense et à l’utilisation tactique. Une partie de la gamme XT (Extrême tactique), qui inclus déjà les différents modèles de XT11 et XT12, accueille à présent la nouvelle XT1A qui est une vrai lampe tactique à porter tous les jours (EDC every day carry). Elle utilise 1 pile AA ou une batterie 14500, de taille maniable, elle est très facile à transporter dans une poche ou dans un sac.', null, 'product12.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (212, 4, 'Pied de biche', 19.99, 'Traité thermiquement pour une durabilité accrue. Griffes polies et rayées pour retirer plus facilement les clous et lever les planches  ', null, 'product13.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (213, 1, 'Sac à dos de survie', 99.99, 'Le sac Alpin Twin est un sac à dos conçu pour les longues expéditions, disposant d\'une capacité de stockage de 110 litres.
Il est muni de deux grandes poches latérales détachables et d\'un grand compartiment central avec un espace réservé au linge sale.
Son système de portage rembourré et ses échafaudages métalliques dorsaux permettent d\'avaler les kilomètres tout en conservant un grand confort d\'utilisation.', null, 'product14.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (214, 6, 'Kit de survie en plein air', 49.99, 'Ce kit de survie catastrophe est un équipement indispensable pour survivre aux catastrophes. Il comprend une boîte de transport anti-choc et étanche, une lampe de poche LED, un bracelet paracorde avec boussole, un couvert multifonction, un sifflet puissant, une scie à fil, de la paracorde, une carte multifonction, une couverture de survie, un stylo tactique, des tournevis, des mousquetons, une compresse d\'alcool, un kit de pêche et un soufflet paille télescopique. Chaque élément a été soigneusement sélectionné pour offrir aux aventuriers une gamme complète d\'outils pratiques pour toutes les situations de survie. Compact et léger, cet équipement est facile à transporter dans votre poche ou votre sac à dos pour être paré à toute situation d\'urgence.', null, 'product15.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (215, 1, 'Gants de protection', 24.99, 'Pour protéger vos mains lors des combats contre les zombies', null, 'product16.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (216, 5, 'Sifflet de survie', 4.99, 'Pour signaler votre présence aux secours ou à d\'autres survivants', null, 'product17.png');





INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (50, 3, 'tente', 45, 'tente deux personnes', null, 'Capture d’écran 2023-04-12 à 18.19.18.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (112, 6, 'Eius omnis eius eius.', 226, 'Voluptate eos ut sed cupiditate eligendi eius amet. Adipisci facilis earum sed unde sed magnam facilis. Provident perferendis qui culpa tempore quisquam. Vero hic libero eum ducimus sed sed. Veritatis explicabo aut voluptas dignissimos.', null, 'png1.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (113, 6, 'Ut sed ipsa.', 642, 'Ratione repellat laborum fuga qui sint. Consequuntur est repudiandae esse quidem ducimus illum eos. Dolorem iusto aut eos neque qui. Velit incidunt vel nesciunt recusandae dolorum laboriosam eum repellat.', null, 'png5.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (114, 4, 'Incidunt magnam perspiciatis ea.', 876, 'Nisi a voluptates et. Doloremque maxime vero est ratione natus. Et natus quaerat dignissimos nulla minus iusto maxime voluptas. Iste rerum consequatur exercitationem omnis.', null, 'png20.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (116, 2, 'Hic explicabo accusamus error.', 10, 'Esse vitae illo ut porro. Sed magnam nesciunt voluptas nihil quia.', null, 'png42.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (117, 6, 'Voluptatem ducimus et.', 211, 'Distinctio occaecati atque saepe amet ipsam. Saepe tempora sequi ea minus quas. Animi ipsam qui neque asperiores in minus.', null, 'png3.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (119, 1, 'Vero et et.', 880, 'Accusantium eos libero hic non et a et. Qui magni similique fuga explicabo vel omnis eveniet. Magnam impedit est provident aut.', null, 'png53.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (120, 4, 'Autem consequatur sunt hic.', 576, 'Et dicta possimus quasi laudantium saepe et. Error aliquid ut est eligendi. Tenetur doloremque suscipit perspiciatis harum qui aliquam.', null, 'png18.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (122, 1, 'Omnis quos.', 84, 'Quia voluptates rerum fugiat modi perspiciatis. Ut consequuntur similique maxime enim. Perferendis id facilis neque voluptatibus. Enim provident error nobis ex amet aspernatur.', null, 'png51.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (123, 1, 'Maxime et aspernatur et eligendi.', 30, 'Corrupti voluptatum ut voluptas illum. Praesentium saepe similique ducimus. Sit est vel accusamus voluptatem sint repudiandae qui. Dolor autem saepe quis et dolores eum.', null, 'png50.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (124, 2, 'Architecto asperiores.', 33, 'Ut quidem explicabo excepturi voluptatem error. Magni nulla qui vero voluptatum cupiditate autem facilis. Sequi molestiae officiis placeat deleniti qui dicta rerum. Molestiae aliquid ut laborum ut nihil.', null, 'png46.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (125, 5, 'Voluptas alias eaque nesciunt.', 75, 'Qui reprehenderit omnis quis. Voluptatem aut est veniam quo aliquam. Qui quam repellendus fugiat modi unde fugiat officia. Temporibus quia sequi id omnis quod. Cupiditate et nulla animi deleniti non.', null, 'png29.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (126, 4, 'Distinctio sit.', 34, 'Repellat suscipit nam neque aut. Aperiam quod ratione iusto culpa ad qui sit velit. Eos ut qui explicabo sint harum sed id. Enim animi assumenda perspiciatis dolorem alias. Eos molestiae nulla quo rerum praesentium voluptatem ut.', null, 'png16.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (127, 1, 'Quidem nisi at nam.', 42, 'Animi saepe autem mollitia laboriosam non est facilis. Sunt voluptatem at ea iste. Iure asperiores esse est explicabo.', null, 'png49.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (128, 3, 'Blanditiis commodi nisi ea.', 97, 'Et aut atque nesciunt sunt. Excepturi suscipit asperiores est cumque vitae perferendis odio. Nulla odit vel quia ut. Consequuntur et voluptates qui tenetur.', null, 'png34.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (129, 1, 'Hic quia deserunt.', 48, 'Sint sunt aut rerum odit assumenda facilis laborum. Repellat incidunt recusandae aliquid eos repellat. Dolorum sit architecto est. Ut aut saepe explicabo ullam facilis nostrum maxime.', null, 'png48.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (130, 2, 'Qui iusto saepe.', 12, 'Sunt dolores quae eaque ducimus neque veniam. Porro rerum blanditiis expedita asperiores consequatur. Est rem minus non ex iste id.', null, 'png45.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (131, 4, 'Perferendis est sapiente.', 16, 'Dicta et doloribus illum autem aspernatur sint minus. Earum eius ut quia adipisci laudantium quidem molestias. Dolores rem rerum accusamus ut voluptas tempore.', null, 'png15.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (132, 5, 'Nesciunt dolorum explicabo.', 57, 'Odit eum aperiam harum ut. Placeat autem numquam assumenda modi voluptate. Ipsam accusamus doloribus aut velit ut qui est.', null, 'png28.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (133, 4, 'Fugit error qui voluptas.', 46, 'Ipsum aspernatur temporibus quisquam culpa neque nesciunt. Magnam laudantium rerum aut. Laudantium dolorem dolores incidunt autem quaerat autem ipsa sed. Atque dolor et nisi cupiditate.', null, 'png9.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (134, 5, 'Quaerat omnis reiciendis consequatur.', 27, 'Dolorem saepe nam libero voluptatem velit doloribus atque. Rerum qui molestiae accusantium accusamus et tempore. Voluptates officia similique soluta voluptatem sequi id.', null, 'png25.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (135, 3, 'Dolorem est voluptas.', 18, 'Quibusdam quia iusto ullam aut non quo. Similique et dolorem repellat. Et fugit quod omnis porro delectus ut provident.', null, 'png31.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (136, 5, 'Quas dolor ex.', 30, 'Error et ut non repudiandae accusantium corporis qui. Facilis est vero quia dolorem. Aperiam non unde et deleniti et. Eius sint aspernatur rerum quae vitae.', null, 'png23.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (137, 4, 'Delectus eos aut.', 25, 'Qui voluptatem id odit consequatur fuga voluptatem dolores. Quia assumenda quam distinctio repellat hic et alias. Animi sit error nesciunt.', null, 'png13.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (138, 4, 'Dolorem soluta deserunt minima.', 60, 'Soluta veniam rerum tempore sint earum magnam eligendi animi. Quia et est laborum quaerat commodi eum earum. Et cupiditate error sit dolores aut.', null, 'png14.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (139, 3, 'Iste accusamus in.', 93, 'Molestias deserunt voluptatem atque reiciendis a enim fugiat. Quibusdam omnis quod dignissimos sit alias laboriosam tenetur. Qui numquam necessitatibus tempora sed ullam odit similique. Mollitia molestias in adipisci iure ea. Rerum recusandae ullam repudiandae odio quia.', null, 'png32.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (140, 2, 'Qui voluptas laboriosam.', 22, 'Quia mollitia perferendis hic odit enim rem asperiores. In eveniet illo ea numquam neque. Harum magnam officiis iure odit quia.', null, 'png47.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (141, 2, 'Qui velit ipsam nihil.', 32, 'Ut dicta sit consequatur incidunt. Officia et fuga excepturi fuga. Sunt ad minima aut ratione consequuntur nostrum rerum voluptas. Consequatur nobis nulla unde placeat est tempora fuga natus.', null, 'png42.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (142, 6, 'Vitae impedit dolorum enim.', 32, 'Sit eligendi voluptates sunt quis dolore et optio. Accusantium voluptas culpa officia ullam et impedit. Sed omnis reiciendis sint molestias sunt. Excepturi fugit accusamus laudantium expedita eius.', null, 'png3.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (143, 4, 'Similique sit ea.', 95, 'Ducimus reiciendis sapiente numquam ea a. Aliquid consequatur earum et error omnis. Hic molestiae modi dignissimos quis eligendi nesciunt. Commodi consequatur praesentium quia eos.', null, 'png17.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (144, 4, 'Non deleniti dolorum.', 33, 'Consectetur et voluptatem sunt harum quia ratione. Rem soluta iusto ducimus necessitatibus esse aliquam. Ut aut sunt quia et reiciendis consequatur quis.', null, 'png10.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (145, 2, 'Blanditiis et.', 93, 'Dolores libero autem dolorum quibusdam velit et consequatur ullam. Quas ea earum temporibus velit voluptatem provident aliquam. Deserunt atque architecto qui temporibus. Laborum possimus esse iure aut nulla.', null, 'png44.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (146, 5, 'Qui velit perferendis.', 61, 'Non laboriosam labore molestias corrupti consequatur voluptatem dolor. Pariatur doloribus dolor consequatur omnis reiciendis molestias. Sed sed qui eveniet.', null, 'png29.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (147, 2, 'Eligendi deserunt.', 14, 'Dolores sequi deleniti quo mollitia minus ut est. Dicta consequatur sequi perspiciatis ut et. Et animi debitis sit ut. Magnam est vel ipsum dolorum dolores sed sit.', null, 'png43.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (148, 3, 'Velit fugiat ipsa ea.', 20, 'Doloremque labore maxime odit expedita a eos. Nihil labore ut ut rerum laudantium.', null, 'png36.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (149, 2, 'Non placeat totam neque.', 29, 'Ratione porro quo earum neque sint. Necessitatibus consequatur exercitationem dolore repellendus. Et sunt omnis possimus vero omnis vero maiores dolor. Provident sapiente sequi beatae quam autem.', null, 'png40.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (150, 6, 'Natus est eos.', 69, 'Autem molestiae est praesentium. Incidunt quod nihil explicabo aut sit repellat. Dolor dolorem reprehenderit qui est eligendi iusto et. Dolorem cupiditate vitae quo. Et expedita et earum vel aut fuga itaque ut.', null, 'png6.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (151, 4, 'Quod omnis ad aut.', 52, 'Maiores vero sit cum cum et. Illo dolores et quisquam modi.', null, 'png22.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (152, 5, 'Voluptatibus nobis sed veritatis.', 48, 'Accusantium dolores omnis laboriosam eveniet praesentium est. Eum quasi voluptas recusandae quibusdam quod debitis voluptatem est. Porro et ipsa ut nesciunt similique soluta voluptate.', null, 'png24.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (153, 2, 'Nam asperiores soluta dolores sint.', 80, 'Tenetur voluptates quae dicta ullam cum. Nesciunt et quos quidem consequuntur est. Animi quis totam beatae voluptatem. Quis voluptatem veniam reprehenderit et dicta iste.', null, 'png39.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (154, 1, 'Sunt ipsam distinctio animi.', 84, 'Pariatur minus aliquam tempore quae hic eligendi animi fugiat. Neque error incidunt mollitia animi.', null, 'png54.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (155, 4, 'Veritatis qui repudiandae.', 96, 'Quidem porro porro dignissimos in nobis qui sit. Non qui aperiam et quae voluptatem sed. Voluptatem unde ab iusto alias quas est illo. Ut nostrum iure dicta ipsa molestiae laborum.', null, 'png21.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (156, 5, 'Enim perferendis vitae.', 84, 'Est dolorem qui tenetur impedit minus. Quia id unde eligendi voluptatem tempore. Facilis aliquid eum dolores est magni.', null, 'png26.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (157, 3, 'Voluptatem est et.', 27, 'Dolores nesciunt possimus sed aspernatur laudantium. Soluta architecto totam illum incidunt quam. Omnis unde nostrum perferendis illo soluta. Repellendus atque et aspernatur est.', null, 'png32.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (158, 5, 'Deserunt illum sit.', 15, 'Sed et totam nesciunt maxime rerum et ipsam. Aut quidem asperiores qui quia veniam vel ut. Dolore voluptate soluta architecto qui suscipit culpa.', null, 'png27.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (159, 4, 'Dolores at facilis.', 98, 'Qui dolor illo adipisci. Quia nam consequuntur eum consequatur enim consequatur. Laboriosam omnis eos maiores sed quia corporis quibusdam.', null, 'png19.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (160, 6, 'Laboriosam aperiam qui exercitationem.', 78, 'Voluptatibus voluptatem rem inventore non excepturi eaque enim. Iste ullam ut ut veniam. Natus nobis velit error soluta voluptas delectus aut.', null, 'png2.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (161, 2, 'Velit ullam corporis.', 80, 'Voluptas et modi velit ea eos. Recusandae fuga omnis id eum quia. Nobis vero sunt blanditiis sapiente laboriosam. Sed iusto quaerat sunt iste.', null, 'png37.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (162, 5, 'Quia ut.', 54, 'Consequuntur officiis neque ab labore. Nesciunt quam dolorem ut eos autem aut eos. Molestiae perferendis accusamus blanditiis nulla quod. Illum consectetur illo maiores provident molestias voluptatem quo.', null, 'png23.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (163, 6, 'Quasi maiores ut iste.', 59, 'Voluptates sed ut fugit at impedit. Sint quo soluta voluptatem quasi sequi. Sit magni ut aspernatur totam.', null, 'png7.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (164, 5, 'Delectus corporis consectetur.', 45, 'Dolorem quidem vitae voluptatem eos incidunt perferendis tenetur. Illo repellat consequatur ut praesentium dolorum quia.', null, 'png24.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (165, 6, 'Molestiae quae est.', 33, 'Tempore qui veniam hic enim ipsa aspernatur. Et natus doloremque dolor. Illo temporibus est aliquid magnam.', null, 'png6.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (166, 6, 'Ducimus aut voluptas eum.', 99, 'Commodi qui a odit quis quasi nihil. Ut et quod deleniti consequuntur et at aut. Temporibus consequatur rerum magni voluptates cupiditate.', null, 'png5.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (167, 5, 'Dolor culpa.', 87, 'Atque dignissimos amet laboriosam. Culpa non reprehenderit sunt repellat. Esse voluptas autem delectus est. Nemo maiores id incidunt placeat. Nulla minima aut tenetur minima.', null, 'png27.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (168, 6, 'Facilis alias assumenda aliquid.', 21, 'Placeat ex hic enim deleniti. Qui placeat et aut excepturi dolorem voluptas dolores. Maiores esse quas et facere quasi.', null, 'png4.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (169, 6, 'Culpa in aut.', 88, 'Sed quia sequi harum error vel est. Ad quo laborum vitae ab. Corrupti reiciendis et neque recusandae modi tempora cumque.', null, 'png2.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (170, 5, 'Ipsum sint repudiandae.', 32, 'Ipsa nemo quam sed neque soluta id. Quo numquam esse maiores. Vel est deleniti ea sunt est aut quis. Autem ullam minima quibusdam nesciunt quaerat et inventore.', null, 'png30.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (171, 5, 'Aut ut id et eligendi.', 28, 'Reprehenderit tempora perspiciatis dolores accusamus. Neque deleniti non at incidunt. Sapiente expedita animi eos vel dignissimos cum corporis. Saepe et qui incidunt consectetur asperiores sint officia.', null, 'png23.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (172, 6, 'Illum quia placeat.', 62, 'Quo quod ut recusandae nemo. Delectus quaerat quis dolorem et. Aut consectetur vero et tempora corrupti. Explicabo ex dolorem qui eos. Vel rerum doloribus modi quia quasi aspernatur et.', null, 'png1.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (173, 5, 'Maxime maxime aperiam enim.', 71, 'Modi quaerat a molestias dolor hic occaecati voluptates saepe. Officia quis neque aliquam ipsum autem. Vel fugit ullam reprehenderit iste nemo. Veritatis quis est praesentium nostrum. Minima qui et fugiat qui quis.', null, 'png24.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (174, 5, 'Molestiae qui nobis.', 65, 'Atque corporis architecto ut est sapiente dolorum sunt. Eaque autem ad assumenda excepturi iusto exercitationem distinctio. Doloribus necessitatibus beatae quia et sequi.', null, 'png25.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (175, 2, 'Eum minima blanditiis facilis.', 80, 'Sed quia nostrum magnam. Inventore maxime quia illo mollitia fugiat. Omnis consequuntur consectetur ut rerum ducimus. Nihil ad ut ea non.', null, 'png38.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (176, 3, 'Perferendis accusamus animi inventore.', 91, 'Neque sint dolore est molestiae officia est. Ut omnis at in. Consequuntur minus accusamus animi. Molestias accusamus praesentium quaerat excepturi quidem sunt fuga.', null, 'png31.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (177, 3, 'Omnis sit molestias.', 45, 'Neque deserunt architecto porro vero tempora quas. Architecto in maiores qui maxime reiciendis vitae suscipit. Dolorem natus sed reiciendis voluptatem et commodi. Eligendi voluptates voluptate id voluptatem ut officiis assumenda.', null, 'png35.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (178, 5, 'Nemo neque aut consequatur.', 57, 'Et nesciunt amet quis qui. Perspiciatis non quo id vel. Et dolorem cum maxime qui est iusto.', null, 'png28.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (179, 5, 'Facilis sapiente non.', 38, 'Iusto mollitia voluptatem exercitationem aut dolor voluptatibus. Perferendis sed quia nam incidunt quia non est. Vel consequatur est accusantium inventore nisi qui et. Quia illum architecto facilis tempora impedit quas sit.', null, 'png26.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (180, 5, 'Quo laboriosam non.', 92, 'Ex voluptas culpa nihil ducimus. Alias voluptates temporibus aut voluptatem voluptates pariatur incidunt repudiandae.', null, 'png25.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (181, 4, 'Voluptas harum eos.', 12, 'Harum sed cupiditate ducimus. Voluptatem voluptatum sapiente voluptas maxime. Ipsum aut quia distinctio fugit. Non non eius aut aperiam aut sunt.', null, 'png12.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (182, 5, 'Excepturi aut incidunt.', 55, 'Eum perspiciatis velit magni dicta autem corrupti. Totam exercitationem libero quis possimus amet. Vero voluptatem quibusdam tempore excepturi illum.', null, 'png30.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (183, 6, 'Beatae pariatur ad.', 9, 'Suscipit quia quia animi ea ea et qui. Omnis sint dolore est et aut dignissimos et. Aliquid non aut nobis omnis itaque quisquam. At aliquid sed nobis culpa qui molestiae doloremque.', null, 'png4.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (184, 1, 'Eos expedita maiores eaque consectetur.', 41, 'Quo illum asperiores ducimus error ea quod. Quas id nesciunt cum. Quia tenetur explicabo ut placeat excepturi omnis. Dicta dolorem omnis earum corrupti et consectetur consequuntur.', null, 'png52.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (185, 4, 'Eveniet nam sit eos velit.', 99, 'Quisquam sint maiores molestias voluptatem quidem. Consequatur temporibus corrupti quidem quod quis suscipit. Veniam distinctio facere rerum non ipsa aut quae.', null, 'png11.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (186, 2, 'Delectus est commodi et.', 42, 'Voluptates qui sunt consequatur nostrum ut eos. Ab qui eligendi nihil voluptas. In sed quos doloremque nesciunt. Voluptate nihil omnis repellendus nihil aliquam. Rerum optio aliquid autem in ut.', null, 'png45.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (187, 6, 'Ut sit sed dicta.', 51, 'Adipisci in aut sequi quo nostrum ipsum dignissimos corporis. Ut mollitia consectetur sit distinctio velit aut. Magni cumque amet soluta ut. Voluptas laborum incidunt dolorem sit.', null, 'png3.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (188, 3, 'Eius voluptatibus dolorem.', 26, 'Laborum et qui dolorum ut adipisci. Rerum sunt sed rerum quis voluptas assumenda quas. Distinctio totam enim odit sed et ratione ipsam.', null, 'png33.jpeg');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (189, 1, 'sac étanche big river 65L', 89.95, 'Le sac étanche Sea to Summit Big River de 65 litres est fabriqué en nylon résistant à l\'eau et à l\'abrasion, avec un design minimaliste et polyvalent, il est indispensable pour garder votre équipement au sec, et vous pouvez le porter confortablement sur votre dos. Poignées faciles à saisir, fermeture supérieure à enroulement résistante à l\'humidité et bandoulière réglable.', null, 'product19.png');
INSERT INTO wildshop.WS_product (id, sub_category_id_cat, name_product, price, description, nbr_sale, image) VALUES (190, 4, 'Adler Yankee Hatchet, vert-noir', 69, 'L\'Adler Yankee Hatchet vous accompagnera lors de toutes vos aventures. Cette hache est inspirée des hachettes typiques américaines, avec une tête plus large et plus lourde que les haches allemandes. Le tranchant est également plus fin et aiguisé. C\'est parfait pour se frayer un chemin dans la forêt. Cette hache a été entièrement fabriquée en Allemagne. Elle est livrée avec un étui de rangement en cuir.', null, 'product20.png');

create table ws_promotions
(
    id        int auto_increment
        primary key,
    name      varchar(60) not null,
    reduction float       not null,
    seuil     int         not null
);

INSERT INTO wildshop.ws_promotions (id, name, reduction, seuil) VALUES (1, 'BIENVENUE', 15, 150);

INSERT INTO wildshop.WS_category (id, name_category) VALUES (1, 'water');
INSERT INTO wildshop.WS_category (id, name_category) VALUES (2, 'earth');
INSERT INTO wildshop.WS_category (id, name_category) VALUES (3, 'fire');
INSERT INTO wildshop.WS_category (id, name_category) VALUES (4, 'wind');
INSERT INTO wildshop.WS_category (id, name_category) VALUES (5, 'chemical');
INSERT INTO wildshop.WS_category (id, name_category) VALUES (6, 'exterior');

INSERT INTO wildshop.WS_sub_category (id_cat, name_sub_category) VALUES (1, 'get_dressed');
INSERT INTO wildshop.WS_sub_category (id_cat, name_sub_category) VALUES (2, 'to_eat');
INSERT INTO wildshop.WS_sub_category (id_cat, name_sub_category) VALUES (3, 'take_shelter');
INSERT INTO wildshop.WS_sub_category (id_cat, name_sub_category) VALUES (4, 'to defend');
INSERT INTO wildshop.WS_sub_category (id_cat, name_sub_category) VALUES (5, 'orientation');
INSERT INTO wildshop.WS_sub_category (id_cat, name_sub_category) VALUES (6, 'survival_kit');
