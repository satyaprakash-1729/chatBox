<!-- 
Author: Satya Prakash, CSE, IIT Guwahati
Project: Simple Chat Page
 -->
<?php 
    if(isset($_GET["userId"])){
        $userId = $_GET["userId"];
            $dir = 'uploads/'.$userId.'/';
            $file_display = array(
                'jpg',
                'jpeg',
                'png',
                'gif'
            );

            if (file_exists($dir) == false) {
            } else {
                $dir_contents = scandir($dir);
                $index = 0;
                foreach ($dir_contents as $file) {
                    $tmp = explode('.', $file);
                    $file_type = strtolower(end($tmp));
                    if ($file !== '.' && $file !== '..' && in_array($file_type, $file_display) == true) {
                        if($index%6==0){
                            echo '<tr class="danger">';
                        }
                        $fileNew = "'".$file."'";
                        echo "<td id='td".$index."' width='17%'><a href='".$dir."".$file."' target='_blank'>";
                        echo '<img data-toggle="tooltip" title="Click to see in new tab" src="'. $dir. ''. $file. '" alt="'. $file. '" height=100 width=100 /></a><div class="input-group-btn" id="deleteBut"><button data-toggle="tooltip" title="Delete Pic" type="button" class="btn btn-danger" value="'.$index.'" name="picdelete" onclick="deleteFunct('.$fileNew.', this.value); return false;"><i class="glyphicon glyphicon-remove-sign"></i></button></div></td>';
                        if($index%6==5){
                            echo '</tr>';
                        }
                        $index++;
                    }
                }
                if($index%6!=5){
                    while($index%6!=5){
                        echo '<td></td>';
                        $index++;
                    }
                    echo '<td></td></tr>';
                }
            }
        }
        ?>