<?php

	class VerticalChart extends BarChart
	{

		function VerticalChart($width = 600, $height = 250)
		{
			parent::BarChart($width, $height);

			$this->setLabelMarginLeft(50);
			$this->setLabelMarginRight(30);
			$this->setLabelMarginTop(40);
			$this->setLabelMarginBottom(50);
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
				$y = $this->graphBRY - ($value - $minValue) * ($this->graphBRY - $this->graphTLY) / ($this->axis->displayDelta);

				imagerectangle($this->img, $this->graphTLX - 3, $y, $this->graphTLX - 2, $y + 1, $this->axisColor1->getColor($this->img));
				imagerectangle($this->img, $this->graphTLX - 1, $y, $this->graphTLX, $y + 1, $this->axisColor2->getColor($this->img));

				$this->text->printText($this->img, $this->graphTLX - 5, $y, $this->textColor, $value, $this->text->fontCondensed, $this->text->HORIZONTAL_RIGHT_ALIGN | $this->text->VERTICAL_CENTER_ALIGN);
			}

			$columnWidth = ($this->graphBRX - $this->graphTLX) / $this->sampleCount;

			reset($this->point);

			for($i = 0; $i <= $this->sampleCount; $i++)
			{
				$x = $this->graphTLX + $i * $columnWidth;

				imagerectangle($this->img, $x - 1, $this->graphBRY + 2, $x, $this->graphBRY + 3, $this->axisColor1->getColor($this->img));
				imagerectangle($this->img, $x - 1, $this->graphBRY, $x, $this->graphBRY + 1, $this->axisColor2->getColor($this->img));

				if($i < $this->sampleCount)
				{
					$point = current($this->point);
					next($this->point);
	
					$text = $point->getX();

					$this->text->printDiagonal($this->img, $x + $columnWidth * 1 / 3, $this->graphBRY + 10, $this->textColor, $text);
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

			$columnWidth = ($this->graphBRX - $this->graphTLX) / $this->sampleCount;

			for($i = 0; $i < $this->sampleCount; $i++)
			{
				$x = $this->graphTLX + $i * ($this->graphBRX - $this->graphTLX) / $this->sampleCount;

				$point = current($this->point);
				next($this->point);

				$value = $point->getY();
				
				$ymin = $this->graphBRY - ($value - $minValue) * ($this->graphBRY - $this->graphTLY) / ($this->axis->displayDelta);

				$this->text->printText($this->img, $x + $columnWidth / 2, $ymin - 5, $this->textColor, $value, $this->text->fontCondensed, $this->text->HORIZONTAL_CENTER_ALIGN | $this->text->VERTICAL_BOTTOM_ALIGN);

				$x1 = $x + $columnWidth * 1 / 5;
				$x2 = $x + $columnWidth * 4 / 5;

				imagefilledrectangle($this->img, $x1, $ymin, $x2, $this->graphBRY - 1, $this->barColor2->getColor($this->img));
				imagefilledrectangle($this->img, $x1 + 1, $ymin + 1, $x2 - 4, $this->graphBRY - 1, $this->barColor1->getColor($this->img));
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
