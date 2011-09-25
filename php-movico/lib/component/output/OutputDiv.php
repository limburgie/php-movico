<?php
class OutputDiv extends Component {
	
	private $value;
	
	public function setValue($value) {
		$this->value = $value;
	}

	public function doRender($row=null) {
		$c = $this->class;
		$class = empty($c) ? "" : " class=\"$c\"";
		return "<div$class>".$this->getConvertedValue($this->value, $row)."</div>";
	}
	
	public function getValidParents() {
		return array("View", "Form", "PanelGrid", "Column", "ColHeader", "PanelGroup", "PanelSeries", "PanelGridSeries", "div", "p", "h1", "h2", "h3", "h4", "h5", "h6");
	}
	
}
?>