<?php 
    //initialisation des variables pour message errreur
    $array = array(
                    //Variable initial
                    'firstname' => "",
                    'name' => "",
                    'email' => "",
                    'phone' => "",
                    'message' => "",
                    //variable lorsque erreur
                    'firstnameError' => "",
                    'nameError' => "",
                    'emailError' => "",
                    'phoneError' => "",
                    'messageError' => "",
                    //initialisation de la variable confirmant l'envoie du formulaire
                    'isSuccess' => false
    );

    //initialisation de la variable pour l'envoie du formulaire
    //client vers boite mail
    $emailTo = "fivehundred93@hotmail.com";

    //function servant a verifier les charactere pour
    //chaque champs dentre
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $array["firstname"] = verifyInput ($_POST['firstname']);
        $array["name"] = verifyInput($_POST['name']);
        $array["email"] = verifyInput($_POST['email']);
        $array["phone"] = verifyInput($_POST['phone']);
        $array["message"] = verifyInput($_POST['message']);
            //fonction d'envoi confirmation au client lorsque
            //formulaire est remplie correctement sans erreur
            $array["isSuccess"] = true;

            //definition de la fonction permettant l'envoi du email
            $emailText = "";

        //definition messages erreur si utilisateur
        //soumet cases obligatoire sans remplir ou avec erreur

            //--prenom--
        if (empty($array["firstname"])) {
            $array["firstnameError"] = "Champs Obligatoire, prenom requis !";
            $array["isSuccess"] = false;
        }
            else {
                $emailText .= "Firstname: {$array["firstname"]}\n";
            }

            //--nom famille--
        if (empty($array["name"])) {
            $array["nameError"] = "Champs obligatoire, nom de famille requis !";
            $array["isSuccess"] = false;
        }    
            else {
                $emailText .= "Name: {$array["name"]}\n";
            }

            //--Commentaire--
            //message erreur si aucun message
        if (empty($array["message"])) {
            $array["messageError"] = "S.v.p veuillez inscrire un bref message";
            $array["isSuccess"] = false;
        }
            else {
                $emailText .= "Message: {$array["message"]}\n";
            }

            //--Email--
            //definition message erreur si email client
            //contient caractere ou email non valide
        if (!isEmail($array["email"])) {
            $array["emailError"] = "Adresse email non valide, s.v.p entrez une adresse valide";
            $array["isSuccess"] = false;
        }
            else {
                $emailText .= "Adresse email: {$array["email"]}\n";
            }

            //--Telephone--
            //definition message erreur num.telephone client
            //validation du respect de la casse du num de tel
        if (!isPhone($array["phone"])) {
            $array["phoneError"] = "Veuillez entrer un numero de telephone valide s.v.p";
            $array["isSuccess"] = false;
        } 
            else {
                $emailText .= "No.Telephone: {$array["phone"]}\n";
            } 

            //definition du contenu email cote receveur
        if ($array["isSuccess"]) {
            $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]} ";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
                //reeinitialisation du formulaire losrque email client
                //envoye conformement
        }

        //permet l'encodage des donne du array en objet javascript
        echo json_encode($array);
    }

    //fonction permettant la validation du num.telephone client
    function isPhone($var){
        return preg_match("/^[0-9]*$/", $var);
    }

    //fonction permettant la validattion du email client
    function isEmail($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }   

    //function servant a nettoyer les charactere pour securise le formulaire
    //et pervenir d'eventuelle faille HSS
    function verifyInput($var){
        $var = trim($var);
        $var = stripcslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }
?>