<?php

	class Chart
	{

		
		function chart($width, $height)
		{
			$this->width = $width;
			$this->height = $height;

			$this->reset();
		}

	
		function reset()
		{
			$this->text = new Text();		
			$this->point = array();

			unset($this->lowerBound);
			unset($this->upperBound);

			$this->setTitle("Untitled chart");
			$this->setLogo(dirname(__FILE__) . "/../images/PoweredBy.png");
		}

		
		function addPoint($point)
		{
			array_push($this->point, $point);
		}

		
		function setTitle($title)
		{
			$this->title = $title;
		}

		
		function setLogo($logoFileName)
		{
			$this->logoFileName = $logoFileName;
		}

		
		function printTitle()
		{
			$this->text->printCentered($this->img, ($this->labelMarginTop + $this->margin) / 2, $this->textColor, $this->title, $this->text->fontCondensedBold);
		}

		
		function printLogo()
		{
			@$logoImage = imageCreateFromPNG($this->logoFileName);

			if($logoImage)
				imagecopymerge($this->img, $logoImage, 2*$this->margin, $this->margin, 0, 0, imagesx($logoImage), imagesy($logoImage), 100);
		}


		function setMargin($margin)
		{
			$this->margin = $margin;
		}

	
		function setLabelMarginLeft($labelMarginLeft)
		{
			$this->labelMarginLeft = $labelMarginLeft;
		}

		
		function setLabelMarginRight($labelMarginRight)
		{
			$this->labelMarginRight = $labelMarginRight;
		}

		
		function setLabelMarginTop($labelMarginTop)
		{
			$this->labelMarginTop = $labelMarginTop;
		}

		
		function setLabelMarginBottom($labelMarginBottom)
		{
			$this->labelMarginBottom = $labelMarginBottom;
		}

		
		function createImage()
		{
			$this->img = imagecreatetruecolor($this->width, $this->height);
			
			$this->primitive = new Primitive($this->img);

			$this->backGroundColor = new Color(255, 255, 255);
			$this->textColor = new Color(0, 0, 0);

			imagefilledrectangle($this->img, 0, 0, $this->width - 1, $this->height - 1, $this->backGroundColor->getColor($this->img));
		}
	}
?>
