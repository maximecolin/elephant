# Elephant

This is a fake project used to show example of architecture, pattern and best practices I use in my Symfony projects. 

## Clean architecture

```
src:
  - Application : application code, mostly commands and queries handler
  - Domain : domain code, mostly models, dto, interfaces, domain rules, exceptions and event
  - Infrastructure : mostly infrastructure adapters, implementation of domain intefaces, framework related stuff
  - Ui : user interface stuff, mostly controllers, forms, ui helper, ...
```

See [sources](/maximecolin/elephant/tree/master/server/src).

## Hexagonal architecture

Business code and technical code are separated.

For example, for persistence:

* Interface of repositories are defined in [business code](/maximecolin/elephant/blob/master/server/src/Infrastructure/Repository)
* Doctrine implementations are defined in [technical code](/maximecolin/elephant/tree/master/server/src/Domain/Repository)

## Keep your model framework agnostic

In order to keep models agnostic from framework, Doctrine mapping is defined in [yml files](maximecolin/elephant/tree/master/server/app/config/doctrine/entity) instead of annotations. These yml files are loaded thanks to [this config](/maximecolin/elephant/blob/master/server/app/config/doctrine.yml#L18).

If you prefer you can use xml too.

Same for validation, use [validation yml file](/maximecolin/elephant/tree/master/server/app/config/validation) instead of annotations. Disable annotation and set validation yml directory path in [config.yml](/maximecolin/elephant/blob/master/server/app/config/config.yml#L23)

## Business rules

Business rules should be defined in [classes in Domain](/maximecolin/elephant/tree/master/server/src/Domain/Rules) to be reusable and not repeated accross code.

## Much files, so tiny

Split your config files in smaller files for better readability. For example, split services [in several files](/maximecolin/elephant/tree/master/server/app/config/services) grouping them by theme. You can also split `router.yml` or `config.yml` for example.

## User adapter

In order to keep Symfony user concept appart from your User model, you can use a [Symfony user adapter](/maximecolin/elephant/blob/master/server/src/Infrastructure/Security/User/SymfonyUser.php) provided by a custom [user provider](/maximecolin/elephant/blob/master/server/src/Infrastructure/Security/User/SymfonyUserProvider.php).

See configuration [here](/maximecolin/elephant/blob/master/server/app/config/security.yml#L12).
