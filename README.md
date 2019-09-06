# cfg
Class File Generator

# Quick Examples

```
use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;

$meta = new ClassMeta();
$renderer = new ClassRenderer();
echo $renderer->render($meta);
```

# Setup

## Class

### Class

```
$meta = new ClassMeta();
$meta->setupClass()
    ->setName("MyTestClass")
    ->setNamespace("nrslib")
    ->setConstructor(function ($define) {
        $define->addArgument('testField', 'string')
            ->addBody('$this->testField = $testField;');
    });
```

### Fields

```
$meta = new ClassMeta();
$meta->setupFields()
    ->addField('testField', 'string')
    ->addField('testField2', 'string', AccessLevel::public());
```

### Methods

```
$meta = new ClassMeta();
$meta->setupMethods()
    ->addMethod('test', function ($define) {
        $define->setAccessLevel(AccessLevel::public())
            ->addArgument('test', 'string')
            ->addArgument('test2', 'string');
    })
    ->addMethod('test2', function ($define) {
        $define->addBody('$testField = 1;');
    });
```