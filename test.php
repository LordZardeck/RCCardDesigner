<?php
	require 'Card.php';

	$Card = new Card('angel');

	$Card->WriteImage(base64_encode(file_get_contents('assets/pic.png')));
	$Card->WriteSpecialAbility('Hey! This is my very special multi-line shadowed special ability. What do you think of it?');
	$Card->WriteBrigade('evil-character', 'multi', '1', '6');
	$Card->WriteClass('territory');
	$Card->WriteTitle('Awesome card!');
	$Card->WriteVerse('For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.');
	$Card->WriteReference('John 3:16');
	$Card->WriteArtist('Ill. by Sean Templeton');
	$Card->WriteCopyright('by lordzardeck');
	$Card->WriteIdentifier('Cool Card');

	$Card->render();
?>