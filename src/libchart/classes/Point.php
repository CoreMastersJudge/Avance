<?php

	class Point
	{
		
		function Point($x, $y, $c=null)
		{
			$this->x = $x;
			$this->y = $y;
			if($c != null) {
				list($r,$g,$b) = $c;
				$this->color = new Color($r,$g,$b);
				$shadowFactor = 0.5;
                        	$this->shadowColor = new Color($r * $shadowFactor,
                                	                        $g * $shadowFactor,
                                        	                $b * $shadowFactor);
			} else {
				$this->color = null;
				$this->shadowColor = null;
			}
		}
		
		function getX()
		{
			return $this->x;
		}
		
		function getY()
		{
			return $this->y;
		}

		function getColor() { return $this->color; }
		function getShadowColor() { return $this->shadowColor; }
	}
?>
