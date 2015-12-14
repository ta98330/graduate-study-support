<?php
    require "spheader.php";//ヘッダー読み込み

    if($_SESSION['login'] == "ログインしていません．"){
        header('Location: index.php');
    }
    else if($_SESSION['userId'] != 999)//管理用
        header('Location: top.php');

    require "header.php";//ヘッダー読み込み
        
    require "state.php";
    
?>

        <div id="user">
          
          <?php
          echo "<p>{$_SESSION['login']}{$_SESSION['userName']}さん管理者用ページです．　<a href='logout.php'><i class=\"fa fa-sign-out\"></i>ログアウト</a></p>";//管理用
          ?>
        </div>

        <div id="main">
            
            <section id="personal_schedule">
                <h2><i class="fa fa-calendar-check-o"></i>個人予定</h2>
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
                <h2><i class="fa fa-calendar-plus-o"></i>全体予定登録</h2>
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
                <h2><i class="fa fa-calendar-plus-o"></i>個人予定登録</h2>
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
            
            
            
            <section id="calendar">
                <h2><i class="fa fa-calendar"></i>カレンダー</h2>
            <iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTz=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=jouhoubuturi2015%40gmail.com&amp;color=%231B887A&amp;src=5udlp7brhcnbuv0mq7t0jcmh04%40group.calendar.google.com&amp;color=%23AB8B00&amp;src=ja.japanese%23holiday%40group.v.calendar.google.com&amp;color=%23125A12&amp;ctz=Asia%2FTokyo" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe>

            </section><!--calendar-->

            <section id="bbs">
                <h2><i class="fa fa-pencil-square-o"></i>簡易掲示板</h2>
                <ul>
                <?php
                $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
                $st = $pdo->query("SELECT * FROM bbs_logs");//SQL文の発行

                while ($row = $st->fetch()) {
                    $name = htmlspecialchars($row['name']);
                    $time = htmlspecialchars($row['time']);
                    $content = htmlspecialchars($row['content']);

                    echo "<hr />";
                    echo "<li>$name&emsp;$time<br />&emsp;&emsp;$content&emsp;<br /></li>";

                }
                echo "<hr id='bbsend'/>";

                echo "</ul>";

                echo "<form action='bbs.php' method='post'>";
                echo "<p>name:<input type='text' name='contributeName'  value={$_SESSION['userName']}></p>";

                ?>

                    <textarea name="contributeContent" maxlength='200' required></textarea>
                    <input type="submit" value='書き込む'>
                    <input type="submit" name="alldel" value="※掲示板リセット※" onClick="return check('掲示板がリセットされます．本当によろしいですか？\n※元には戻せません．')">
                </form>
            </section><!--bbs-->



            <section id="twitter">
                <h2><i class="fa fa-twitter "></i>Twitter</h2>
                <a class="twitter-timeline" href="https://twitter.com/j_b_2015" width="480px" height="430px" data-chrome="noheader nofooter transparent noscrollbar" data-widget-id="611469774460051457">@j_b_2015さんのツイート</a>
                <script>
                    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
                </script>
            </section>
            
            <section>
                <h2><i class="fa fa-search"></i>学生出席確認検索</h2>
                <form action="admin.php" method="post">
                    生徒
                    <select name="id">
                    <?php
                    $st = $pdo->query("SELECT * FROM member WHERE NOT id = 999");//SQL文の発行
                    while ($row = $st->fetch()) {
                        $id = htmlspecialchars($row['id']);
                        $name = htmlspecialchars($row['name']);
                        echo "<option value='$id'>$name</option>";
                    }
                    ?>
                    </select><br />
                    期間
                    <?php
                    $now = date("Y-m");
                    echo "<input name='period' type='month' min='2015-04' max='$now'>";
                    ?>
                    <br />
                    <input type="submit">
                </form>
            </section>


            <section>
                <h2><i class="fa fa-cog"></i>パスワード変更</h2>
                <form name="pass_insert" action="pass_update.php" method="post">
                現在のパスワード
                <input type="password" name="pass" required><br>
                新しいパスワード
                <input type="password" name="newPass" onblur="passCheck();" required><br>
                <input type="submit">
                </form>
            </section>

            <section>
                <h2><i class="fa fa-check-circle-o"></i>ユーザー情報確認</h2>
                <form action="user_info.php" method="post">
                パスワード
                <input type="password" name="pass" required>
                <input type="submit">
                </form>
            </section>


            <section id="update">
                <h2><i class="fa fa-info-circle"></i>更新情報</h2>
                <ul>
                    <li><time>2015.12.14</time>　登下校が研究室のTwitterにつぶやかれるようになりました．</li>
                    <li><time>2015.10.30</time>　レイアウト・デザインを変更し，出席確認機能を追加しました．</li>
                    <li><time>2015.6.8</time>　管理者ページで掲示板のリセットが出来るようになりました．</li>
                    <li><time>2015.6.8</time>　予定の削除ができるようになりました．今後の予定ボタンから行えます．</li>
                    <li><time>2015.6.8</time>　更新情報の掲載を開始しました．</li>
                </ul>
             </section>

        </div><!--main-->

<?php require "footer.php" //フッター読み込み?>