<?php


namespace nrslib\Cfg\Parser;


use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition;
use nrslib\Cfg\Meta\Settings\ClassSetting;
use nrslib\Cfg\Meta\Settings\FieldsSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;
use nrslib\Cfg\Meta\Words\AccessLevel;
use nrslib\Cfg\Parser\Builder\StatementBuilderFactory;
use PhpParser\Comment;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Use_;

class NodeToMetaConverter
{
    private $statementBuilderFactory;

    public function __construct(StatementBuilderFactory $statementBuilderFactory)
    {
        $this->statementBuilderFactory = $statementBuilderFactory;
    }

    public function convert(Name $aNamespace, array $aUses, Class_ $clazz): ClassMeta
    {
        $className = $clazz->name->name;
        $meta = new ClassMeta($className, $aNamespace);

        $this->setupClass($meta->setupClass(), $aUses, $clazz);
        $this->setupFields($meta->setupFields(), $clazz);
        $this->setupMethods($meta->setupMethods(), $clazz);

        return $meta;
    }

    /**
     * @param ClassSetting $setting
     * @param array $aUses
     * @param Class_ $clazz
     */
    private function setupClass(ClassSetting $setting, array $aUses, Class_ $clazz)
    {
        foreach ($aUses as $use) {
            $useText = $this->convertUse_($use);
            $setting->addUse($useText);
        }

        if (!is_null($clazz->extends)) {
            $extendsClass = implode('\\', $clazz->extends->parts);
            $setting->setExtend($extendsClass);
        }

        if (!empty($clazz->implements)) {
            foreach ($clazz->implements as $implement) {
                $setting->addImplement($implement);
            }
        }

        $constructorMethod = $this->extractConstructor($clazz);
        if (!is_null($constructorMethod)) {
            $setting->setConstructor(function ($constructorDefinition) use ($constructorMethod) {
                $this->setupConstructor($constructorDefinition, $constructorMethod);
            });
        }
    }

    /**
     * @param Use_ $use
     * @return string
     */
    private function convertUse_(Use_ $use)
    {
        $useuse = $use->uses[0];
        $importTarget = implode('\\', $useuse->name->parts);
        $useStmt = $importTarget;
        if (!is_null($useuse->alias)) {
            $useStmt .= ' as ' . $useuse->alias->name;
        }

        return $useStmt;
    }

    /**
     * @param ConstructorDefinition $definition
     * @param ClassMethod $classMethod
     * @throws \Exception
     */
    private function setupConstructor(ConstructorDefinition $definition, ClassMethod $classMethod)
    {
        $this->setupMethodCore($classMethod,
            function ($comment) use ($definition) {
                $definition->addComment($comment);
            },
            function ($name, $type) use ($definition) {
                $definition->addArgument($name, $type);
            },
            function ($text) use ($definition) {
                $definition->addBody($text);
            });
    }

    /**
     * @param FieldsSetting $setting
     * @param Class_ $clazz
     */
    private function setupFields(FieldsSetting $setting, Class_ $clazz)
    {
        $props = $this->extractProperties($clazz);
        foreach ($props as $stmtProperty) {
            $prop = $stmtProperty->props[0];
            $type = $this->extractPropertyType($stmtProperty);
            $accessor = $this->getAccessor($stmtProperty);
            $setting->addField($prop->name, $type, $accessor);
        }
    }

    /**
     * @param MethodsSetting $methodsSetting
     * @param Class_ $clazz
     */
    private function setupMethods(MethodsSetting $methodsSetting, Class_ $clazz)
    {
        $methods = $this->extractMethods($clazz);

        foreach ($methods as $method) {
            $methodsSetting->addMethod($method->name->name, function ($methodDefinition) use ($method) {
                $this->setupMethodCore($method,
                    function ($comment) use ($methodDefinition) {
                        $methodDefinition->addComment($comment);
                    },
                    function ($name, $type) use ($methodDefinition) {
                        $methodDefinition->addArgument($name, $type);
                    },
                    function ($text) use ($methodDefinition) {
                        $methodDefinition->addBody($text);
                    });

                $accessor = $this->getAccessor($method);
                $methodDefinition->setAccessLevel($accessor);

                if (!is_null($method->returnType)) {
                    $methodDefinition->setReturnType($method->returnType);
                }
            });
        }
    }

    /**
     * @param ClassMethod $classMethod
     * @param callable $addArgument (string $name, string $type) => void
     * @param callable $addBody (string $text) => void;
     * @throws \Exception
     */
    private function setupMethodCore(ClassMethod $classMethod, callable $addComment, callable $addArgument, callable $addBody)
    {
        $attributes = $classMethod->getAttributes();
        if (array_key_exists('comments', $attributes)) {
            $comments = $attributes["comments"];

            foreach ($comments as $comment)
            {
                $commentTexts = $this->extractRawComments($comment);
                foreach ($commentTexts as $commentText)
                {
                    $addComment($commentText);
                }
            }
        }

        foreach ($classMethod->params as $param) {
            $addArgument($param->var->name, $param->type);
        }

        foreach ($classMethod->stmts as $stmt) {
            $builder = $this->statementBuilderFactory->getBuilder($stmt);
            $text = $builder->build();
            foreach ($text as $tex) {
                $addBody($tex);
            }
        }
    }

    /**
     * @param Class_ $clazz
     * @return Property[]
     */
    private function extractProperties(Class_ $clazz): array
    {
        $props = array_filter($clazz->stmts, function ($stmt) {
            return $stmt instanceof Property;
        });
        $props = array_values($props);

        return $props;
    }

    /**
     * @param Property $property
     * @return string null: empty
     */
    private function extractPropertyType(Property $property)
    {
        $comments = $property->getComments();
        foreach ($comments as $comment) {
            $text = $comment->getText();
            if (preg_match('/.*@var (\w+) .*/', $text, $match)) {
                return $match[1];
            }
        }

        return '';
    }

    /**
     * @param Class_ $clazz
     * @return ClassMethod|null
     */
    private function extractConstructor(Class_ $clazz): ?ClassMethod
    {
        $methods = array_filter($clazz->stmts, function ($stmt) {
            return $stmt instanceof ClassMethod;
        });
        $methods = array_filter($methods, function ($method) {
            return $result = $method->name->name === '__construct';
        });
        $methods = array_values($methods);

        if (empty($methods)) {
            return null;
        }

        return $methods[0];
    }

    /**
     * @param Class_ $clazz
     * @return ClassMethod[]
     */
    private function extractMethods(Class_ $clazz): array
    {
        $methods = array_filter($clazz->stmts, function ($stmt) {
            return $stmt instanceof ClassMethod;
        });
        $methods = array_filter($methods, function ($method) {
            return $method->name->name !== '__construct';
        });
        $methods = array_values($methods);

        return $methods;
    }

    /**
     * @param Property|ClassMethod $prop
     * @return AccessLevel
     */
    private function getAccessor($prop): AccessLevel
    {
        if ($prop->isPublic()) {
            return AccessLevel::public();
        } else if ($prop->isProtected()) {
            return AccessLevel::protected();
        } else {
            return AccessLevel::private();
        }
    }

    /**
     * @param Comment $comment
     * @return array
     */
    private function extractRawComments(Comment $comment): array
    {
        $text = $comment->getText();
        $lines = explode("\n", $text);
        $comments = array_map([$this, 'commentLineToRawText'], $lines);
        $count = count($comments);
        if ($count > 0)
        {
            $comments = array_slice($comments, 1, $count - 1);
        }
        return array_filter($comments, function($text) { return !is_null($text); } );
    }

    private function commentLineToRawText(string $org): ?string
    {
        if (preg_match('/.*\\*(.*)\\r/', $org, $match)) {
            return ltrim($match[1]);
        }
        return null;
    }
}