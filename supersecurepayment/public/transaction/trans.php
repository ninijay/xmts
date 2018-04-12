<?php
    if(!isset($_POST['trans']))
    {
        die("Something went wrong");
    }
    $tr_nr=$_POST['trans'];
    $welcum="Welcome to the supersecurepayment.com transaction interface";
    $title="Transaction Nr.: ".$tr_nr;
    $content="To complete the transaction download the transaction software for your corresponding system:";

    $linux_link;
    $win_link;
    $mac_link;

    $warning="Make sure to check your transaction before you download the software!";
?>