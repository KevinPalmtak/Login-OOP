XAMPP INSTALLATIE

1. Pak login_website_xampp.zip uit naar C:\xampp\htdocs\
2. Start XAMPP en zet Apache + MySQL aan.
3. Open http://localhost/phpmyadmin
4. Klik Importeren en kies database.sql.
5. Open http://localhost/login_website/
6. Klik Registreren en maak een account.
7. Log daarna in.

De database gebruikt standaard XAMPP: localhost, database login_website, gebruiker root, leeg wachtwoord.

User.php bevat de methods uit het class diagram:
ValidateLogin(), RegisterUser(), LoginUser(), IsLoggedIn(), SetPassword(), GetPassword().
Wachtwoorden worden gehasht met password_hash() en gecontroleerd met password_verify().
