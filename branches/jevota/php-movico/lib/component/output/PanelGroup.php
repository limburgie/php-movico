<?
class PanelGroup extends Component {
	
	public function doRender($rowIndex=null) {
		return $this->renderChildren();
	}
	
	public function getValidParents() {
		return array("View", "Form", "PanelGrid", "Column", "ColHeader", "PanelGroup", "div", "li", "ul");
	}
	
}
?>