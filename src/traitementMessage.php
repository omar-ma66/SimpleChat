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
$pseudo   =   $data["pseudo"]; 

                            $query = "INSERT INTO messages(message_user,date,user_id ,pseudo)values( :mes ,:date_ , :id , :pseudo ) ";
                    $reqPreparer =      $idcon->prepare($query);
                        $dataPreparer = ["mes"=>$message ,"date_"=>$dateTime, "id"=>$id ,"pseudo"=>$pseudo];

                        $reqPreparer->execute($dataPreparer);

                        if( $reqPreparer->rowCount() == 1)
                            {
                                $result = ["status"=>"succes"] ;
                                  echo json_encode($result);
                                  $reqPreparer->closeCursor();
                                  $idcon=null;
                                  exit;
                            }
                        else
                            {
                               $result = ["status"=>"echec"] ;
                                  echo json_encode($result);
                                    $reqPreparer->closeCursor();
                                  $idcon=null;
                                  exit;   
                            }
                            }

?>