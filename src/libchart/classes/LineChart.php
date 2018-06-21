<?php

	class LineChart extends BarChart
	{
		
		function LineChart($width = 600, $height = 250)
		{
			parent::BarChart($width, $height);

			$this->setLabelMarginLeft(50);
			$this->setLabelMarginRight(50);
			$this->setLabelMarginTop(40);
			$this->setLabelMarginBottom(50);
		}
		
		function printAxis()
		{

			
			if($this->sampleCount < 2)
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

			$columnWidth = ($this->graphBRX - $this->graphTLX) / ($this->sampleCount - 1);

			reset($this->point);

			for($i = 0; $i < $this->sampleCount; $i++)
			{
				$x = $this->graphTLX + $i * $columnWidth;

				imagerectangle($this->img, $x - 1, $this->graphBRY + 2, $x, $this->graphBRY + 3, $this->axisColor1->getColor($this->img));
				imagerectangle($this->img, $x - 1, $this->graphBRY, $x, $this->graphBRY + 1, $this->axisColor2->getColor($this->img));

				$point = current($this->point);
				next($this->point);

				$text = $point->getX();

				$this->text->printDiagonal($this->img, $x - 5, $this->graphBRY + 10, $this->textColor, $text);
			}
		}

		function printLine()
		{
			
			if($this->sampleCount < 2)
				return;
			
			reset($this->point);

			$minValue = $this->axis->getLowerBoundary();
			$maxValue = $this->axis->getUpperBoundary();
			
			$columnWidth = ($this->graphBRX - $this->graphTLX) / ($this->sampleCount - 1);

			$x1 = null;
			$y1 = null;

			for($i = 0; $i < $this->sampleCount; $i++)
			{
				$x2 = $this->graphTLX + $i * $columnWidth;

				$point = current($this->point);
				next($this->point);

				$value = $point->getY();
				
				$y2 = $this->graphBRY - ($value - $minValue) * ($this->graphBRY - $this->graphTLY) / ($this->axis->displayDelta);


				if($x1)
				{
					$this->primitive->line($x1, $y1, $x2, $y2, $this->barColor4, 4);
					$this->primitive->line($x1, $y1 - 1, $x2, $y2 - 1, $this->barColor3, 2);
				}
				
				$x1 = $x2;
				$y1 = $y2;
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
			$this->printLine();

			if(isset($fileName))
				imagepng($this->img, $fileName);
			else
				imagepng($this->img);
		}
	}
?>
