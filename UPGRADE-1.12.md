# UPGRADE TO SYLIUS 1.12+

Ce fichier documente les changements effectués pour rendre le plugin compatible avec Sylius 1.12 et versions ultérieures.

## Changements apportés

### 1. Mise à jour de `composer.json`

#### Dépendances principales
- **PHP** : `^8.1 || ^8.2 || ^8.3` (auparavant `^7.1 || ^8.0`)
- **Sylius** : `^1.12 || ^1.13` (auparavant `>=1.4 <1.12`)

#### Dépendances de développement
Mise à jour des packages Symfony pour supporter Symfony 5.4, 6.0 et 7.0 :
- `symfony/browser-kit`: `^5.4 || ^6.0 || ^7.0`
- `symfony/debug-bundle`: `^5.4 || ^6.0 || ^7.0`
- `symfony/dotenv`: `^5.4 || ^6.0 || ^7.0`
- `symfony/intl`: `^5.4 || ^6.0 || ^7.0`
- `symfony/web-profiler-bundle`: `^5.4 || ^6.0 || ^7.0`

Mise à jour d'autres packages :
- `sylius-labs/coding-standard`: `^5.0`
- `phpunit/phpunit`: `^9.0 || ^10.0`
- `behat/behat`: `^3.8`
- `behat/mink`: `^1.8`
- `behat/mink-browserkit-driver`: `^1.4 || ^2.0`
- `behat/mink-selenium2-driver`: `^1.4 || ^1.6`
- `friends-of-behat/symfony-extension`: `^2.0`
- `rector/rector`: `^0.15.0 || ^1.0`

### 2. Bundles retirés de `tests/Application/config/bundles.php`

Les bundles suivants ont été retirés car ils sont dépréciés ou supprimés dans Symfony 6+ :
- `Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle` (remplacé par Symfony Mailer)
- `Sonata\CoreBundle\SonataCoreBundle` (abandonné)
- `Symfony\Bundle\WebServerBundle\WebServerBundle` (déprécié, utiliser Symfony CLI)

### 3. Configurations SwiftMailer supprimées

Les fichiers de configuration suivants ont été supprimés :
- `tests/Application/config/packages/swiftmailer.yaml`
- `tests/Application/config/packages/dev/swiftmailer.yaml`
- `tests/Application/config/packages/test/swiftmailer.yaml`
- `tests/Application/config/packages/test_cached/swiftmailer.yaml`
- `tests/Application/config/packages/staging/swiftmailer.yaml`

La configuration SwiftMailer a également été retirée de `tests/Application/app/config/config.yml`.

**Note** : Sylius 1.12+ utilise Symfony Mailer au lieu de SwiftMailer.

## Prochaines étapes

Après avoir appliqué ces changements, vous devez :

1. **Mettre à jour les dépendances** :
   ```bash
   composer update
   ```

2. **Installer les assets** (si nécessaire) :
   ```bash
   cd tests/Application
   bin/console assets:install public
   ```

3. **Lancer les tests** pour vérifier la compatibilité :
   ```bash
   vendor/bin/phpunit
   vendor/bin/behat
   ```

4. **Vérifier le code avec les outils de qualité** :
   ```bash
   vendor/bin/ecs
   vendor/bin/phpstan analyse
   ```

## Compatibilité

Ce plugin est maintenant compatible avec :
- PHP 8.1, 8.2, 8.3
- Sylius 1.12.x et 1.13.x
- Symfony 5.4, 6.x, 7.x

## Notes importantes

- **SwiftMailer** : Si votre code utilise directement SwiftMailer, vous devrez migrer vers Symfony Mailer.
- **Tests** : Assurez-vous que tous vos tests fonctionnent correctement après la mise à jour.
- **Bundles tiers** : Vérifiez que tous les bundles tiers que vous utilisez sont compatibles avec Sylius 1.12+.

