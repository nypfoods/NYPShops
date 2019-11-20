<?php 
$g = $GLOBALS;
$r = $_REQUEST;
$ukey = isset($_SESSION["ukey"])?$_SESSION["ukey"]:"uname";
$menu = $rscreen["/admin"];
?>
<div class="" style="margin-bottom: 52px;" >
  <nav class="w3-white w3-sidebar w3-bar-block w3-card animated" id="mySidebar">
    <div class="w3-container w3-theme-d2">
      <span onclick="closeSidebar()" class="w3-button w3-display-topright w3-large">X</span>
      <br>
      <div class="w3-padding w3-center">
        <img class="w3-circle" src="abc.png" onerror="this.src='<?=get_url("/res/images/logo.png")?>'" alt="User Profile" style="width:75%;max-height: 100px;">
      </div>
    </div>
    <?php function recurdrop($rmenu,$sm=false) {
          global $gmenu,$rscreen;
          $small = $sm?"":"";
          $gmenulst = toCol($gmenu,"name");
          if(($p=array_search("/admin/login",$rmenu))!==false){
            $val = $rmenu[$p];
            array_splice($rmenu,$p, 1);
            $rmenu[count($rmenu)] = $val;
          } 
          if(($p=array_search("/admin/logout",$rmenu))!==false){
            $val = $rmenu[$p];
            array_splice($rmenu,$p, 1);
            $rmenu[count($rmenu)] = $val;
          }
          for($i=0;$i<count($rmenu);$i++) {
            if(($pos = array_search($rmenu[$i],$gmenulst))!==false) {
              $menu = $gmenu[$pos];
              $dpf = isset($rscreen[$menu["name"]])&&count($rscreen[$menu["name"]])>0;
              $drop = $dpf?$rscreen[$menu["name"]]:array();
              $lg = isset($menu["lg"])?$menu["lg"]:0;
              $slg = isset($menu["slg"])?$menu["slg"]:0;
              $ssc = $_REQUEST["screen"]!=$menu["name"];
              $rff = ($lg==1&&$slg==0&&$GLOBALS["islogin"]);//is Login and lg mode 1
              $rff = $rff||$lg==0;//lg mode 0
              $rff = $rff||$drop;//If Drop
              $rff = $rff&&$ssc;// Not in same screen
            if($rff) { 
              if(!$dpf) {
    ?>
                <a href="<?=screen_url($menu["name"])?>" class="w3-bar-item w3-button w3-padding-large <?=$small?>">
                  <i class="<?=$menu["icon"]?>" style="margin-right: 2px;">
                    <?=(isset($menu["cicon"])&&$menu["cicon"]!="NULL")?$menu["cicon"]:""?>
                  </i>
                  <b><?php echo $menu["display"];?></b>   
                </a>
        <?php } else { ?>
          <div class="w3-dropdown-click <?=$small?>">
            <button class="w3-padding-large w3-button" title="More" onclick="dropnav(this)">
              <i class="<?=$menu["icon"]?>" style="margin-right: 2px;">
                <?=(isset($menu["cicon"])&&$menu["cicon"]!="NULL")?$menu["cicon"]:""?>
              </i>
              <b><?php echo $menu["display"];?></b>
              <i class="arrow dsc" style="top:-2px"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
              <?php recurdrop($drop,$sm); ?>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
    <?php   
            }
          } 
    ?>
    <?php } recurdrop($menu); ?>
  </nav>
  <header class="w3-top w3-white w3-bar w3-card">
    <button class="w3-bar-item w3-button w3-xlarge" onclick="openSidebar()">&#9776;</button>
    <div class="w3-left middle">
        <a href="#" class="w3-bar-item w3-button" style="padding: 4px 4px;">
          <img src="{!!get_url('res/images/logo.png')!!}" style="max-height: 45px;" />
        </a>
        <?php if($GLOBALS["islogin"]) { ?>
        <b class="w3-bar-item myname ellip">
          <?=ucwords($udtl[$ukey])?>
        </b>
        <?php } ?>
    </div>
    <div class="w3-right middle">
      <a href="javascript:void(0)" class="w3-bar-item ico w3-padding-large" tooltip="Notification">
          <span class="w3-badge" id="notify" >0</span>
          <i class="fa fa-bell"></i>
      </a>
      <a href="javascript:window.location.reload()" class="w3-bar-item ico w3-padding-large" tooltip="Refresh">
          <i class="fa fa-redo"></i>
      </a>
    </div>
  </header>
</div>