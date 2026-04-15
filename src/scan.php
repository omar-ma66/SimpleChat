<?php
header("content-type:application/json");
    
           $data_ =  file_get_contents("php://input");
           $data =  json_decode($data_,true);
//  echo json_encode(["status"=>"succes","datat"=>["un"=>"un","deux"=>"deux"]]);          
$date_message = $data["date_message"];
                               if($data)
                                     {
                                         require("PDOconnect.php");
                                         $idcon = PDOconnect("param","chat");
                                        //  $query = "SELECT * FROM messages where id_message > $date_message";
                                         $query = "SELECT * FROM messages where date > :date_message";

                                      $reqPrepare = $idcon->prepare($query);
                                      $dataReq = ["date_message"=>$date_message];
                                      $isOK = $reqPrepare->execute($dataReq);

                                                         if(!$isOK)
                                                             {
                                                                echo  json_encode(  ["status"=>"echec"]);
                                                            }
                                                             else
                                                                {
                                                                     $massageAll = $reqPrepare->fetchAll(PDO::FETCH_ASSOC);    
                                                                     echo json_encode(["status"=>"succes","bddMessage"=>$massageAll]);             
                                                                }
                                     }


?>