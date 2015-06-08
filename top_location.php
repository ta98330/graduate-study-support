<?php
    require "spheader.php";//ヘッダー読み込み

    if($_SESSION['login'] == "ログインしていません．"){
        header('Location: index.php');
    }
    else if($_SESSION['userId'] == 999)
        header('Location: top_pro.php');

    require "header.php";//ヘッダー読み込み
        
    require "state.php";
    
?>

        <div id="user">
          
          <?php

          echo "<p>{$_SESSION['login']}{$_SESSION['userName']}さん．　<a href='logout.php'>ログアウト</a></p>";

          ?>
        </div>

        <div id="main">
            
        <div id="calendar">
            
        <iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTz=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=jouhoubuturi2015%40gmail.com&amp;color=%231B887A&amp;src=5udlp7brhcnbuv0mq7t0jcmh04%40group.calendar.google.com&amp;color=%23AB8B00&amp;src=ja.japanese%23holiday%40group.v.calendar.google.com&amp;color=%23125A12&amp;ctz=Asia%2FTokyo" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
        
        </div>       
        
            
        
        <section id="bbs">
            <h2>簡易掲示板</h2>
            <ul>
            <?php
            $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
            $st = $pdo->query("SELECT * FROM bbs_logs");//SQL文の発行

            while ($row = $st->fetch()) {
                $name = htmlspecialchars($row['name']);
                $time = htmlspecialchars($row['time']);
                $content = htmlspecialchars($row['content']);
                
                echo "<hr />";
                echo "<li>$name&nbsp;$time<br />&nbsp;&nbsp;&nbsp;&nbsp;$content&nbsp;<br /></li>";
                
            }
            echo "<hr id='bbsend'/>";

            echo "</ul>";
            
            echo "<form action='bbs.php' method='post'>";
            echo "<p>name:<input type='text' name='contributeName'  value={$_SESSION['userName']}></p>";
                        
            ?>
            
                <p><textarea name="contributeContent" maxlength='200' required></textarea>
                <input type="submit" value='書き込む'></p>        
            </form>
            
            <div id="twitter">
            
            <a class="twitter-timeline" href="https://twitter.com/j_b_2015" data-widget-id="600917355250651136">@j_b_2015さんのツイート</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            
            </div>
            
            
        </section>
            
        <section>
        
        <button onclick="start()">位置情報取得開始(getCurrentPosition)</button>
        <?php
        echo "<div id='message'></div>";
            
        
        
        
        
        
        
        ?>
        
        
        
        
        
        </section>
                

        
        <section id="registration">
            <h2>登下校登録</h2>
            <?php
            $today = date("Y-m-d");
            $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
            $st = $pdo->query("SELECT * FROM user_logs WHERE id = {$_SESSION['userId']} AND date = '$today'");
            while ($row = $st->fetch()) {
                $str = htmlspecialchars($row['start_time']);
                $end = htmlspecialchars($row['end_time']);
                
                $start_time = htmlspecialchars($row['start_time']);
                $end_time = htmlspecialchars($row['end_time']);
                $stay_time = htmlspecialchars($row['stay_time']);
            }

            if(empty($str)){
                echo "<form id='attend' method='post' action='http://buturi.heteml.jp/student/2015/misawa/test/attendance/external_reception.php'>";
                //echo "<input type='submit' value='登校' name='come' id='toukou'>";
                //echo "<input type='submit' value='下校' name='out' id='gekou' disabled>";
                echo "</form>";
                
                echo "<form method='post' action='http://buturi.heteml.jp/student/2015/misawa/test/attendance/situation_update.php' id='joukyou'>";    
                echo "<p>";
                echo "<select name='situation'>";
                echo "<option value='kitaku'>帰宅</option>";
                echo "<option value='kisei'>帰省</option>";
                echo "<option value='syuukatsu'>就活</option>";
                echo "</select>";
                echo "<input type='submit' value='状況変更'>";
                echo "</p>";
            }
            else if(empty($end)){
                echo "<form method='post' action='http://buturi.heteml.jp/student/2015/misawa/test/attendance/external_reception.php'>";
                echo "<input type='submit' value='登校時間\n$start_time' name='come' id='toukou' disabled>";
                echo "<input type='submit' value='下校' name='out' id='gekou'>";
                echo "</form>";
                
                echo "<form method='post' action='http://buturi.heteml.jp/student/2015/misawa/test/attendance/situation_update.php' id='joukyou'>";    
                echo "<p>";
                echo "<select name='situation'>";
                echo "<option value='zaishitsu'>在室</option>";
                echo "<option value='jugyou'>授業</option>";
                echo "<option value='syokuji'>食事</option>";
                echo "<option value='kounai'>校内</option>";
                echo "</select>";
                echo "<input type='submit' value='状況変更'>";
                echo "</p>";
            echo "</form>";
            }
            else{
                echo "<form method='post' action='http://buturi.heteml.jp/student/2015/misawa/test/attendance/external_reception.php'>";
                echo "<input type='submit' value='登校時間\n$start_time' name='come' id='toukou' disabled>";
                echo "<input type='submit' value='下校時間\n$end_time' name='out' id='gekou' disabled>";
                echo "<input type='submit' value='下校\n取り消し\n$stay_time' name='outreset' id='regekou'>";
                echo "</form>";
                
                echo "<form method='post' action='http://buturi.heteml.jp/student/2015/misawa/test/attendance/situation_update.php' id='joukyou'>";    
                echo "<p>";
                echo "<select name='situation'>";
                echo "<option value='kitaku'>帰宅</option>";
                echo "<option value='kisei'>帰省</option>";
                echo "<option value='syuukatsu'>就活</option>";
                echo "</select>";
                echo "<input type='submit' value='状況変更'>";
                echo "</p>";
            echo "</form>";
            }
            ?>
            
        </section>
        
        <section id="personal_schedule">
            <h2>個人予定</h2>
            <ul>
            <?php
            $today = date("Y-m-d");
            $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
            $st = $pdo->query("SELECT * FROM task WHERE id = {$_SESSION['userId']} ORDER BY date ASC");
            $liNo = 0;    
            while ($row = $st->fetch()) {
                $date = htmlspecialchars($row['date']);
                $content = htmlspecialchars($row['content']);
                
                if((strtotime($date) - strtotime($today)) / (60 * 60 * 24) == 0)
                    echo "<li class='todaystasks'>今日は",$content, "の日です．</li>";  
                else if((strtotime($date) - strtotime($today)) / (60 * 60 * 24) == 1)
                    echo "<li class='tommorowstasks'>明日は",$content, "の日です．</li>";
                else
                    echo "<li>",$content, "まで残り", (strtotime($date) - strtotime($today)) / (60 * 60 * 24), "日です．</li>";  
                $liNo++;
            }

            if($liNo == 0)
                echo "<li>個人予定は登録されていません．</li>";
            
            ?>
            </ul>
        
        
        
        </section>
            
                        
            
        <!--予定レコードの追加-->
        <section id="memtask">
            <h2>全体予定登録</h2>
            <form action="task_insert.php" method="post">
              日付
              <input type="date" name="date" pattern="\d{4}-?\d{2}-?\d{2}" min="2015-04-01" max="2016-03-31"><br><!--日付範囲制限-->
              時刻
              <input type="time" name="time"><br>
              場所
              <input type="text" name="place"><br>
              内容
              <input type="text" name="content" required><br>
              <input type="submit">
            </form>
        </section>
        
        <section id="pertask">
            <h2>個人予定登録</h2>
            <form action="task_insert.php" method="post">
              <?php
              echo "<input type='hidden' name='id' value='{$_SESSION['userId']}'>";
              ?>
              
              日付
              <input type="date" name="date" pattern="\d{4}-?\d{2}-?\d{2}" min="2015-04-01" max="2016-03-31"><br><!--日付範囲制限-->
              時刻
              <input type="time" name="time"><br>
              場所
              <input type="text" name="place"><br>
              内容
              <input type="text" name="content" required><br>
              <input type="submit">
            </form>
        </section>
            
        <section>    
            <h2>パスワード変更</h2>
            <form name="pass_insert" action="pass_update.php" method="post">
            現在のパスワード
            <input type="password" name="pass" required><br>
            新しいパスワード
            <input type="password" name="newPass" onblur="passCheck();" required><br>
            <input type="submit">
            </form>
        </section>
        
        <section>
            <h2>ユーザー情報確認</h2>
            <form action="user_info.php" method="post">
            パスワード
            <input type="password" name="pass" required>
            <input type="submit">
            </form>
         </section>   
            
            
            
            
        </div>

<?php require "footer.php" //フッター読み込み?>