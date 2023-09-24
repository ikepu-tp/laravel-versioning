# Laravel Versionning

## Features

- Generate release notes using interactive command-line interface.
- Automatic release and tagging if using GitHub.

## How to use

### 1. **Installation**

```bash
composer require ikepu-tp/laravel-versioning
```

### 2. **Installation Command**

```bash
php artisan versioning:install
```

### 3. **Create Release Notes**

```bash
php artisan versioning:make
```

| Option                 | Description                                           |
| ---------------------- | ----------------------------------------------------- |
| --VT / --version_type= | Specify the version type (`major`, `minor`, `patch`). |
| --J  / --major         | Perform a major version upgrade.                      |
| --M  / --minor         | Perform a minor version upgrade.                      |
| --P  / --patch         | Perform a patch version upgrade.                      |

#### Descriptions

When creating release notes, the following information will be recorded using an interactive command:

| Key             | Required (Y/N) | Description                                                      |
| --------------- | -------------- | ---------------------------------------------------------------- |
| version         | Y              | The version for which the release notes are being created.       |
| releaseDate     | Y              | The release date.                                                |
| Author          | N              | The name of the release note creator (bulleted list).            |
| url             | N              | Links to include in the release notes.                           |
| description     | N              | Concise descriptions of changes, etc. (bulleted list).           |
| newFeatures     | N              | Descriptions of new features (bulleted list).                    |
| changedFeatures | N              | Descriptions of changed features (bulleted list).                |
| deletedFeatures | N              | Descriptions of deleted features (bulleted list).                |
| notice          | N              | Important information to convey to users (bulleted list).        |
| security        | N              | Security-related information to convey to users (bulleted list). |
| futurePlans     | N              | Plans for future changes (bulleted list).                        |
| note            | N              | Additional notes.                                                |


### 4. **View Release Notes**

[http://localhost/version](http://localhost/version)
*Please replace `http://localhost` with your own domain.

## Contributing

We welcome contributions to the project! You can get involved through the following ways:

Issue: Use for bug reports, feature suggestions, and more.

Pull Requests: We encourage code contributions for new features and bug fixes.

## License

See [LICENSE](./LICENSE).
