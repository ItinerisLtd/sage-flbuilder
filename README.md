# itineris/sage-flbuilder

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Minimum Requirements](#minimum-requirements)
- [Installation](#installation)
- [Rules](#rules)
- [Caveats](#caveats)
  - [Module Names](#module-names)
- [`PostGrid` (filter bar and post theme) Templates](#postgrid-filter-bar-and-post-theme-templates)
- [Rendering `FilterBar`](#rendering-filterbar)
  - [Customizing](#customizing)
- [Usage - Minimum](#usage---minimum)
  - [Step 1 - Define helper class](#step-1---define-helper-class)
  - [Step 2](#step-2)
- [Usage - Custom PHP Module](#usage---custom-php-module)
  - [Step 1 - Define module class](#step-1---define-module-class)
  - [Step 2 - Frontend Template](#step-2---frontend-template)
  - [Step 3 - Add custom module into `SageFLBuilder`](#step-3---add-custom-module-into-sageflbuilder)
- [Usage - Custom Blade Module](#usage---custom-blade-module)
  - [Step 1 - Inherit from `AbstractBladeModule`.](#step-1---inherit-from-abstractblademodule)
  - [Step 2 - Frontend Template](#step-2---frontend-template-1)
  - [Step 3](#step-3)
- [Usage - Custom Settings](#usage---custom-settings)
  - [Step 1 - Define Setting Class](#step-1---define-setting-class)
  - [Step 2](#step-2-1)
- [Usage - Extra Settings](#usage---extra-settings)
- [Usage - Exclude Default Modules / Settings](#usage---exclude-default-modules--settings)
- [Migrating from Fabric](#migrating-from-fabric)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->


## Minimum Requirements

* PHP v7.1
* Sage v9.0.0-beta.4
* illuminate/support v5.4
* Advanced Custom Fields PRO v5.6.9
* Beaver Builder Plugin (Pro Version) v2.0.6.1
* Beaver Themer v1.1.0.3
* Gravity Forms v2.2.6.5

You must ensure these 3 required plugins installed via Bedrock's composer.json.

## Installation

Sage theme's composer.json:
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:ItinerisLtd/sage-flbuilder.git"
    }
  ]
}
```

```bash
➜ composer require itineris/sage-flbuilder
```

## Rules

* Follow [PSR-4](https://www.php-fig.org/psr/psr-4/)
* Follow [PSR-1](https://www.php-fig.org/psr/psr-1/)
* Do not copy and paste from default modules - huge technical debt in this package
* Do not use `God` class - it is pure technical debt
* Do not inherit from any concrete classes

## Caveats

### Module Names

Beaver Builder can't accept 2 modules with the same file name even they follow PSR-4.

For example, these 3 modules conflict each other:

- `vendor/itineris/sage-flbuilder/src/Modules/Button/Button.php`
- `app/Plugins/FLBuilder/Modules/BrainHouse/Button/Button.php`
- `app/Plugins/FLBuilder/Modules/Trinity/Button/Button.php`

Solution - Use unique class names:

- `vendor/itineris/sage-flbuilder/src/Modules/Button/Button.php`
- `app/Plugins/FLBuilder/Modules/BrainHouseButton/BrainHouseButton.php`
- `app/Plugins/FLBuilder/Modules/TrinityButton/TrinityButton.php`

## `PostGrid` (filter bar and post theme) Templates

**Deprecated:** Prior to v0.5.0, `PostGrid::DIR` is used to locate template directory. This is replaced with `AbstractHelper::getPostGridTemplateDir`.

Filter bar and post theme templates are customizable in projects, both Blade(`.blade.php`) and normal `.php` are supported.

For example:
```bash
➜ tree web/app/themes/greenwich/app/Plugins/FLBuilder
web/app/themes/greenwich/app/Plugins/FLBuilder
├── Helper.php
└── post-grid
    ├── filter-bar-event.blade.php
    ├── filter-bar.php
    ├── post-theme-event.blade.php
    ├── post-theme-product.php
    └── post-theme.blade.php
```

```php
class Helper extends AbstractHelper
{
    /**
     * Full path to PostGrid template directory.
     *
     * @return string
     */
    public function getPostGridTemplateDir(): string
    {
        return __DIR__ . '/post-grid';
    }
}
```

## Rendering `FilterBar`

```
use App\Plugins\FLBuilder\Settings\FilterBar;

$htmlString = sage(FilterBar::class)::html($settingsObject);

// Equivalent to echo sage(FilterBar::class)::html($settingsObject);
sage(FilterBar::class)::render($settingsObject);

// Using filter
$htmlStringForFrontend = apply_filters('fl_builder_module_frontend_custom_fab_filter_bar', '');
```

### Customizing 

**Important:** Overriding `FilterBar` is not recommended:

- Preferred: Tweak your project to fit in default `FilterBar` and `PostGrid` whenever possible
- Good: Use filter bar and post theme templates, see [above](#postgrid-filter-bar-and-post-theme-templates)
- Last Resort: Replace the default `FilterBar` class with a custom one in Sage's container

If you must override `FilterBar` with a custom class **as a last resort**, you have to put it into Sage's container **after** `SageFLBuilder::init`:

```
use App\Plugins\FLBuilder\Settings\FilterBar;
use Itineris\SageFLBuilder\Settings\FilterBar as SageFLBuilderFilterBar;

$sageFLBuilder->init();
sage()->bind(SageFLBuilderFilterBar::class, FilterBar::class);
```

## Usage - Minimum

### Step 1 - Define helper class

```php
namespace App\Plugins\FLBuilder;

use Itineris\SageFLBuilder\AbstractHelper;

class Helper extends AbstractHelper
{
    // Implement all abstract methods.
}
```

### Step 2

Within `app/setup.php` / `app/farbic.php`:

```php
use App\Plugins\FLBuilder\Helper;
use Itineris\SageFLBuilder\SageFLBuilder;

$sageFLBuilder = new SageFLBuilder(
    new Helper()
);

$sageFLBuilder->init();
```

Tips: Put these lines into a class method.

## Usage - Custom PHP Module

### Step 1 - Define module class

See: https://kb.wpbeaverbuilder.com/article/124-custom-module-developer-guide

```php
namespace App\Plugins\FLBuilder\Modules\RunnerBlock;

use Itineris\SageFLBuilder\AbstractModule;
use Itineris\SageFLBuilder\AbstractHelper;

class RunnerBlock extends AbstractModule
{
    /**
     * Register the module and its form settings.
     * If needed, register a settings form to use in the "form" field type.
     */
    public static function register(): void
    {
        // Invoke `\FLBuilder::register_module` here
        // Invoke `\FLBuilder::register_settings_form` here
    }

    public function __construct()
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        parent::__construct([
            'name' => __('Runner block', 'fabric'),
            'description' => __('Runner block widget', 'fabric'),
            'category' => 'Basic',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'layout.svg',
        ]);
    }
}
```

### Step 2 - Frontend Template

Create `includes/frontend.php`:

```
<sage>/app/Plugins/FLBuilder/Modules
└── RunnerBlock
   ├── RunnerBlock.php
   └── includes
       └── frontend.php
```

### Step 3 - Add custom module into `SageFLBuilder`

```php
use App\Plugins\FLBuilder\Helper;
use App\Plugins\FLBuilder\Modules\RunnerBlock\RunnerBlock;
use Itineris\SageFLBuilder\SageFLBuilder;

$sageFLBuilder = new SageFLBuilder(
    new Helper()
);

$sageFLBuilder->add(RunnerBlock::class)
              ->init();
```

## Usage - Custom Blade Module

Similar to custom PHP module.

### Step 1 - Inherit from `AbstractBladeModule`.

```php
namespace App\Plugins\FLBuilder\Modules\BladeRunnerBlock;

use Itineris\SageFLBuilder\AbstractBladeModule;

class BladeRunnerBlock extends AbstractBladeModule
{
    // Similar to custom PHP module
}
```

### Step 2 - Frontend Template

Create `includes/frontend.blade.php`:

```
<sage>/app/Plugins/FLBuilder/Modules
└── BladeRunnerBlock
   ├── BladeRunnerBlock.php
   └── includes
       └── frontend.blade.php
```

### Step 3

```php
$sageFLBuilder->add(RunnerBlock::class, BladeRunnerBlock::class)
              ->init();
```

## Usage - Custom Settings

### Step 1 - Define Setting Class

```php
namespace App\Plugins\FLBuilder\Settings;

use Itineris\SageFLBuilder\InitializableInterface;

class MySetting implements InitializableInterface
{
    // Implement all required methods.
}
```

### Step 2

```php
$sageFLBuilder->add(RunnerBlock::class, BladeRunnerBlock::class, MySetting::class)
              ->init();
```

## Usage - Extra Settings

The following settings are disabled by default:

- [`ProductsArchive`](./src/Settings/ProductsArchive.php)
- [`FourOFourThemeLayout`](./src/Settings/ThemeLayouts/FourOFourThemeLayout.php)
- [`SearchThemeLayout`](./src/Settings/ThemeLayouts/SearchThemeLayout.php)
- [`WooCommerceThemeLayout`](./src/Settings/ThemeLayouts/WooCommerceThemeLayout.php)

To enable them:

```php
// Example: Enabling `FourOFourThemeLayout`
$sageFLBuilder->add(FourOFourThemeLayout::class)
              ->init();
```

## Usage - Exclude Default Modules / Settings

```php
$sageFLBuilder->add(RunnerBlock::class, BladeRunnerBlock::class, MySetting::class)
              ->remove(FilterBar::class, EventsArchive::class)
              ->init();
```

## Migrating from Fabric

Since `sage-flbuilder` uses PSR-4 while `Fabric` doesn't, module names are changed.
When migrating from `Fabric`, you have to *search and replace* all module name saved in database:

```bash
$ wp search-replace 'OLD_NAME' 'NEW_NAME'
$ wp search-replace 'fab_accordion' 'Accordion'
```

This is a bash script for `sage-flbuilder`'s default modules:

```bash
#!/bin/bash

declare -A modules

# Base Modules
modules[fab_accordion]=Accordion
modules[fab_alert]=Alert
modules[fab_breadcrumbs]=Breadcrumbs
modules[fab_button]=Button
modules[fab_content_image]=ContentImage
modules[fab_filter_bar]=FilterBar
modules[fab_gallery]=Gallery
modules[fab_gravity_form]=GravityForm
modules[fab_page_heading]=PageHeading
modules[fab_page_slider]=PageSlider
modules[fab_secondary_nav]=SecondaryNav
modules[fab_table]=Table
modules[fab_testimonial]=Testimonial
modules[fab_video]=Video

# Add project-specific modules here, for example:
# modules[gh_welcome_section]=WelcomeSection

for i in "${!modules[@]}"
do
    echo "$i -> ${modules[$i]}"
    command="wp search-replace '$i' '${modules[$i]}' --dry-run"
    echo "Running $command"
    result=$(eval "${command} 2> /dev/null")
    if [ $? -eq 0 ];then
        echo "${result##*$'\n'}"
        printf "\n------------\n\n"
    else
        echo "Failed!"
        echo $(result | tail -n 1)
        break
    fi

done
```
