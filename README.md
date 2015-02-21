# Nous le peuple

NLP est la future nouvelle version de la plateforme qui permet le fonctionnement
de "Nous le Peuple", l'agora citoyenne du [Mouvement pour la 6ème
République](http://www.m6r.fr).

C'est la plateforme qui permet déjà le fonctionnement du vote pour l'Assemblée
Représentative du mouvement.

Si vous êtes développeuse ou développeur, vous êtes invité-e à contribuer au
développement en rejoignant la liste http://listes.m6r.fr/wws/info/nouslepeuple-
devel, et en faisant des pull requests. Avant toute chose, lisez cependant le
[paragraphe suivant](#contribuer) ainsi le fichier
[CONTRIBUTING](https://github.com/m6r/nouslepeuple/blob/master/CONTRIBUTING.md).

Merci aussi de ne pas utiliser Github pour proposer de nouvelles fonctionnalités
ou discuter de l'évolution de la plateforme. Utilisez plutôt la [catégorie
dédiée](https://www.m6r.fr/nouslepeuple/?category=propositions-evolution) sur
Nous le Peuple.

Le projet utilise le framework PHP [Symfony](symfony.com). La documentation de
Symfony est riche et bien construite. Il nécessite PHP >= 5.3 et une base de
donnée Mysql ou MariaDB.

# Contribuer

Si vous n’êtes pas habitué-e à Github et aux Pull Requests, vous trouverez de
l'aide dans le fichier
[CONTRIBUTING](https://github.com/m6r/nouslepeuple/blob/master/CONTRIBUTING.md).

Les contributions doivent être accompagnées des tests unitaires nécessaires.

Le code suit les standards [PSR-1](http://www.php-fig.org/psr/psr-1/) et
[PSR-2](http://www.php-fig.org/psr/psr-2/), plus les standards de [php-cs-fixer]
avec `--level=symfony`.
