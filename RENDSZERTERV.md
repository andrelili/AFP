# Rendszerterv

## A rendszer célja
A webshop célja egy modern, egyszerűen használható, reszponzív online felület biztosítása, ahol a vásárlók böngészhetnek különgöző bútor kategóriák között (pl. nappali, hálószoba, fürdőszoba),  részletes termékleírásokat és képeket tekinthetnek meg, majd kosárba helyezhetik őket, és később rendelést adhatnak le.  
A fejlesztés *két fázisban* történik:  
1. *Kis projekt* – csak a kosár működésének megvalósítása adatbázis nélkül.  
2. *Teljes webshop* – adatbázisra épülő, admin felülettel és felhasználói fiókokkal bővített rendszer.  

---

## Projektterv

### Projektmunkások és felelőségek

* *Frontend:*
    + 
    + 
  * Feladatuk:  
    - HTML, CSS, JavaScript alapú felület létrehozása  
    - Reszponzív design készítése  
    - Kosár működésének megvalósítása  

* *Backend:*
    + 
    + André Lili
  * Feladatuk:  
    - API és adatbáziskapcsolat kialakítása  
    - Rendelési és felhasználói logika kezelése  
    - Admin funkciók fejlesztése  

* *Tesztelés:*
  + Minden résztvevő  
  * Feladatuk:  
    - Hibák feltárása az üzembe helyezés előtt.

---

## Fejlesztési fázisok

### *Fázis 1 – Kis projekt (alapverzió)*
- *Cél:* működő prototípus létrehozása, ahol a felhasználók kosárba tehetik a bútorokat.  
- *Technológia:* HTML, CSS, JavaScript.  
- *Funkciók:*  
  + Termékek listázása (statikus fájlból)  
  + Termék kosárba helyezése  
  + Kosár tartalmának megjelenítése (név, ár, mennyiség, végösszeg)  
  + Kosárból törlés, mennyiség növelés/csökkentés  
  + „Rendelés leadása” gomb (egyelőre csak jelzés)  

 *Szereplők:*  
- Látogató = Vásárló (még nincs regisztráció és admin szerepkör).  

---

### *Fázis 2 – Teljes webshop (adatbázissal és backenddel)*  
- *Cél:* a kis projekt kibővítése valós adatbázissal, felhasználói fiókokkal és admin felülettel.  
- *Technológia:*  
  + Frontend: HTML, CSS, JavaScript  
  + Backend: PHP
  + Adatbázis: MySQL (XAMPP + phpMyAdmin)
- *Funkciók:*  
  + *Felhasználók*: regisztráció, bejelentkezés, profil  
  + *Termékek*: adatbázisból betöltve (név, leírás, ár, készlet, kép)  
  + *Kosár és rendelés*: kosár mentése adatbázisba, rendelés leadása  
  + *Értékelés*: vásárlók a megvásárolt termékekhez értékelést adhatnak (0–5 csillag + szöveges komment)
  + *Admin felület*: termékek és kategóriák kezelése, rendelések státuszváltása  
  + *Keresés és szűrés*: kategória, ár és népszerűség alapján

 *Szereplők:*  
- *Admin:* kezeli a termékeket, kategóriákat, felhasználókat, rendeléseket  
- *Vásárló:* regisztráció után tud rendelni
- *Látogató:* böngészhet, de vásárláshoz be kell jelentkeznie  

---

## Követelmények

### Funkcionális követelmények
+ Termékek listázása és kosárkezelés  
+ Felhasználói adatok és rendelések tárolása (Fázis 2)  
+ Adminisztrációs felület (Fázis 2)  
+ Keresés és szűrés (Fázis 2)  

### Nemfunkcionális követelmények
- Biztonságos adatkezelés (Fázis 2 – jelszó hash, HTTPS)  
- Reszponzív és felhasználóbarát design  
- Telepítés nélkül böngészőből elérhető  

---

## Architekturális terv

### Fázis 1 – Kis projekt
- *Frontend:*  
  + Statikus terméklista (JavaScript fájlban)  
  + Kosár logika JS-ben  
  + Nincs adatbázis  

### Fázis 2 – Teljes webshop
- *Backend:* PHP 
- *Adatbázis:* MySQL (felhasználók, termékek, rendelések)  
- *Frontend:*  
  + HTML, CSS, JS + Fetch API az API hívásokhoz  

---

## Adatbázis terv (Fázis 2)

* *USERS*
  + USER_ID (PRIMARY KEY)  
  + USERNAME  
  + PASSWORD (hash-elt)  
  + EMAIL  
  + ADDRESS
  + PHONE
  + ROLE (USER / ADMIN)  

* *PRODUCTS*
  + PRODUCT_ID (PRIMARY KEY)  
  + NAME  
  + DESCRIPTION  
  + PRICE  
  + STOCK  
  + CATEGORY_ID (FOREIGN KEY → CATEGORIES)  
  + IMAGE_URL  

* *CATEGORIES*
  + CATEGORY_ID (PRIMARY KEY)  
  + NAME  
  + DESCRIPTION  

* *ORDERS*
  + ORDER_ID (PRIMARY KEY)  
  + USER_ID (FOREIGN KEY → USERS)  
  + DATE  
  + STATUS (PENDING, PROCESSING, SHIPPED, COMPLETED)  

* *ORDERS*
  + REVIEW_ID (PRIMARY KEY)
  + UDER_ID (FOREIGN KEY -> USERS)
  + PRODUCT_ID (FOREIGN KEY -> PRODUCTS)
  + RATING (0-5)
  + COMMENT 
  + DATE

* *ORDER_ITEMS*
  + ORDER_ID (FOREIGN KEY → ORDERS)  
  + PRODUCT_ID (FOREIGN KEY → PRODUCTS)  
  + QUANTITY  

---

## Tesztterv

### Fázis 1
- Kosár működésének ellenőrzése (hozzáadás, törlés, mennyiség módosítás, összegzés)  
- Reszponzív megjelenés ellenőrzése

### Fázis 2
- Regisztráció és bejelentkezés tesztelése  
- Rendelési folyamat tesztelése (kosár mentése, rendelés státusz)  
- Felhasználói értékelések rögzítésének és megjelenítésének tesztelése
- Értékelések alapján a termékek népszerűségének megfelelő sorrend ellenőrzése
- Admin funkciók ellenőrzése (új termék felvétele, készlet módosítása)  
- Biztonsági teszt (SQL injection elleni védelem, jelszóhash ellenőrzés)  

---

## Karbantartási terv

### Tartalmi karbantartás
- Termékek és kategóriák frissítése (admin)  
- Elfogyott termékek törlése vagy inaktiválása  

### Rendszeres karbantartás
- Adatbázis biztonsági mentések  
- Backend és frontend frissítések telepítése  

---