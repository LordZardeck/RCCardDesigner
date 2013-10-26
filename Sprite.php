<?php

	define('SPRITE_FOLDER', 'assets/');
	define('SPRITE_CONFIG', 'sprites.json');
	define('ABILITY_FONT', 'assets/fonts/LucianBT.ttf');
	

	class Sprite
	{
		private static $_instance = null;

		private $_sprites = null;
		private $_config = null;

		private function __construct()
		{			
			// Load the sprite configuration file
			$config = json_decode(file_get_contents(SPRITE_FOLDER . SPRITE_CONFIG), true);

			// Load the sprite image file
			$this->_sprites = imagecreatefrompng(SPRITE_FOLDER . $config['src']);

			// Remove unnecessary config values
			unset($config['src']);

			// Save config values
			$this->_config = $config;
		}

		private static function GetInstance()
		{
			if(is_null(self::$_instance))
				self::$_instance = new Sprite();

			return self::$_instance;
		}

		private static function GetConfig()
		{
			$sprite = Sprite::GetInstance();
			return $sprite->_config;
		}

		private static function GetSprites()
		{
			$sprite = Sprite::GetInstance();
			return $sprite->_sprites;
		}

		public static function GetSprite($type = null, $color = null, $strength = null, $toughness = null)
		{
			if(is_null($type) || is_null($color))
				throw new Exception("Sprite type and color cannot be null.", 1);

			// If the the type is an enhancement and has no strenght or toughness, use a special sprite type
			if(($type == 'hero-enhancment' || $type == 'evil-enhancement') && (is_null($strength) && is_null($toughness)))
				$type .= '-no-ability';
				
			// Get the config details on the sprite
			$Config = Sprite::GetConfig();
			$Config = $Config["prebuilt"][$type];

			// Get the size of the sprite
			$size = (array_key_exists("size", $Config))? $Config["size"] : array("width" => $Config[$color]["width"], "height" => $Config[$color]["height"]);
			// If not a class, need to extract the color details			
			$colorConfig = (array_key_exists("colors", $Config))? $Config["colors"][$color] : $Config[$color];

			// Create GD Image with the size of the sprite.
			$brigadeImage = imagecreatetruecolor($size["width"], $size["height"]);
			imagealphablending($brigadeImage,false);
			imagefilledrectangle($brigadeImage, 0, 0, $size["width"], $size["height"], imagecolorallocatealpha($brigadeImage, 255, 255, 255, 127));
			imagealphablending($brigadeImage, true);

			imagecopy(
				$brigadeImage, // The image resource to copy the sprite image to
				Sprite::GetSprites(), // The sprite sheet to retrive the sprite from
				0, 
				0, 
				$colorConfig["x"], // X Position of the sprite on the sprite sheet
				$colorConfig["y"], // Y Position of the sprite on the sprite sheet
				$size["width"], // Width of area to crop from sprite image
				$size["height"] // Height of area to crop from sprite image
			);
			imagealphablending($brigadeImage, true);
			

			// Add the abilities if applicable
			if(strpos($type, '-no-ability') === false && array_key_exists('text-area', $Config))
			{
				// Build the abilities string
				$ability = ((is_null($strength))? '0' : $strength) . '/' . ((is_null($toughness))? '0' : $toughness);

				// Determine the abilities font size
				$abilityFontSize = (strlen($strength) > 1 && strlen($toughness) > 1)? 15 : 17;

				// Determine the width of the abilities string
				$abilityBB = imagettfbbox($abilityFontSize, 0, ABILITY_FONT, $ability);

				// Position the abilities string
				$abilityX = $Config["text-area"]["x"] + 
							(
								(
									$Config["text-area"]["width"] -
									$abilityBB[4] + $abilityBB[0] // Bound box width
								) // Space difference between text-area width and bounding box
							/ 2); // Half the space to get the left margin
				
				$abilityY = ceil($Config["text-area"]["y"] +
							(
								(
									$Config["text-area"]["height"] -
									$abilityBB[5] // Bound box width
								) // Space difference between text-area width and bounding box
							/ 2)); // Half the space to get the left margin

				// Set default abilities color
				if(array_key_exists('color', $colorConfig) && is_array($colorConfig['color']) && count($colorConfig['color']) == 3) 					
					$abilityColor = imagecolorallocate(
						$brigadeImage, 
						$colorConfig['color'][0], 
						$colorConfig['color'][1], 
						$colorConfig['color'][2]
					);
				else
					$abilityColor = imagecolorallocate($brigadeImage, 0, 0, 0);

				// Draw the ability
				imagettftext(
					$brigadeImage, 
					$abilityFontSize, 
					0, 
					$abilityX, 
					$abilityY, 
					$abilityColor, 
					ABILITY_FONT, 
					$ability
				);	
			}
			
				
			imagealphablending($brigadeImage, true);
			imagesavealpha($brigadeImage, true);

			return $brigadeImage;
		}
	}

?>