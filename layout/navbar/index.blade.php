<?php 
$g = $GLOBALS;
$r = $_REQUEST;
$ukey = isset($_SESSION["ukey"])?$_SESSION["ukey"]:"uname";
$menu = $rscreen["/admin"];
?>
<div id="navbar" style="margin-bottom: 50px;">
    <div class="w3-top bgf-pri-var" style="z-index: 100">
        <div class="w3-bar ">
            <a class="w3-bar-item w3-button w3-padding-large w3-hide-large w3-right" href="javascript:void(0)" onclick="dropnav(this,'#navDemo')" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
            <div class="w3-left">
                <a href="#" class="w3-bar-item w3-button w3-padding-large" style="margin-right: 50px">
                    <img src="{!!get_url('res/images/logo.png')!!}" style="height: 45px;position: absolute;top: 0px;left: 20px;" />
                </a>
                <a href="javascript:void(0)" class="w3-bar-item ico w3-padding-large" tooltip="Help"><i class="fa fa-exclamation-circle"></i></a>
                <a href="javascript:void(0)" class="w3-bar-item ico w3-padding-large" tooltip="Notification">
                    <span class="w3-badge" id="notify">0</span>
                    <i class="fa fa-bell"></i>
                </a>
                <?php if($GLOBALS["islogin"]) { ?>
                <b class="w3-bar-item w3-padding-large">
                    <?=ucwords($udtl[$ukey])?>
                </b>
                <?php } ?>
            </div>
            <div id="notifycon">
            </div>
            <div class="w3-right w3-hide-medium w3-hide-small">
                <?php function recurdrop($rmenu,$sm=false) {
          global $gmenu,$rscreen;
          $small = $sm?"":"";//w3-hide-small
          $gmenulst = toCol($gmenu,"name");
        ?>
                <?php
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
              $rff = $rff||$drop;
              $rff = $rff&&$ssc;// Not in same screen
        ?>
                <?php if($rff) { ?>
                <?php if(!$dpf) { ?>
                <a href='<?=screen_url($menu["name"])?>' class="w3-bar-item w3-button w3-padding-large
                    <?=$small?>">
                    <i class='<?=$menu["icon"]?>' style="margin-right: 2px;">
                        <?=(isset($menu["cicon"])&&$menu["cicon"]!="-")?$menu["cicon"]:""?>
                    </i>
                    <b>
                        <?php echo $menu["display"];?></b>
                </a>
                <?php } else { ?>
                <div class="w3-dropdown-click <?=$small?>">
                    <button class="w3-padding-large w3-button" title="More" onclick="dropnav(this)">
                        <i class='<?=$menu["icon"]?>' style="margin-right: 2px;">
                            <?=(isset($menu["cicon"])&&$menu["cicon"]!="-")?$menu["cicon"]:""?>
                        </i>
                        <b>
                            <?php echo $menu["display"];?></b>
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
            </div>
        </div>
    </div>
    <div id="navDemo" class="w3-bar-block bgf-pri-var w3-hide w3-hide-large  w3-top" style="margin-top:46px">
        <?php recurdrop($menu,true); ?>
    </div>
</div>