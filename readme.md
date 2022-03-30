*************************************************** CONCEPTION ET MISE EN PLACE ***************************************************


s'inscrire : admin, customer

# Entités
   Créer d'abord les entités qui ne dépendent pas d'entités pas encore créées (dans la mesure du possible). Lorsque cela n'est pas possible, laisser de côté le champs qui dépend d'une autre entité et revenir dessus une fois que l'entity dont il depend est créée.
   EX: Si le champs a de l'entité A est une relation avec l'entité B qui n'est pas encore créée, Créer l'entité A sans le champs a. Créer ensuite complétement l'entité B puis revenir sur l'entité A (make:entity) pour créer le champs a.

 - User
    - email (string)
    - password (string)
    - role : Json (?)
    - favorites : Items [] (later)
    - customerProfile : CustomerProfile (auto-créa)
    - bookings : Booking (auto-créa)

 - CustomerProfile
    - customer : User
    - phone : (int, nullable)
    - address : Address [] (nullable) (later)

 - ItemCategory
    - name (string)
    - items : Item (auto-créa)

 - Unavailability
    - unavailableFrom (date)
    - unavailableUntil (date) 
    - quantity (int)
    - item : Item (auto-créa)

 - Item
    - name (string)
    - details (string)
    - price (float)
    - img 1 (string) (à la fin)
    - img 2 (string) (à la fin)
    - img 3 (string) (à la fin)
    - alt 1 (string) (à la fin)
    - alt 2 (string) (à la fin)
    - alt 3 (string) (à la fin)
    - category : ItemCategory
    - quantityInStock (int)
    - unavailability : Unavailability [] (nullable)
    - requestedItems : RequestedItem (auto-créa)
    - decorationServiceItems : NeededItems[] (auto-créa)
    >>> ajouter la propriété favoris dans l'entité User


 - RequestedItem
    - item : Item
    - quantity (int)
    - requestedFrom (date)
    - requestedUntil (date)
    - booking : Booking (auto-créa)

 - Booking
    - customer : User
    - details : RequestedItem []
    - total (float)
    - withDelivery (boolean)
    - address : Address
    - initialPayment (boolean)
    - fullPayment (boolean)
    - securityDepositIsPaid (boolean)
    - securityDepositIsReturned (boolean)
    - bookedAt (datetime -> remplacé par datetime_immutable)
    - reference
 
 - Address
    - addressLine1
    - addressLine2
    - zipCode
    - city
    - floor (int)
    - lift (boolean)
    - country
    - customerProfile (auto-créa)
    - bookings [] : Booking (auto-créa)
    >>> ajouter la propriété address dans l'entité CustomerProfile et copier le update CustomerProfile dans le Readme
    >>> ajouter la propriété address dans l'entité Booking et copier le update Booking dans le Readme.
    

 - InspirationCategory 
    - name
    - inspirations : Inspiration [] (auto-créa)

 - Inspiration
    - title
    - description (text)
    - price (float)
    - img 1
    - img 2
    - img 3
    - alt 1
    - alt 2
    - alt 3
    - video
    - items : Item []
    - category : InspirationCategory 

 - QuoteRequest
    - firstname
    - lastname
    - email
    - phone
    - eventType
    - eventStarts (datetime)
    - eventEnds (datetime)
    - outdoors (boolean)
    - hostingPlace
    - eventAddress (string) 
    - placeImg1 (file)
    - placeImg2 (file)
    - placeImg3 (file)
    - theme (string)
    - colourCode (string)
    - inspiration : Inspiration
    - decorationModel1 (file)
    - decorationModel2 (file)
    - decorationModel3 (file)
    - nbrOfGuests (int)
    - nbrOfTables (int)
    - itemsAlreadyAvailable (text)
    - photoCorner (boolean)
    - Minbudget
    - Maxbudget
    - message (text)
    - itemsNeeded : Items []  (j'aurais du le lier a Needed items et pas à Items -> J'ai effacé ce qui est relatif à cet ajout dans les 2 tables)
    - agreedPrice
    - isValidated (boolean)
    - initialPayment (boolean)
    - fullPayment (boolean)
    - reference
    - neededItems : NeededItems[] (auto-créa) (créer pour remplacer itemsNeeded)

 - NeededItem
    - item : Item
    - quantity (int)
   



*************************************************** ALGORITHME ***************************************************


https://excalidraw.com/#json=XhWfxCi3_CIVQRs_MMREd,KxRjmoz6GkiGHJwKZCGzoA

# exemple : 

Item
- name : nappe dentelle
- category : nappes
- quantityInStock : 8
- unavailability : []

Unavailability
- unavailableFrom : 8/11/2022
- unavailableUntil : 9/11/2022  --------- plugin carbon ou fonction php date_dif ou datetime --------
- quantity : 3
- item : nappe dentelle

06/09    Requested.date n'existe pas dans Unavailable.date
7X       Requested.quantity < ou = Item.quantityInStock 
         => DISPO 

12/09    Requested.date n'existe pas dans Unavailable.date
X10      Requested.quantity n'est pas < ou = Item.quantityInStock 
         => PAS DISPO (seulement "Item.quantityInStock" est/sont dispo(s))   

06/09    Requested.date existe dans Unavailable.date
X2       Requested.quantity n'est pas < ou = Item.quantityInStock - la somme des Unavailable.quantity pour Requested.date 
         => PAS DISPO (seulement "quantityInStock - la somme des Unavailable.quantity pour la même Unavailable.date" est/sont dispo(s) pour vos dates)   


06/09    Requested.date existe dans Unavailable.date
X1       Requested.quantity < ou = quantityInStock - la somme des Unavailable.quantity pour la même Unavailable.date et même item
         => DISPO  

# Algo Diponibilité

if Requested.date n'est pas dans Unavailable.date de cet item
    verifier if Requested.quantity < ou = Item.quantityInStock => DISPO 
    else PAS DISPO (afficher : seulement Item.quantityInStock sont dispo)
else
    vérifier if Requested.quantity < ou = quantityInStock - somme(Unavailable.quantity qui ont même date et même item) => DISPO
    else PAS DISPO (afficher : seulement "quantityInStock - la somme des Unavailable.quantity pour la même Unavailable.date" est/sont dispo(s) pour vos dates)   


# Algo blocage des dates
Gérer les dates
- nombres de sec depuis 1970 ?? 
   ou
- Enregistrer les dates au format yyyymmdd
Bloquer les dates entre le from et le to compris
A chaque paiement d'acompte ajouter les dates au Unavailable avec le nombre de produits réservés
Ne libérer que les dates de NOW à NOW+365
Quand Unavailable.date existe déjà pour le item réservé editer le Unavalable.quantité en faisant + new quantity (pour ne pas créer un nouvel objet mais juste updater la quantity existante)



*************************************************** INSTALLATION ***************************************************



## 1 Terminal : 
    - installer dernière version par défault : 
       - symfony new dydream_decor --full  (cest quoi full ???)
    - installer une version en particulier : 
       - symfony new my_project_name --version=X.X
       - composer create-project symfony/skeleton my_project_name "X.X.*"  (version choisie. * sur windows et rien sur mac)
   - SOLUTION pour utiliser --full (pour qu'il nous installe tout les packages) et choisir la version : symfony new mytestproject --version=5.4 --full


2 Placer le dossier dans MAMP > htdocs > 
3 .env : configurer la bdd : DATABASE_URL="mysql://root:root@127.0.0.1:8889/dydream_decor?serverVersion=5.7"
4 Templates > base.html.twig : 
    - configurer bootstrap : css (head) et js (body)
    - configurer fontawsome : cdn js > premier lien : (head)
5 Config > Packages > twig.yaml : configurer twig ligne 3 : 
    - Ajouter un sytle pour les forms : form_themes: ['bootstrap_5_layout.html.twig']
6 Vérifier le fonctionnement : 
    - Terminal : symfony serve 
    _ Navigateur : localhost:8888/chemin_vers_le_dossier/public/
    _ VERSION 5.4.1

*************************************************** MAKE ***************************************************
## USER 
   - php bin/console make:user
   - The name of the security user class (e.g. User) [User]:
   > (ENTER)
   - Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
   > (ENTER)
   - Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
   > (ENTER)
   - Will this app need to hash/check user passwords? Choose No if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).
   Does this app need to hash/check user passwords? (yes/no) [yes]:
   > (ENTER)
   >>> created: src/Entity/User.php
   >>> created: src/Repository/UserRepository.php
   >>> updated: src/Entity/User.php
   >>> updated: config/packages/security.yaml
- On ne crée pas encore la propriété favorites car on n'a pas encore créé l'entité Item
- Une fois l'entité Item créée, on update l'entité User pour y ajouter la propriété favorites :
- php bin/console make:entity User (et surtout pas php bin/console make:user)
- Your entity already exists! So let's add some new fields!
--- New property name (press <return> to stop adding fields):
   # favorites
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > Item
   - What type of relationship is this?  
   > ManyToMany : 
                  - Each User can relate to (can have) many Item objects.
                  - Each Item can also relate to (can also have) many User objects  
   - Do you want to add a new property to Item so that you can access/update User objects from it - e.g. $item->getUsers()? (yes/no) [yes]:
   > no
   >>> updated: src/Entity/User.php

## REGISTER et LOGIN 
## ENTITIES
   *** CustomerProfile ***
   - php bin/console make:entity CustomerProfile
   --- New property name (press <return> to stop adding fields):
   # customer
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > User
   - What type of relationship is this?
   > OneToOne :
               - Each CustomerProfile relates to (has) exactly one User.
               - Each User also relates to (has) exactly one CustomerProfile.
   - Is the CustomerProfile.customer property allowed to be null (nullable)? (yes/no) [yes]:
   > no
   - Do you want to add a new property to User so that you can access/update CustomerProfile objects from it - e.g. $user->getCustomerProfile()? (yes/no) [no]:
   > yes
   --- A new property will also be added to the User class so that you can access the related CustomerProfile object from it.
   # New field name inside User [customerProfile]:
   > (ENTER)
   --- New property name (press <return> to stop adding fields):
   # phone
   - Field type (enter ? to see all types) [string]:
   > integer
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > yes

   >>> created: src/Entity/CustomerProfile.php
   >>> created: src/Repository/CustomerProfileRepository.php
   >>> updated: src/Entity/CustomerProfile.php
   >>> updated: src/Entity/User.php (X2)
   
   - php bin/console make:entity CustomerProfile
   - Your entity already exists! So let's add some new fields!
   --- New property name (press <return> to stop adding fields):
   # address
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > Address
   - What type of relationship is this?
   > OneToMany :
                  - Each CustomerProfile can relate to (can have) many Address objects.           
                  - Each Address relates to (has) one CustomerProfile 
   --- A new property will also be added to the Address class so that you can access and set the related CustomerProfile object from it.
   # New field name inside Address [customerProfile]:
   > (ENTER)
   - Is the Address.customerProfile property allowed to be null (nullable)? (yes/no) [yes]:
   > no
   - Do you want to activate orphanRemoval on your relationship?
   A Address is "orphaned" when it is removed from its related CustomerProfile.
   e.g. $customerProfile->removeAddress($address)
   NOTE: If a Address may *change* from one CustomerProfile to another, answer "no".
   Do you want to automatically delete orphaned App\Entity\Address objects (orphanRemoval)? (yes/no) [no]:
   > (ENTER) 


   *** ItemCategory ***
   - php bin/console make:entity ItemCategory
   --- New property name (press <return> to stop adding fields):
   # name
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   >>> created: src/Entity/ItemCategory.php
   >>> created: src/Repository/ItemCategoryRepository.php
   >>> updated: src/Entity/ItemCategory.php

   *** Unavailability ***
   - php bin/console make:entity Unavailability
   --- New property name (press <return> to stop adding fields):
   # unavailableFrom
   - Field type (enter ? to see all types) [string]:
   > date
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)  
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # unavailableUntil
   - Field type (enter ? to see all types) [string]:
   > date
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # quantity
   - Field type (enter ? to see all types) [string]:
   > integer
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   >>> created: src/Entity/Unavailability.php
   >>> created: src/Repository/UnavailabilityRepository.php
   >>> updated: src/Entity/Unavailability.php (X3)

   *** Item ***
   - php bin/console make:entity Item
   --- New property name (press <return> to stop adding fields):
   # name
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # details
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # price
   - Field type (enter ? to see all types) [string]:
   > float
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # category
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > ItemCategory
   - What type of relationship is this?
   > ManyToOne :
                  - Each Item relates to (has) one ItemCategory.                            
                  - Each ItemCategory can relate to (can have) many Item objects   
   - Is the Item.category property allowed to be null (nullable)? (yes/no) [yes]:
   > no
   - Do you want to add a new property to ItemCategory so that you can access/update Item objects from it - e.g. $itemCategory->getItems()? (yes/no) [yes]:
   > (ENTER)
   --- A new property will also be added to the ItemCategory class so that you can access the related Item objects from it.
   # New field name inside ItemCategory [items]:
   > (ENTER)
   - Do you want to activate orphanRemoval on your relationship?
   A Item is "orphaned" when it is removed from its related ItemCategory. 
   e.g. $itemCategory->removeItem($item)
   NOTE: If a Item may *change* from one ItemCategory to another, answer "no".
   Do you want to automatically delete orphaned App\Entity\Item objects (orphanRemoval)? (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # quantityInStock
   - Field type (enter ? to see all types) [string]:
   > integer
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # unavailability
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > Unavailability
   - What type of relationship is this?
   > OneToMany :
               - Each Item can relate to (can have) many Unavailability objects.           
               - Each Unavailability relates to (has) one Item  
   --- A new property will also be added to the Unavailability class so that you can access and set the related Item object from it.
   # New field name inside Unavailability [item]:
   > (ENTER)
   - Is the Unavailability.item property allowed to be null (nullable)? (yes/no) [yes]:
   > no
   - Do you want to activate orphanRemoval on your relationship?
   A Unavailability is "orphaned" when it is removed from its related Item.
   e.g. $item->removeUnavailability($unavailability)
   NOTE: If a Unavailability may *change* from one Item to another, answer "no".
   Do you want to automatically delete orphaned App\Entity\Unavailability objects (orphanRemoval)? (yes/no) [no]:
   > yes
   >>> created: src/Entity/Item.php
   >>> created: src/Repository/ItemRepository.php
   >>> updated: src/Entity/Item.php (X6)
   >>> updated: src/Entity/ItemCategory.php
   >>> updated: src/Entity/Unavailability.php           

 
   *** RequestedItem ***
   - php bin/console make:entity RequestedItem
   --- New property name (press <return> to stop adding fields):
   # item
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > Item
   - What type of relationship is this?
   > ManyToOne :
                  - Each RequestedItem relates to (has) one Item.
                  - Each Item can relate to (can have) many RequestedItem objects
   - Is the RequestedItem.item property allowed to be null (nullable)? (yes/no) [yes]:
   > no
   - Do you want to add a new property to Item so that you can access/update RequestedItem objects from it - e.g. $item->getRequestedItems()? (yes/no) [yes]:
   > (ENTER)
   --- A new property will also be added to the Item class so that you can access the related RequestedItem objects from it.
   # New field name inside Item [requestedItems]:
   > (ENTER)       
   - Do you want to activate orphanRemoval on your relationship?
   A RequestedItem is "orphaned" when it is removed from its related Item.
   e.g. $item->removeRequestedItem($requestedItem)
   NOTE: If a RequestedItem may *change* from one Item to another, answer "no".
   Do you want to automatically delete orphaned App\Entity\RequestedItem objects (orphanRemoval)? (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # quantity
   - Field type (enter ? to see all types) [string]:
   > integer
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # requestedFrom
   - Field type (enter ? to see all types) [string]:
   > date
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)  
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # requestedUntil
   - Field type (enter ? to see all types) [string]:
   > date
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   >>> created: src/Entity/RequestedItem.php
   >>> created: src/Repository/RequestedItemRepository.php
   >>> updated: src/Entity/RequestedItem.php (X4)
   >>> updated: src/Entity/Item.php

   *** Booking ***
   - php bin/console make:entity Booking
   --- New property name (press <return> to stop adding fields):
   # customer
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > User
   - What type of relationship is this?
   > ManyToOne : 
               - Each Booking relates to (has) one User.                            
               - Each User can relate to (can have) many Booking objects 
   - Is the Booking.customer property allowed to be null (nullable)? (yes/no) [yes]:
   > no
   - Do you want to add a new property to User so that you can access/update Booking objects from it - e.g. $user->getBookings()? (yes/no) [yes]:
   > (ENTER)
   --- A new property will also be added to the User class so that you can access the related Booking objects from it.
   # New field name inside User [bookings]:
   > (ENTER)
   - Do you want to activate orphanRemoval on your relationship?
   A Booking is "orphaned" when it is removed from its related User.
   e.g. $user->removeBooking($booking)
   NOTE: If a Booking may *change* from one User to another, answer "no".
   Do you want to automatically delete orphaned App\Entity\Booking objects (orphanRemoval)? (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # details
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > RequestedItem
   - What type of relationship is this?
   > OneToMany :
               - Each Booking can relate to (can have) many RequestedItem objects.           
               - Each RequestedItem relates to (has) one Booking
   --- A new property will also be added to the RequestedItem class so that you can access and set the related Booking object from it.
   # New field name inside RequestedItem [booking]:
   > (ENTER)
   - Is the RequestedItem.booking property allowed to be null (nullable)? (yes/no) [yes]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # total
   - Field type (enter ? to see all types) [string]:
   > float
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # withDelivery
   - Field type (enter ? to see all types) [string]:
   > boolean
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # initialPayment
   - Field type (enter ? to see all types) [string]:
   > boolean
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # fullPayment
   - Field type (enter ? to see all types) [string]:
   > boolean
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # securityDepositIsPaid
   - Field type (enter ? to see all types) [string]:
   > boolean
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # securityDepositIsReturned
   - Field type (enter ? to see all types) [string]:
   > boolean
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # bookedAt
   - Field type (enter ? to see all types) [datetime_immutable]:
   > datetime
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > no      
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # reference
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   >>> created: src/Entity/Booking.php
   >>> created: src/Repository/BookingRepository.php
   >>> updated: src/Entity/Booking.php (10)
   >>> updated: src/Entity/User.php
   >>> updated: src/Entity/RequestedItem.php
   
   - php bin/console make:entity Booking  
   Your entity already exists! So let's add some new fields!
   --- New property name (press <return> to stop adding fields):
   # address
   - Field type (enter ? to see all types) [string]:
   >> RELATION
   - What class should this entity be related to?:
   > Address
   - What type of relationship is this?
   > ManyToOne :
                  - Each Booking relates to (has) one Address.                            
                  - Each Address can relate to (can have) many Booking objects
   - Is the Booking.address property allowed to be null (nullable)? (yes/no) [yes]:
   > (ENTER)
   - Do you want to add a new property to Address so that you can access/update Booking objects from it - e.g. $address->getBookings()? (yes/no) [yes]:
   > (ENTER)
   --- A new property will also be added to the Address class so that you can access the related Booking objects from it.
   # New field name inside Address [bookings]:
   > (ENTER)


   *** Address ***
   - php bin/console make:entity Address
   --- New property name (press <return> to stop adding fields):
   # addressLine1
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # addressLine2
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > yes
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # zipCode
   - Field type (enter ? to see all types) [string]:
   > integer
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # city
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # floor
   - Field type (enter ? to see all types) [string]:
   > integer
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # lift
   - Field type (enter ? to see all types) [string]:
   > boolean
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # country
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)   


   >>> created: src/Entity/Address.php
   >>> created: src/Repository/AddressRepository.php
   updated: src/Entity/Booking.php
   updated: src/Entity/Address.php (X5)
   updated: src/Entity/CustomerProfile.php
   updated: src/Entity/Address.php
    updated: src/Entity/Address.php
    updated: src/Entity/Address.php
     updated: src/Entity/Address.php
     updated: src/Entity/Address.php
     updated: src/Entity/Address.php
   updated: src/Entity/Address.php
   updated: src/Entity/Address.php
      updated: src/Entity/Address.php
      updated: src/Entity/CustomerProfile.php
   updated: src/Entity/Address.php

   *** InspirationCategory ***
   - php bin/console make:entity InspirationCategory
   --- New property name (press <return> to stop adding fields):
   # name
   - Field type (enter ? to see all types) [string]:
   > (ENTER)
   - Field length [255]:
   > (ENTER)
   - Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   >>> created: src/Entity/InspirationCategory.php
   >>> created: src/Repository/InspirationCategoryRepository.php
   >>> updated: src/Entity/InspirationCategory.php

   *** Inspiration ***
   - php bin/console make:entity Inspiration        

   created: src/Entity/Inspiration.php
   created: src/Repository/InspirationRepository.php
   

   --- New property name (press <return> to stop adding fields):
   # title
   Field type (enter ? to see all types) [string]:
   > (ENTER)
   Field length [255]:
   > (ENTER)
   Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   updated: src/Entity/Inspiration.php
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # description
   Field type (enter ? to see all types) [string]:
   > text
   Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   updated: src/Entity/Inspiration.php
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # price
   Field type (enter ? to see all types) [string]:
   > float
   Can this field be null in the database (nullable) (yes/no) [no]:
   > (ENTER)
   updated: src/Entity/Inspiration.php
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # items 
   Field type (enter ? to see all types) [string]:
   >> RELATION
   What class should this entity be related to?:
   > Item
   What type of relationship is this? 
   > ManyToMany : 
                  - Each Inspiration can relate to (can have) many Item objects.           
                  - Each Item can also relate to (can also have) many Inspiration objects 
   Do you want to add a new property to Item so that you can access/update Inspiration objects from it - e.g. $item->getInspirations()? (yes/no) [yes]:
   > (ENTER)
   --- A new property will also be added to the Item class so that you can access the related Inspiration objects from it.
   # New field name inside Item [inspirations]:
   > (ENTER)
   updated: src/Entity/Inspiration.php
   updated: src/Entity/Item.php
   --- Add another property? Enter the property name (or press <return> to stop adding fields):
   # category
   Field type (enter ? to see all types) [string]:
   >> RELATION
   What class should this entity be related to?:
   > InspirationCategory
   What type of relationship is this?
   > ManyToOne : 
                  - Each Inspiration relates to (has) one InspirationCategory.                            
                  - Each InspirationCategory can relate to (can have) many Inspiration objects 
   Is the Inspiration.category property allowed to be null (nullable)? (yes/no) [yes]:
   > no
   Do you want to add a new property to InspirationCategory so that you can access/update Inspiration objects from it - e.g. $inspirationCategory->getInspirations()? (yes/no) [yes]:
   > (ENTER)
   A new property will also be added to the InspirationCategory class so that you can access the related Inspiration objects from it.
   New field name inside InspirationCategory [inspirations]:
   > (ENTER)
   Do you want to activate orphanRemoval on your relationship?
   A Inspiration is "orphaned" when it is removed from its related InspirationCategory.
   e.g. $inspirationCategory->removeInspiration($inspiration)
   NOTE: If a Inspiration may *change* from one InspirationCategory to another, answer "no".
   Do you want to automatically delete orphaned App\Entity\Inspiration objects (orphanRemoval)? (yes/no) [no]:
   > (ENTER)
   updated: src/Entity/Inspiration.php
   updated: src/Entity/InspirationCategory.php

   *** QuoteRequest ***
   php bin/console make:entity QuoteRequest

 created: src/Entity/QuoteRequest.php
 created: src/Repository/QuoteRequestRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > firstname

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > lastname

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > email

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > phone

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > eventType

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > eventStarts

 Field type (enter ? to see all types) [string]:
 > datetime

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > eventEnds

 Field type (enter ? to see all types) [string]:
 > datetime

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > outdoors

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > hostingPlace          

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > eventAddress

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > theme

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > colourCode

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > inspiration

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Inspiration

What type of relationship is this?
 ------------ ------------------------------------------------------------------------------- 
  Type         Description                                                                    
 ------------ ------------------------------------------------------------------------------- 
  ManyToOne    Each QuoteRequest relates to (has) one Inspiration.                            
               Each Inspiration can relate to (can have) many QuoteRequest objects            
                                                                                              
  OneToMany    Each QuoteRequest can relate to (can have) many Inspiration objects.           
               Each Inspiration relates to (has) one QuoteRequest                             
                                                                                              
  ManyToMany   Each QuoteRequest can relate to (can have) many Inspiration objects.           
               Each Inspiration can also relate to (can also have) many QuoteRequest objects  
                                                                                              
  OneToOne     Each QuoteRequest relates to (has) exactly one Inspiration.                    
               Each Inspiration also relates to (has) exactly one QuoteRequest.               
 ------------ ------------------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the QuoteRequest.inspiration property allowed to be null (nullable)? (yes/no) [yes]:
 > 

 Do you want to add a new property to Inspiration so that you can access/update QuoteRequest objects from it - e.g. $inspiration->getQuoteRequests()? (yes/no) [yes]:
 > no

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > nbrOfGuests

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > nbrOfTables 

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > itemsAlreadyAvailable

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > photoCorner

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > minBudget

 Field type (enter ? to see all types) [string]:
 > float

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > maxBudget

 Field type (enter ? to see all types) [string]:
 > float

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > message

 Field type (enter ? to see all types) [string]:
 > text

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > itemsNeeded

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Item

What type of relationship is this?
 ------------ ------------------------------------------------------------------------ 
  Type         Description                                                             
 ------------ ------------------------------------------------------------------------ 
  ManyToOne    Each QuoteRequest relates to (has) one Item.                            
               Each Item can relate to (can have) many QuoteRequest objects            
                                                                                       
  OneToMany    Each QuoteRequest can relate to (can have) many Item objects.           
               Each Item relates to (has) one QuoteRequest                             
                                                                                       
  ManyToMany   Each QuoteRequest can relate to (can have) many Item objects.           
               Each Item can also relate to (can also have) many QuoteRequest objects  
                                                                                       
  OneToOne     Each QuoteRequest relates to (has) exactly one Item.                    
               Each Item also relates to (has) exactly one QuoteRequest.               
 ------------ ------------------------------------------------------------------------ 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToMany

 Do you want to add a new property to Item so that you can access/update QuoteRequest objects from it - e.g. $item->getQuoteRequests()? (yes/no) [yes]:
 > 

 A new property will also be added to the Item class so that you can access the related QuoteRequest objects from it.

 New field name inside Item [quoteRequests]:
 > 

 updated: src/Entity/QuoteRequest.php
 updated: src/Entity/Item.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > agreedPrice

 Field type (enter ? to see all types) [string]:
 > float

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > isValidated

 Field type (enter ? to see all types) [boolean]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 >      

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > initialPayment

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > fullPayment

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > reference

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/QuoteRequest.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
 
tinhinanecherifi@Tinhinanes-MacBook-Air dydream_decor % php bin/console make:entity QuoteRequest 

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration

   *** CustomerProfile ***
   php bin/console make:entity NeededItems 

 created: src/Entity/NeededItems.php
 created: src/Repository/NeededItemsRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > item

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Item

What type of relationship is this?
 ------------ ----------------------------------------------------------------------- 
  Type         Description                                                            
 ------------ ----------------------------------------------------------------------- 
  ManyToOne    Each NeededItems relates to (has) one Item.                            
               Each Item can relate to (can have) many NeededItems objects            
                                                                                      
  OneToMany    Each NeededItems can relate to (can have) many Item objects.           
               Each Item relates to (has) one NeededItems                             
                                                                                      
  ManyToMany   Each NeededItems can relate to (can have) many Item objects.           
               Each Item can also relate to (can also have) many NeededItems objects  
                                                                                      
  OneToOne     Each NeededItems relates to (has) exactly one Item.                    
               Each Item also relates to (has) exactly one NeededItems.               
 ------------ ----------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the NeededItems.item property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Item so that you can access/update NeededItems objects from it - e.g. $item->getNeededItems()? (yes/no) [yes]:
 > 

 A new property will also be added to the Item class so that you can access the related NeededItems objects from it.

 New field name inside Item [neededItems]:
 > quantity

 Do you want to activate orphanRemoval on your relationship?
 A NeededItems is "orphaned" when it is removed from its related Item.
 e.g. $item->removeNeededItems($neededItems)
 
 NOTE: If a NeededItems may *change* from one Item to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\NeededItems objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/NeededItems.php
 updated: src/Entity/Item.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
 
tinhinanecherifi@Tinhinanes-MacBook-Air dydream_decor % php bin/console make:entity NeededItems

 created: src/Entity/NeededItems.php
 created: src/Repository/NeededItemsRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 >   


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
 
tinhinanecherifi@Tinhinanes-MacBook-Air dydream_decor % php bin/console make:entity NeededItem 

 created: src/Entity/NeededItem.php
 created: src/Repository/NeededItemRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > item

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Item

What type of relationship is this?
 ------------ ---------------------------------------------------------------------- 
  Type         Description                                                           
 ------------ ---------------------------------------------------------------------- 
  ManyToOne    Each NeededItem relates to (has) one Item.                            
               Each Item can relate to (can have) many NeededItem objects            
                                                                                     
  OneToMany    Each NeededItem can relate to (can have) many Item objects.           
               Each Item relates to (has) one NeededItem                             
                                                                                     
  ManyToMany   Each NeededItem can relate to (can have) many Item objects.           
               Each Item can also relate to (can also have) many NeededItem objects  
                                                                                     
  OneToOne     Each NeededItem relates to (has) exactly one Item.                    
               Each Item also relates to (has) exactly one NeededItem.               
 ------------ ---------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the NeededItem.item property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Item so that you can access/update NeededItem objects from it - e.g. $item->getNeededItems()? (yes/no) [yes]:
 > 

 A new property will also be added to the Item class so that you can access the related NeededItem objects from it.

 New field name inside Item [neededItems]:
 > decorationServiceItems

 Do you want to activate orphanRemoval on your relationship?
 A NeededItem is "orphaned" when it is removed from its related Item.
 e.g. $item->removeNeededItem($neededItem)
 
 NOTE: If a NeededItem may *change* from one Item to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\NeededItem objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/NeededItem.php
 updated: src/Entity/Item.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > quantity

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/NeededItem.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
 
tinhinanecherifi@Tinhinanes-MacBook-Air dydream_decor % 

# ADMIN 
# PAGES
- Home : affiche un carousel des inspis et quelques items à mettre en avant
- registration : affiche un formulaire d'inscription
- login : affiche un formulaire de connexion
- Profile : affiche une page de profil pour modifier ses infos
- item_catalogue items : affiche tous les items
- inspi_catalogue : affiche toutes les inspirations
- item : affiche le détail d'un item
- Inspi : affiche le détail d'une inspiration
- demande_devis : affiche un formulaire de demande de devis
- devis_à_traiter : liste des devis
- deliveries : affiche la liste des livraisons 
- favoris : affiche liste des favoris
- panier : affiche les items séléctionnés + total et propose livraison
- bookings : liste des bookings
- contact_us : affiche un formulaire de contact


*************************************************** DEMANDER A ANDY ***************************************************
- finalement je pense que je vais réussir à faire la gestion de calendrier - c'est préférable niveau expéreince client.
- combien de temps de latence entre les locations ? date ou datetime ?
- quand pourras-tu me fournir des photos (de qualité) des articles et des prestations (vidéos)
- infos sur les articles (prix, dimension, couleur, quantité en stock)
- logo : que'en penses-tu ? s'il ne te plait pas je le mets quand même pour l'examen et on le changera après.
- montants l'acompte, de la caution et 
- calcul du prix de livraison
- 

*************************************************** A RECHERCHER ***************************************************

- A quoi sert symfony serve
- Comment changer de version sans tout recommencer ?
- Dans une relation OneToMany que se passe-t-il si on refuse de supprimer les orphelin alors que le champs qu'on supprime n'est pas nullable ?
Ex: Item -OneToMany- Category. Si on refuse qu'en supprimant une category ça supprime les orphelins de Item, on aura des Items sans category alors que le champs category dans Item n'est pas nullable 
- Que se passe-t-il si on utile plusieurs fois make:user ? Cela créera-t-il un second user ?Le second va-t-il remplacer le premier ? Ou bien est-ce que ça ne va tout simplement pas fonctionner ?
- Datatype pour les nombre entiers (positifs et négatifs) exemple pour modeliser une adresse et donc un étage -2, -1, 0, 1, 2, 3
- Revoir tous les datatypes de symfony et ce à quoi il servent.
- comment fonctionne Localhost - php MydAmin 

*************************************************** NE PAS OUBLIER *************************************************** 
- Responsive
- Entity Item : ajouter les champs :
    - img 1 (string)
    - img 2 (string)
    - img 3 (string)
    - alt 1 (string)
    - alt 2 (string)
    - alt 3 (string)
- Changer la Booking.bookedAt de datetime en datetime_immutable
- Entity Inspiration : ajouter les champs :
    - img 1 (string)
    - img 2 (string)
    - img 3 (string)
    - alt 1 (string)
    - alt 2 (string)
    - alt 3 (string)
    - video (string)
- Entity QuoteRequest : ajouter les champs :
    - placeImg1 (string)
    - placeImg2 (string)
    - placeImg3 (string)
    - decorationModel1 (string)
    - decorationModel2 (string)
    - decorationModel3 (string)

    *************************************************** A Mettre dans le dossier *************************************************** 
   - Entités et Algorithmes : 
         - Pour les items dispoibles en plusieurs exemplaires : rentrer chaque exemlaire comme un item séparé ? pb le catalogue affichera x fois le même items (pas top). Ou idéalement rentrer un seul exemplaire, ajouter une proprité quantity-in-stock dans l'entité Item pour pouvoir compter combien sont disponibles aux dates demandées.
         - Une seule date et une seule adresse de commande
   Définitions:

   Doctrine : ORM qui fait la relation entre le PHP et la base de données.
   Repository : centralise la récupération de données d'une entity
   Migration : un fichier comptenant des requettes SQL à executer dans la bdd avec deux fonction up (CREATE pour transférer les données en bdd) et down (DROP pour supprimer de la bdd)