<?php

	class BarChart extends Chart
	{
		
		function BarChart($width, $height)
		{
			parent::Chart($width, $height);

			$this->setMargin(5);
			$this->setLowerBound(0);
		}
		
		function computeBound()
		{

			$point = current($this->point);
			
			if(!$point)
			{
				$yMin = 0;
				$yMax = 1;
			}
			else
			{
				$yMax = $yMin = $point->getY();
	
				foreach($this->point as $point)
				{
					$y = $point->getY();
	
					if($y < $yMin)
						$yMin = $y;
	
					if($y > $yMax)
						$yMax = $y;
				}
			}

			$this->yMinValue = isset($this->lowerBound) ? $this->lowerBound : $yMin;
			$this->yMaxValue = isset($this->upperBound) ? $this->upperBound : $yMax;

			$this->sampleCount = count($this->point);
		}
		
		function setLowerBound($lowerBound)
		{
			$this->lowerBound = $lowerBound;
		}
		
		function setUpperBound($upperBound)
		{
			$this->upperBound = $upperBound;
		}

	
		function computeLabelMargin()
		{
			$this->axis = new Axis($this->yMinValue, $this->yMaxValue);
			$this->axis->computeBoundaries();

			$this->graphTLX = $this->margin + $this->labelMarginLeft;
			$this->graphTLY = $this->margin + $this->labelMarginTop;
			$this->graphBRX = $this->width - $this->margin - $this->labelMarginRight;
			$this->graphBRY = $this->height - $this->margin - $this->labelMarginBottom;
		}
		
		function createImage()
		{
			parent::createImage();

			$this->axisColor1 = new Color(201, 201, 201);
			$this->axisColor2 = new Color(158, 158, 158);

			$this->aquaColor1 = new Color(242, 242, 242);
			$this->aquaColor2 = new Color(231, 231, 231);
			$this->aquaColor3 = new Color(239, 239, 239);
			$this->aquaColor4 = new Color(253, 253, 253);

			$this->barColor1 = new Color(42, 71, 181);
			$this->barColor2 = new Color(33, 56, 143);

			$this->barColor3 = new Color(172, 172, 210);
			$this->barColor4 = new Color(117, 117, 143);
			

			$aquaColor = Array($this->aquaColor1, $this->aquaColor2, $this->aquaColor3, $this->aquaColor4);

			for($i = $this->graphTLY; $i < $this->graphBRY; $i++)
			{
				$color = $aquaColor[($i + 3) % 4];
				$this->primitive->line($this->graphTLX, $i, $this->graphBRX, $i, $color);
			}


			imagerectangle($this->img, $this->graphTLX - 1, $this->graphTLY, $this->graphTLX, $this->graphBRY, $this->axisColor1->getColor($this->img));
			imagerectangle($this->img, $this->graphTLX - 1, $this->graphBRY, $this->graphBRX, $this->graphBRY + 1, $this->axisColor1->getColor($this->img));
		}
	}
?>
