<?php

// Variables to edit
$servername = "CSGO";
$serverurl = "https://research.cs.cornell.edu/csgo";

$ignore = ['vendor', '.git', 'auth', 'conf', 'twigs'];


// Variables you should leave alone
$alwaysignore = ['.', '..'];

// Folder Inventory function
function dirToArray($dir) {
    global $alwaysignore, $ignore, $deeper;
    $entries = scandir(".");
    $dirlist = array();
    foreach($entries as $entry) {
        if (is_dir($entry) && !in_array($entry, $alwaysignore) && !in_array($entry, $ignore)) {
            $dirlist[] = $entry;
        }
    }

    return $dirlist;
}

// Call the function
$list = dirToArray('.');

?>
<html>
<head>
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CSGO: Computer Science Graduate Organization</title>
</head>

<body>
    <header>
        <nav>
            <a href="/"><img alt="Cornell Logo" src="https://www.cornell.edu/assets/core/images/logo-red@2x.png" height="120"></a>
            <ul>
                <li><a href="https://www.cornell.edu">Cornell University</a></li>
                <li><a href="https://www.cs.cornell.edu">CS Department</a></li>
            </ul>
	</nav>
        <!--<h1>Cornell CS <?php echo $servername ?> Server Contents</h1>-->
	<!--<h2>This page is no longer updated and is kept for archival purposes only.</h2>-->
	<h1>CSGO: Computer Science Graduate Organization</h1>
        <p> The CSGO is the body of political representation of all graduate students in the field of computer science. It serves as the interface to talk to the faculty and administration about graduate student concerns, such as requirements, communication policies, etc., and sends representatives to the larger student representative bodies. CSGO can also provide funding for student activities and events.</p>
        <p>All computer science graduate students are welcome to be involved in CSGO activities.</p>
        <br>
	<p>
            <a href="#TBD"><b>Board + Contact</b></a>
	    <a href="#TBD"><b>Calendar</b></a>
	    <a href="https://forms.gle/JBgGJeqdNZQf8pwWA"><b>Leave feedback? &rarr;</b></a>
	</p>
	<p>
 	   <a href="https://drive.google.com/drive/folders/0BxSQwSBWX-4fSmphUHp5eHpiSzg?resourcekey=0-mzHZrsU1nABn9Rv8APN-qw&usp=sharing"><i>Public Working Notes</i></a>
           <a href="https://list.cs.cornell.edu/pipermail/csgo-archive/"><i>Email Archive</i></a>
            <a href="https://cornellcis.slack.com/archives/C04T7QT7D"><i>Slack Channel</i></a>
	</p>
    </header>
    <main>
        <hr>
        <h1>Subproject Pages</h1>
        <ul>
<?php
foreach ($list as $item) {
    echo("        <li><a href=\"{$serverurl}/{$item}\">$item</a></li>\n");
}
?>
	</ul>
        <p><em>This is a registered student organization of Cornell University.</em></p>
    </main>
</body>
