# Kirby SEO

A simple SEO plugin for [Kirby CMS](https://getkirby.com).

## Requirements

Kirby CMS (`>=4.0`)  
PHP (`>= 8.3`)

## Installation

### Composer

```sh
composer require hksagentur/kirby-seo
```

### Download

Download the project archive and copy the files to the plugin directory of your kirby installation. By default this directory is located at `/site/plugins`.

## Usage

All blueprints provided by the plugin are registered within a custom namespace (`@hksagentur/seo`). You have to reference or extend these blueprints to take advantage of the provided data structures.

A simple exampe would be to use the navigation blueprint for the site:

```yaml
# site/blueprints/default.yml
tabs:
  content:
    label: Content
    icon: 
    fields: []
  seo:
    label: SEO
    icon: search
    sections:
      seo: @hksagentur/seo/sections/seo
```

## License

ISC License. Please see [License File](LICENSE.txt) for more information.