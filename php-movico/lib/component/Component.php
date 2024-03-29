<?php
abstract class Component {
	
	private $parent;
	protected $children = array();
	protected $id;
	protected $class;
	
	protected static $settings = null;
	
	protected $rendered = "true";
	
	public function __construct() {
		$this->id = rand(100000, 999999);
		if(is_null(self::$settings)) {
			self::$settings = Singleton::create("Settings");
		}
	}
	
	public function addChild(Component $component) {
		$parentClass = get_class($this);
		if(get_class($this) == "HtmlComponent") {
			$parentClass = $this->getTagName();
		}
		$this->children[] = $component;
		$component->setParent($this);
	}
	
	public function render($index=null) {
		return $this->shouldBeRendered($index) ? $this->doRender($index) : "";
	}
	
	public abstract function doRender($index=null);
	
	public function renderChildren($include=array(), $exclude=array(), $index=null) {
		$result = "";
		$includeAll = empty($include);
		foreach($this->children as $child) {
			$childClass = get_class($child);
			$childInInclude = in_array($childClass, $include);
			$childInExclude = in_array($childClass, $exclude);
			if(($includeAll && !$childInExclude) || $childInInclude) {
				$result .= $child->render($index);
			}
		}
		return $result;
	}
	
	private function setParent(Component $parent) {
		$this->parent = $parent;
	}
	
	protected function getParent() {
		return $this->parent;
	}
	
	protected function getFirstAncestorOfType($className) {
		$result = null;
		$current = $this;
		while(!ClassUtil::isSubclassOf(get_class($current), $className)) {
			$parent = $current->getParent();
			if(get_class($parent) === "View" && $className !== "View") {
				throw new NoSuchAnchestorComponentException(get_class($this), $className);
			}
			$current = $parent;
		}
		return $current;
	}
	
	protected function hasAnchestorOfType($className) {
		try {
			$this->getFirstAncestorOfType($className);
			return true;
		} catch(NoSuchAnchestorComponentException $e) {
			return false;
		}
	}
	
	protected function hasDescendantOfType($type) {
		return $this->checkHasDescendantOfType($this, $type);
	}
	
	private function checkHasDescendantOfType(Component $comp, $type) {
		$children = $comp->getChildren();
		foreach($children as $child) {
			if($child instanceof $type) {
				return true;
			}
			if($this->checkHasDescendantOfType($child, $type)) {
				return true;
			}
		}
		return false;
	}
	
	protected function getConvertedValue($string, $rowIndex=null) {
		preg_match_all("/#\{[a-zA-Z\.]+\}/", $string, $matches);
		if(count($matches)==1 && isset($matches[0][0]) && $matches[0][0]==$string) {
			return $this->getBeanValue($matches[0][0], $rowIndex);
		}
		$replaces = array();
		foreach($matches as $match) {
			for($i=0; $i<count($match); $i++) {
				$replaces[$match[$i]] = $this->getBeanValue($match[$i], $rowIndex);
			}
		}
		return str_replace(array_keys($replaces), array_values($replaces), $string);
	}

	private function getBeanValue($valueExpression, $rowIndex=null) {
		list($beanClass, $nestedProperty) = BeanUtil::getBeanAndProperties($valueExpression);
		try {
			$beanObj = BeanLocator::get($beanClass);
		} catch(NoSuchBeanException $e) {
			try {
				$dataSeries = $this->getFirstAncestorOfType("DataSeries");
				if($dataSeries->getVar() !== $beanClass  || is_null($rowIndex)) {
					throw new NoSuchBeanException($beanClass);
				}
				$rows = $dataSeries->getRows();
				$beanObj = $rows[$rowIndex];
			} catch(NoSuchAnchestorComponentException $e) {
				throw new NoSuchBeanException($beanClass);
			}
		}
		return ReflectionUtil::callNestedGetter($beanObj, $nestedProperty);
	}
	
	protected function hasChildren() {
		return !empty($this->children);
	}
	
	protected function getChildrenOfType($class) {
		$result = array();
		foreach($this->children as $child) {
			if($child instanceof $class) {
				$result[] = $child;
			}
		}
		return $result;
	}
	
	protected function hasChildrenOfType($class) {
		$children = $this->getChildrenOfType($class);
		return !empty($children);
	}
	
	protected function getChildren() {
		return $this->children;
	}

	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setClass($class) {
		$this->class = $class;
	}
	
	public function getClass() {
		return $this->class;
	}
	
	public function getClassStr() {
		return empty($this->class) ? "" : " class=\"".$this->class."\"";
	}
	
	public function setRendered($rendered) {
		$this->rendered = $rendered;
	}
	
	public function shouldBeRendered($index) {
		$renderedStr = String::create($this->rendered);
		if($renderedStr->contains("!")) {
			return !$this->getConvertedValue($renderedStr->replace("!", "")->__toString(), $index);
		} else {
			return $this->getConvertedValue($this->rendered, $index);
		}
	}
	
}
?>