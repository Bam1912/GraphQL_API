<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: *");
  
    //  require_once __DIR__ . '/vendor/autoload.php';

    //   use App\Cors;
    //   new cors();

    // $rawInput = file_get_contents('php://input');
    // $input = json_decode($rawInput, true);
    // print_r($_GET);

    /**
     * Фабрика файлов
     */
    if(!empty($_GET ['storage_id'])){
        if(!empty($_GET['imagepreview'])){
            if(!file_exists(__DIR__."/../cloud/{$_GET['storage_id']}/{$_GET['imagepreview']}") || empty($_GET['imagepreview'])) 
                $data = file_get_contents(rawurldecode(__DIR__."/../img/nophoto.jpg"));
                else
                $data = file_get_contents(__DIR__."/../cloud/{$_GET['storage_id']}/{$_GET['imagepreview']}");
                $im = imagecreatefromstring($data);
                $width =  imagesx($im);
                $height =  imagesy($im);
                
                $newwidth = 150;
                $newheight = 150;
                $percent = $newwidth/$width;
                $percent1 = $newheight/$height;
                if($percent1<$percent) $percent=$percent1;
                $thumb = imagecreatetruecolor($width*$percent, $height*$percent);
                $trcolor = ImageColorAllocate($thumb, 10, 10, 0);
                imagefill($thumb,0,0,$trcolor);
                ImageColorTransparent($thumb , $trcolor);
                imagecopyresampled($thumb, $im,0,0,0,0, $width*$percent, $height*$percent, $width, $height);
                imagedestroy($im);
        
                header ("Content-type: image/png");
                imagepng($thumb);
                imagedestroy($thumb); 
        }
    }
    elseif($_POST['action'] == '/DeleteFile' && !empty($_POST['storage_id']) && !empty($_POST['file_name'])){
        if(file_exists(__DIR__."/../cloud/".$_POST['storage_id']."/".$_POST['file_name'])){
            if(unlink(__DIR__."/../cloud/".$_POST['storage_id']."/".$_POST['file_name']))
                echo json_encode(array('success'=>true, 'message'=>"файл удален", 'file'=>array('name'=>$_POST['file_name'])));
            else 
                echo json_encode(array('success'=>false, 'message'=>'Ошибка #4: ошибка удаления файла', 'file'=>array('name'=>$_POST['file_name'])));
        }
        else
                echo json_encode(array('success'=>false, 'message'=>'Ошибка #5: файла не найден'.__DIR__."/../cloud/".$_POST['storage_id']."/".$_POST['file_name'], 'file'=>array('name'=>$_POST['file_name'])));
    }
    elseif($_POST['action'] == '/SaveFiles' && !empty($_POST['storage_id'])){
        header('Content-Type: application/json; charset=UTF-8');

        $answer=[];
        foreach($_FILES as $file ){
            for($i=0;$i<sizeof($file['tmp_name']);$i++) {
                $data = file_get_contents($file['tmp_name'][$i]);
                if(!file_exists(__DIR__."/../cloud/".$_POST['storage_id']."/"))
                    if(!@mkdir(__DIR__."/../cloud/".$_POST['storage_id']."/", 0777, true))
                        die(json_encode(array('success'=>false, 'message'=>'Ошибка: не удалось создать директорию')));

                if(@file_put_contents(__DIR__."/../cloud/".$_POST['storage_id']."/".$file['name'][$i], $data))
                    $answer[]=[ 'name'=>$file['name'][$i], 
                                'path'=>"cloud/".$_POST['storage_id']."/" , 
                                'type'=>$file['type'][$i]
                            ];
            }
        }

        if(count($answer)>0) echo json_encode(array('success'=>true, 'data'=>$answer, 'files'=>$_FILES));
            else echo json_encode(array('success'=>false, 'message'=>'Ошибка #1: нет файлов для добавления', 'post'=>$_POST));
    } 
    else echo json_encode(array('success'=>false, 'message'=>'Ошибка #0: не заполнены необходимые поля', 'post'=>$_POST['action'], 'get'=>$_GET));
    
?>