# Aplikacja stworzona na potrzeby zadania rekrutacyjnego do firmy InPost

## Uruchomienie

`composer install`

`yarn install`

`yarn watch`


## Konwecje

**bar_code_ean_13**
w encji produktu to ean_13. Prefix bar_code dołączony jest, aby podkreślić, którą część zadania spełnia ten atrybut

Walidacja ean13 - https://edmondscommerce.github.io/php/barcode/ean13-barcode-check-digit-with-php.html

## Napotkane problemy
W obecnej wersji nie nadpisuję tabeli ManyToMany przy zapisywaniu formularza dla stanów magazynowych.  
Problem jest powiązany z brakiem wiedzy odnośnie działania Form Buildera w Symfony.
Przy dodawaniu, gdy kod istnieje w bazie pokazuje się błąd, obsłużone jest to try catchem w sposób "na szybko"
# Podsumowanie
Jak wspominałem na rozmowie niestety nie mam dużego doświadczenia w Symfony, budując tą aplikację przez jej prostotę ciężko mi było pokazać swoje dobre strony.  
Jest to jedna z pierwszych aplikacji, którą piszę w Symfony i w porównaniu do innych rozwiązań formularze były dla mnie czymś nowym czego nie potrafię jeszcze w pełni wykorzystywać, a niestety czas był mocno ograniczony
