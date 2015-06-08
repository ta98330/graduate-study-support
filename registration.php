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
                echo "<form method='post' action='time_counter.php'>";
                echo "<input type='submit' value='登校' name='come' id='toukou'>";
                echo "<input type='submit' value='下校' name='out' id='gekou' disabled>";
                echo "</form>";
                
                echo "<form method='post' action='situation_update.php' id='joukyou'>";    
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
                echo "<form method='post' action='time_counter.php'>";
                echo "<input type='submit' value='登校時間\n$start_time' name='come' id='toukou' disabled>";
                echo "<input type='submit' value='下校' name='out' id='gekou'>";
                echo "</form>";
                
                echo "<form method='post' action='situation_update.php' id='joukyou'>";    
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
                echo "<form method='post' action='time_counter.php'>";
                echo "<input type='submit' value='登校時間\n$start_time' name='come' id='toukou' disabled>";
                echo "<input type='submit' value='下校時間\n$end_time' name='out' id='gekou' disabled>";
                echo "<input type='submit' value='下校\n取り消し\n$stay_time' name='outreset' id='regekou'>";
                echo "</form>";
                
                echo "<form method='post' action='situation_update.php' id='joukyou'>";    
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
