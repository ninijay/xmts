<?php
    if(!isset($_POST['trans']))
    {
        die("Something went wrong");
    }
    $tr_nr=$_POST['trans'];
    $valid = "1HTD-3A46-3X29-7R09";

    if($trans == $valid)
    {
        die("Invalid Transaction number");
    }

    $welcum="Welcome to the supersecurepayment.com transaction interface";
    $title="Transaction Nr.: ".$tr_nr;
    $content="To complete the transaction download the transaction software for your corresponding system:";

    $linux_link;
    $win_link;
    $mac_link;

    $warning="Make sure to check your transaction before you download the software!";
?>
<head>
    <title><?php echo $title; ?></title>
    <link href="style.css" rel="stylesheet" />
    <script src="main.js"></script>
</head>
<body>
<header>
  <h1><?php echo $title; ?></h1>
  <h3><?php echo $welcum?></h3>
  <h5><?php echo $content ?></h5></header>
<div class="download-btn">
  <div class="btn__circle"> <svg width="140" height="140"> 
     <circle r="60" cx="70" cy="70"
             class='download' stroke-width="10" />
    </circle>
  <circle class="bar" stroke-width="10" r="60" cx="70" cy="70" fill="transparent" stroke ='red' stroke-dasharray="565.48" stroke-dashoffset="565.48"></circle>
    
</svg>
  </div>

  <div class="btn__arrow btn--icon"><i class="fa fa-arrow-down" aria-hidden="true"></i></div>
  <div class="btn__stop btn--icon"><i class="fa fa-pause" aria-hidden="true"></i></div>
  <div class="btn__done btn--icon"><i class="fa fa-check" aria-hidden="true"></i></div>
</div>
<?php echo $warning; ?>
</body>