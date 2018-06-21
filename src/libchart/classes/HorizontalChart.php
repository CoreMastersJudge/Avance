<?php

	class HorizontalChart extends BarChart
	{
		
		function HorizontalChart($width = 600, $height = 250)
		{
			parent::BarChart($width, $height);

			$this->setLabelMarginLeft(150);
			$this->setLabelMarginRight(30);
			$this->setLabelMarginTop(40);
			$this->setLabelMarginBottom(30);
		}

		function printAxis()
		{
			
			if(!$this->sampleCount)
				return;
		
			$minValue = $this->axis->getLowerBoundary();
			$maxValue = $this->axis->getUpperBoundary();
			$stepValue = $this->axis->getTics();

			for($value = $minValue; $value <= $maxValue; $value += $stepValue)
			{
				$x = $this->graphTLX + ($value - $minValue) * ($this->graphBRX - $this->graphTLX) / ($this->axis->displayDelta);

				imagerectangle($this->img, $x - 1, $this->graphBRY + 2, $x, $this->graphBRY + 3, $this->axisColor1->getColor($this->img));
				imagerectangle($this->img, $x - 1, $this->graphBRY, $x, $this->graphBRY + 1, $this->axisColor2->getColor($this->img));

				$this->text->printText($this->img, $x, $this->graphBRY + 5, $this->textColor, $value, $this->text->fontCondensed, $this->text->HORIZONTAL_CENTER_ALIGN);
			}

			$rowHeight = ($this->graphBRY - $this->graphTLY) / $this->sampleCount;

			reset($this->point);

			for($i = 0; $i <= $this->sampleCount; $i++)
			{
				$y = $this->graphBRY - $i * $rowHeight;

				imagerectangle($this->img, $this->graphTLX - 3, $y, $this->graphTLX - 2, $y + 1, $this->axisColor1->getColor($this->img));
				imagerectangle($this->img, $this->graphTLX - 1, $y, $this->graphTLX, $y + 1, $this->axisColor2->getColor($this->img));

				if($i < $this->sampleCount)
				{
					$point = current($this->point);
					next($this->point);
	
					$text = $point->getX();

					$this->text->printText($this->img, $this->graphTLX - 5, $y - $rowHeight / 2, $this->textColor, $text, $this->text->fontCondensed, $this->text->HORIZONTAL_RIGHT_ALIGN | $this->text->VERTICAL_CENTER_ALIGN);
				}
			}
		}


		function printBar()
		{
			
			if(!$this->sampleCount)
				return;
			
			reset($this->point);

			$minValue = $this->axis->getLowerBoundary();
			$maxValue = $this->axis->getUpperBoundary();
			$stepValue = $this->axis->getTics();

			$rowHeight = ($this->graphBRY - $this->graphTLY) / $this->sampleCount;

			for($i = 0; $i < $this->sampleCount; $i++)
			{
				$y = $this->graphBRY - $i * $rowHeight;

				$point = current($this->point);
				next($this->point);

				$value = $point->getY();
				
				$xmax = $this->graphTLX + ($value - $minValue) * ($this->graphBRX - $this->graphTLX) / ($this->axis->displayDelta);

				$this->text->printText($this->img, $xmax + 5, $y - $rowHeight / 2, $this->textColor, $value, $this->text->fontCondensed, $this->text->VERTICAL_CENTER_ALIGN);

				$y1 = $y - $rowHeight * 4 / 5;
				$y2 = $y - $rowHeight * 1 / 5;

				imagefilledrectangle($this->img, $this->graphTLX + 1, $y1, $xmax, $y2, $this->barColor2->getColor($this->img));
				imagefilledrectangle($this->img, $this->graphTLX + 2, $y1+1, $xmax - 4, $y2, $this->barColor1->getColor($this->img));
			}
		}
		
		function render($fileName = null)
		{
			$this->computeBound();
			$this->computeLabelMargin();
			$this->createImage();
			$this->printLogo();
			$this->printTitle();
			$this->printAxis();
			$this->printBar();

			if(isset($fileName))
				imagepng($this->img, $fileName);
			else
				imagepng($this->img);
		}
	}
?>
