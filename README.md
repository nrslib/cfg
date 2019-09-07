# cfg
Class File Generator

# Quick Examples

```
use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;

$meta = new ClassMeta('MyTestClass', 'nrslib');
$renderer = new ClassRenderer();
echo $renderer->render($meta);
```

# Setup

## Class

### Class

```
$meta = new ClassMeta('MyTestClass', 'nrslib');
$meta->setupClass()
    ->addUse('nrslib\Cfg\ClassRenderer')
    ->addUse('nrslib\Cfg\Meta\Classes\ClassMeta')
    ->setConstructor(function ($define) {
        $define
            ->addArgument('renderer', 'ClassRenderer')
            ->addBody('$this->renderer = $renderer;')
            ->addArgument('meta', 'ClassMeta')
            ->addBody('$this->meta = $meta;');
    });
```

### Fields

```
$meta = new ClassMeta('MyTestClass', 'nrslib');
$meta->setupFields()
    ->addField('testField', 'string')
    ->addField('testField2', 'string', AccessLevel::public())
    ->addField('renderer', 'ClassRenderer')
    ->addField('meta', 'ClassMeta');
```

### Methods

```
$meta = new ClassMeta('MyTestClass', 'nrslib');
$meta->setupMethods()
    ->addMethod('test', function ($define) {
        $define->setAccessLevel(AccessLevel::public())
            ->addArgument('test', 'string')
            ->addArgument('test2', 'string');
    })
    ->addMethod('render', function ($define) {
        $define->addBody('$this->renderer->render($this->meta');
    });
```

## Interface

### Methods
```
$meta = new InterfaceMeta('MyInterface', 'nrslib');

$meta->getMethodsSetting()
    ->addMethod('testMethod', function($define) {
        $define->addArgument('arg', 'string')
            ->addArgument('arg2', 'string');
    })
    ->addMethod('testMethod2', function() {});
```
