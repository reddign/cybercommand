<?PHP
function display_company_form($company=""){

    //text entry
    if($company==""){
        $formHTML = "<h2>Add Company</h2>";
        $company = [];
        $company["companyName"] = "";
        $company["address"] = "";
        $company["city"] = "";
        $company["state"] = "";
        $company["zip"] = "";
        $company["phone"] = "";
        $company["companyID"] = "";
        $buttonString = "Add Company";
    }else{
        $formHTML = "<h2>Edit Company</h2>";
        $buttonString = "Edit Company Info";
    }
    echo '<form method=post action=companies.php>
        Company Name: <input name="companyName" type="text" value="'.$company["companyName"].'"><BR/>
        Address: <input name="address" type="text" value="'.$company["address"].'"><BR/>
        City: <input name="city" type="text" value="'.$company["city"].'"><BR/>
        State: <input name="state" type="text" value="'.$company["state"].'"><BR/>
        Zip: <input name="zip" type="text" value="'.$company["zip"].'"><BR/>
        Phone: <input name="phone" type="text" value="'.$company["phone"].'"><BR/>
        <input name="companyID" type="hidden"  value="'.$company["companyID"].'">
        <input name="page" type="hidden" value="save">  
        <input type="submit" value="'.$buttonString.'">
    </form>';

}
function display_company_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="companies.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="companies.php?page=add">Add Company</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}

//search
function display_search_form(){
    echo '<h2>Search for a company by Name</h2><form method=get action="companies.php">
        Enter Company Name: <input name="search" type="text" autofocus>
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

function display_company_list($data=null){
    if(!is_array($data) || sizeof($data) == 0){
        echo "No matching companies found";
        return;
    }
    foreach ($data as $row) {
            echo "<a href='companies.php?page=company&cid=".$row['companyID']."'>";
            echo $row['companyName']."<br />\n";
            echo "</a>";
    }
}

function display_company_info($company){
    if(!is_array($company)){
        echo "Company Information not found";
    }
    echo "<h4><b>Name:</b> ".$company['companyName']."</h4>\n";
    echo "<h4><b>Address:</b> ".$company['address']."</h4>\n";
    echo "<h4><b>City:</b> ".$company['city']."</h4>\n";
    echo "<h4><b>State:</b> ".$company['state']."</h4>\n";
    echo "<h4><b>Zip:</b> ".$company['zip']."</h4>\n";
    echo "<h4><b>Phone:</b> ".$company['phone']."</h4>\n";
    echo "<a href='companies.php?page=edit&cid=".$company['companyID']."'> Edit Info </a>\n";
    
}

function get_company($cid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM company WHERE companyID=:cid");
    $stmt->execute([':cid' => $cid]); 
    $company = $stmt->fetch(PDO::FETCH_ASSOC);
   
    return $company;
} 
function get_company_by_name($word){
    if($word==""){
        return get_all_companies_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM company WHERE companyName LIKE :name ORDER BY companyName");
    $stmt->execute([':name' => "%".$word."%"]);
    $data = [];
    while($company =  $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $company;
    } 
    
    return $data;
}    
function get_all_companies_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM company ORDER BY companyName")->fetchAll();
    return $data;
}
function process_company_form_data($arrayData){
    print_r($arrayData);
    $cid = $arrayData["companyID"];
    if($cid==""){
        addcompany($arrayData);
    }else{
        editcompany($arrayData);
    }
    
}
function addcompany($arrayData){
    $company_name = $arrayData["company_name"];
    $address = $arrayData["address"];
    $city = $arrayData["city"];
    $state = $arrayData["state"];
    $zip = $arrayData["zip"];
    $phone = $arrayData["phone"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into company (companyName, address, city, state, zip, phone) VALUES (:name, :address, :city, :state, :zip, :phone)");
    $stmt->execute([':name' => $company_name, ":address"=> $address, ":city"=>$city, ":state"=>$state, ":zip"=>$zip, ":phone"=>$phone]);
    $cid = $pdo->lastInsertId();
    header("location:companies.php?page=company&cid=".$cid."&message=Company Added");
  
}
function editcompany($arrayData){
    $company_name = $arrayData["companyName"];
    $address = $arrayData["address"];
    $city = $arrayData["city"];
    $state = $arrayData["state"];
    $zip = $arrayData["zip"];
    $phone = $arrayData["phone"];
    $cid = $arrayData["companyID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("update company set companyName=:name, address=:address, city=:city, state=:state, zip=:zip, phone=:phone where companyID=:cid");
    $stmt->execute([':name' => $company_name, ":address"=> $address, ":city"=>$city, ":state"=>$state, ":zip"=>$zip, ":phone"=>$phone, ":cid"=>$cid]);
    header("location:companies.php?page=company&cid=".$cid."&message=Company Updated");
}