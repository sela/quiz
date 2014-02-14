<?php

/**
 * Widget controller
 */
class WidgetController extends BaseController {
    

	/**
	 * Index action
	 * 
	 * @return string
	 */
	public function executeIndex() {
		$letters = array(
			'a' => 'A',
			'b' => 'B',
			'c' => 'C',
			'd' => 'D',
			'e' => 'E',
			'f' => 'F',
			'g' => 'G',
			'h' => 'H',
			'i' => 'I',
			'j' => 'J',
			'k' => 'K',
			'l' => 'L',
			'm' => 'M',
			'n' => 'N',
			'o' => 'O',
			'p' => 'P',
			'q' => 'Q',
			'r' => 'R',
			's' => 'S',
			't' => 'T',
			'u' => 'U',
			'v' => 'V',
			'w' => 'W',
			'x' => 'X',
			'y' => 'Y',
			'z' => 'Z',
			'0' => 'Others'
		);

		$this->setViewVariable('letters', $letters);

		return $this->renderView('index');
	}

	/**
	 * List action
         * List all the widgets for a letter
	 *
	 * @return string
	 */
	public function executeList() {
		// todo: your controller code
                $letter = $this->getRequestParameter($param);
                $widget_service = new CacheService();
                $widgets_letter = $widget_service->getWidgets();
                $this->setViewVariable('widgets', $widgets_letter);

		return $this->renderView('list');
	}
}
