# Elephant

This is a fake project used to show examples of architectures, patterns and best practices I use in my Symfony projects. 

## Clean architecture

```
src:
  - Application : application code, mostly commands and queries handler
  - Domain : domain code, mostly models, dto, interfaces, domain rules, exceptions and event
  - Infrastructure : mostly infrastructure adapters, implementation of domain intefaces, framework related stuff
  - Ui : user interface stuff, mostly controllers, forms, ui helper, ...
```

See [sources](/server/src).

## Hexagonal architecture

Business code and technical code are separated.

For example, for persistence:

* Interfaces of repositories are defined in [business code](/server/src/Infrastructure/Repository)
* Doctrine implementations are defined in [technical code](/server/src/Domain/Repository)

## Keep your model framework agnostic

In order to keep models agnostic from framework, Doctrine mapping is defined in [yml files](/server/app/config/doctrine/entity) instead of annotations. These yml files are loaded thanks to [this config](/server/app/config/doctrine.yml#L18).

If you prefer you can use xml too.

Same for validation, use [validation yml file](/server/app/config/validation) instead of annotations. Disable annotation and set validation yml directory path in [config.yml](/server/app/config/config.yml#L23)

## Business rules

Business rules should be defined in [classes in Domain](/server/src/Domain/Rules) to be reusable and not repeated accross code.

## Tactician

Take advantage of [Tactician middlewares](/server/app/config/tactician.yml) to handle your commands.

## CQRS

Separate [writing](/server/src/Application/Command) from [reading](/server/src/Application/Query).

## DTO

Use [DTOs](/server/src/Domain/Dto) to carry data that don't need to be persisted (i.e. read only data, form data, ...). DTOs allow you to format/organize data the way is the most convenient for your usage without regardless of persistence models.

## Much files, so tiny

Split your config files in smaller files for better readability. For example, split services [in several files](/server/app/config/services) grouping them by theme. You can also split `router.yml` or `config.yml` for example.

## User adapter

In order to keep Symfony user concept appart from your User model, you can use a [Symfony user adapter](/server/src/Infrastructure/Security/User/SymfonyUser.php) provided by a custom [user provider](/server/src/Infrastructure/Security/User/SymfonyUserProvider.php).

See configuration [here](/server/app/config/security.yml#L12).

## Enhance Doctrine QueryBuidler

Extends Doctrine QueryBuilder to add your business logic in reusable and chainable methods.
 
See:
* [Query builders examples](/server/src/Infrastructure/QueryBuilder)
* [Usages examples](/server/src/Infrastructure/Repository)

## Autocomplete with Vue.js

* [Vue component](/server/assets/js/vue/UserAutocomplete.vue)
* [Autocomplete API](/server/src/Ui/Api/UserAutocompleteAction.php)
* [Form type](/server/src/Ui/Form/Type/UserAutocompleteType.php)
* [Form theme](/server/app/Resources/views/forms.html.twig)

## Custom voter

Custom voters allow you to create and handle permissions based on business rules.

See:
* [Custom voters examples](/server/src/Infrastructure/Security/Voter)
* [Services declaration](/server/app/config/services/security.yml)
* Usage [here](/server/src/Ui/Action/Board/Settings/OptionsAction.php#L91) and [here](/server/app/Resources/views/home.html.twig#L17)

## Api key authenticator

Example of authenticator protecting the graphql API by requiring an API key in the request headers for being authenticated:

* [ApiKeyUserProvider](/server/src/Infrastructure/Security/Api/ApiKeyUserProvider.php) will provide users based on api keys,
* [ApiKeyAuthenticator](/server/src/Infrastructure/Security/Api/ApiKeyAuthenticator.php) will authenticated the founded user and create a preauth token,
* The [graphql firewall](/server/app/config/security.yml#L24) and the [access control](/server/app/config/security.yml#L42) will require authentication.
* See also [service declaration](/server/app/config/services/security.yml#L34)
* Make sure your [CORS config](/server/ansible/group_vars/app.yml#L110) allow the chosen key header name ("key" in this example) for cross domain usage. 

In this example, pairs of api key and username are stored in configs and a very simple user is used. You can easilly modify `ApiKeyUserProvider::getUsernameForApiKey` in order to looking for keys in database for example and `ApiKeyUserProvider::loadUserByUsername` to return a more complexe user.

In order to make **graphiql** working with this authenticator, you must extends the [graphiql.html.twig](/server/app/Resources/views/graphiql.html.twig) template to make graphiql send the key header and [configure the GraphQL bundle](/server/app/config/graphql.yml#L13) to use it. 

## Todos / Coming soon

* Split the command bus into two separate Query and Command buses
* Query cache
* API Plateform
