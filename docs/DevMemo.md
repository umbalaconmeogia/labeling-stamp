# Memo of development

## Install prequesites

### Get base yii2 project skeleton.

### Install login module.

```shell
composer require --prefer-dist yii2mod/yii2-user "*"
```

* Configure user module.
* Configure yii2-user i18n.
* Add *login*, *logout* into SiteController#actions()

Ref: https://github.com/yii2mod/yii2-user

### Install yii2-check-login-attempts

```shell
composer require giannisdag/yii2-check-login-attempts
```

Ref https://github.com/giannisdag/yii2-check-login-attempts

### Run migration

Notice: If user sqlite, don't run the default migration files off yii2-user and yii2-check-login-attempts.
Use the migration files in the *migrations* folder.

### Preparation

* Create user account
  ```shell
  ./yii user/create thanhtt@evolable.asia thanhtt password
  ```
