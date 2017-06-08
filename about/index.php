<?php require '..//script/twtrupdate/user.php'; ?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>About LUNA-LABO</title>
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="/css/index.css">
        <link rel="stylesheet" type="text/css" href="/css/about.css">
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
        <script type="text/javascript" src="//typesquare.com/accessor/script/typesquare.js?inF40kLCQ6w%3D&fadein=10" charset="utf-8"></script>
    </head>
    <body>
        <header><h1><a href="/"><img src="/images/logo1.png"></a></h1></header>
        <nav><ul>
            <li><p><a href="/index.html">TOP</a></p></li>
            <li><p><a href="/about/">About</a></p></li>
            <li><p><a href="/download">Download</a></p></li>
            <li><p><a href="/contact">Contact</a></p></li>
        </ul></nav><!--ここテン-->
        <div class="content">
            <div class="container">
                <div class="circle">
                    <h1>月餅研究所について</h1>
                    <p>このサークルは、<a href="https://twitter.com/<?php echo $lunaId; ?>"><?php echo $lunaName; ?></a>によって設立された東方Projectの同人サークルです。</p>
                    <p>当サークルでは、現在、ゲーム「こがたたき」の開発を行っています。また、それに関連するグッズ等の制作を行っています。</p>
                </div>
                <div class="members">
                    <h2>Members</h2>
                    <div class="leader l">
                        <a href="https://twitter.com/<?php echo $lunaId; ?>"><img src="<?php echo $lunaIcon; ?>"></a>
                        <h3><?php echo $lunaName; ?></h3>
                        <p><?php echo $lunaDesc; ?></p>
                    </div>
                    <div class="kijiniwa r">
                        <a href="https://twitter.com/<?php echo $kijiniwaId; ?>"><img src="<?php echo $kijiniwaIcon; ?>"></a>
                        <h3><?php echo $kijiniwaName; ?></h3>
                        <p><?php echo $kijiniwaDesc; ?></p>
                    </div>
                    <div class="ichika l">
                        <a href="https://twitter.com/<?php echo $ichikaId; ?>"><img src="<?php echo $ichikaIcon; ?>"></a>
                        <h3><?php echo $ichikaName; ?></h3>
                        <p><?php echo $ichikaDesc; ?></p>
                    </div>
                    <div class="hijiri r">
                        <a href="https://twitter.com/<?php echo $hijiriId; ?>"><img src="<?php echo $hijiriIcon; ?>"></a>
                        <h3><?php echo $hijiriName; ?></h3>
                        <p><?php echo $hijiriDesc; ?></p>
                    </div>
                    <div class="karanasi l">
                        <a href="https://twitter.com/<?php echo $karanasiId; ?>"><img src="<?php echo $karanasiIcon; ?>"></a>
                        <h3><?php echo $karanasiName; ?></h3>
                        <p><?php echo $karanasiDesc; ?></p>
                    </div>
                    <div class="masaro r">
                        <a href="https://twitter.com/<?php echo $masaId; ?>"><img src="<?php echo $masaIcon; ?>"></a>
                        <h3><?php echo $masaName; ?></h3>
                        <p><?php echo $masaDesc; ?></p>
                    </div>
                    <div class="unity l">
                        <a href="https://twitter.com/<?php echo $unityId; ?>"><img src="<?php echo $unityIcon; ?>"></a>
                        <h3><?php echo $unityName; ?></h3>
                        <p><?php echo $unityDesc; ?></p>
                    </div>
                    <div class="magia r">
                        <a href="https://twitter.com/<?php echo $magiaId; ?>"><img src="<?php echo $magiaIcon; ?>"></a>
                        <h3><?php echo $magiaName; ?></h3>
                        <p><?php echo $magiaDesc; ?></p>
                    </div>
                    <div class="nyanpass l">
                        <a href="https://twitter.com/<?php echo $nyanpassId; ?>"><img src="<?php echo $nyanpassIcon; ?>"></a>
                        <h3><?php echo $nyanpassName; ?></h3>
                        <p><?php echo $nyanpassDesc; ?></p>
                    </div>
                </div>
            </div>
        </div>


<!--

            ,.　-‐‐-y'ﾆ二_
　　　 　 ,ｨ'ﾆ'.v ´: : : : : : : : : : : : ｀ヽ､
　　　　 {ｲ: :/: : : :/: : ; : : : : : : : : : : : Yﾆiヽ
　　　　 ,ゞ/: : : ;ｲ: ／|: : : : : :_:ｲ: : : : : V: :ﾘ
　　　 彡: |: :|: / |/ 　 V､: : :./｀ﾄ i: : : : :.iイ
　　　　＼:!: : /　　 　 　 ヽ'´ 　 Vヽ: : : :|:.ヽ,
　　 　 　 ,|ﾊ:ｉ　`ー ´ 　　　､　　　 j/: : :|: : r''
　　　 　 ﾉ|:.:ﾞ| l　i 　 　 　 　 `ー‐ /: : :/_ﾙ'
　　　 　'ﾍ|.: :!　　 　 　 　 　 l　i　,': : :ｲ
　　　　　 j:ノ:ヽ､　　　/)　　　 　 j／:/|
　　　　　　ヽ: :ﾊ＞､ ｎ　　＿. .ｨ':,ｨ::∧j
　　　　　　,イﾆ三ﾆ! } }__/三≧x_j/
　 　 　 　 |　ﾞﾐ三ﾆ}〈　　}ﾆﾆ7' 　｀ｉ
　 　 　 　 |　　ﾞﾐ三!'ヽ_ノ}ﾆｦ'　　　|
　 　 　 　 {,r‐=t ∨: : : :/‐" l　 　 |
　　　　　 {三ﾆﾆ}/: : : :/　　 {三三}
　　　　　 ﾞﾐﾆｦ':´: : : :/:|　　 {三三}
　　　　　　/ヽ､:＿;／: :|　　/: : : :/
　　 　 　 /　　　　ｌ: : : :l　 /: : : :∧

-->

    </body>
</html>