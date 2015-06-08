<?php //require "spheader.php";//ヘッダー読み込み ※通常時は必ずコメントアウト！開発時のみ ?>
<?php //require "header.php";//ヘッダー読み込み ※通常時は必ずコメントアウト！開発時のみ ?>

        <div id="rogo">
            <!--<img src=http://buturi.heteml.jp/student/2015/kanani.gif width=200 height=200>-->
            <a href="index.php">
            <img class="sotukenrogo" id="test01" src=http://buturi.heteml.jp/student/2015/maruani.gif width=200 height=200>
            <img class="sotukenrogo" id="test02" src=http://buturi.heteml.jp/student/2015/myoukou.gif width=200 height=200>
            </a>
        
        
        
        
        
        </div>
        
        <section id="today">
            <?php
            $today = date("Y-m-d");//本日の日付取得
            $taskNo = 0;//予定件数

            $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
            if(empty($_SESSION['userId']))
                $st = $pdo->query("SELECT * FROM task WHERE id IS NULL");//SQL文の発行
            else
                $st = $pdo->query("SELECT * FROM task WHERE id IS NULL OR id = {$_SESSION['userId']}");//SQL文の発行
            while ($row = $st->fetch()) {
                $date = htmlspecialchars($row['date']);
                if($date == $today){
                $time[$taskNo] = htmlspecialchars($row['time']);
                $place[$taskNo] = htmlspecialchars($row['place']);
                $content[$taskNo] = htmlspecialchars($row['content']);
                $taskNo++;
                }
            }
            echo "<h2><time>",date('n月 j日 (D)'),"</time> 本日の予定（$taskNo 件）</h2>";

            if($taskNo == 0){
                echo "<MARQUEE>本日の予定はありません.</MARQUEE>";
            }
            else{
                echo "<MARQUEE>";
                for($i = 0; $i < $taskNo; $i++){
                    $n = $i+1;
                    echo "$n 件目&emsp; $time[$i]&emsp; $place[$i]&emsp; $content[$i]&emsp;&emsp;&emsp;&emsp;";
                }
                echo "</MARQUEE>";
            }            
            ?>
            
            <!-- 折りたたみ -->
            <div onclick="obj=document.getElementById('Future_Schedule').style; obj.display=(obj.display=='none')?'block':'none';">
            <button><a style="cursor:pointer;">今後の予定</a></button>
            </div>
            <!--// 折りたたみ -->

            <!-- 折りたたまれ -->
            <div id="Future_Schedule" style="display:none;clear:both;">
            <!--ここに書いたものが上述の「クリックで展開」をクリックすると表示される-->
            <table border="1"><br /><tr><th>日付</th><th>時間</th><th>場所</th><th>内容</th></tr><br />
            <?php 
                
            $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
            if(empty($_SESSION['userId']))
                $st = $pdo->query("SELECT * FROM task WHERE id IS NULL ORDER BY date ASC");//SQL文の発行
            else
                $st = $pdo->query("SELECT * FROM task WHERE id IS NULL OR id = {$_SESSION['userId']} ORDER BY date ASC");//SQL文の発行

        
        
        
        while ($row = $st->fetch()) {
            $date = htmlspecialchars($row['date']);
            $time = htmlspecialchars($row['time']);
            $place = htmlspecialchars($row['place']);
            $content = htmlspecialchars($row['content']);
            echo "<tr><td>$date</td><td>$time</td><td>$place</td><td>$content</td></tr>";
        }
        
            ?>
            </table>
            </div>
            <!--// 折りたたまれ -->
            
                
        </section>
        
        <section id="now">
            <h2>在室状況</h2>
            <div id="member">
                <ul id="memberList">
                <?php
                $yesterday = date("Y-m-d", strtotime("- 1 day"));//本日の日付取得
                $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");

                //未下校登録処理
                $st = $pdo->query("UPDATE member SET situation = 'kitaku' WHERE id IN (SELECT id FROM user_logs WHERE date = '$yesterday' AND end_time IS NULL)");

                $st = $pdo->query("UPDATE user_logs SET end_time = '00:00:00' WHERE date = '$yesterday' AND end_time IS NULL");






                //現状取得
                $st = $pdo->query("SELECT * FROM member WHERE NOT id = 999");//SQL文の発行
                while ($row = $st->fetch()) {
                    $id = htmlspecialchars($row['id']);
                    $pass = htmlspecialchars($row['pass']);
                    $name = htmlspecialchars($row['name']);
                    $lnRuby = htmlspecialchars($row['lnRuby']);
                    $situation = htmlspecialchars($row['situation']);
                    
                    
                   //画像リンク先各ホームページモード                   
                    /*echo "<li><a href='http://buturi.heteml.jp/student/2015/$lnRuby/'><img src=http://buturi.heteml.jp/student/2015/images/profile/$lnRuby.jpg width=100 height=100 alt='No image'><img src=http://buturi.heteml.jp/student/2015/$situation.gif class='situ' width=60 height=60 alt='$situation'><br /><name>$name</name></a></li>";*/
                    
                    
                    
                    //画像リンク先オートログインモード
                    echo "<li><form class='form' name='iform' action='login.php' method='post'>";
                    echo "<input type='hidden' name='id' value='$id'>";
                    echo "<input type='hidden' name='pass' value='$pass'>";
                    echo "<input type='image' src='http://buturi.heteml.jp/student/2015/images/profile/$lnRuby.jpg' id='autologin'>";
                    echo "<input type='image' src=http://buturi.heteml.jp/student/2015/$situation.gif class='situ' width=60 height=60 alt='$situation'>";
                    
                    /*echo "<img src=http://buturi.heteml.jp/student/2015/$situation.gif class='situ' width=60 height=60 alt='$situation'>";*/
                    echo "</form>";
                    echo "<a href='http://buturi.heteml.jp/student/2015/$lnRuby/'><name>$name</name></a></li>";
                    
                    
                
                    
                }
                
                ?>
                </ul>
                
            </div>   
            
            
            <hr /><!--float解除-->
            
            <form>
            <input id="reload" type=button value="更新" onclick=location.reload()>
            </form>
        </section>
       
        
        