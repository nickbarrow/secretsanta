# secretsanta
A little Secret Santa webapp I made for myself and mis amigos.


# How to use:
db.php should be configured to match user's personal database. These changes should only need be made to db.php, as all webpages import and reference from db.php.

Direct users to index.html and allow them to enter their details. Players should save secret code from sent.php, which is generated when they are added to the database. When it is time to pair players up, the user should run randomize.php like:
# > php randomize.php
If necessary, user must modify randomize.php beforehand to prevent boring matches. Randomizer may be run as many times as user deems necessary.

# How to retrieve partner:
Once random pairs have been made, direct players to reveal.php. This is where players must input their unique ID in order to reveal their Secret Santa partner! Results are available only to those with secret code, however user beware as all data can be viewed in PHPmyAdmin.
