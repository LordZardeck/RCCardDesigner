<?php

	require_once(dirname(__FILE__) . '/Sprite.php');

	define('CARD_DEF', 'card_definitions/');
	define('DEF_FILE', 'card_def.json');

	class Card
	{

		private $_width = 344;
		private $_height = 512;

		// Contains the main image data. All editing to be palced on final image is applied to this iable
		private $_cardBase;

		// Contains the positioning configuration for the card definition
		private $_cardDef;

		// The border to use
		private $_border = 'ur';

		// The card's type
		private $_type = 'hero';

		// The card's brigade
		private $_brigade = 'blue';

		// The card's title
		private $_title = null;
		private $_titleColor = null;
		private $_titleShadow = null;

		// The card's abilities
		private $_strength = null;
		private $_toughness = null;
		private $_abilityColor = null;

		// The card's background image
		private $_background = null;
		private $_backgroundX = 0;
		private $_backgroundY = 0;
		private $_backgroundWidth = null;

		// The card's class
		private $_class = null;

		// The card's special ability
		private $_specialAbility = null;
		private $_specialColor = null;
		private $_specialShadow = 'black';

		// The card's identifier
		private $_identifier = null;
		private $_identifierColor = null;
		private $_identifierShadow = null;

		// The card's verse
		private $_verse = null;
		private $_verseSize = 12;

		// The card's reference
		private $_reference = null;

		// The card's set icon
		private $_setIcon = 'assets/r.png';

		// The card's artist
		private $_artist = 'Illus. Artist Unknown';

		// The card's copyright
		private $_copyright = 'by Redemption Connect Card Designer';

		// Maps out where everything should be positioned on the border
		private $_borderMap = array(
			'black1' => array(
				'brigade' => array('x' => 8, 'y' => 3),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 45, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 480),
				'copyright' => array('x' => 315, 'y' => 492),
				'back' => array('x' => 36, 'y' => 42, 'width' => 278, 'height' => 302),
				'class' => array('x' => 25, 'y' => 80),
				'identifier' => array('x' => 37, 'y' => 354, 'size' => 8),
				'set' => array('x' => 45, 'y' => 478)
			),

			'navy' => array(
				'brigade' => array('x' => 8, 'y' => 3),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 45, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 480),
				'copyright' => array('x' => 315, 'y' => 492),
				'back' => array('x' => 35, 'y' => 42, 'width' => 275, 'height' => 299),
				'class' => array('x' => 25, 'y' => 80),
				'identifier' => array('x' => 37, 'y' => 354, 'size' => 9),
				'set' => array('x' => 45, 'y' => 478)
			),

			'demon' => array(
				'brigade' => array('x' => 8, 'y' => 3),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 45, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 480),
				'copyright' => array('x' => 315, 'y' => 492),
				'back' => array('x' => 36, 'y' => 42, 'width' => 277, 'height' => 302),
				'class' => array('x' => 25, 'y' => 80),
				'identifier' => array('x' => 37, 'y' => 354, 'size' => 8),
				'set' => array('x' => 45, 'y' => 478)
			),

			'angel' => array(
				'brigade' => array('x' => 6, 'y' => 6),
				'title' => array('x' => 310, 'y' => 39, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 42, 'y' => 385),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 482, 'color' => array(0, 0, 0)),
				'copyright' => array('x' => 315, 'y' => 494, 'color' => array(0, 0, 0)),
				'back' => array('x' => 33, 'y' => 48, 'width' => 278, 'height' => 299),
				'class' => array('x' => 25, 'y' => 80),
				'identifier' => array('x' => 34, 'y' => 358, 'size' => 8, 'color' => array(0, 0, 0)),
				'set' => array('x' => 45, 'y' => 481)
			),

			'ur' => array(
				'brigade' => array('x' => 7, 'y' => 7),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(0, 0, 0)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 40, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 483, 'color' => array(0, 0, 0)),
				'copyright' => array('x' => 315, 'y' => 492, 'color' => array(0, 0, 0)),
				'back' => array('x' => 33, 'y' => 53, 'width' => 279, 'height' => 301),
				'class' => array('x' => 25, 'y' => 80),
				'identifier' => array('x' => 37, 'y' => 354, 'size' => 8),
				'set' => array('x' => 45, 'y' => 478)
			),

			'blue' => array(
				'brigade' => array('x' => 4, 'y' => 3),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 45, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 483),
				'copyright' => array('x' => 315, 'y' => 495),
				'back' => array('x' => 31, 'y' => 42, 'width' => 279, 'height' => 301),
				'class' => array('x' => 20, 'y' => 80),
				'identifier' => array('x' => 35, 'y' => 356, 'size' => 9),
				'set' => array('x' => 45, 'y' => 481)
			),

			'green' => array(
				'brigade' => array('x' => 4, 'y' => 3),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 45, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 483),
				'copyright' => array('x' => 315, 'y' => 495),
				'back' => array('x' => 31, 'y' => 42, 'width' => 279, 'height' => 301),
				'class' => array('x' => 20, 'y' => 80),
				'identifier' => array('x' => 35, 'y' => 356, 'size' => 9),
				'set' => array('x' => 45, 'y' => 481)
			),

			'red' => array(
				'brigade' => array('x' => 4, 'y' => 3),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 45, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 483),
				'copyright' => array('x' => 315, 'y' => 495),
				'back' => array('x' => 31, 'y' => 42, 'width' => 279, 'height' => 301),
				'class' => array('x' => 20, 'y' => 80),
				'identifier' => array('x' => 35, 'y' => 356, 'size' => 9),
				'set' => array('x' => 45, 'y' => 481)
			),

			'redorange' => array(
				'brigade' => array('x' => 4, 'y' => 6),
				'title' => array('x' => 312, 'y' => 33, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 45, 'y' => 380),
				'reference' => array('x' => 300, 'y' => 458),
				'artist' => array('x' => 185, 'y' => 483),
				'copyright' => array('x' => 315, 'y' => 495),
				'back' => array('x' => 31, 'y' => 42, 'width' => 279, 'height' => 301),
				'class' => array('x' => 20, 'y' => 80),
				'identifier' => array('x' => 35, 'y' => 356, 'size' => 9),
				'set' => array('x' => 45, 'y' => 481)
			),

			'borderless' => array(
				'brigade' => array('x' => 17, 'y' => 17),
				'title' => array('x' => 312, 'y' => 45, 'color' => array(255, 255, 255)),
				'special' => array('x' => 53, 'y' => 310),
				'verse' => array('x' => 1000, 'y' => 1000),
				'reference' => array('x' => 310, 'y' => 495),
				'artist' => array('x' => 1000, 'y' => 1000),
				'copyright' => array('x' => 1000, 'y' => 1000, 'color' => array(0, 0, 0)),
				'back' => array('x' => 0, 'y' => 0, 'width' => 344, 'height' => 512),
				'class' => array('x' => 33, 'y' => 100),
				'identifier' => array('x' => 35, 'y' => 356, 'size' => 9),
				'set' => array('x' => 25, 'y' => 481)
			)

		);

		private $_typeWithAbilities = array(
			'hero', 'he', 'ec', 'ee'
		);

		private $_lightBrigades = array(
			'gold', 'multi', 'white', 'silver'
		);

		/**
		 * The font's used
		 */
		private $_titleFont = "assets/fonts/LucianBT.ttf";
		private $_artistFont = "assets/fonts/CGOmega Bold.ttf";
		private $_artistFontRegular = "assets/fonts/CGOmega.ttf";


		public function __construct($border = null)
		{			
			//$this->_background = WWW_ROOT . '/img/cdesigner/background.gif';
			//$this->_setIcon = WWW_ROOT . '/img/cdesigner/silverrtiny.png';

			if(!is_null($border))
				$this->_border = $border;

			// Load the sprite configuration file
			$this->_cardDef = json_decode(file_get_contents(CARD_DEF . $this->_border . '/' . DEF_FILE), true);
			$baseFile = CARD_DEF . $this->_border . '/' . $this->_cardDef["src"];

			$this->_cardBase = imagecreatetruecolor($this->_width, $this->_height);

			// Load the sprite image file
			$cardBase = imagecreatefrompng($baseFile);
			list($fileWidth, $fileHeight) = getimagesize($baseFile);

			// Make sure the image is the proper size
			if($fileWidth != $this->_width || $fileHeight != $this->_height)
				imagecopyresampled($this->_cardBase, $cardBase, 0, 0, 0, 0, $this->_width, $this->_height, $fileWidth, $fileHeight);
			else
				$this->_cardBase = $cardBase;

			// Have the card use anti-alias
			imageantialias($this->_cardBase, true);
		}

		public function WriteBrigade($type, $color, $strength, $toughness)
		{			
			if(!array_key_exists("brigade", $this->_cardDef["elements"]))
				return;

			// Card base brigade definition
			$brigadeDef = $this->_cardDef["elements"]["brigade"];

			// Apply the brigade image
			$brigadeImage = Sprite::GetSprite($type, $color, $strength, $toughness);
			imagecopy(
				$this->_cardBase, 
				$brigadeImage, 
				$brigadeDef["x"], 
				$brigadeDef["y"], 
				0, 
				0, 
				imagesx($brigadeImage), 
				imagesy($brigadeImage)
			);
		}

		public function WriteTitle($title, $color = null, $shadow = null)
		{
			if(!array_key_exists("title", $this->_cardDef["elements"]))
				return;

			// Card base title definition
			$titleDef = $this->_cardDef["elements"]["title"];

			// Find title width
			$titleBB = imagettfbbox(15, 0, $this->_titleFont, $title);

			// If the title is too big, use smaller font size
			$titleSize = (($titleBB[4] - $titleBB[6]) > 215)? 15 : 17;

			// Find new title size
			$titleBB = imagettfbbox($titleSize, 0, $this->_titleFont, $title);

			// Position the title
			$titleX = $titleDef['x'] - ($titleBB[4] - $titleBB[6]);

			// Determine the color of the title, defaulting to card definitons title color
			if(is_null($color) || !is_array($color) || count($color) != 3)
				$color = imagecolorallocate(
					$this->_cardBase, 
					$titleDef['color'][0], 
					$titleDef['color'][1], 
					$titleDef['color'][2]
				);
			else
				$color = imagecolorallocate($this->_cardBase, $color[0], $color[1], $color[2]);

			// Create the title shadow
			if(is_null($shadow) && array_key_exists("shadow", $titleDef))
				$shadow = $titleDef["shadow"];

			if(!is_null($shadow) && is_array($shadow) && count($shadow) == 3)
			{				
				// Draw the title shadow
				imagettftext(
					$this->_cardBase, 
					$titleSize, 
					0, 
					$titleX + 1, 
					$titleDef['y'] + 1, 
					imagecolorallocate($this->_cardBase, $shadow[0], $shadow[1], $shadow[2]), // Shadow color
					$this->_titleFont, 
					$title
				);
			}

			// Draw the title
			imagettftext(
				$this->_cardBase, 
				$titleSize, 
				0, 
				$titleX, 
				$titleDef['y'], 
				$color, 
				$this->_titleFont, 
				$title
			);
		}

		public function WriteIdentifier($identifier, $color = null, $shadow = null)
		{
			if(!array_key_exists("identifier", $this->_cardDef["elements"]))
				return;

			// Card base identifier definition
			$identifierDef = $this->_cardDef["elements"]["identifier"];

			// Determine the color of the identifier, defaulting to card definitons identifier color
			if(is_null($color) || !is_array($color) || count($color) != 3)
				$color = imagecolorallocate(
					$this->_cardBase, 
					$identifierDef['color'][0], 
					$identifierDef['color'][1], 
					$identifierDef['color'][2]
				);
			else
				$color = imagecolorallocate($this->_cardBase, $color[0], $color[1], $color[2]);

			// Create the title shadow
			if(is_null($shadow) && array_key_exists("shadow", $identifierDef))
				$shadow = $identifierDef["shadow"];

			// Create the identifier shadow
			if(!is_null($shadow) && is_array($shadow) && count($shadow) == 3)
			{				
				// Draw the identifier shadow
				imagettftext(
					$this->_cardBase, 
					$identifierDef["size"], 
					0, 
					$identifierDef['x'] + 1, 
					$identifierDef['y'] + 1, 
					imagecolorallocate($this->_cardBase, $shadow[0], $shadow[1], $shadow[2]), // Shadow color
					$this->_artistFont, 
					$identifier
				);
			}

			// Draw the identifier
			imagettftext(
				$this->_cardBase, 
				$identifierDef['size'], 
				0, 
				$identifierDef['x'], 
				$identifierDef['y'], 
				$color, 
				$this->_artistFont, 
				$identifier
			);
		}

		public function WriteVerse($verse)
		{
			if(!array_key_exists("verse", $this->_cardDef["elements"]))
				return;

			// Card base verse definition
			$verseDef = $this->_cardDef["elements"]["verse"];

			// Bounding box for verse. Possibly needs moved to Card Definition?
			$verseWidth = 380;
			
			// At what words do we need to make a line break?
			$verseBreak = floor($verseWidth / imagefontwidth($this->_verseSize));
			// Create an array of lines of the verse
			$verseArr = explode("\n", wordwrap($verse, $verseBreak, "\n"));
			// What Y position do we start at?
			$verseStart = $verseDef['y'];
			// Spacing between lines
			$verseSpacing = 3;

			// Loop through the lines and write them to the image
			for($i = 0; $i < count($verseArr); $i++)
			{
				imagettftext(
					$this->_cardBase, 
					$this->_verseSize, 
					0, 
					$verseDef['x'], // X position to write to
					$verseStart + ($i * ($this->_verseSize + $verseSpacing)), // Y Position to write to 
					imagecolorallocate($this->_cardBase, 0, 0, 0), // Use black color for text.
					$this->_titleFont, 
					$verseArr[$i] // The verse line to write to the image
				);
			}
		}

		public function WriteReference($reference)
		{
			if(!array_key_exists("reference", $this->_cardDef["elements"]))
				return;
			
			// Card base reference definition
			$referenceDef = $this->_cardDef["elements"]["reference"];

			// Reference text bounding box
			$refereceBB = imagettfbbox($this->_verseSize, 0, $this->_titleFont, $reference);

			imagettftext(
				$this->_cardBase, 
				$this->_verseSize, 
				0, 
				$referenceDef['x'] - ($refereceBB[4] - $refereceBB[6]), 
				$referenceDef['y'], 
				imagecolorallocate($this->_cardBase, 0, 0, 0), // Use black color for text.
				$this->_titleFont, 
				$reference
			);
		}

		public function WriteArtist($artist)
		{
			if(!array_key_exists("artist", $this->_cardDef["elements"]))
				return;
			
			// Card base artist definition
			$artistDef = $this->_cardDef["elements"]["artist"];
			$fontSize = 11;

			if(array_key_exists("color", $artistDef)) 
				$artistColor = imagecolorallocate(
					$this->_cardBase, 
					$artistDef['color'][0], 
					$artistDef['color'][1], 
					$artistDef['color'][2]
				);
			else
				$artistColor = imagecolorallocate($this->_cardBase, 255, 255, 255); // Default: White

			// Right align the text
			$artistBB = imagettfbbox($fontSize, 0, $this->_artistFont, $artist);			
			$artistX = $artistDef['x'] - ($artistBB[4] - $artistBB[6]);

			imagettftext(
				$this->_cardBase, 
				$fontSize, 
				0, 
				$artistX, 
				$artistDef['y'], 
				$artistColor, 
				$this->_artistFont, 
				$artist
			);
		}

		public function WriteCopyright($copyright)
		{
			if(!array_key_exists("copyright", $this->_cardDef["elements"]))
				return;
			
			// Card base copyright definition
			$copyrightDef = $this->_cardDef["elements"]["copyright"];

			if(array_key_exists("color", $copyrightDef))
				$copyrightColor = imagecolorallocate(
					$this->_cardBase, 
					$copyrightDef['color'][0], 
					$copyrightDef['color'][1], 
					$copyrightDef['color'][2]
				);
			else
				$copyrightColor = imagecolorallocate($this->_cardBase, 255, 255, 255); // Default: White

			$copyrightBB = imagettfbbox(9, 0, $this->_artistFont, $copyright);

			if($this->_border != 'ur')
				imagettftext(
					$this->_cardBase, 
					9, 
					0, 
					$copyrightDef['x'] - ($copyrightBB[4] - $copyright[6]), 
					$copyrightDef['y'], 
					$copyrightColor, 
					$this->_artistFont, 
					$copyright
				);
		}

		public function WriteImage($image)
		{
			if(!array_key_exists("image", $this->_cardDef["elements"]))
				return;
			
			// Card base copyright definition
			$imageDef = $this->_cardDef["elements"]["image"];

			// Decode a base64 encoded image string (used for json serialization)
			$image = imagecreatefromstring(base64_decode($image));

			imagecopyresampled($this->_cardBase, $image, $imageDef["x"], $imageDef["y"], 0, 0, $imageDef["width"], $imageDef["height"], imagesx($image), imagesy($image));
		}

		public function WriteClass($class)
		{
			if(!array_key_exists("class", $this->_cardDef["elements"]))
				return;

			$classIcon = Sprite::GetSprite("class", $class);

			// Card base brigade definition
			$classDef = $this->_cardDef["elements"]["class"];

			imagecopy(
				$this->_cardBase, 
				$classIcon, 
				$classDef["x"], 
				$classDef["y"], 
				0, 
				0, 
				imagesx($classIcon), 
				imagesy($classIcon)
			);
		}

		public function WriteSpecialAbility($ability, $color = null, $shadow = null)
		{
			if(!array_key_exists("image", $this->_cardDef["elements"]))
				return;
			
			// Card base image definition
			$imageDef = $this->_cardDef["elements"]["image"];

			// Wrap the special ability
			$arrText = explode("\n", wordwrap($ability, 30, "\n"));

			// Starting at the bottom of the image area
			$y = $imageDef['y'] + 
					$imageDef['height'] + 
					5; // Margin from bottom
			$fontSize = 15;

			// Space between lines
			$spacing = 7;

			// The box to contain the special ability. Also used to determine centering
			$boxWidth = $imageDef["width"] - 20;
			$boxHeight = $imageDef["height"] - 10;
			
			// Determine the color of the image, defaulting to card definitons image color
			$color = $this->GetColor($color, array(255, 255, 255));
			$shadowColor = $this->GetColor($shadow, array(0, 0, 0));	

			// Explode the ability into an array of words to split into lines
			$words = explode(' ', $ability);
			$lines = array();
			$currentLine = "";			

			// Break the words into lines that fit the image width
			do
			{				
				// Grab the next word
				$word = array_shift($words);

				// Check the size of the line with the next word
				$lineSize = imagettfbbox($fontSize, 0, $this->_titleFont, trim($currentLine . $words));
				
				// The line would be too big. Go ahead and save the line and reset
				if(($lineSize[4] - $lineSize[6]) > $boxWidth)
				{
					$lines[] = trim($currentLine);
					$currentLine = "";
				}
				
				// Append the word onto the current line
				$currentLine .= $word . " ";

				// If we are on the last word, save the line.
				if(empty($words))
					$lines[] = trim($currentLine);
			}	
			while (!empty($words));	


			// Iterate through all the lines of the special ability
			for($i = count($lines) - 1; $i >= 0; $i--)
			{
				// Determine line width
				$lineBB = imagettfbbox($fontSize, 0, $this->_titleFont, $lines[$i]);
				$lineWidth = $lineBB[4] - $lineBB[6];
				$lineHeight = $lineBB[1] - $lineBB[7];				

				// Create x position so the text is centered
				$x = ($imageDef["x"] + 10 /* margin */) + (($boxWidth - $lineWidth) / 2);
				// Adjust x positioning
				$y -= $lineHeight;

				// Draw shadow if applicable				
				imagettftext(
					$this->_cardBase, 
					$fontSize, 
					0, 
					$x + 1, 
					$y + 1, 
					$shadowColor, 
					$this->_titleFont, 
					$lines[$i]
				);

				// Draw special ability
				imagettftext(
					$this->_cardBase, 
					$fontSize, 
					0, 
					$x, 
					$y, 
					$color, 
					$this->_titleFont, 
					$lines[$i]
				);
			}

		}

		private function GetColor($color, $default = array(0, 0, 0))
		{
			// Determine the color of the image, defaulting to card definitons image color
			if(is_null($color) || !is_array($color) || count($color) != 3)
				return imagecolorallocate(
					$this->_cardBase, 
					$default[0], 
					$default[1], 
					$default[2]
				);
			else
				return imagecolorallocate($this->_cardBase, $color[0], $color[1], $color[2]);
		}

		public function Render()
		{
			// Apply RC set icon
			imagecopyresampled(
				$this->_cardBase, 
				imagecreatefrompng($this->_setIcon), 
				$this->_cardDef["elements"]['set']['x'], 
				$this->_cardDef["elements"]['set']['y'], 
				0, 
				0, 
				$this->_cardDef["elements"]['set']["size"],
				$this->_cardDef["elements"]['set']["size"],
				16, 
				16
			);

			header('Content-Type: image/png');			
			echo imagepng($this->_cardBase);
			imagedestroy($this->_cardBase);
		}
	}

?>