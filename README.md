# secretsanta
A little Secret Santa webapp I made for some friends.


# How to use:
db.php would need configured to match user's personal database. These changes should only need be made to db.php, as all webpages import and reference from db.php.

Direct users to index.html and allow them to enter their details. Players should save secret code from sent.php, which is generated when they are added to the database. When it is time to pair players up, the user should run randomize.php like:
# > php randomize.php
If necessary, user must modify randomize.php beforehand to prevent boring matches. Randomizer may be run as many times as user deems necessary.
