<?php
header("content-type:application/json");

  $data = file_get_contents("php://input");

  $data = json_decode($data,true);

                    if($data)
                        {
                            require("PDOconnect.php");
                            $idcon = PDOconnect("param","chat");
$message = $data["message"];
$id      = (int) $data["user_id"];
$dateTime =      $data["dateHeure"];

                            $query = "INSERT INTO messages(message_user,date,user_id)values( :mes ,:date_ , :id ) ";
                    $reqPreparer =      $idcon->prepare($query);
                        $dataPreparer = ["mes"=>$message ,"date_"=>$dateTime, "id"=>$id];

                        $reqPreparer->execute($dataPreparer);

                        if( $reqPreparer->rowCount() == 1)
                            {
                                $result = ["status"=>"succes"] ;
                                  echo json_encode($result);
                                  exit;
                            }
                        else
                            {
                               $result = ["status"=>"echec"] ;
                                  echo json_encode($result);
                                  exit;   
                            }
                            }

?>