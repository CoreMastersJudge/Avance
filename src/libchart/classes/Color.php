<?php

	class Color
	{
		
		function Color($red, $green, $blue, $alpha = 0)
		{
			$this->red = (int)$red;
			$this->green = (int)$green;
			$this->blue = (int)$blue;
			$this->alpha = (int)round($alpha * 127.0 / 255);
			
			$this->gdColor = null;
		}
		
		function getColor($img)
		{
			
			if(!$this->gdColor)
			{
				if($this->alpha == 0 || !function_exists('imagecolorallocatealpha'))
					$this->gdColor = imagecolorallocate($img, $this->red, $this->green, $this->blue);
				else
					$this->gdColor = imagecolorallocatealpha($img, $this->red, $this->green, $this->blue, $this->alpha);
			}
			
			return $this->gdColor;
		}
	}
?>
