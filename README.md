# itineris/sage-flbuilder

## Minimum Requirements

* PHP v7.2
* Sage v9.0.0-beta.4
* Advanced Custom Fields PRO v5.6.9
* Beaver Builder Plugin (Pro Version) v2.0.6.1
* Beaver Themer v1.1.0.3

You must ensure these 3 required plugins installed via Bedrock's composer.json.

## Installation

Sage theme's composer.json:
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/ItinerisLtd/sage-flbuilder.git"
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
* Do not copy and paste from default modules - huge technical debt in this package. 

## Usage - Minimum

### Step 1 - Define helper class

```php
namespace App\Plugins\FLBuilder;

use Itineris\SageFLBuilder\AbstractHelper;

class Helper extends AbstractHelper
{
    // Impletement all abstract methods.
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

See: [https://kb.wpbeaverbuilder.com/article/124-custom-module-developer-guide

```php
namespace App\Plugins\FLBuilder\Modules\RunnerBlock;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractModule;
use Itineris\SageFLBuilder\AbstractHelper;

class RunnerBlock extends AbstractBladeModule
{
    /**
     * Register the module and its form settings.
     * If needed, register a settings form to use in the "form" field type.
     */
    public static function register(): void
    {
        // Call `\FLBuilder::register_module` here.
        // Call `\FLBuilder::register_settings_form` here.
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
            'url' => asset_path(__DIR__),
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

### Step 1 - Subclass from `AbstractBladeModule`.

```php
class BladeRunnerBlock extends AbstractBladeModule
{
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

## Usage - Exclude Default Modules / Settings

```php
$sageFLBuilder->add(RunnerBlock::class, BladeRunnerBlock::class, MySetting::class)
              ->remove(FilterBar::class, EventsArchive::class)
              ->init();
```
