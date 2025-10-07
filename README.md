# Bútor Webshop

Egy modern, reszponzív és könnyen használható online bútorwebshop fejlesztése, amely böngészőből telepítés nélkül elérhető.  
A webshop célja, hogy gyors, letisztult és felhasználóbarát vásárlási élményt biztosítson minden eszközön.  

## Projekt áttekintés

A fejlesztés két fázisban történik:

1. **Kis projekt (prototípus)**  
   - Statikus terméklista  
   - Kosár funkció (hozzáadás, törlés, mennyiség módosítás, végösszeg)  
   - „Rendelés leadása” gomb (még nem kapcsolódik adatbázishoz)  

2. **Teljes webshop (adatbázissal és backenddel)**  
   - Felhasználói fiókok (regisztráció, bejelentkezés, profil)  
   - Termékek adatbázisból (név, leírás, ár, készlet, kép)  
   - Kosár mentése adatbázisba, rendelés leadása  
   - Értékelési rendszer (0–5 csillag + komment)  
   - Admin felület (termékek, kategóriák, felhasználók, rendelések kezelése)  
   - Keresés és szűrés (kategória, ár, népszerűség alapján)  

---

## Használt technológiák

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Adatbázis:** MySQL (XAMPP + phpMyAdmin)  
- **Fejlesztői környezet:** XAMPP
- **Keretrendszer:** Laravel

---

## Szerepkörök

- **Admin** – termékek, kategóriák, felhasználók és rendelések kezelése  
- **Vásárló** – regisztráció után rendelést adhat le és értékelhet  
- **Látogató** – böngészhet, de vásárláshoz regisztráció szükséges  

---

## Funkciók

- Termékek böngészése kategóriák szerint, részletes leírással és képpel  
- Kosár kezelése (hozzáadás, törlés, mennyiség módosítás, összegzés)  
- Rendelés leadása  
- Felhasználói fiókok kezelése (regisztráció, belépés, profil, jelszókezelés)  
- Értékelési rendszer (csillagos + szöveges)  
- Keresés és szűrés  
- Admin felület a teljes tartalom kezeléséhez  

---

## Projekt dokumentáció

- [Követelmény specifikáció](docs/KOVSPEC.md)  
- [Funkcionális specifikáció](docs/FUNKSPEC.md)  
- [Rendszerterv](docs/RENDSZERTERV.md)  

---

## Tesztelés

- **Fázis 1:** kosár funkciók ellenőrzése, reszponzív megjelenés tesztelése  
- **Fázis 2:** regisztráció, rendelési folyamat, értékelések, admin funkciók és biztonsági tesztek  

---

## Karbantartás

- Adatbázis biztonsági mentések  
- Rendszeres frissítések (frontend + backend)  
- Tartalomkezelés (termékek, kategóriák frissítése)  

---

## Fejlesztők

- **Frontend:** Szeghalmi Bence, Patnon Patrik, Seres Tibor
- **Backend:** Patnon Patrik, André Lili  
- **Tesztelés:** Minden csapattag  

---
