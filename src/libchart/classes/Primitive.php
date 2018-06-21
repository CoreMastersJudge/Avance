<?php

	class Primitive
	{

		
		function Primitive($img)
		{
			$this->img = $img;
		}
		
		function line($x1, $y1, $x2, $y2, $color, $width = 1)
		{
			imagefilledpolygon($this->img, array($x1, $y1 - $width / 2, $x1, $y1 + $width / 2, $x2, $y2 + $width / 2, $x2, $y2 - $width / 2), 4, $color->getColor($this->img));
		}
	}
?>
